// External JS: usa la variable global APP_URL inyectada por la vista PHP.

let itemsSeleccionados = [];
let materiaPrimaDisponible = [];
let productosDisponibles = [];

// Elementos de la tabla de detalles
const tipoCompraSelect = document.getElementById("tipoCompra");
const tablaItemsBody = document.getElementById("tablaItemsCompra");
const totalGeneralEl = document.getElementById("totalGeneral");
const totalCompraHidden = document.getElementById("totalCompraHidden"); // Campo oculto para el total

// Elementos del modal y botones
const btnAddItem = document.getElementById("btnAddItem");
const btnGuardarCompra = document.getElementById("btnGuardarCompra");

// Modales de Compra (Referenciados desde la vista PHP)
const modalMateriaPrima = document.getElementById("modalMateriaPrima");
const listaMateriaPrima = document.getElementById("listaMateriaPrima");
const buscarMateriaPrima = document.getElementById("buscarMateriaPrima");
const btnCerrarModalMP = document.getElementById("btnCerrarModalMP");

const modalProductos = document.getElementById("modalProductos");
const listaProductos = document.getElementById("listaProductos");
const buscarProducto = document.getElementById("buscarProducto");
const btnCerrarModalProd = document.getElementById("btnCerrarModalProd");

// ------------------ FUNCIONES AUXILIARES DE MODALES ------------------

// Función para mostrar/ocultar los modales personalizados
const toggleModal = (modalElement, show) => {
    if (show) {
    modalElement.classList.remove('hidden');
    modalElement.setAttribute('aria-hidden', 'false');
    } else {
    modalElement.classList.add('hidden');
    modalElement.setAttribute('aria-hidden', 'true');
    }
};

const cerrarModales = () => {
    toggleModal(modalMateriaPrima, false);
    toggleModal(modalProductos, false);
};

// ------------------ INICIALIZACIÓN ------------------
document.addEventListener("DOMContentLoaded", () => {
    const fechaCompraInput = document.getElementById("fechaCompra");

    // 1. Establecer la fecha y hora actual al cargar
    if (fechaCompraInput && !fechaCompraInput.value) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        fechaCompraInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    // 2. Event Listeners para cerrar modales
    btnCerrarModalMP && btnCerrarModalMP.addEventListener("click", cerrarModales);
    btnCerrarModalProd && btnCerrarModalProd.addEventListener("click", cerrarModales);

    // 3. Listener principal para añadir ítem (abre el modal correcto)
    btnAddItem && btnAddItem.addEventListener("click", abrirModalItems);

    // 4. Listeners de búsqueda
    buscarMateriaPrima && buscarMateriaPrima.addEventListener("input", (e) => renderizarItems(e.target.value, 'MATERIA PRIMA'));
    buscarProducto && buscarProducto.addEventListener("input", (e) => renderizarItems(e.target.value, 'PRODUCTO TERMINADO'));

    // 5. Listener para guardar
    btnGuardarCompra && btnGuardarCompra.addEventListener("click", guardarCompra);

    // 6. Inicializar el manejo de tipo de compra (lógica copiada de la vista)
    tipoCompraSelect && tipoCompraSelect.addEventListener('change', manejarCambioTipo);
    // Ejecutar al inicio para asegurar el estado inicial
    const tipoItemDisplay = document.getElementById('tipoItemDisplay');
    if (tipoCompraSelect) {
        if (tipoCompraSelect.value) {
            tipoItemDisplay.textContent = tipoCompraSelect.value;
            btnAddItem.removeAttribute('disabled');
        } else {
            tipoItemDisplay.textContent = 'No Seleccionado';
            btnAddItem.setAttribute('disabled', 'true');
        }
    }
});

// ------------------ MANEJO DE TIPO DE COMPRA ------------------

