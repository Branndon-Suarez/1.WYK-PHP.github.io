document.addEventListener('DOMContentLoaded', function () {
    const generatePdfBtn = document.getElementById('generatePdfBtn');

    generatePdfBtn.addEventListener('click', () => {
        // --- Paso 1: Obtener todos los valores de los filtros activos ---

        // 1.1. Obtener el valor de la búsqueda rápida principal
        const searchTextPrincipal = document.getElementById('buscarRapido').value;

        // 1.2. Obtener el valor de la búsqueda dentro del modal
        const searchTextModal = document.getElementById('buscarRapidoModal').value;

        // 1.3. Obtener el estado del filtro de estado
        let estadoFilter = null;
        const btnEstado = document.querySelector("#botonesColumnas button[data-estado]");
        if (btnEstado) {
            estadoFilter = btnEstado.dataset.estado;
        }

        // 1.4. Obtener los valores de los chips seleccionados (filtros de columna)
        const chipsActivos = document.querySelectorAll(".chip.bg-primary");
        const chipFilters = {};
        chipsActivos.forEach(chip => {
            const accordionBody = chip.closest(".accordion-body");
            const colIndex = accordionBody.querySelector(".filtro-columna").dataset.col;
            const columnaNombre = document.querySelector(`thead th:nth-child(${parseInt(colIndex, 10) + 1})`).textContent.trim();
            
            if (!chipFilters[columnaNombre]) {
                chipFilters[columnaNombre] = [];
            }
            chipFilters[columnaNombre].push(chip.textContent.trim());
        });

        // --- Paso 2: Construir la cadena de consulta (query string) ---
        let queryString = '';
        let hasFilter = false;
        
        // El filtro de búsqueda principal toma precedencia sobre el del modal si ambos tienen valor
        let finalSearchText = searchTextPrincipal || searchTextModal;
        
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

        // Agregar los filtros de chips. Debemos convertirlos a un formato que PHP pueda entender.
        // Ejemplo: &filtro_Rol=Gerente,Administrador&filtro_Clasificacion=Empleado
        // Nota: Esto requiere que modifiques tu controlador para procesar estos nuevos parámetros
        for (const columna in chipFilters) {
            if (chipFilters[columna].length > 0) {
                const paramName = `filtro_${columna.replace(/\s+/g, '_')}`;
                const paramValue = chipFilters[columna].map(v => encodeURIComponent(v)).join(',');
                if (hasFilter) {
                    queryString += `&`;
                }
                queryString += `${paramName}=${paramValue}`;
                hasFilter = true;
            }
        }

        // --- Paso 3: Redireccionar al controlador con los filtros aplicados ---
        if (hasFilter) {
            window.location.href = `${APP_URL}roles/generateReportPDF?${queryString}`;
        } else {
            // Si no hay ningún filtro, generar el reporte sin parámetros
            window.location.href = `${APP_URL}roles/generateReportPDF`;
        }
    });
});