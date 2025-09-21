document.addEventListener('DOMContentLoaded', function () {
    const generatePdfBtn = document.getElementById('generatePdfBtn');

    generatePdfBtn.addEventListener('click', () => {
        // --- 1. Obtener valores de los filtros de texto y estado ---
        // El filtro de búsqueda principal toma precedencia sobre el del modal
        const searchTextPrincipal = document.getElementById('buscarRapido').value;
        const searchTextModal = document.getElementById('buscarRapidoModal').value;
        const finalSearchText = searchTextPrincipal || searchTextModal;

        // Obtener el estado del filtro de estado
        let estadoFilter = null;
        const btnEstado = document.querySelector("#botonesColumnas button[data-estado]");
        if (btnEstado) {
            estadoFilter = btnEstado.dataset.estado;
        }

        // --- 2. Obtener los filtros de chips (columnas de los acordeones) ---
        const chipsActivos = document.querySelectorAll(".chip.bg-primary");
        const chipFilters = {};

        // Helper function to normalize strings by removing diacritics (accents)
        const normalizeString = (str) => {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        };

        chipsActivos.forEach(chip => {
            const accordionBody = chip.closest(".accordion-body");
            const colIndex = accordionBody.querySelector(".filtro-columna").dataset.col;
            
            // Obtener el nombre de la columna desde el encabezado de la tabla
            const columnaNombre = document.querySelector(`#tablaRoles thead th:nth-child(${parseInt(colIndex, 10) + 1})`).textContent.trim();

            // Normalize the column name to remove accents before creating the parameter
            const normalizedColumnaNombre = normalizeString(columnaNombre);

            // Si la columna aún no está en el objeto, la creamos como un array
            if (!chipFilters[normalizedColumnaNombre]) {
                chipFilters[normalizedColumnaNombre] = [];
            }
            // Agregamos el texto del chip al array de esa columna
            chipFilters[normalizedColumnaNombre].push(chip.textContent.trim());
        });

        // --- 3. Construir la cadena de consulta (query string) ---
        let queryString = '';
        let hasFilter = false;

        // Agregar el filtro de búsqueda de texto
        if (finalSearchText) {
            queryString += `search=${encodeURIComponent(finalSearchText)}`;
            hasFilter = true;
        }

        // Agregar el filtro de estado si no es 'todos'
        if (estadoFilter && estadoFilter !== 'todos') {
            if (hasFilter) {
                queryString += `&`;
            }
            queryString += `estado=${estadoFilter}`;
            hasFilter = true;
        }

        // Agregar los filtros de chips de los acordeones
        for (const columna in chipFilters) {
            if (chipFilters[columna].length > 0) {
                // Generamos un nombre de parámetro legible para PHP, p.ej. "filtro_CLASIFICACION"
                const paramName = `filtro_${columna.replace(/\s+/g, '_').toUpperCase()}`;
                const paramValue = chipFilters[columna].map(v => encodeURIComponent(v)).join(',');
                if (hasFilter) {
                    queryString += `&`;
                }
                queryString += `${paramName}=${paramValue}`;
                hasFilter = true;
            }
        }

        // --- 4. Redireccionar con la URL final ---
        if (hasFilter) {
            window.location.href = `${APP_URL}roles/generateReportPDF?${queryString}`;
        } else {
            window.location.href = `${APP_URL}roles/generateReportPDF`;
        }
    });
});