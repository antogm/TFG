function obtenerValorParaOrdenar(valor, tipo) {
    if (!valor) {
        if (tipo === 'text') {
            return '';
        }

        return Number.NEGATIVE_INFINITY;
    }

    if (tipo === 'number') {
        const numero = Number(valor);
        return Number.isNaN(numero) ? Number.NEGATIVE_INFINITY : numero;
    }

    if (tipo === 'date') {
        const fecha = Date.parse(valor);
        return Number.isNaN(fecha) ? Number.NEGATIVE_INFINITY : fecha;
    }

    return String(valor).toLowerCase();
}

function actualizarFlechas(tabla, botonActivo, direccion) {
    const botones = tabla.querySelectorAll('[data-sort-key]');

    botones.forEach((boton) => {
        const flecha = boton.querySelector('[data-sort-indicator]');

        if (!flecha) {
            return;
        }

        if (boton === botonActivo) {
            flecha.textContent = direccion === 'asc' ? '↑' : '↓';
        } else {
            flecha.textContent = '';
        }
    });
}

function ordenarTabla(tabla, campo, tipo, direccion) {
    const cuerpoTabla = tabla.querySelector('tbody');

    if (!cuerpoTabla) {
        return;
    }

    const filas = Array.from(cuerpoTabla.querySelectorAll('tr'));
    const filasConDatos = [];
    const filasSinDatos = [];

    filas.forEach((fila) => {
        if (fila.dataset[campo] !== undefined) {
            filasConDatos.push(fila);
        } else {
            filasSinDatos.push(fila);
        }
    });

    filasConDatos.sort((filaA, filaB) => {
        const valorA = obtenerValorParaOrdenar(filaA.dataset[campo], tipo);
        const valorB = obtenerValorParaOrdenar(filaB.dataset[campo], tipo);

        if (valorA < valorB) {
            return direccion === 'asc' ? -1 : 1;
        }

        if (valorA > valorB) {
            return direccion === 'asc' ? 1 : -1;
        }

        return 0;
    });

    cuerpoTabla.innerHTML = '';

    filasConDatos.forEach((fila) => {
        cuerpoTabla.appendChild(fila);
    });

    filasSinDatos.forEach((fila) => {
        cuerpoTabla.appendChild(fila);
    });
}

function prepararOrdenacionHistorial() {
    const tablas = document.querySelectorAll('[data-sortable-table]');

    tablas.forEach((tabla) => {
        const botones = tabla.querySelectorAll('[data-sort-key]');

        botones.forEach((boton) => {
            boton.addEventListener('click', () => {
                const campo = boton.dataset.sortKey;
                const tipo = boton.dataset.sortType || 'text';
                let direccion = 'asc';

                if (boton.dataset.direction === 'asc') {
                    direccion = 'desc';
                }

                botones.forEach((otroBoton) => {
                    if (otroBoton !== boton) {
                        otroBoton.dataset.direction = '';
                    }
                });

                boton.dataset.direction = direccion;
                ordenarTabla(tabla, campo, tipo, direccion);
                actualizarFlechas(tabla, boton, direccion);
            });
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', prepararOrdenacionHistorial);
} else {
    prepararOrdenacionHistorial();
}
