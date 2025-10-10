document.addEventListener("DOMContentLoaded", () => {
  const tabla = document.getElementById("tablaUsuarios");
  if (!tabla) {
    console.error("No se encontró la tabla con el ID 'tablaUsuarios'.");
    return;
  }
  const filas = tabla.querySelectorAll("tbody tr");
  const columnas = Array.from(tabla.querySelectorAll("thead th")).map(th => th.textContent.trim());
  const botonesContainer = document.getElementById("botonesColumnas");
  const accordion = document.getElementById("accordionFiltros");
  const generatePdfBtn = document.getElementById("generatePdfBtn");

  const estadoIndex = columnas.findIndex(c => c && c.toLowerCase().includes("estado"));
  const numDocIndex = columnas.findIndex(c => c && c.toLowerCase().includes("documento"));
  const telefonoIndex = columnas.findIndex(c => c && c.toLowerCase().includes("teléfono"));
  const fechaRegistroIndex = columnas.findIndex(c => c && c.toLowerCase().includes("fecha registro"));

  // ============================
  // 🔎 BÚSQUEDA RÁPIDA PRINCIPAL
  // ============================
  document.getElementById("buscarRapido").addEventListener("keyup", aplicarFiltros);
  document.getElementById("buscarRapidoModal").addEventListener("keyup", aplicarFiltros);

  // Función para normalizar los nombres de las columnas
  function normalizeColumnName(name) {
    return name.toLowerCase().replace(/[\s\W]+/g, '_').replace(/^_|_$/g, '');
  }

  // ================================
  // 📌 BOTONES DINÁMICOS POR COLUMNA
  // ================================
  columnas.forEach((columna, index) => {
    if (!columna || columna.toLowerCase() === "acciones" || columna.toLowerCase() === "id_usuario") return;

    // 🟢 Botón especial Estado
    if (estadoIndex !== -1 && index === estadoIndex) {
      const btnEstado = document.createElement("button");
      btnEstado.textContent = "Todos";
      btnEstado.className = "btn btn-warning btn-sm me-2 mb-2 text-dark";
      btnEstado.dataset.estado = "todos";

      btnEstado.addEventListener("click", () => {
        if (btnEstado.dataset.estado === "activo") {
          btnEstado.dataset.estado = "inactivo";
          btnEstado.textContent = "Inactivos";
          btnEstado.className = "btn btn-danger btn-sm me-2 mb-2";
        } else if (btnEstado.dataset.estado === "inactivo") {
          btnEstado.dataset.estado = "todos";
          btnEstado.textContent = "Todos";
          btnEstado.className = "btn btn-warning btn-sm me-2 mb-2 text-dark";
        } else {
          btnEstado.dataset.estado = "activo";
          btnEstado.textContent = "Activos";
          btnEstado.className = "btn btn-success btn-sm me-2 mb-2";
        }
        aplicarFiltros();
      });
      botonesContainer.appendChild(btnEstado);
      return;
    }

    // 🟡 Botones especiales para N° Documento y Fecha de Registro
    if (index === numDocIndex || index === fechaRegistroIndex) {
      const btn = document.createElement("button");
      btn.textContent = columna;
      btn.className = "btn btn-outline-primary btn-sm me-2 mb-2";
      btn.dataset.index = index;

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
                            <label for="fecha-inicio" class="form-label">Desde:</label>
                            <input type="datetime-local" id="fecha-inicio" class="form-control mb-2 filtro-rango" data-col="${index}">
                            <label for="fecha-fin" class="form-label">Hasta:</label>
                            <input type="datetime-local" id="fecha-fin" class="form-control mb-2 filtro-rango" data-col="${index}">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="filtroDiaCompleto">
                                <label class="form-check-label" for="filtroDiaCompleto">
                                    Filtrar día completo
                                </label>
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
            input.addEventListener("change", aplicarFiltros);
            input.addEventListener("keyup", aplicarFiltros);
          });

          const checkbox = card.querySelector("#filtroDiaCompleto");
          if (checkbox) {
            checkbox.addEventListener("change", () => {
              const fechaInicioInput = card.querySelector("#fecha-inicio");
              const fechaFinInput = card.querySelector("#fecha-fin");

              if (checkbox.checked) {
                fechaInicioInput.type = "date";
                fechaFinInput.type = "date";
              } else {
                fechaInicioInput.type = "datetime-local";
                fechaFinInput.type = "datetime-local";
              }
              aplicarFiltros();
            });
          }
        } else if (acordeonExistente) {
          acordeonExistente.remove();
          aplicarFiltros();
        }
      });
      botonesContainer.appendChild(btn);
      return;
    }

    // 🟦 Botones normales con chips
    const btn = document.createElement("button");
    btn.textContent = columna;
    btn.className = "btn btn-outline-primary btn-sm me-2 mb-2";
    btn.dataset.index = index;

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
  // FUNCIÓN DE APLICAR FILTROS VISUALES
  // ============================
  function aplicarFiltros() {
    const chipsActivos = document.querySelectorAll(".chip.bg-primary");
    const rangoInputs = document.querySelectorAll(".filtro-rango");
    const btnEstado = botonesContainer.querySelector("button[data-estado]");
    const textoGlobal = document.getElementById("buscarRapido").value.toLowerCase();
    const textoModal = document.getElementById("buscarRapidoModal").value.toLowerCase();

    const chipsActivosPorColumna = {};
    chipsActivos.forEach(chip => {
      const accordionBody = chip.closest(".accordion-body");
      const colIndex = parseInt(accordionBody.querySelector(".filtro-columna").dataset.col, 10);
      if (!chipsActivosPorColumna[colIndex]) {
        chipsActivosPorColumna[colIndex] = new Set();
      }
      chipsActivosPorColumna[colIndex].add(chip.textContent.trim());
    });

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
        if (!valoresSeleccionados.has(valorCelda)) {
          visible = false;
          break;
        }
      }

      // Filtros de rango
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
        } else { // N° Documento o cualquier otro rango
          rangosActivos[colIndex].value = input.value;
        }
      });

      const filtroDiaCompleto = document.getElementById("filtroDiaCompleto");

      for (const colIndex in rangosActivos) {
        const celdaValor = fila.cells[colIndex]?.textContent.trim() || "";
        const filtro = rangosActivos[colIndex];

        if (colIndex == numDocIndex) {
          if (filtro.value && celdaValor !== filtro.value) {
            visible = false;
          }
        }

        if (colIndex == fechaRegistroIndex) {
          const celdaFecha = new Date(celdaValor.replace(" ", "T"));
          let fechaInicioFiltro = filtro.start ? new Date(filtro.start) : null;
          let fechaFinFiltro = filtro.end ? new Date(filtro.end) : null;

          if (filtroDiaCompleto && filtroDiaCompleto.checked) {
            if (fechaInicioFiltro) fechaInicioFiltro.setHours(0, 0, 0, 0);
            if (fechaFinFiltro) fechaFinFiltro.setHours(23, 59, 59, 999);
          }

          if (fechaInicioFiltro && celdaFecha < fechaInicioFiltro) {
            visible = false;
          }
          if (fechaFinFiltro && celdaFecha > fechaFinFiltro) {
            visible = false;
          }
        }
      }

      // Filtro de estado
      if (btnEstado && btnEstado.dataset.estado !== "todos") {
        const esperadoActivo = btnEstado.dataset.estado === "activo";
        if (estadoIndex !== -1) {
          const celdaEstado = fila.cells[estadoIndex];
          let filaEsActivo = false;
          if (celdaEstado) {
            const inputCheck = celdaEstado.querySelector("input[type='checkbox']");
            if (inputCheck) {
              filaEsActivo = inputCheck.checked;
            } else {
              const txt = celdaEstado.textContent.trim().toLowerCase();
              filaEsActivo = (txt === "1" || txt === "activo" || txt === "true");
            }
          }
          if (esperadoActivo && !filaEsActivo) visible = false;
          if (!esperadoActivo && filaEsActivo) visible = false;
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
      const btnEstado = botonesContainer.querySelector("button[data-estado]");
      const textoGlobal = document.getElementById("buscarRapido").value || document.getElementById("buscarRapidoModal").value;
      const filtroDiaCompleto = document.getElementById("filtroDiaCompleto");

      const params = new URLSearchParams();

      // Añadir filtros de texto globales
      if (textoGlobal) {
        params.append('search', textoGlobal);
      }

      // Añadir filtros de estado
      if (btnEstado && btnEstado.dataset.estado !== "todos") {
        params.append('estado', btnEstado.dataset.estado);
      }

      // Añadir filtros de chips
      const chipsPorColumna = {};
      chipsActivos.forEach(chip => {
        const accordionBody = chip.closest(".accordion-body");
        const colIndex = parseInt(accordionBody.querySelector(".filtro-columna").dataset.col, 10);
        const colName = normalizeColumnName(columnas[colIndex]);
        if (!chipsPorColumna[colName]) {
          chipsPorColumna[colName] = [];
        }
        chipsPorColumna[colName].push(chip.textContent.trim());
      });
      for (const colName in chipsPorColumna) {
        params.append(`filtro_${colName}`, chipsPorColumna[colName].join(','));
      }

      // Añadir filtros de rango de fechas y número de documento
      rangoInputs.forEach(input => {
        const colIndex = parseInt(input.dataset.col, 10);
        const colName = normalizeColumnName(columnas[colIndex]);
        if (input.value) {
          if (input.id.includes("fecha-inicio")) {
            params.append('fecha_inicio', input.value);
          } else if (input.id.includes("fecha-fin")) {
            params.append('fecha_fin', input.value);
          } else { // N° Documento o cualquier otro rango
            params.append(`filtro_${colName}`, input.value);
          }
        }
      });

      // Si el checkbox de día completo está activo, añadirlo a los parámetros
      if (filtroDiaCompleto && filtroDiaCompleto.checked) {
        params.append('diaCompleto', 'true');
      }

      // Redirección para generar el PDF
      const urlBase = "?views=usuarios&action=generateReportPDF";
      const urlFinal = urlBase + "&" + params.toString();

      // Abrir el PDF en la misma pestaña
      window.location.href = urlFinal;
    });
  }
});