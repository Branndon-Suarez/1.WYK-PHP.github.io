document.addEventListener("DOMContentLoaded", () => {
  const tabla = document.getElementById("tablaRoles");
  const filas = tabla.querySelectorAll("tbody tr");

  // ============================
  // 🔎 BÚSQUEDA RÁPIDA PRINCIPAL
  // ============================
  document.getElementById("buscarRapido").addEventListener("keyup", function() {
    const valor = this.value.toLowerCase();
    filas.forEach(fila => {
      fila.style.display = fila.textContent.toLowerCase().includes(valor) ? "" : "none";
    });
  });

  // =================================
  // 🔎 BÚSQUEDA RÁPIDA EN EL MODAL
  // =================================
  document.getElementById("buscarRapidoModal").addEventListener("keyup", function() {
    const valor = this.value.toLowerCase();
    filas.forEach(fila => {
      fila.style.display = fila.textContent.toLowerCase().includes(valor) ? "" : "none";
    });
  });

  // ================================
  // 📌 BOTONES DINÁMICOS POR COLUMNA
  // ================================
  const columnas = Array.from(tabla.querySelectorAll("thead th")).map(th => th.textContent.trim());
  const botonesContainer = document.getElementById("botonesColumnas");
  const accordion = document.getElementById("accordionFiltros");

  columnas.forEach((columna, index) => {
    const btn = document.createElement("button");
    btn.textContent = columna;
    btn.className = "btn btn-outline-primary btn-sm me-2 mb-2";
    btn.dataset.index = index;

    btn.addEventListener("click", () => {
      btn.classList.toggle("active"); // mantenerlo "oprimido"

      const acordeonId = `accordion-${columna}`;
      const acordeonExistente = document.getElementById(acordeonId);

      if (btn.classList.contains("active")) {
        // Crear acordeón
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

        // valores únicos de esa columna
        const valoresUnicos = [...new Set(
          Array.from(filas).map(f => f.cells[index].textContent.trim())
        )];

        const chipsContainer = card.querySelector(".chips-container");
        valoresUnicos.forEach(valor => {
          const chip = document.createElement("span");
          chip.textContent = valor;
          chip.className = "badge bg-secondary me-1 chip";
          chip.addEventListener("click", () => {
            chip.classList.toggle("bg-primary");
            aplicarFiltros();
          });
          chipsContainer.appendChild(chip);
        });

        // búsqueda interna del acordeón
        card.querySelector(".filtro-columna").addEventListener("keyup", function() {
          const valor = this.value.toLowerCase();
          Array.from(chipsContainer.querySelectorAll(".chip")).forEach(chip => {
            chip.style.display = chip.textContent.toLowerCase().includes(valor) ? "" : "none";
          });
        });

      } else if (acordeonExistente) {
        // eliminar acordeón si se desactiva
        acordeonExistente.remove();
        aplicarFiltros(); // actualizar filtros
      }
    });

    botonesContainer.appendChild(btn);
  });

  // ============================
  // FUNCIÓN DE APLICAR FILTROS
  // ============================
  function aplicarFiltros() {
    const chipsActivos = document.querySelectorAll(".chip.bg-primary");

    filas.forEach(fila => {
      let visible = true;
      chipsActivos.forEach(chip => {
        const colIndex = chip.closest(".accordion-body").querySelector(".filtro-columna").dataset.col;
        const valorCelda = fila.cells[colIndex].textContent.trim();
        if (chip.textContent !== valorCelda) visible = false;
      });
      fila.style.display = visible ? "" : "none";
    });
  }
});
