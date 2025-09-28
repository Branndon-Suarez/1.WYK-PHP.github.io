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

const fechaVentaInput = document.getElementById("fechaVenta"); // NUEVO: Obtener el input de fecha

if (!APP_URL) console.warn("APP_URL no está definida. Revisa la vista PHP.");

// ------------------ INICIALIZACIÓN ------------------
// Establecer la fecha y hora actual al cargar
document.addEventListener("DOMContentLoaded", () => {
    if (!fechaVentaInput.value) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        fechaVentaInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    }
});

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

            // Validar que la cantidad no exceda la existencia
            const productoExistente = productosDisponibles.find(prod => String(prod.id) === String(p.id));
            if (productoExistente && v > productoExistente.existencia) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock Insuficiente',
                    text: 'No hay más cantidad de este producto.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
                v = productoExistente.existencia;
                inputCantidad.value = v;
            }

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
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡El producto se eliminará de la lista de productos seleccionados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    productosSeleccionados.splice(i, 1);
                    actualizarTabla();
                    Swal.fire(
                        '¡Removido!',
                        'El producto ha sido removido.',
                        'success'
                    );
                }
            });
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
        td.colSpan = 4;
        td.textContent = "No hay productos";
        tr.appendChild(td);
        listaProductos.appendChild(tr);
        return;
    }

    filtrados.forEach(p => {
        const tr = document.createElement("tr");

        // NUEVO: Color de fila si el stock es bajo o cero
        if (p.existencia <= 5 && p.existencia > 0) {
            tr.classList.add("low-stock");
        } else if (p.existencia === 0) {
            tr.classList.add("no-stock");
        }

        const tdNombre = document.createElement("td");
        tdNombre.textContent = p.nombre;

        const tdPrecio = document.createElement("td");
        tdPrecio.textContent = `$${Number(p.precio).toFixed(0)}`;

        // NUEVA COLUMNA: Cantidad de existencia
        const tdExistencia = document.createElement("td");
        tdExistencia.textContent = p.existencia;

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
        btn.addEventListener("click", () => {
            // NUEVO: No permitir agregar si no hay stock
            if (p.existencia <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sin Stock',
                    text: 'No hay más cantidad de este producto.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                agregarProducto(p);
            }
        });
        tdAccion.appendChild(btn);

        tr.appendChild(tdNombre);
        tr.appendChild(tdPrecio);
        tr.appendChild(tdExistencia); // Añade la nueva celda
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
            precio: Number(item.valor_unitario_producto ?? item.VALOR_UNITARIO_PRODUCTO ?? 0),
            // Mapear la cantidad existente
            existencia: Number(item.cant_exist_producto ?? item.CANT_EXIST_PRODUCTO ?? 0)
        }));

        renderizarProductos();
    } catch (err) {
        console.error("Error cargando productos:", err);
        listaProductos.innerHTML = `<tr><td colspan="4">Error cargando productos</td></tr>`;
    }
}

// ------------------ AGREGAR PRODUCTO ------------------
function agregarProducto(p) {
    const existente = productosSeleccionados.find(x => String(x.id) === String(p.id));
    if (existente) {
        // Validar que no se exceda la existencia
        if (existente.cantidad >= p.existencia) {
            Swal.fire({
                icon: 'warning',
                title: 'Stock Insuficiente',
                text: 'No hay más cantidad de este producto.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
            return;
        }
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
btnGuardarPedido.addEventListener("click", () => {
    const fecha = document.getElementById("fechaVenta").value;
    const mesa = document.getElementById("numeroMesa").value || null;
    const estadoPedido = document.getElementById("estadoPedido").value;
    const estadoPago = document.getElementById("estadoPago").value;
    const descripcion = document.getElementById("descripcion").value || '';
    const usuarioId = (typeof USER_ID !== 'undefined') ? USER_ID : null;

    if (productosSeleccionados.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin Productos',
            text: 'Debes añadir al menos un producto.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
        return;
    }
    if (!usuarioId) {
        Swal.fire({
            icon: 'error',
            title: 'Error de Autenticación',
            text: 'Usuario no identificado. Vuelve a iniciar sesión.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    // Diálogo de confirmación antes de guardar
    Swal.fire({
        title: '¿Deseas finalizar la venta?',
        text: "Una vez aceptada, el pedido será registrado y el inventario actualizado.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const productosParaEnviar = productosSeleccionados.map(p => ({
                id: p.id,
                cantidad: Number(p.cantidad),
                precio: Number(p.precio)
            }));

            const total = Number(totalGeneralEl.textContent) || 0;

            const payload = {
                fecha,
                mesa,
                estadoPedido,
                estadoPago,
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
                    Swal.fire({
                        icon: 'success',
                        title: '¡Pedido guardado!',
                        text: "El pedido se ha guardado correctamente.",
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    console.error("Respuesta del servidor:", json);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar',
                        text: "Error al guardar el pedido: " + (json.message || JSON.stringify(json)),
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Aceptar'
                    });
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de red',
                    text: 'Error de red al guardar el pedido.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Aceptar'
                });
            } finally {
                btnGuardarPedido.disabled = false;
                btnGuardarPedido.textContent = "✅ Aceptar Pedido";
            }
        }
    });
});