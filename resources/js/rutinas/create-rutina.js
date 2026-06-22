document.addEventListener('DOMContentLoaded', () => {

    const routineBuilderTranslationsNode = document.getElementById('routine_builder_translations');
    const routineBuilderTranslations = routineBuilderTranslationsNode
        ? JSON.parse(routineBuilderTranslationsNode.textContent || '{}')
        : {};

    const t = (key, replacements = {}) => {
        const translation = routineBuilderTranslations[key] || key;

        return Object.entries(replacements).reduce(
            (text, [name, value]) => text.replaceAll(`:${name}`, String(value)),
            translation
        );
    };

    //////////////////////////////
    // CONTADOR DE CARACTERES 
    const inputNombre = document.getElementById('nombre');
    const contadorNombre = document.getElementById('nombre_count');

    const inputDescripcion = document.getElementById('descripcion');
    const contadorDescripcion = document.getElementById('descripcion_count');

    if (inputNombre && contadorNombre) {
        contadorNombre.textContent = t('characters_count', { count: inputNombre.value.length, max: 100 });

        inputNombre.addEventListener('input', () => {
            contadorNombre.textContent = t('characters_count', { count: inputNombre.value.length, max: 100 });
        });
    }

    if (inputDescripcion && contadorDescripcion) {
        contadorDescripcion.textContent = t('characters_count', { count: inputDescripcion.value.length, max: 255 });

        inputDescripcion.addEventListener('input', () => {
            contadorDescripcion.textContent = t('characters_count', { count: inputDescripcion.value.length, max: 255 });
        });
    }

    //////////////////////////////

    const daysInputs = Array.from(document.querySelectorAll('input[name="dias_entreno"]'));
    const exerciseDaysContainer = document.getElementById('exercise_days_container');
    const exerciseCatalogUrl = exerciseDaysContainer?.dataset.exerciseCatalogUrl || '/api/ejercicios/catalogo';
    const exerciseSummaryBadge = document.getElementById('exercise_summary_badge');
    const exerciseNoDays = document.querySelector('[data-exercise-no-days]');
    const exerciseDayCards = Array.from(document.querySelectorAll('[data-exercise-day-card]'));
    const dayNameInputs = Array.from(document.querySelectorAll('[data-day-name-input]'));
    const exerciseRowTemplate = document.getElementById('exercise_row_template');
    const routineStepPanels = Array.from(document.querySelectorAll('[data-routine-step-panel]'));
    const routineStepTabs = Array.from(document.querySelectorAll('[data-routine-step-tab]'));
    const routineStepLines = Array.from(document.querySelectorAll('[data-routine-step-line]'));
    const routineStepPrev = document.getElementById('routine_step_prev');
    const routineStepNext = document.getElementById('routine_step_next');
    const routineSubmitButton = document.getElementById('routine_submit_button');
    const routineForm = document.getElementById('routine_form');
    const routineStepOneValidationMessage = document.getElementById('routine_step_one_validation_message');
    const routineExerciseValidationMessage = document.getElementById('routine_exercise_validation_message');
    let currentRoutineStep = 0;
    let exerciseLibrary = [];
    let exerciseCatalogLoaded = false;
    let exerciseCatalogLoading = false;
    let exerciseCatalogError = false;
    let stepOneValidationVisible = false;
    let exerciseValidationVisible = false;
    let dayPlans = [];

    if (exerciseDaysContainer?.dataset.initialDayPlans) {
        dayPlans = JSON.parse(exerciseDaysContainer.dataset.initialDayPlans);
    }

    const activeNumberClasses = [
        'bg-emerald-600',
        'border-emerald-600',
        'text-white',
        'dark:bg-emerald-500',
        'dark:border-emerald-500',
    ];
    const inactiveNumberClasses = [
        'bg-white',
        'border-gray-300',
        'text-gray-600',
        'dark:bg-gray-800',
        'dark:border-gray-600',
        'dark:text-gray-300',
    ];
    const completedLineClasses = [
        'bg-emerald-500',
        'dark:bg-emerald-500',
    ];
    const pendingLineClasses = [
        'bg-gray-300',
        'dark:bg-gray-700',
    ];
    const validSubmitClasses = [
        'bg-emerald-600',
        'text-white',
        'hover:bg-emerald-700',
        'focus:bg-emerald-700',
        'active:bg-emerald-800',
        'focus:ring-emerald-500',
        'dark:bg-emerald-500',
        'dark:text-white',
        'dark:hover:bg-emerald-400',
        'dark:focus:bg-emerald-400',
        'dark:active:bg-emerald-600',
    ];
    const invalidSubmitClasses = [
        'bg-gray-800',
        'text-white',
        'hover:bg-gray-700',
        'focus:bg-gray-700',
        'active:bg-gray-900',
        'focus:ring-indigo-500',
        'dark:bg-gray-200',
        'dark:text-gray-800',
        'dark:hover:bg-white',
        'dark:focus:bg-white',
        'dark:active:bg-gray-300',
    ];

    // Returns the currently selected number of training days.
    const getSelectedDayCount = () => {
        return document.querySelector('input[name="dias_entreno"]:checked')?.value || '';
    };

    const getStepOneInvalidFields = () => {
        return [
            document.getElementById('nombre'),
            ...daysInputs,
            document.getElementById('kcal_objetivo'),
            document.getElementById('duracion_aproximada_min'),
            document.getElementById('pasos_objetivo'),
        ].filter((field) => field && !field.checkValidity());
    };

    const updateStepOneValidationMessage = (showMessage = stepOneValidationVisible) => {
        const invalidFields = getStepOneInvalidFields();

        stepOneValidationVisible = showMessage && invalidFields.length > 0;

        if (!routineStepOneValidationMessage) {
            return;
        }

        routineStepOneValidationMessage.classList.toggle('hidden', !stepOneValidationVisible);
        routineStepOneValidationMessage.textContent = stepOneValidationVisible
            ? t('complete_required_fields')
            : '';
    };

    const requireStepOneFields = () => {
        const invalidFields = getStepOneInvalidFields();

        if (invalidFields.length === 0) {
            updateStepOneValidationMessage(false);
            return true;
        }

        updateStepOneValidationMessage(true);

        invalidFields[0].focus();
        invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });

        return false;
    };

    const getDaysWithoutExercises = () => {
        const dayCount = clampDayCount(getSelectedDayCount());

        return Array.from({ length: dayCount }, (_, index) => index)
            .filter((dayIndex) => (dayPlans[dayIndex]?.exercises.length || 0) === 0);
    };

    const updateExerciseValidationMessage = (showMessage = exerciseValidationVisible) => {
        const daysWithoutExercises = getDaysWithoutExercises();

        exerciseValidationVisible = showMessage && daysWithoutExercises.length > 0;

        if (!routineExerciseValidationMessage) {
            return;
        }

        routineExerciseValidationMessage.classList.toggle('hidden', !exerciseValidationVisible);
        routineExerciseValidationMessage.textContent = exerciseValidationVisible
            ? t('missing_exercises_by_day', { days: daysWithoutExercises
                .map((dayIndex) => t('day_label', { number: dayIndex + 1 }))
                .join(', ') })
            : '';
    };

    const requireExercisesInEveryDay = () => {
        const daysWithoutExercises = getDaysWithoutExercises();

        if (daysWithoutExercises.length === 0) {
            updateExerciseValidationMessage(false);
            return true;
        }

        updateExerciseValidationMessage(true);

        const firstMissingDay = daysWithoutExercises[0];
        const firstMissingSelect = document.getElementById(`day-exercise-${firstMissingDay}`);

        firstMissingSelect?.focus();
        firstMissingSelect?.scrollIntoView({ behavior: 'smooth', block: 'center' });

        return false;
    };

    const isRoutineFormReadyToSubmit = () => {
        return routineForm.checkValidity()
            && isRoutineStepComplete(0)
            && isRoutineStepComplete(1)
            && getDaysWithoutExercises().length === 0;
    };

    const updateSubmitButtonState = () => {
        if (!routineSubmitButton) {
            return;
        }

        const isReady = isRoutineFormReadyToSubmit();

        routineSubmitButton.classList.remove(...validSubmitClasses, ...invalidSubmitClasses);
        routineSubmitButton.classList.add(...(isReady ? validSubmitClasses : invalidSubmitClasses));
        routineSubmitButton.setAttribute(
            'aria-label',
            isReady
                ? t('save_routine_valid_aria')
            : t('review_before_save_aria')
        );
    };

    const showFirstInvalidHtmlField = () => {
        const invalidField = routineForm.querySelector(':invalid');

        if (!invalidField) {
            return true;
        }

        const invalidPanel = invalidField.closest('[data-routine-step-panel]');
        const invalidStep = invalidPanel ? routineStepPanels.indexOf(invalidPanel) : 0;

        setRoutineStep(invalidStep);
        invalidField.focus();
        invalidField.reportValidity();

        return false;
    };

    // Determines whether a step has enough data to be considered complete.
    const isRoutineStepComplete = (stepIndex) => {
        if (stepIndex === 0) {
            const name = document.getElementById('nombre');

            return Boolean(name?.checkValidity() && daysInputs.some((input) => input.checked));
        }

        if (stepIndex === 1) {
            const dayCount = clampDayCount(getSelectedDayCount());

            return dayCount > 0
                && dayPlans.length >= dayCount
                && dayPlans.slice(0, dayCount).every((day) => day.exercises.length > 0);
        }

        return false;
    };

    // Shows the requested wizard step and updates step indicators.
    const setRoutineStep = (stepIndex) => {
        currentRoutineStep = Math.max(0, Math.min(stepIndex, routineStepPanels.length - 1));

        routineStepPanels.forEach((panel, index) => {
            panel.classList.toggle('hidden', index !== currentRoutineStep);
        });

        routineStepTabs.forEach((tab, index) => {
            const number = tab.querySelector('[data-routine-step-number]');
            const isActive = index === currentRoutineStep;
            const isCompleted = isRoutineStepComplete(index);

            tab.setAttribute('aria-current', isActive ? 'step' : 'false');

            if (number) {
                number.classList.remove(...activeNumberClasses, ...inactiveNumberClasses);
                number.classList.add(...(isActive || isCompleted ? activeNumberClasses : inactiveNumberClasses));
                number.textContent = isCompleted && !isActive ? '✓' : String(index + 1);
            }
        });

        routineStepLines.forEach((line) => {
            const lineStep = Number(line.dataset.routineStepLine);

            line.classList.remove(...completedLineClasses, ...pendingLineClasses);
            line.classList.add(...(isRoutineStepComplete(lineStep) ? completedLineClasses : pendingLineClasses));
        });

        routineStepPrev.classList.toggle('hidden', currentRoutineStep === 0);
        routineStepNext.classList.toggle('hidden', currentRoutineStep === routineStepPanels.length - 1);
        routineSubmitButton.classList.toggle('hidden', currentRoutineStep !== routineStepPanels.length - 1);

        updateStepOneValidationMessage();
        updateSubmitButtonState();

        if (currentRoutineStep === 1) {
            loadExerciseCatalog();
        }
    };

    // Clamps the day count to the supported 0-7 range.
    const clampDayCount = (value) => {
        const parsed = Number.parseInt(value, 10);

        if (Number.isNaN(parsed) || parsed < 0) {
            return 0;
        }

        return Math.min(parsed, 7);
    };

    const durationUnitMultipliers = {
        seconds: 1,
        minutes: 60,
        hours: 3600,
    };

    const durationUnitMaxValues = {
        seconds: 86400,
        minutes: 1440,
        hours: 24,
    };

    const normalizeDurationUnit = (unit) => (
        Object.prototype.hasOwnProperty.call(durationUnitMultipliers, unit) ? unit : 'seconds'
    );

    const secondsFromDurationControls = (value, unit) => {
        if (value === '') {
            return '';
        }

        const numericValue = Number.parseInt(value, 10);
        const normalizedUnit = normalizeDurationUnit(unit);

        if (Number.isNaN(numericValue) || numericValue < 1) {
            return '';
        }

        return Math.min(numericValue * durationUnitMultipliers[normalizedUnit], 86400);
    };

    const durationControlsFromSeconds = (seconds) => {
        const numericSeconds = Number.parseInt(seconds, 10);

        if (Number.isNaN(numericSeconds) || numericSeconds < 1) {
            return { value: '', unit: 'seconds' };
        }

        if (numericSeconds % durationUnitMultipliers.hours === 0) {
            return { value: numericSeconds / durationUnitMultipliers.hours, unit: 'hours' };
        }

        if (numericSeconds % durationUnitMultipliers.minutes === 0) {
            return { value: numericSeconds / durationUnitMultipliers.minutes, unit: 'minutes' };
        }

        return { value: numericSeconds, unit: 'seconds' };
    };

    const syncExerciseDuration = (control) => {
        const dayIndex = Number(control.dataset.dayIndex);
        const exerciseIndex = Number(control.dataset.exerciseIndex);
        const row = control.closest('[data-exercise-row]');
        const valueInput = row?.querySelector('[data-exercise-duration-value]');
        const unitSelect = row?.querySelector('[data-exercise-duration-unit]');
        const secondsInput = row?.querySelector('[data-exercise-duration-seconds-input]');

        if (!valueInput || !unitSelect || !secondsInput || !dayPlans[dayIndex]?.exercises[exerciseIndex]) {
            return;
        }

        const unit = normalizeDurationUnit(unitSelect.value);
        const seconds = secondsFromDurationControls(valueInput.value, unit);

        valueInput.max = String(durationUnitMaxValues[unit]);
        secondsInput.value = seconds;
        dayPlans[dayIndex].exercises[exerciseIndex].duracion_valor = valueInput.value;
        dayPlans[dayIndex].exercises[exerciseIndex].duracion_unidad = unit;
        dayPlans[dayIndex].exercises[exerciseIndex].duracion_segundos = seconds;
    };

    // Creates the internal state object for a new training day.
    const createEmptyDay = () => ({
        name: '',
        selectedExerciseId: '',
        exercises: [],
    });

    // Resizes the day state array to match the selected number of training days.
    const syncDayPlansWithCount = (count) => {
        while (dayPlans.length < count) {
            dayPlans.push(createEmptyDay());
        }

        if (dayPlans.length > count) {
            dayPlans = dayPlans.slice(0, count);
        }
    };

    // Updates the summary badge shown in the exercise assignment step.
    const updateExerciseSummary = () => {
        const total = dayPlans.reduce((sum, day) => sum + day.exercises.length, 0);
        exerciseSummaryBadge.textContent = total === 1
            ? t('exercise_summary_singular', { count: total })
            : t('exercise_summary_plural', { count: total });
    };

    // Converts exercise API rows into the shape used by the routine builder.
    const normalizeExerciseCatalog = (exercises) => exercises.map((exercise) => ({
        id: String(exercise.id),
        name: exercise.name,
        group: exercise.group || t('no_muscle_groups_short'),
        image: exercise.image || '',
    }));

    // Adds or updates one exercise in the local catalog after postMessage creation.
    const upsertExerciseInCatalog = (exercise) => {
        if (!exercise?.id || !exercise.name) {
            return;
        }

        const normalizedExercise = {
            id: String(exercise.id),
            name: exercise.name,
            group: exercise.group || t('no_muscle_groups_short'),
            image: exercise.image || '',
        };
        const existingExerciseIndex = exerciseLibrary.findIndex(
            (catalogExercise) => String(catalogExercise.id) === normalizedExercise.id
        );

        if (existingExerciseIndex === -1) {
            exerciseLibrary.push(normalizedExercise);
        } else {
            exerciseLibrary[existingExerciseIndex] = normalizedExercise;
        }

        exerciseCatalogError = false;
        renderExerciseDays();
    };

    // Loads the exercise catalog once for the assignment selectors.
    const loadExerciseCatalog = async () => {
        if (exerciseCatalogLoading || exerciseCatalogLoaded) {
            return;
        }

        exerciseCatalogLoading = true;
        exerciseCatalogError = false;
        renderExerciseDays();

        try {
            const response = await fetch(exerciseCatalogUrl, {
                headers: {
                    Accept: 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error(`Error ${response.status}`);
            }

            exerciseLibrary = normalizeExerciseCatalog(await response.json());
            exerciseCatalogLoaded = true;
        } catch (error) {
            exerciseCatalogError = true;
        } finally {
            exerciseCatalogLoading = false;
            renderExerciseDays();
        }
    };

    // Builds an option node for an exercise selector.
    const createExerciseOption = (value, label, selected = false) => new Option(label, value, selected, selected);

    // Renders the available exercise options for a specific day selector.
    const renderExerciseSelectOptions = (select, day) => {
        if (exerciseCatalogLoading) {
            select.replaceChildren(createExerciseOption('', t('loading_exercises')));
            return;
        }

        if (exerciseCatalogError) {
            select.replaceChildren(createExerciseOption('', t('exercises_load_error')));
            return;
        }

        if (exerciseLibrary.length === 0) {
            select.replaceChildren(createExerciseOption('', t('no_exercises_available')));
            return;
        }

        const selectedExerciseIds = new Set(day.exercises.map((exercise) => String(exercise.exerciseId)));
        const options = exerciseLibrary
            .slice()
            .filter((exercise) => (
                !selectedExerciseIds.has(String(exercise.id))
                || String(exercise.id) === String(day.selectedExerciseId)
            ))
            .sort((first, second) => first.name.localeCompare(second.name, 'es'));

        if (options.length === 0) {
            select.replaceChildren(createExerciseOption('', t('all_exercises_added')));
            return;
        }

        select.replaceChildren(
            createExerciseOption('', t('select_exercise')),
            ...options.map((exercise) => createExerciseOption(
                String(exercise.id),
                `${exercise.name} - ${exercise.group}`,
                String(exercise.id) === String(day.selectedExerciseId)
            ))
        );
    };

    // Clones the Blade template for an exercise card and wires its form fields.
    const createExerciseRow = (exercise, dayIndex, exerciseIndex) => {
        const row = exerciseRowTemplate.content.firstElementChild.cloneNode(true);
        const removeButton = row.querySelector('[data-remove-exercise-button]');
        const moveLeftButton = row.querySelector('[data-move-exercise-left]');
        const moveRightButton = row.querySelector('[data-move-exercise-right]');

        row.dataset.dayIndex = String(dayIndex);
        row.dataset.exerciseIndex = String(exerciseIndex);
        const exerciseImage = row.querySelector('[data-exercise-image]');
        const exerciseImageFallback = row.querySelector('[data-exercise-image-fallback]');
        const exerciseIdInput = row.querySelector('[data-exercise-id-input]');
        const exerciseNameInput = row.querySelector('[data-exercise-name-input]');
        const durationValueInput = row.querySelector('[data-exercise-duration-value]');
        const durationUnitSelect = row.querySelector('[data-exercise-duration-unit]');
        const durationSecondsInput = row.querySelector('[data-exercise-duration-seconds-input]');

        // Assigns stable ids, names and state bindings for one editable exercise field.
        const setExerciseField = (field, labelSelector, value) => {
            const input = row.querySelector(`[data-exercise-field="${field}"]`);
            const label = row.querySelector(labelSelector);
            const id = `${field}-${dayIndex}-${exerciseIndex}`;

            input.id = id;
            input.name = `dias[${dayIndex}][ejercicios][${exerciseIndex}][${field}]`;
            input.value = value;
            input.dataset.dayIndex = String(dayIndex);
            input.dataset.exerciseIndex = String(exerciseIndex);
            label.setAttribute('for', id);
        };

        row.querySelector('[data-exercise-name]').textContent = exercise.name;
        row.querySelector('[data-exercise-group]').textContent = exercise.group || t('no_muscle_groups_short');

        const fallbackLabel = exercise.name
            .split(/\s+/)
            .filter(Boolean)
            .slice(0, 2)
            .map((segment) => segment.charAt(0))
            .join('')
            .toUpperCase() || 'EX';

        exerciseImageFallback.textContent = fallbackLabel;

        if (exercise.image) {
            exerciseImage.src = exercise.image;
            exerciseImage.alt = exercise.name;
            exerciseImage.hidden = false;
            exerciseImageFallback.hidden = true;
            exerciseImage.onerror = () => {
                exerciseImage.hidden = true;
                exerciseImageFallback.hidden = false;
            };
        } else {
            exerciseImage.removeAttribute('src');
            exerciseImage.alt = '';
            exerciseImage.hidden = true;
            exerciseImageFallback.hidden = false;
        }

        const totalExercises = dayPlans[dayIndex]?.exercises.length || 0;
        const isFirstExercise = exerciseIndex === 0;
        const isLastExercise = exerciseIndex === totalExercises - 1;

        if (moveLeftButton) {
            moveLeftButton.dataset.moveExercise = `${dayIndex}:${exerciseIndex}:-1`;
            moveLeftButton.disabled = isFirstExercise;
            moveLeftButton.setAttribute('aria-label', t('move_exercise_left_aria', { name: exercise.name }));
            moveLeftButton.title = t('move_exercise_left_aria', { name: exercise.name });
        }

        if (moveRightButton) {
            moveRightButton.dataset.moveExercise = `${dayIndex}:${exerciseIndex}:1`;
            moveRightButton.disabled = isLastExercise;
            moveRightButton.setAttribute('aria-label', t('move_exercise_right_aria', { name: exercise.name }));
            moveRightButton.title = t('move_exercise_right_aria', { name: exercise.name });
        }

        removeButton.dataset.removeExercise = `${dayIndex}:${exerciseIndex}`;
        removeButton.setAttribute('aria-label', t('remove_exercise_aria', { name: exercise.name }));

        exerciseIdInput.name = `dias[${dayIndex}][ejercicios][${exerciseIndex}][ejercicio_id]`;
        exerciseIdInput.value = exercise.exerciseId;
        exerciseNameInput.name = `dias[${dayIndex}][ejercicios][${exerciseIndex}][nombre]`;
        exerciseNameInput.value = exercise.name;

        setExerciseField('series', '[data-exercise-series-label]', exercise.series);
        setExerciseField('repeticiones', '[data-exercise-repetitions-label]', exercise.repeticiones);
        setExerciseField('carga', '[data-exercise-load-label]', exercise.carga);

        const durationControls = exercise.duracion_unidad
            ? {
                value: exercise.duracion_valor || '',
                unit: normalizeDurationUnit(exercise.duracion_unidad),
            }
            : durationControlsFromSeconds(exercise.duracion_segundos);
        const durationId = `duracion-${dayIndex}-${exerciseIndex}`;

        durationValueInput.id = durationId;
        durationValueInput.value = durationControls.value;
        durationValueInput.max = String(durationUnitMaxValues[durationControls.unit]);
        durationValueInput.dataset.dayIndex = String(dayIndex);
        durationValueInput.dataset.exerciseIndex = String(exerciseIndex);
        durationUnitSelect.value = durationControls.unit;
        durationUnitSelect.dataset.dayIndex = String(dayIndex);
        durationUnitSelect.dataset.exerciseIndex = String(exerciseIndex);
        durationSecondsInput.name = `dias[${dayIndex}][ejercicios][${exerciseIndex}][duracion_segundos]`;
        durationSecondsInput.value = exercise.duracion_segundos || '';
        row.querySelector('[data-exercise-duration-label]').setAttribute('for', durationId);

        return row;
    };

    // Resets a hidden or unused day card so it cannot submit stale inputs.
    const clearDayCard = (card, dayIndex) => {
        card.querySelector(`[data-exercise-day-count="${dayIndex}"]`).textContent = t('exercise_count_plural', { count: 0 });
        card.querySelector(`[data-day-exercise-select="${dayIndex}"]`)
            .replaceChildren(createExerciseOption('', t('select_exercise')));
        card.querySelector(`[data-exercise-empty-state="${dayIndex}"]`).classList.remove('hidden');

        const dayNameInput = card.querySelector(`[data-day-name-input="${dayIndex}"]`);
        dayNameInput.value = '';
        dayNameInput.name = '';
        dayNameInput.disabled = true;

        const exerciseList = card.querySelector(`[data-exercise-list="${dayIndex}"]`);
        exerciseList.classList.add('hidden');
        exerciseList.replaceChildren();
    };

    // Updates one visible day card from its state object.
    const renderExistingDayCard = (card, day, dayIndex) => {
        const exerciseCount = day.exercises.length;
        const exerciseCountLabel = exerciseCount === 1
            ? t('exercise_count_singular', { count: exerciseCount })
            : t('exercise_count_plural', { count: exerciseCount });
        const select = card.querySelector(`[data-day-exercise-select="${dayIndex}"]`);
        const dayNameInput = card.querySelector(`[data-day-name-input="${dayIndex}"]`);
        const emptyState = card.querySelector(`[data-exercise-empty-state="${dayIndex}"]`);
        const exerciseList = card.querySelector(`[data-exercise-list="${dayIndex}"]`);

        dayNameInput.disabled = false;
        dayNameInput.name = `dias[${dayIndex}][nombre]`;
        dayNameInput.value = day.name || '';
        card.querySelector(`[data-exercise-day-count="${dayIndex}"]`).textContent = exerciseCountLabel;
        renderExerciseSelectOptions(select, day);
        select.value = day.selectedExerciseId;
        emptyState.classList.toggle('hidden', exerciseCount > 0);
        exerciseList.classList.toggle('hidden', exerciseCount === 0);
        exerciseList.replaceChildren(
            ...day.exercises.map((exercise, exerciseIndex) => createExerciseRow(exercise, dayIndex, exerciseIndex))
        );
    };

    // Shows the selected day cards and keeps their DOM synced with dayPlans.
    const renderExerciseDays = () => {
        const dayCount = clampDayCount(getSelectedDayCount());

        syncDayPlansWithCount(dayCount);
        updateExerciseSummary();
        exerciseNoDays?.classList.toggle('hidden', dayCount !== 0);

        exerciseDayCards.forEach((card, dayIndex) => {
            const isVisible = dayIndex < dayCount;

            card.classList.toggle('hidden', !isVisible);

            if (isVisible) {
                renderExistingDayCard(card, dayPlans[dayIndex], dayIndex);
            } else {
                clearDayCard(card, dayIndex);
            }
        });

        updateExerciseValidationMessage();
        updateSubmitButtonState();
    };

    // Finds an exercise in the local catalog by id.
    const findExerciseById = (id) => {
        if (!id) {
            return null;
        }

        return exerciseLibrary.find((exercise) => String(exercise.id) === String(id)) || null;
    };

    // Adds a catalog exercise to a day with default prescription values.
    const addExerciseToDay = (dayIndex, exercise) => {
        if (!dayPlans[dayIndex]) {
            return;
        }

        dayPlans[dayIndex].exercises.push({
            uid: `${exercise.id}-${Date.now()}`,
            exerciseId: exercise.id,
            name: exercise.name,
            group: exercise.group || t('no_muscle_groups_short'),
            image: exercise.image || '',
            duracion_segundos: '',
            duracion_valor: '',
            duracion_unidad: 'seconds',
            series: 4,
            repeticiones: 10,
            carga: '',
        });
        dayPlans[dayIndex].selectedExerciseId = '';
        renderExerciseDays();
        setRoutineStep(currentRoutineStep);
    };

    // Preserves whether a selected day radio was already checked before clicking it.
    daysInputs.forEach((input) => {
        input.addEventListener('pointerdown', () => {
            input.dataset.wasChecked = input.checked ? 'true' : 'false';
        });

        // Allows clicking the active day count again to clear the selection.
        input.addEventListener('click', () => {
            if (input.dataset.wasChecked === 'true') {
                input.checked = false;
                delete input.dataset.wasChecked;
                renderExerciseDays();
                setRoutineStep(currentRoutineStep);
            }
        });

        input.addEventListener('change', () => {
            renderExerciseDays();
            setRoutineStep(currentRoutineStep);
        });
    });

    dayNameInputs.forEach((input) => {
        input.addEventListener('input', () => {
            const dayIndex = Number(input.dataset.dayNameInput);

            if (dayPlans[dayIndex]) {
                dayPlans[dayIndex].name = input.value;
            }
        });
    });

    // Stores selector changes and duration unit changes in the local state.
    exerciseDaysContainer.addEventListener('change', (event) => {
        if (event.target.dataset.exerciseDurationUnit !== undefined) {
            syncExerciseDuration(event.target);
            return;
        }

        const selectedDay = event.target.dataset.dayExerciseSelect;

        if (selectedDay === undefined || !dayPlans[Number(selectedDay)]) {
            return;
        }

        dayPlans[Number(selectedDay)].selectedExerciseId = event.target.value;
    });

    // Keeps series, repetitions, load and duration edits mirrored in dayPlans.
    exerciseDaysContainer.addEventListener('input', (event) => {
        if (event.target.dataset.exerciseDurationValue !== undefined) {
            syncExerciseDuration(event.target);
            return;
        }

        const field = event.target.dataset.exerciseField;
        if (!field) {
            return;
        }

        const dayIndex = Number(event.target.dataset.dayIndex);
        const exerciseIndex = Number(event.target.dataset.exerciseIndex);

        if (!dayPlans[dayIndex] || !dayPlans[dayIndex].exercises[exerciseIndex]) {
            return;
        }

        dayPlans[dayIndex].exercises[exerciseIndex][field] = event.target.value;
    });

    // Handles adding and removing exercises from day cards.
    exerciseDaysContainer.addEventListener('click', (event) => {
        const addButton = event.target.closest('[data-add-exercise]');
        if (addButton) {
            const dayIndex = Number(addButton.dataset.addExercise);
            const selectedExerciseId = dayPlans[dayIndex]?.selectedExerciseId || '';

            if (!selectedExerciseId) {
                document.getElementById(`day-exercise-${dayIndex}`)?.focus();
                return;
            }

            const exercise = findExerciseById(selectedExerciseId);

            if (exercise) {
                addExerciseToDay(dayIndex, exercise);
            }

            return;
        }

        const moveButton = event.target.closest('[data-move-exercise]');
        if (moveButton) {
            const [dayIndex, exerciseIndex, delta] = moveButton.dataset.moveExercise.split(':').map(Number);
            const exercises = dayPlans[dayIndex]?.exercises;
            const destinationIndex = exerciseIndex + delta;

            if (!Array.isArray(exercises) || destinationIndex < 0 || destinationIndex >= exercises.length) {
                return;
            }

            if (moverElemento(exercises, exerciseIndex, destinationIndex)) {
                renderExerciseDays();
                setRoutineStep(currentRoutineStep);
            }

            return;
        }

        const removeButton = event.target.closest('[data-remove-exercise]');
        if (removeButton) {
            const [dayIndex, exerciseIndex] = removeButton.dataset.removeExercise.split(':').map(Number);

            dayPlans[dayIndex].exercises.splice(exerciseIndex, 1);
            renderExerciseDays();
            setRoutineStep(currentRoutineStep);
        }
    });

    // Receives exercises created in the secondary tab without refetching the catalog.
    window.addEventListener('message', (event) => {
        if (event.origin !== window.location.origin || event.data?.type !== 'tfg:exercise-created') {
            return;
        }

        upsertExerciseInCatalog(event.data.exercise);
    });

    // Wires direct navigation clicks in the routine wizard.
    routineStepTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const targetStep = Number(tab.dataset.routineStepTab);

            if (targetStep > 0 && getStepOneInvalidFields().length > 0) {
                setRoutineStep(0);
                requireStepOneFields();
                return;
            }

            setRoutineStep(targetStep);
        });
    });

    // Moves to the previous wizard step.
    routineStepPrev.addEventListener('click', () => {
        setRoutineStep(currentRoutineStep - 1);
    });

    // Moves to the next wizard step.
    routineStepNext.addEventListener('click', () => {
        if (currentRoutineStep === 0 && !requireStepOneFields()) {
            return;
        }

        if (currentRoutineStep === 1 && !requireExercisesInEveryDay()) {
            return;
        }

        setRoutineStep(currentRoutineStep + 1);
    });

    // Refreshes step completion and review content when form data changes.
    routineForm.addEventListener('input', () => {
        setRoutineStep(currentRoutineStep);
    });

    routineForm.addEventListener('submit', (event) => {
        if (getStepOneInvalidFields().length > 0) {
            event.preventDefault();
            setRoutineStep(0);
            requireStepOneFields();
            return;
        }

        if (getDaysWithoutExercises().length === 0) {
            updateExerciseValidationMessage(false);

            if (showFirstInvalidHtmlField()) {
                return;
            }

            event.preventDefault();
            return;
        }

        event.preventDefault();
        setRoutineStep(1);
        requireExercisesInEveryDay();
    });

    // Si ha habido un error de validación, pone el foco en el primer error detectado
    const firstInvalid = document.querySelector('[aria-invalid="true"]');
    
    if (firstInvalid) {
        const invalidPanel = firstInvalid.closest('[data-routine-step-panel]');
        const invalidStep = invalidPanel ? routineStepPanels.indexOf(invalidPanel) : 0;

        setRoutineStep(invalidStep);
        firstInvalid.focus();
    } else {
        setRoutineStep(0);
    }

    renderExerciseDays();

    /*
	----------------------------
		REORDENACIÓN
    ---------------------------- 
	*/

    function moverElemento(array, indiceOrigen, indiceDestino) {
        if (!Array.isArray(array) || indiceOrigen === indiceDestino) {
            return false;
        }

        const elemento = array.splice(indiceOrigen, 1)[0];

        if (elemento === undefined) {
            return false;
        }

        array.splice(indiceDestino, 0, elemento);

        return true;
    }
});