function manejarCambioTipo() {
    const nuevoTipo = this.value;
    const tipoActual = document.getElementById('tipoItemDisplay').textContent;
    const tablaItemsBody = document.getElementById('tablaItemsCompra');

    if (tablaItemsBody.children.length > 0 && nuevoTipo !== tipoActual) {
        Swal.fire({
            title: '¿Cambiar Tipo de Compra?',
            text: `Si cambias a "${nuevoTipo}", se perderán todos los ítems agregados.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#933e0d',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar tipo'
        }).then((result) => {
            if (result.isConfirmed) {
                tablaItemsBody.innerHTML = ''; // Limpia la tabla
                itemsSeleccionados = []; // Limpia el array JS
                actualizarTabla(); // Recalcula el total
                actualizarBotonYDisplay(nuevoTipo);
            } else {
                // Revertir la selección
                this.value = tipoActual === 'No Seleccionado' ? '' : tipoActual;
            }
        });
    } else {
        actualizarBotonYDisplay(nuevoTipo);
    }
}

function actualizarBotonYDisplay(tipo) {
    const tipoItemDisplay = document.getElementById('tipoItemDisplay');
    if (tipo) {
        tipoItemDisplay.textContent = tipo;
        btnAddItem.removeAttribute('disabled');
    } else {
        tipoItemDisplay.textContent = 'No Seleccionado';
        btnAddItem.setAttribute('disabled', 'true');
    }
}

// ------------------ MODALES Y CARGA DE DATOS ------------------

function abrirModalItems() {
    const tipoSeleccionado = tipoCompraSelect.value;

    cerrarModales();

    if (tipoSeleccionado === 'MATERIA PRIMA') {
        toggleModal(modalMateriaPrima, true);
        if (materiaPrimaDisponible.length === 0) {
            cargarDatos('MATERIA PRIMA');
        } else {
            renderizarItems("", 'MATERIA PRIMA');
        }
    } else if (tipoSeleccionado === 'PRODUCTO TERMINADO') {
        toggleModal(modalProductos, true);
        if (productosDisponibles.length === 0) {
            cargarDatos('PRODUCTO TERMINADO');
        } else {
            renderizarItems("", 'PRODUCTO TERMINADO');
        }
    } else {
        Swal.fire('Atención', 'Por favor, seleccione el Tipo de Compra primero.', 'info');
    }
}

async function cargarDatos(tipo) {
    const endpoint = (tipo === 'MATERIA PRIMA') ? 'compras/listarMateriaPrimaAjax' : 'compras/listarProductosAjax';
    const targetList = (tipo === 'MATERIA PRIMA') ? listaMateriaPrima : listaProductos;

    targetList.innerHTML = `<tr><td colspan="5">Cargando ${tipo}...</td></tr>`;

    try {
        const url = APP_URL + endpoint;
        const res = await fetch(url, { cache: "no-store" });
        if (!res.ok) throw new Error('Error en la respuesta del servidor');
        const data = await res.json();

        const itemsMapeados = (Array.isArray(data) ? data : []).map(item => {
            if (tipo === 'MATERIA PRIMA') {
                return {
                    id: item.ID_MATERIA_PRIMA ?? null,
                    nombre: item.NOMBRE_MATERIA_PRIMA ?? '',
                    // 🚨 CORRECCIÓN: Usamos parseInt para asegurar que el precio sea entero.
                    precio_referencia: parseInt(item.VALOR_UNITARIO_MAT_PRIMA ?? 0, 10), 
                    // 🚨 CORRECCIÓN: Usamos parseInt para asegurar que la existencia sea entera.
                    existencia: parseInt(item.CANTIDAD_EXIST_MATERIA_PRIMA ?? 0, 10),
                    unidad: item.PRESENTACION_MATERIA_PRIMA ?? 'N/A' 
                };
            } else {
                return {
                    id: item.ID_PRODUCTO ?? null,
                    nombre: item.NOMBRE_PRODUCTO ?? '',
                    // 🚨 CORRECCIÓN: Usamos parseInt para asegurar que el precio sea entero.
                    precio_referencia: parseInt(item.VALOR_UNITARIO_PRODUCTO ?? 0, 10),
                    // 🚨 CORRECCIÓN: Usamos parseInt para asegurar que la existencia sea entera.
                    existencia: parseInt(item.CANT_EXIST_PRODUCTO ?? 0, 10),
                    unidad: 'N/A' 
                };
            }
        });

        if (tipo === 'MATERIA PRIMA') {
            materiaPrimaDisponible = itemsMapeados;
        } else {
            productosDisponibles = itemsMapeados;
        }

        renderizarItems("", tipo);
    } catch (err) {
        console.error(`Error cargando ${tipo}:`, err);
        targetList.innerHTML = `<tr><td colspan="5">Error cargando ${tipo}</td></tr>`;
    }
}

// Renderiza la lista de Materias Primas o Productos en el modal
function renderizarItems(filtro = "", tipo) {
    const data = (tipo === 'MATERIA PRIMA') ? materiaPrimaDisponible : productosDisponibles;
    const targetList = (tipo === 'MATERIA PRIMA') ? listaMateriaPrima : listaProductos;
    targetList.innerHTML = "";
    const filtroLow = (filtro || "").toLowerCase();

    const filtrados = data.filter(p => p.nombre.toLowerCase().includes(filtroLow));

    if (filtrados.length === 0) {
        targetList.innerHTML = `<tr><td colspan="5">No hay ${tipo.toLowerCase()} disponibles</td></tr>`;
        return;
    }
    
    filtrados.forEach(p => {
        const tr = document.createElement("tr");

        const tdNombre = document.createElement("td");
        tdNombre.textContent = p.nombre;
        
        // Columna secundaria para Unidad (MP) o Precio Venta (Prod)
        const tdSecundario = document.createElement("td");
        if (tipo === 'MATERIA PRIMA') {
            tdSecundario.textContent = p.unidad; // Muestra la unidad
        } else {
            // Producto terminado: Muestra el precio de venta como referencia
            // 🚨 CORRECCIÓN: Precio sin toFixed(2)
            tdSecundario.textContent = `$${p.precio_referencia}`; 
        }

        const tdAccion = crearBotonAgregar(p, tipo);
        
        if (tipo === 'MATERIA PRIMA') {
            const tdExistencia = document.createElement("td");
            tdExistencia.textContent = p.existencia;
            
            // Añadimos la columna de Precio
            const tdPrecio = document.createElement("td");
            // 🚨 CORRECCIÓN: Precio sin toFixed(2)
            tdPrecio.textContent = `$${p.precio_referencia}`; 
            
            tr.appendChild(tdNombre);
            tr.appendChild(tdSecundario); // Unidad
            tr.appendChild(tdPrecio);     // Precio Ref
            tr.appendChild(tdExistencia); // Stock
            tr.appendChild(tdAccion);
            
            targetList.appendChild(tr);

        } else {
            // Si es Producto Terminado, (TH: Nombre, Precio Venta, Stock Actual, Acción)
            const tdExistencia = document.createElement("td"); 
            tdExistencia.textContent = p.existencia; // Stock Actual

            tr.appendChild(tdNombre);
            tdSecundario.textContent = `$${p.precio_referencia}`; // Precio Venta (Sin decimales)
            tr.appendChild(tdSecundario); 
            tr.appendChild(tdExistencia); // Stock Actual
            tr.appendChild(tdAccion);
            
            targetList.appendChild(tr);
        }
    });
}

function crearBotonAgregar(p, tipo) {
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

    btn.addEventListener("click", () => agregarItem(p, tipo));
    tdAccion.appendChild(btn);
    return tdAccion;
}


// ------------------ AGREGAR ITEM A LA TABLA DE COMPRA ------------------

function agregarItem(item, tipo) {
    const itemTipoCorto = tipo === 'MATERIA PRIMA' ? 'MP' : 'PROD';
    const itemExistente = itemsSeleccionados.find(x => String(x.id) === String(item.id) && x.tipo === itemTipoCorto);

    if (itemExistente) {
        Swal.fire('Ya Agregado', `El ${tipo.toLowerCase()} ya está en la lista de compra. Edite la cantidad directamente.`, 'info');
    } else {
        itemsSeleccionados.push({
            id: item.id,
            nombre: item.nombre,
            tipo: itemTipoCorto, 
            cantidad: 1,
            // 🚨 CORRECCIÓN: El precio ya es un entero
            precio: item.precio_referencia 
        });
        actualizarTabla();
    }
    cerrarModales();
}

// ------------------ TABLA DE ITEMS SELECCIONADOS ------------------

function actualizarTabla() {
    tablaItemsBody.innerHTML = "";
    let total = 0;

    itemsSeleccionados.forEach((item, i) => {
        // 🚨 CORRECCIÓN: La subtotal se calcula con enteros (o se redondea si la cantidad viniera con decimales)
        const subtotal = Math.round(item.cantidad * item.precio);
        total += subtotal;

        const tr = document.createElement("tr");

        const tdTipo = document.createElement("td");
        tdTipo.textContent = item.tipo === 'MP' ? 'Materia Prima' : 'Producto';

        const tdNombre = document.createElement("td");
        tdNombre.textContent = item.nombre;

        // Campo Cantidad (Editable)
        const tdCantidad = document.createElement("td");
        const inputCantidad = document.createElement("input");
        inputCantidad.type = "number";
        inputCantidad.min = "1";
        inputCantidad.value = item.cantidad;
        inputCantidad.className = "input-cantidad-compra";
        inputCantidad.addEventListener("change", (e) => {
            // 🚨 CORRECCIÓN: Usamos parseInt para que la cantidad siempre sea entera
            let v = parseInt(e.target.value, 10);
            if (isNaN(v) || v < 1) v = 1;
            itemsSeleccionados[i].cantidad = v;
            actualizarTabla(); // Recalcula subtotal y total
        });
        tdCantidad.appendChild(inputCantidad);

        // 🚨 CAMBIO DE ESTRUCTURA Y ESTILO: Campo Precio Unitario (NO EDITABLE, se ve como texto de tabla)
        const tdPrecio = document.createElement("td");
        // 🚨 CORRECCIÓN: El valor se muestra directamente sin toFixed()
        tdPrecio.textContent = `$${item.precio}`; 
        // No necesita input, por lo que se verá como un campo normal de la tabla.
        
        // Subtotal
        const tdSubtotal = document.createElement("td");
        // 🚨 CORRECCIÓN: El valor se muestra directamente sin toFixed()
        tdSubtotal.textContent = `$${subtotal}`;

        // Acciones (Eliminar)
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
                text: "¡El ítem se eliminará de la lista!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    itemsSeleccionados.splice(i, 1);
                    actualizarTabla();
                    Swal.fire('¡Removido!', 'El ítem ha sido removido.', 'success');
                }
            });
        });
        tdAcciones.appendChild(btnEliminar);

        tr.appendChild(tdTipo);
        tr.appendChild(tdNombre);
        tr.appendChild(tdCantidad);
        tr.appendChild(tdPrecio); // Ahora es una simple celda <td>
        tr.appendChild(tdSubtotal);
        tr.appendChild(tdAcciones);

        tablaItemsBody.appendChild(tr);
    });

    // 🚨 CORRECCIÓN: El total se muestra como entero
    totalGeneralEl.textContent = Math.round(total);
    totalCompraHidden.value = Math.round(total);
}

// ------------------ GUARDAR COMPRA ------------------

async function guardarCompra(e) {
    e.preventDefault();

    const form = document.getElementById("formNuevaCompra");
    const formData = new FormData(form);

    // 🚨 CORRECCIÓN: El total se parsea como entero
    const total = parseInt(totalCompraHidden.value, 10);

    // 1. Validaciones
    if (itemsSeleccionados.length === 0) {
        Swal.fire('Sin Ítems', 'Debes añadir al menos un ítem a la compra.', 'warning');
        return;
    }
    
    // Validar que no haya precios en 0 o negativos 
    const itemsSinPrecioValido = itemsSeleccionados.filter(item => item.precio <= 0);
    if (itemsSinPrecioValido.length > 0) {
        Swal.fire('Precio Inválido', 'Uno o más ítems tienen un Precio Unitario de $0. Verifique el precio de referencia en el sistema.', 'error');
        return;
    }
    
    if (total <= 0 || isNaN(total)) {
        Swal.fire('Total Inválido', 'El total de la compra debe ser mayor a cero.', 'warning');
        return;
    }
    if (!formData.get('nombreProveedor') || !formData.get('marca') || !formData.get('telProveedor') || !formData.get('emailProveedor')) {
        Swal.fire('Datos Faltantes', 'Complete todos los campos del proveedor.', 'warning');
        return;
    }

    // 2. Mapear ítems para el backend (estructura DETALLE_COMPRA_...)
    const itemsParaEnviar = itemsSeleccionados.map(item => ({
        id: item.id,
        tipo: item.tipo, // 'MP' o 'PROD'
        cantidad: item.cantidad, // Ya es un entero
        precio_unitario: item.precio, // Ya es un entero
        subtotal: Math.round(item.cantidad * item.precio) // Subtotal entero
    }));

    // 3. Crear Payload para el Controller (JSON)
    const payload = {
        fecha: formData.get('fecha'),
        proveedorId: 1, 

        nombreProveedor: formData.get('nombreProveedor'),
        marca: formData.get('marca'),
        telProveedor: formData.get('telProveedor'),
        emailProveedor: formData.get('emailProveedor'),

        tipo: formData.get('tipo'), 
        estadoCompra: formData.get('estadoCompra'), 
        usuarioId: formData.get('usuarioId'),
        descripcion: formData.get('descripcion'),
        totalCompra: total, // Ya es un entero

        // Incluimos los detalles de los ítems
        items: itemsParaEnviar
    };

    // 4. Diálogo de confirmación
    Swal.fire({
        title: '¿Deseas finalizar la Compra?',
        text: "Una vez aceptada, la compra será registrada y el inventario actualizado.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            btnGuardarCompra.disabled = true;
            btnGuardarCompra.textContent = "Guardando...";

            try {
                const url = APP_URL + 'compras/create';
                console.log("➡️ Fetch guardar compra:", url, payload);

                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const json = await res.json();

                if (res.ok && json.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Compra guardada!',
                        text: `Compra ID ${json.idCompra} registrada correctamente.`,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // 🚨 Usamos history.back() si no hay URL de reporte definida
                        window.location.href = APP_URL + 'compras/reports'; 
                    });
                } else {
                    console.error("Respuesta del servidor:", json);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar',
                        text: "Error al guardar la compra: " + (json.message || JSON.stringify(json)),
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Aceptar'
                    });
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de red',
                    text: 'Error de red al guardar la compra.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Aceptar'
                });
            } finally {
                btnGuardarCompra.disabled = false;
                btnGuardarCompra.textContent = "✅ Guardar Compra";
            }
        }
    });
}
