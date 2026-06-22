import Chart from 'chart.js/auto';

let chart = null;

// Crea la grafica por primera vez con los datos recibidos.
window.iniciarGrafica = function (canvas, datos) {
    if (!canvas || !datos) {
        return;
    }

    const mensaje = document.getElementById('grafica-progreso-empty');

    if (mensaje) {
        if (datos.values.length === 0) {
            mensaje.classList.remove('hidden');
            mensaje.classList.add('flex');
        } else {
            mensaje.classList.add('hidden');
            mensaje.classList.remove('flex');
        }
    }

    chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels: datos.labels,
            datasets: [
                {
                    label: datos.label,
                    unit: datos.unit,
                    data: datos.values,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.18)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' ' + context.dataset.unit;
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        color: '#6b7280',
                    },
                },
                y: {
                    beginAtZero: datos.beginAtZero,
                    grid: {
                        color: 'rgba(107, 114, 128, 0.25)',
                    },
                    ticks: {
                        color: '#6b7280',
                    },
                },
            },
        },
    });
};

// Cambia la metrica o el periodo de la grafica si el usuario ha cambiado métrica o fecha, sin recargar la pagina.
window.actualizarGrafica = function (datos) {
    if (!datos) {
        return;
    }

    // Muestra u oculta el mensaje de "no hay datos registrados para este intervalo" según sea necesario.
    const mensaje = document.getElementById('grafica-progreso-empty');

    if (mensaje) {
        if (datos.values.length === 0) {
            mensaje.classList.remove('hidden');
            mensaje.classList.add('flex');
        } else {
            mensaje.classList.add('hidden');
            mensaje.classList.remove('flex');
        }
    }

    // Si la gráfica no ha sido pintada aún, llama a la función de iniciarGrafica
    if (!chart) {
        const canvas = document.getElementById('grafica-progreso');
        window.iniciarGrafica(canvas, datos);
        return;
    }

    // Actualiza los datos de la gráfica existente
    chart.data.labels = datos.labels;
    chart.data.datasets = [
        {
            label: datos.label,
            unit: datos.unit,
            data: datos.values,
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.18)',
            fill: true,
            tension: 0.35,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#4f46e5',
            pointBorderWidth: 3,
        },
    ];
    chart.options.scales.y.beginAtZero = datos.beginAtZero;
    chart.update();
};

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('grafica-progreso');

    if (!window.datosGraficaProgreso) {
        return;
    }

    const datos = window.datosGraficaProgreso.peso['6m'];
    window.iniciarGrafica(canvas, datos);
});
