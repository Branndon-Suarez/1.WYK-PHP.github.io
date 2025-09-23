// pedidosMesero.js 
// External JS: usa las variables globales APP_URL y USER_ID inyectadas por la vista PHP.

let productosSeleccionados = [];
let productosDisponibles = [];

const tablaProductos = document.getElementById("tablaProductos");
const totalGeneralEl = document.getElementById("totalGeneral");

const modal = document.getElementById("modalProductos");
const listaProductos = document.getElementById("listaProductos");
const buscarProducto = document.getElementById("buscarProducto");
const btnAddProducto = document.getElementById("btnAddProducto");
const btnCerrarModal = document.getElementById("btnCerrarModal");
const btnGuardarPedido = document.getElementById("btnGuardarPedido");

if (!APP_URL) console.warn("APP_URL no está definida. Revisa la vista PHP.");

// ------------------ TABLA (productos seleccionados) ------------------
function actualizarTabla() {
  tablaProductos.innerHTML = "";
  let total = 0;

  productosSeleccionados.forEach((p, i) => {
    const subtotal = p.cantidad * p.precio;
    total += subtotal;

    const tr = document.createElement("tr");

    const tdNombre = document.createElement("td");
    tdNombre.textContent = p.nombre;

    const tdCantidad = document.createElement("td");
    const inputCantidad = document.createElement("input");
    inputCantidad.type = "number";
    inputCantidad.min = "1";
    inputCantidad.value = p.cantidad;
    inputCantidad.className = "input-cantidad";
    inputCantidad.addEventListener("change", (e) => {
      let v = parseInt(e.target.value, 10);
      if (isNaN(v) || v < 1) v = 1;
      productosSeleccionados[i].cantidad = v;
      actualizarTabla();
    });
    tdCantidad.appendChild(inputCantidad);

    const tdPrecio = document.createElement("td");
    tdPrecio.textContent = `$${Number(p.precio).toFixed(0)}`;

    const tdSubtotal = document.createElement("td");
    tdSubtotal.textContent = `$${(subtotal).toFixed(0)}`;

    const tdAcciones = document.createElement("td");
    const btnEliminar = document.createElement("button");
    btnEliminar.className = "btn-rojo";
    btnEliminar.type = "button";
    btnEliminar.innerHTML = `
        <lord-icon
            src="https://cdn.lordicon.com/hfacemai.json"
            trigger="hover"
            stroke="light"
            colors="primary:#121331,secondary:#c71f16,tertiary:#ebe6ef"
            style="width:30px;height:30px">
        </lord-icon>`;
    btnEliminar.addEventListener("click", () => {
      productosSeleccionados.splice(i, 1);
      actualizarTabla();
    });
    tdAcciones.appendChild(btnEliminar);

    tr.appendChild(tdNombre);
    tr.appendChild(tdCantidad);
    tr.appendChild(tdPrecio);
    tr.appendChild(tdSubtotal);
    tr.appendChild(tdAcciones);

    tablaProductos.appendChild(tr);
  });

  totalGeneralEl.textContent = Number(total).toFixed(0);
}

// ------------------ MODAL ------------------
btnAddProducto.addEventListener("click", () => abrirModal());
btnCerrarModal.addEventListener("click", () => cerrarModal());

function abrirModal() {
  modal.classList.remove("hidden");
  if (productosDisponibles.length === 0) {
    cargarProductos();
  } else {
    renderizarProductos();
  }
}

function cerrarModal() {
  modal.classList.add("hidden");
}

// Renderiza la lista de productos en el modal
function renderizarProductos(filtro = "") {
  listaProductos.innerHTML = "";
  const filtroLow = (filtro || "").toLowerCase();

  const filtrados = productosDisponibles.filter(p => p.nombre.toLowerCase().includes(filtroLow));
  if (filtrados.length === 0) {
    const tr = document.createElement("tr");
    const td = document.createElement("td");
    td.colSpan = 3;
    td.textContent = "No hay productos";
    tr.appendChild(td);
    listaProductos.appendChild(tr);
    return;
  }

  filtrados.forEach(p => {
    const tr = document.createElement("tr");

    const tdNombre = document.createElement("td");
    tdNombre.textContent = p.nombre;

    const tdPrecio = document.createElement("td");
    tdPrecio.textContent = `$${Number(p.precio).toFixed(0)}`;

    const tdAccion = document.createElement("td");
    const btn = document.createElement("button");
    btn.className = "btn-verde";
    btn.innerHTML = `
        <lord-icon
            src="https://cdn.lordicon.com/ueoydrft.json"
            trigger="hover"
            stroke="light"
            style="width:30px;height:30px">
        </lord-icon>`;
    btn.type = "button";
    btn.addEventListener("click", () => agregarProducto(p));
    tdAccion.appendChild(btn);

    tr.appendChild(tdNombre);
    tr.appendChild(tdPrecio);
    tr.appendChild(tdAccion);

    listaProductos.appendChild(tr);
  });
}

