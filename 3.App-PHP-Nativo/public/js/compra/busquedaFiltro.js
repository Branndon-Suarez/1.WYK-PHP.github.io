document.addEventListener("DOMContentLoaded", () => {
    const tabla = document.getElementById("tablaCompras");
    if (!tabla) {
        console.error("No se encontró la tabla con el ID 'tablaCompras'.");
        return;
    }
    const filas = tabla.querySelectorAll("tbody tr");
    const columnas = Array.from(tabla.querySelectorAll("thead th")).map(th => th.textContent.trim());
    const botonesContainer = document.getElementById("botonesColumnas");
    const accordion = document.getElementById("accordionFiltros");
    const generatePdfBtn = document.getElementById("generatePdfBtn");

    const estadoPedidoIndex = columnas.findIndex(c => c && c.toLowerCase().includes("estado pedido"));
    const estadoPagoIndex = columnas.findIndex(c => c && c.toLowerCase().includes("estado pago"));
    const numDocIndex = columnas.findIndex(c => c && c.toLowerCase().includes("documento"));
    const fechaRegistroIndex = columnas.findIndex(c => c && (c.toLowerCase().includes("fecha") || c.toLowerCase().includes("hora")));

    // ============================
    // 🔎 BÚSQUEDA RÁPIDA PRINCIPAL
    // ============================
    document.getElementById("buscarRapido").addEventListener("keyup", aplicarFiltros);
    document.getElementById("buscarRapidoModal")?.addEventListener("keyup", aplicarFiltros);

    // Función para normalizar los nombres de las columnas
    function normalizeColumnName(name) {
        return name.toLowerCase().replace(/[\s\W]+/g, '_').replace(/^_|_$/g, '');
    }

    // Función auxiliar para crear botones
    function createFilterButton(columna, index) {
        const btn = document.createElement("button");
        btn.textContent = columna;
        btn.className = "btn btn-outline-primary btn-sm me-2 mb-2";
        btn.dataset.index = index;
        return btn;
    }

    // ================================
    // 📌 BOTONES DINÁMICOS POR COLUMNA
    // ================================
    columnas.forEach((columna, index) => {
        if (!columna || columna.toLowerCase() === "acciones" || columna.toLowerCase().includes("id_")) return;

        // 🟡 Botones especiales para N° Documento y Fechas (Usa inputs de rango)
        if (index === numDocIndex || index === fechaRegistroIndex) {
            const btn = createFilterButton(columna, index);

            btn.addEventListener("click", () => {
                btn.classList.toggle("active");
                const acordeonId = `accordion-${normalizeColumnName(columna)}`;
                const acordeonExistente = document.getElementById(acordeonId);

                if (btn.classList.contains("active")) {
                    const card = document.createElement("div");
                    card.className = "accordion-item";
                    card.id = acordeonId;

                    let inputsHtml = "";
                    if (index === fechaRegistroIndex) {
                        inputsHtml = `
                            <div class="row">
                                <div class="col-6">
                                    <label for="fecha-inicio" class="form-label">Desde:</label>
                                    <input type="datetime-local" id="fecha-inicio" class="form-control mb-2 filtro-rango" data-col="${index}">
                                </div>
                                <div class="col-6">
                                    <label for="fecha-fin" class="form-label">Hasta:</label>
                                    <input type="datetime-local" id="fecha-fin" class="form-control mb-2 filtro-rango" data-col="${index}">
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm me-2 btn-fecha-preset" data-preset="today">Hoy</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm me-2 btn-fecha-preset" data-preset="month">Este Mes</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-fecha-preset" data-preset="year">Este Año</button>
                            </div>
                        `;
                    } else { // numDocIndex
                        inputsHtml = `<input type="number" class="form-control mb-2 filtro-rango" placeholder="Buscar por ${columna}" data-col="${index}">`;
                    }

                    card.innerHTML = `
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${normalizeColumnName(columna)}" aria-expanded="true">
                                Filtrar por ${columna}
                            </button>
                        </h2>
                        <div id="collapse-${normalizeColumnName(columna)}" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                ${inputsHtml}
                            </div>
                        </div>
                    `;
                    accordion.appendChild(card);

                    card.querySelectorAll(".filtro-rango").forEach(input => {
                        // ⭐️ Esto asegura que al cambiar manualmente los inputs se dispara el filtro
                        input.addEventListener("change", aplicarFiltros);
                        input.addEventListener("keyup", aplicarFiltros);
                    });
                    
                    // Lógica de Presets de Fecha
                    card.querySelectorAll(".btn-fecha-preset").forEach(btnPreset => {
                        btnPreset.addEventListener("click", () => {
                            const preset = btnPreset.dataset.preset;
                            const now = new Date();
                            const year = now.getFullYear();
                            const month = String(now.getMonth() + 1).padStart(2, '0');
                            const day = String(now.getDate()).padStart(2, '0');
                            
                            const hours = String(now.getHours()).padStart(2, '0');
                            const minutes = String(now.getMinutes()).padStart(2, '0');
                            
                            const fechaInicioInput = card.querySelector("#fecha-inicio");
                            const fechaFinInput = card.querySelector("#fecha-fin");
                            
                            if (preset === "today") {
                                // Hoy: Desde 00:00 hasta el momento actual
                                fechaInicioInput.value = `${year}-${month}-${day}T00:00`;
                                fechaFinInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
                            } else if (preset === "month") {
                                // Este Mes: Desde el día 1 00:00:00 hasta el momento actual
                                fechaInicioInput.value = `${year}-${month}-01T00:00`;
                                fechaFinInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
                            } else if (preset === "year") {
                                // Este Año: Desde Enero 1 00:00:00 hasta el momento actual
                                fechaInicioInput.value = `${year}-01-01T00:00`;
                                fechaFinInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
                            }
                            // ⭐️ CONFIRMADO: Esta llamada es la que dispara el filtro
                            aplicarFiltros();
                        });
                    });
                    
                } else if (acordeonExistente) {
                    acordeonExistente.remove();
                    aplicarFiltros();
                }
            });
            botonesContainer.appendChild(btn);
            return;
        }

        // 🟦 Botones normales con chips (Incluye Estado Pedido y Estado Pago)
        const btn = createFilterButton(columna, index);
        // ... (El resto de la lógica de creación de acordeones y chips permanece igual)
        btn.addEventListener("click", () => {
            btn.classList.toggle("active");
            const acordeonId = `accordion-${normalizeColumnName(columna)}`;
            const acordeonExistente = document.getElementById(acordeonId);

            if (btn.classList.contains("active")) {
                const card = document.createElement("div");
                card.className = "accordion-item";
                card.id = acordeonId;

                card.innerHTML = `
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${normalizeColumnName(columna)}">
                            Filtrar por ${columna}
                        </button>
                    </h2>
                    <div id="collapse-${normalizeColumnName(columna)}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <input type="text" class="form-control mb-2 filtro-columna" placeholder="Buscar en ${columna}" data-col="${index}">
                            <div class="chips-container"></div>
                        </div>
                    </div>
                `;
                accordion.appendChild(card);

                const valoresUnicos = [...new Set(
                    Array.from(filas).map(f => f.cells[index]?.textContent.trim())
                )].filter(v => v !== "");

                const chipsContainer = card.querySelector(".chips-container");
                valoresUnicos.forEach(valor => {
                    if (valor) {
                        const chip = document.createElement("span");
                        chip.textContent = valor;
                        chip.className = "badge bg-secondary me-1 chip";
                        chip.style.cursor = "pointer";
                        chip.addEventListener("click", () => {
                            chip.classList.toggle("bg-primary");
                            chip.classList.toggle("text-white");
                            aplicarFiltros();
                        });
                        chipsContainer.appendChild(chip);
                    }
                });

                card.querySelector(".filtro-columna").addEventListener("keyup", function () {
                    const valor = this.value.toLowerCase();
                    Array.from(chipsContainer.querySelectorAll(".chip")).forEach(chip => {
                        chip.style.display = chip.textContent.toLowerCase().includes(valor) ? "" : "none";
                    });
                });
            } else if (acordeonExistente) {
                acordeonExistente.remove();
                aplicarFiltros();
            }
        });
        botonesContainer.appendChild(btn);
    });

    // ============================
    // FUNCIÓN DE APLICAR FILTROS VISUALES (LÓGICA REFORZADA)
    // ============================
    function aplicarFiltros() {
        const chipsActivos = document.querySelectorAll(".chip.bg-primary");
        const rangoInputs = document.querySelectorAll(".filtro-rango");
        
        const textoGlobal = document.getElementById("buscarRapido").value.toLowerCase();
        const textoModal = document.getElementById("buscarRapidoModal")?.value.toLowerCase() || "";

        const chipsActivosPorColumna = {};
        chipsActivos.forEach(chip => {
            const accordionBody = chip.closest(".accordion-body");
            const inputElement = accordionBody.querySelector(".filtro-columna");
            
            if (inputElement) {
                const colIndex = parseInt(inputElement.dataset.col, 10);
                if (!chipsActivosPorColumna[colIndex]) {
                    chipsActivosPorColumna[colIndex] = new Set();
                }
                chipsActivosPorColumna[colIndex].add(chip.textContent.trim());
            }
        });

        // Encontrar el índice de la columna de fecha
        const fechaRegistroIndex = columnas.findIndex(c => c && (c.toLowerCase().includes("fecha") || c.toLowerCase().includes("hora")));

        filas.forEach(fila => {
            let visible = true;

            // Filtro de búsqueda global
            const textoFila = fila.textContent.toLowerCase();
            if (textoGlobal && !textoFila.includes(textoGlobal)) visible = false;
            if (textoModal && !textoFila.includes(textoModal)) visible = false;

            // Filtros por chips
            for (const colIndex in chipsActivosPorColumna) {
                const valoresSeleccionados = chipsActivosPorColumna[colIndex];
                const valorCelda = fila.cells[colIndex]?.textContent.trim() || "";
                
                if (valoresSeleccionados.size > 0 && !valoresSeleccionados.has(valorCelda)) {
                    visible = false;
                    break;
                }
            }

            // Filtros de rango (N° Documento y Fecha)
            const rangosActivos = {};
            rangoInputs.forEach(input => {
                const colIndex = parseInt(input.dataset.col, 10);
                if (!rangosActivos[colIndex]) {
                    rangosActivos[colIndex] = {};
                }
                if (input.id.includes("fecha-inicio")) {
                    rangosActivos[colIndex].start = input.value;
                } else if (input.id.includes("fecha-fin")) {
                    rangosActivos[colIndex].end = input.value;
                } else { // N° Documento
                    rangosActivos[colIndex].value = input.value;
                }
            });
            
            for (const colIndex in rangosActivos) {
                const filtro = rangosActivos[colIndex];

                if (parseInt(colIndex, 10) === numDocIndex) {
                    const celdaValor = fila.cells[colIndex]?.textContent.trim() || "";
                    if (filtro.value && celdaValor !== filtro.value) {
                        visible = false;
                    }
                }

                // 🚀 Lógica de Filtro de Fechas REFORZADA
                if (parseInt(colIndex, 10) === fechaRegistroIndex) {
                    const celdaValor = fila.cells[colIndex]?.textContent.trim() || "";
                    if (!celdaValor) continue;
                    
                    // 1. Normalizar la cadena de la tabla (ej: '2025-09-27 18:16:00' -> '2025-09-27T18:16:00')
                    const isoCeldaValor = celdaValor.replace(" ", "T");
                    
                    // 2. Obtener el timestamp de la celda
                    const celdaTimestamp = new Date(isoCeldaValor).getTime(); 
                    
                    if (isNaN(celdaTimestamp)) continue; 

                    let inicioTimestamp = null;
                    let finTimestamp = null;

                    if (filtro.start) {
                        // 3. Obtener el timestamp del filtro de inicio (YYYY-MM-DDTHH:mm)
                        inicioTimestamp = new Date(filtro.start).getTime();
                    }

                    if (filtro.end) {
                        // 4. Obtener el timestamp del filtro de fin y asegurar el final del día si es necesario
                        let fechaFin = new Date(filtro.end);
                        
                        // Si el input solo tiene fecha (o la hora está en T00:00), forzamos al final del día
                        if (filtro.end.endsWith('T00:00')) {
                            fechaFin.setHours(23, 59, 59, 999);
                        }
                        finTimestamp = fechaFin.getTime();
                    }

                    // 5. Aplicar los filtros de rango comparando milisegundos
                    if (inicioTimestamp !== null && celdaTimestamp < inicioTimestamp) {
                        visible = false;
                    }
                    if (finTimestamp !== null && celdaTimestamp > finTimestamp) {
                        visible = false;
                    }
                }
            }

            fila.style.display = visible ? "" : "none";
        });
    }

    // ==================================
    // 📄 FUNCIÓN PARA GENERAR EL PDF CON FILTROS
    // ==================================
    if (generatePdfBtn) {
        generatePdfBtn.addEventListener("click", (e) => {
            e.preventDefault();
            
            const chipsActivos = document.querySelectorAll(".chip.bg-primary");
            const rangoInputs = document.querySelectorAll(".filtro-rango");
            
            const textoGlobal = document.getElementById("buscarRapido").value || document.getElementById("buscarRapidoModal")?.value;

            const params = new URLSearchParams();

            // Añadir filtros de texto globales
            if (textoGlobal) {
                params.append('search', textoGlobal);
            }

            // Añadir filtros de chips
            const chipsPorColumna = {};
            chipsActivos.forEach(chip => {
                const accordionBody = chip.closest(".accordion-body");
                const inputElement = accordionBody.querySelector(".filtro-columna");
                if (inputElement) {
                     const colIndex = parseInt(inputElement.dataset.col, 10);
                     const colName = normalizeColumnName(columnas[colIndex]);
                     
                     let paramName = `filtro_${colName}`;
                     if (colIndex === estadoPedidoIndex) paramName = 'estado_pedido';
                     if (colIndex === estadoPagoIndex) paramName = 'estado_pago';
                     
                     if (!chipsPorColumna[paramName]) {
                         chipsPorColumna[paramName] = [];
                     }
                     chipsPorColumna[paramName].push(chip.textContent.trim());
                }
            });
            
            for (const paramName in chipsPorColumna) {
                params.append(paramName, chipsPorColumna[paramName].join(','));
            }

            // Añadir filtros de rango de fechas y número de documento
            rangoInputs.forEach(input => {
                const colIndex = parseInt(input.dataset.col, 10);
                const colName = normalizeColumnName(columnas[colIndex]);
                if (input.value) {
                    if (input.id.includes("fecha-inicio")) {
                        params.append('fecha_inicio', input.value);
                    } else if (input.id.includes("fecha-fin")) {
                        // Enviamos el valor tal cual. El backend debe manejar la lógica de rango final (ej: sumar un día o usar 23:59:59).
                        params.append('fecha_fin', input.value);
                    } else { // N° Documento o cualquier otro rango
                        params.append(`filtro_${colName}`, input.value);
                    }
                }
            });

            // Redirección para generar el PDF
            const urlBase = "?views=usuarios&action=generateReportPDF";
            const urlFinal = urlBase + "&" + params.toString();

            window.location.href = urlFinal;
        });
    }
});