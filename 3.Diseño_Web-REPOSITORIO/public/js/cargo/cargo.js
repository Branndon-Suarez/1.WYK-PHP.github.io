// Inicializa Feather (reemplaza los <i data-feather>)
    feather.replace();

    // ===== Utilidades =====
    const IVA_RATE = 0.19;

    const formatCurrency = (n) => {
      if (isNaN(n)) return '$0.00';
      return '$' + Number(n).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    };

    const parseCurrency = (str) => {
      if (!str) return 0;
      const num = String(str).replace(/[^0-9.-]+/g, '');
      return parseFloat(num) || 0;
    };

    // ===== Elementos =====
    const facturaForm = document.getElementById('formFactura');          // formulario
    const tbody = document.querySelector('#tablaFactura tbody');         // cuerpo de la tabla 

    // Totales globales (abajo)
    const subtotalGlobalEl = document.getElementById('subtotalGlobal');
    const ivaGlobalEl = document.getElementById('ivaGlobal');
    const totalGlobalEl = document.getElementById('totalGlobal');

    // Campos del formulario que calculan IVA/Total por factura (permiten digitar el subtotal)
    const inputSubtotal = document.getElementById('subtotal');
    const inputIva = document.getElementById('iva');
    const inputTotal = document.getElementById('total');

    // Calcula IVA y Total del formulario cuando el usuario digita el Subtotal
    const recalcularFormulario = () => {
      const sub = parseFloat(inputSubtotal.value) || 0;
      const iva = sub * IVA_RATE;
      const tot = sub + iva;
      inputIva.value = Number(iva.toFixed(2));
      inputTotal.value = Number(tot.toFixed(2));
    };

    // Añadimos listener sólo si existe el inputSubtotal
    if (inputSubtotal) inputSubtotal.addEventListener('input', recalcularFormulario);

    // --- Recalcular totales SOLO para un registro ---
    function recalcularTotalesIndividual(subtotal) {
      const iva = subtotal * 0.19;
      const total = subtotal + iva;

      // Mostrar en la caja de totales
      subtotalEl.textContent = formatCurrency(subtotal);
      ivaEl.textContent = formatCurrency(iva);
      totalEl.textContent = formatCurrency(total);
    }

    // --- Envío del formulario ---
    facturaForm.addEventListener('submit', (e) => {
      e.preventDefault();

      // Capturamos valores
      const descripcion = document.getElementById('descripcion').value.trim();
      const empleado = document.getElementById('empleado').value;
      const pedido = document.getElementById('pedido').value;
      const cliente = document.getElementById('cliente').value;
      const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
      const estado = document.getElementById('estado').value;
      const fecha = new Date().toISOString().slice(0, 16).replace("T", " ");

      if (!descripcion || subtotal <= 0) {
        alert('Ingrese datos válidos');
        return;
      }

      // Insertar fila
      agregarFila({ fecha, descripcion, empleado, pedido, cliente, estado, subtotal });

      // Recalcular solo con este subtotal
      recalcularTotalesIndividual(subtotal);

      // Limpiar formulario
      facturaForm.reset();
    });

    // ===== Agregar fila =====
    function agregarFila({ fecha, descripcion, empleado, pedido, cliente, estado, subtotal }) {
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td class="td-fecha">${fecha}</td>
      <td class="td-descripcion">${descripcion}</td>
      <td class="td-empleado">${empleado}</td>
      <td class="td-pedido">${pedido}</td>
      <td class="td-cliente">${cliente}</td>
      <td class="td-estado">${estado}</td>
      <td class="td-sub" style="text-align:right">${formatCurrency(subtotal)}</td>
      <td class="acciones" style="text-align:center">
        <button class="btn btn-warning btn-update" title="Actualizar"><i data-feather="edit-2"></i></button>
        <button class="btn btn-danger btn-delete" title="Eliminar"><i data-feather="trash-2"></i></button>
        <button class="btn btn-secondary btn-toggle" title="Desactivar/activar"><i data-feather="slash"></i></button>
      </td>
    `;
      tbody.appendChild(tr);

      feather.replace();

      recalcularTotalesGlobales();

    }

    // ===== Envío de formulario =====
    facturaForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const fechaRaw = document.getElementById('fecha').value;                         // datetime-local
      const fecha = fechaRaw ? fechaRaw.replace('T', ' ') : '';
      const descripcion = document.getElementById('descripcion').value.trim();
      const empleado = document.getElementById('empleado').value;
      const pedido = document.getElementById('pedido').value;
      const cliente = document.getElementById('cliente').value;
      const estado = document.getElementById('estado').value;
      const subtotal = parseFloat(inputSubtotal.value) || 0;

      if (!descripcion) return alert('Ingrese la descripción.');
      if (subtotal <= 0) return alert('Ingrese un subtotal válido.');

      agregarFila({ fecha, descripcion, empleado, pedido, cliente, estado, subtotal });

      // Limpiar y resetear cálculos del form
      facturaForm.reset();
      inputIva.value = '';
      inputTotal.value = '';
    });

    // ===== Acciones en la tabla (delegación) =====
    tbody.addEventListener('click', (e) => {
      const btn = e.target.closest('button');
      if (!btn) return;
      const tr = e.target.closest('tr');
      if (!tr) return;

      // Eliminar
      if (btn.classList.contains('btn-delete')) {
        if (confirm('¿Eliminar esta factura?')) {
          tr.remove();
          recalcularTotalesGlobales();
        }
        return;
      }

      // Desactivar (solo visual, no excluye del total)
      if (btn.classList.contains('btn-toggle')) {
        tr.classList.toggle('row-disabled');
        return;
      }

      // Actualizar (cambiar descripción y/o subtotal)
      if (btn.classList.contains('btn-update')) {
        const descCell = tr.querySelector('.td-descripcion');
        const subCell = tr.querySelector('.td-sub');

        const nuevaDesc = prompt('Nueva descripción:', descCell.textContent);
        if (nuevaDesc !== null) descCell.textContent = nuevaDesc;

        const nuevoSubStr = prompt('Nuevo subtotal:', parseCurrency(subCell.textContent));
        if (nuevoSubStr !== null) {
          const nuevoSub = parseFloat(nuevoSubStr);
          if (!isNaN(nuevoSub) && nuevoSub >= 0) {
            subCell.textContent = formatCurrency(nuevoSub);
            recalcularTotalesGlobales();
          } else {
            alert('Subtotal inválido.');
          }
        }
        return;
      }
    });

    // Iniciar totales en 0
    document.addEventListener('DOMContentLoaded', () => {
      recalcularFormulario();
      recalcularTotalesGlobales();
    });