// búsqueda en tiempo real
buscarProducto && buscarProducto.addEventListener("input", (e) => {
  renderizarProductos(e.target.value);
});

// ------------------ CARGAR PRODUCTOS DESDE BACKEND ------------------
async function cargarProductos() {
  try {
    const url = APP_URL + 'productos/listar';
    console.log("➡️ Fetch productos:", url);

    const res = await fetch(url, { cache: "no-store" });
    if (!res.ok) throw new Error('Error en la respuesta del servidor');
    const data = await res.json();

    productosDisponibles = (Array.isArray(data) ? data : []).map(item => ({
      id: item.id_producto ?? item.ID_PRODUCTO ?? null,
      nombre: item.nombre_producto ?? item.NOMBRE_PRODUCTO ?? '',
      precio: Number(item.valor_unitario_producto ?? item.VALOR_UNITARIO_PRODUCTO ?? 0)
    }));

    renderizarProductos();
  } catch (err) {
    console.error("Error cargando productos:", err);
    listaProductos.innerHTML = `<tr><td colspan="3">Error cargando productos</td></tr>`;
  }
}

// ------------------ AGREGAR PRODUCTO ------------------
function agregarProducto(p) {
  const existente = productosSeleccionados.find(x => String(x.id) === String(p.id));
  if (existente) {
    existente.cantidad = Number(existente.cantidad) + 1;
  } else {
    productosSeleccionados.push({
      id: p.id,
      nombre: p.nombre,
      precio: p.precio,
      cantidad: 1
    });
  }
  actualizarTabla();
  cerrarModal();
}

// ------------------ GUARDAR PEDIDO ------------------
btnGuardarPedido.addEventListener("click", async () => {
  const fecha = document.getElementById("fechaVenta").value;
  const mesa = document.getElementById("numeroMesa").value;
  const estado = document.getElementById("estadoVenta").value;
  const descripcion = document.getElementById("descripcion").value || '';
  const usuarioId = (typeof USER_ID !== 'undefined') ? USER_ID : null;

  if (!mesa) {
    alert("Por favor ingresa el número de mesa.");
    return;
  }
  if (productosSeleccionados.length === 0) {
    alert("Debes añadir al menos un producto.");
    return;
  }
  if (!usuarioId) {
    alert("Usuario no identificado. Vuelve a iniciar sesión.");
    return;
  }

  const productosParaEnviar = productosSeleccionados.map(p => ({
    id: p.id,
    cantidad: Number(p.cantidad),
    precio: Number(p.precio)
  }));

  const total = Number(totalGeneralEl.textContent) || 0;

  const payload = {
    fecha,
    mesa,
    estado,
    descripcion,
    usuarioId,
    productos: productosParaEnviar,
    total
  };

  btnGuardarPedido.disabled = true;
  btnGuardarPedido.textContent = "Guardando...";

  try {
    const url = APP_URL + 'pedidos/guardar';
    console.log("➡️ Fetch guardar pedido:", url, payload);

    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });

    const json = await res.json();

    if (res.ok && (json.success || json.idVenta)) {
      alert("Pedido guardado con éxito. ID venta: " + (json.idVenta ?? json.id));
      location.reload();
    } else {
      console.error("Respuesta del servidor:", json);
      alert("Error al guardar el pedido: " + (json.message || JSON.stringify(json)));
    }
  } catch (err) {
    console.error(err);
    alert("Error de red al guardar el pedido.");
  } finally {
    btnGuardarPedido.disabled = false;
    btnGuardarPedido.textContent = "✅ Aceptar Pedido";
  }
});
