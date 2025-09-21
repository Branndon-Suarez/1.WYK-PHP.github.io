document.addEventListener("DOMContentLoaded", () => {
  const tabla = document.getElementById("tablaRoles");
  const filas = tabla.querySelectorAll("tbody tr");

  // ============================
  // 🔎 BÚSQUEDA RÁPIDA PRINCIPAL
  // ============================
  document.getElementById("buscarRapido").addEventListener("keyup", function () {
    aplicarFiltros(); // ahora usa la función unificada
  });

  // =================================
  // 🔎 BÚSQUEDA RÁPIDA EN EL MODAL
  // =================================
  document.getElementById("buscarRapidoModal").addEventListener("keyup", function () {
    aplicarFiltros(); // también usa la misma función
  });

  // ================================
  // 📌 BOTONES DINÁMICOS POR COLUMNA
  // ================================
  const columnas = Array.from(tabla.querySelectorAll("thead th")).map(th => th.textContent.trim());
  const botonesContainer = document.getElementById("botonesColumnas");
  const accordion = document.getElementById("accordionFiltros");

  // índice de la columna "Estado" si existe
  const estadoIndex = columnas.findIndex(c => c && c.toLowerCase().includes("estado"));

  columnas.forEach((columna, index) => {
    if (!columna || columna.toLowerCase() === "acciones" || columna.toLowerCase() === "id_rol") return;

    // 🟢 Botón especial Estado (3 estados)
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
        aplicarFiltros(); // aplicar siempre
      });

      botonesContainer.appendChild(btnEstado);
      return;
    }

    // 🟦 Botones normales (Rol, Categoría, etc.)
    const btn = document.createElement("button");
    btn.textContent = columna;
    btn.className = "btn btn-outline-primary btn-sm me-2 mb-2";
    btn.dataset.index = index;

    btn.addEventListener("click", () => {
      btn.classList.toggle("active");

      const acordeonId = `accordion-${columna}`;
      const acordeonExistente = document.getElementById(acordeonId);

      if (btn.classList.contains("active")) {
        const card = document.createElement("div");
        card.className = "accordion-item";
        card.id = acordeonId;

        card.innerHTML = `
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${columna}">
                            Filtrar por ${columna}
                        </button>
                    </h2>
                    <div id="collapse-${columna}" class="accordion-collapse collapse">
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
        });

        // búsqueda interna de chips
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
  // FUNCIÓN DE APLICAR FILTROS
  // ============================
  function aplicarFiltros() {
    const chipsActivos = document.querySelectorAll(".chip.bg-primary");
    const btnEstado = botonesContainer.querySelector("button[data-estado]");
    const textoGlobal = document.getElementById("buscarRapido").value.toLowerCase();
    const textoModal = document.getElementById("buscarRapidoModal").value.toLowerCase();

    filas.forEach(fila => {
      let visible = true;

      // 🔎 búsqueda global (entrada principal y modal, ambas deben coincidir si se usan)
      const textoFila = fila.textContent.toLowerCase();
      if (textoGlobal && !textoFila.includes(textoGlobal)) visible = false;
      if (textoModal && !textoFila.includes(textoModal)) visible = false;

      // 📌 filtros por chips
      chipsActivos.forEach(chip => {
        const accordionBody = chip.closest(".accordion-body");
        const colIndex = parseInt(accordionBody.querySelector(".filtro-columna").dataset.col, 10);
        const valorCelda = fila.cells[colIndex]?.textContent.trim() || "";
        if (chip.textContent !== valorCelda) visible = false;
      });

      // ✅ filtro de estado
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
});