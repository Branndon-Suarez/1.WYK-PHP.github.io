document.addEventListener('DOMContentLoaded', function () {
    const generatePdfBtn = document.getElementById('generatePdfBtn');

    if (generatePdfBtn) {
        generatePdfBtn.addEventListener('click', () => {
            // --- 1. Obtener valores de los filtros de texto y estado ---
            const searchTextPrincipal = document.getElementById('buscarRapido').value;
            const searchTextModal = document.getElementById('buscarRapidoModal').value;
            const finalSearchText = searchTextPrincipal || searchTextModal;

            let estadoFilter = null;
            const btnEstado = document.querySelector("#botonesColumnas button[data-estado]");
            if (btnEstado) {
                estadoFilter = btnEstado.dataset.estado;
            }

            // --- 2. Obtener los filtros de chips y de rango ---
            const chipsActivos = document.querySelectorAll(".chip.bg-primary");
            const rangoInputs = document.querySelectorAll(".filtro-rango");
            const filtroDiaCompleto = document.getElementById("filtroDiaCompleto");

            const chipFilters = {};
            const rangeFilters = {};

            // Función auxiliar para normalizar cadenas
            const normalizeString = (str) => {
                return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toUpperCase().trim().replace(/\s+/g, '_');
            };

            // Recopilar filtros de chips
            chipsActivos.forEach(chip => {
                const accordionBody = chip.closest(".accordion-body");
                const colIndex = accordionBody.querySelector(".filtro-columna").dataset.col;
                const columnaNombre = document.querySelector(`#tablaAjustesInv thead th:nth-child(${parseInt(colIndex, 10) + 1})`).textContent.trim();
                const normalizedColumnaNombre = normalizeString(columnaNombre);

                if (!chipFilters[normalizedColumnaNombre]) {
                    chipFilters[normalizedColumnaNombre] = [];
                }
                chipFilters[normalizedColumnaNombre].push(chip.textContent.trim());
            });

            // Recopilar filtros de rango (fechas y n° documento)
            rangoInputs.forEach(input => {
                if (input.value) {
                    const colIndex = input.dataset.col;
                    const columnaNombre = document.querySelector(`#tablaAjustesInv thead th:nth-child(${parseInt(colIndex, 10) + 1})`).textContent.trim();
                    const normalizedColumnaNombre = normalizeString(columnaNombre);

                    if (input.id.includes("fecha-inicio")) {
                        rangeFilters['fecha_inicio'] = input.value;
                    } else if (input.id.includes("fecha-fin")) {
                        rangeFilters['fecha_fin'] = input.value;
                    } else { // Para el número de documento
                        rangeFilters[normalizedColumnaNombre] = input.value;
                    }
                }
            });

            // --- 3. Construir la cadena de consulta (query string) ---
            const params = new URLSearchParams();

            // Agregar el filtro de búsqueda de texto
            if (finalSearchText) {
                params.append('search', finalSearchText);
            }

            // Agregar el filtro de estado si no es 'todos'
            if (estadoFilter && estadoFilter !== 'todos') {
                params.append('estado', estadoFilter);
            }

            // Agregar los filtros de chips de los acordeones
            for (const columna in chipFilters) {
                if (chipFilters[columna].length > 0) {
                    const paramName = `filtro_${columna}`;
                    params.append(paramName, chipFilters[columna].join(','));
                }
            }

            // Agregar los nuevos filtros de rango
            for (const key in rangeFilters) {
                params.append(key, rangeFilters[key]);
            }

            // Agregar el estado del checkbox de día completo
            if (filtroDiaCompleto && filtroDiaCompleto.checked) {
                params.append('diaCompleto', 'true');
            }

            // --- 4. Redireccionar con la URL final ---
            const queryString = params.toString();
            const urlFinal = `${APP_URL}usuarios/generateReportPDF?${queryString}`;

            // Abrir el PDF en una nueva pestaña
            window.open(urlFinal, '_blank');
        });
    } else {
        console.error("No se encontró el botón con ID 'generatePdfBtn'.");
    }
});