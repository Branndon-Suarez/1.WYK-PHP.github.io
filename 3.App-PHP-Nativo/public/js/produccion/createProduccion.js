document.addEventListener('DOMContentLoaded', () => {
    // --- Variables Globales y Selectores ---
    const appUrl = (typeof APP_URL !== 'undefined') ? APP_URL : '/';
    const formNuevaProduccion = document.getElementById('formNuevaProduccion');
    const tablaBody = document.getElementById('tablaItemsProduccion');
    const btnGuardarProduccion = document.getElementById('btnGuardarProduccion');

    // Selectores de Campos Principales
    const inputProductoProducir = document.getElementById('inputProductoProducir');
    const idProductoProducir = document.getElementById('idProductoProducir');
    const cantidadProducida = document.getElementById('cantidadProducida');
    const nombreProduccion = document.getElementById('nombreProduccion');
    const descripcionProduccion = document.getElementById('descripcionProduccion');

    // Selectores del Modal de Producto
    const modalProducto = document.getElementById('modalSelectProducto');
    const searchProducto = document.getElementById('searchProducto');
    const productosTableBody = document.getElementById('productosTableBody');

    // Selectores del Modal de Materia Prima
    const modalMp = document.getElementById('modalAddMateriaPrima');
    const searchMateriaPrima = document.getElementById('searchMateriaPrima');
    const selectMateriaPrima = document.getElementById('selectMateriaPrima');
    const cantidadMateriaPrima = document.getElementById('cantidadMateriaPrima');
    const btnAgregarMPModal = document.getElementById('btnAgregarMPModal');
    const stockDisponibleMP = document.getElementById('stockDisponibleMP');
    const unidadPresentacion = document.getElementById('unidadPresentacion');
    const alertaStock = document.getElementById('alertaStock'); // Alerta de stock dentro del modal

    // Almacenamiento de Datos
    let itemsProduccion = [];
    let listaMateriaPrima = [];
    let listaProductos = [];

    // --- SweetAlert Función de Alerta ---
    const mostrarAlerta = (icon, title, text) => {
        Swal.fire({ icon, title, text, confirmButtonText: 'Aceptar' });
    };

    // --- Funciones de Utilidad ---

    const actualizarBotonGuardar = () => {
        const idProductoValido = idProductoProducir.value !== '';
        const cantidadValida = parseFloat(cantidadProducida.value) > 0;
        const nombreValido = nombreProduccion.value.trim() !== '';
        const mpAgregada = itemsProduccion.length > 0;

        btnGuardarProduccion.disabled = !(idProductoValido && cantidadValida && nombreValido && mpAgregada);
    };

    const renderItemsTable = () => {
        if (itemsProduccion.length === 0) {
            tablaBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center">Use el botón "Añadir Ítem" para agregar la Materia Prima utilizada.</td>
                </tr>
            `;
            actualizarBotonGuardar();
            return;
        }

        tablaBody.innerHTML = itemsProduccion.map((item, index) => {
            const itemOriginal = listaMateriaPrima.find(mp => mp.ID_MATERIA_PRIMA === item.id_materia_prima);
            const stockActual = itemOriginal ? parseFloat(itemOriginal.CANTIDAD_EXIST_MATERIA_PRIMA) : 0;

            const stockSuficiente = item.cantidad_requerida <= stockActual;
            const claseStock = stockSuficiente ? 'text-success' : 'text-danger fw-bold';
            const mensajeStock = stockSuficiente ? 'OK' : '¡INSUFICIENTE!';

            return `
                <tr data-id="${item.id_materia_prima}">
                    <td>${item.id_materia_prima}</td>
                    <td>${item.nombre_mp}</td>
                    <td>${item.cantidad_requerida.toFixed(2)}</td>
                    <td>${item.presentacion}</td>
                    <td class="${claseStock}" title="Stock Actual: ${stockActual}">${stockActual} (${mensajeStock})</td>
                    <td>
                        <button type="button" class="btn-eliminar-item btn-icon" data-index="${index}" title="Quitar Materia Prima">
                            <lord-icon
                                src="https://cdn.lordicon.com/hfacemai.json"
                                trigger="hover"
                                stroke="light"
                                colors="primary:#121331,secondary:#c71f16,tertiary:#ebe6ef"
                                style="width:30px;height:30px">
                            </lord-icon>
                        </button>
                        </td>
                </tr>
            `;
        }).join('');

        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        actualizarBotonGuardar();
    };

    // --- Lógica de Modales ---

    // 1. Modal de Producto

    const cargarProductosModal = async () => {
        productosTableBody.innerHTML = '<tr><td colspan="5" class="text-center">Cargando productos...</td></tr>';
        try {
            const response = await fetch(`${appUrl}produccion/listarProductosAjax`);

            // INTENTO DE SOLUCION AL ERROR JSON: Leer el texto de la respuesta primero
            const responseText = await response.text();

            let data;
            try {
                data = JSON.parse(responseText);
            } catch (jsonError) {
                // Si falla, significa que el servidor devolvió algo que no es JSON (ej. un error de PHP)
                console.error('Error al parsear JSON:', jsonError);
                console.error('Respuesta recibida:', responseText);
                mostrarAlerta('error', 'Error de Carga', 'No se pudo cargar la lista de productos. El servidor devolvió datos inválidos o un error. Revise la consola y el log del servidor.');
                productosTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error: Datos inválidos del servidor.</td></tr>';
                return;
            }

            if (data.success && data.productos.length > 0) {
                listaProductos = data.productos;
                renderProductosTable(listaProductos);
            } else {
                productosTableBody.innerHTML = '<tr><td colspan="5" class="text-center">No hay productos activos para producir.</td></tr>';
            }
        } catch (error) {
            console.error('Error al cargar productos (Fetch/Red):', error);
            productosTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error al cargar la lista de productos por un fallo de red o servidor.</td></tr>';
            mostrarAlerta('error', 'Error de Conexión', 'No se pudo conectar con el servidor para obtener los productos.');
        }
    };

    const renderProductosTable = (productos) => {
        productosTableBody.innerHTML = productos.map(prod => `
            <tr>
                <td>${prod.ID_PRODUCTO}</td>
                <td>${prod.NOMBRE_PRODUCTO}</td>
                <td>${prod.TIPO_PRODUCTO}</td>
                <td>${prod.CANT_EXIST_PRODUCTO}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-success btn-select-producto" data-id="${prod.ID_PRODUCTO}" data-nombre="${prod.NOMBRE_PRODUCTO}">
                        Seleccionar
                    </button>
                </td>
            </tr>
        `).join('');
    };

    // Evento de búsqueda de producto
    searchProducto.addEventListener('input', () => {
        const query = searchProducto.value.toLowerCase();
        const filtered = listaProductos.filter(prod =>
            prod.NOMBRE_PRODUCTO.toLowerCase().includes(query) ||
            prod.ID_PRODUCTO.toString().includes(query)
        );
        renderProductosTable(filtered);
    });

    // Evento de selección de producto
    productosTableBody.addEventListener('click', (e) => {
        if (e.target.closest('.btn-select-producto')) {
            const button = e.target.closest('.btn-select-producto');
            idProductoProducir.value = button.getAttribute('data-id');
            inputProductoProducir.value = button.getAttribute('data-nombre');

            const modalInstance = bootstrap.Modal.getInstance(modalProducto);
            if (modalInstance) modalInstance.hide();

            actualizarBotonGuardar();
        }
    });

    // Al abrir el modal, cargamos la lista de productos
    modalProducto.addEventListener('show.bs.modal', cargarProductosModal);


    // 2. Modal de Materia Prima (MP)

    const cargarMateriaPrimaModal = async () => {
        selectMateriaPrima.innerHTML = '<option value="" disabled selected>Cargando Materia Prima...</option>';
        try {
            const response = await fetch(`${appUrl}produccion/listarMateriaPrimaAjax`);
            listaMateriaPrima = await response.json();

            if (listaMateriaPrima.length > 0) {
                renderMateriaPrimaSelect(listaMateriaPrima);
            } else {
                selectMateriaPrima.innerHTML = '<option value="" disabled selected>No hay Materia Prima activa.</option>';
                mostrarAlerta('warning', 'Sin Stock', 'No se encontró Materia Prima activa. Regístrela primero.');
            }
        } catch (error) {
            console.error('Error al cargar la Materia Prima:', error);
            selectMateriaPrima.innerHTML = '<option value="" disabled selected>Error al cargar la Materia Prima.</option>';
            mostrarAlerta('error', 'Error de Carga', 'No se pudo conectar con el servidor para obtener la lista de Materia Prima.');
        }
    };

    const renderMateriaPrimaSelect = (mpList) => {
        selectMateriaPrima.innerHTML = '<option value="" disabled selected>Seleccione la Materia Prima</option>';
        mpList.forEach(mp => {
            selectMateriaPrima.innerHTML += `
                <option value="${mp.ID_MATERIA_PRIMA}" 
                        data-stock="${mp.CANTIDAD_EXIST_MATERIA_PRIMA}" 
                        data-unidad="${mp.PRESENTACION_MATERIA_PRIMA}" 
                        data-nombre="${mp.NOMBRE_MATERIA_PRIMA}">
                    ${mp.NOMBRE_MATERIA_PRIMA} (${mp.PRESENTACION_MATERIA_PRIMA})
                </option>
            `;
        });
    };

    // Evento de búsqueda de Materia Prima
    searchMateriaPrima.addEventListener('input', () => {
        const query = searchMateriaPrima.value.toLowerCase();
        const filtered = listaMateriaPrima.filter(mp =>
            mp.NOMBRE_MATERIA_PRIMA.toLowerCase().includes(query) ||
            mp.ID_MATERIA_PRIMA.toString().includes(query)
        );
        renderMateriaPrimaSelect(filtered);
    });

    // Evento al cambiar la selección de Materia Prima en el modal.
    selectMateriaPrima.addEventListener('change', () => {
        const selectedOption = selectMateriaPrima.options[selectMateriaPrima.selectedIndex];
        if (!selectedOption.value) return;

        const stock = parseFloat(selectedOption.getAttribute('data-stock'));
        const unidad = selectedOption.getAttribute('data-unidad');

        stockDisponibleMP.textContent = `${stock} ${unidad}`;
        unidadPresentacion.textContent = `Unidad de medida: ${unidad}`;
        alertaStock.textContent = '';
        cantidadMateriaPrima.value = '';
        btnAgregarMPModal.disabled = true;
        cantidadMateriaPrima.disabled = (stock <= 0);

        if (stock <= 0) {
            alertaStock.textContent = '¡No hay stock disponible de esta materia prima!';
        } else {
            // Activar la validación de la cantidad
            cantidadMateriaPrima.dispatchEvent(new Event('input'));
        }
    });

    // Evento de validación al ingresar la cantidad. (Lógica de stock y suma)
    cantidadMateriaPrima.addEventListener('input', () => {
        const cantidad = parseFloat(cantidadMateriaPrima.value);
        const selectedOption = selectMateriaPrima.options[selectMateriaPrima.selectedIndex];

        if (!selectedOption || !selectedOption.value || isNaN(cantidad) || cantidad <= 0) {
            btnAgregarMPModal.disabled = true;
            alertaStock.textContent = '';
            return;
        }

        const stock = parseFloat(selectedOption.getAttribute('data-stock'));
        const existingItem = itemsProduccion.find(item => item.id_materia_prima === parseInt(selectedOption.value));
        const cantidadYaAgregada = existingItem ? existingItem.cantidad_requerida : 0;
        const totalRequerido = cantidad + cantidadYaAgregada;
        const nombreMP = selectedOption.getAttribute('data-nombre');

        if (totalRequerido > stock) {
            alertaStock.textContent = `La cantidad total (${totalRequerido.toFixed(2)}) excede el stock disponible (${stock}).`;
            btnAgregarMPModal.disabled = true;

            // SweetAlert para la alerta de stock
            mostrarAlerta('warning', 'Stock Insuficiente',
                `No puedes utilizar ${cantidad.toFixed(2)} unidades más de ${nombreMP}. El stock disponible es ${stock} y ya has agregado ${cantidadYaAgregada} a esta producción.`
            );
        } else {
            alertaStock.textContent = '';
            btnAgregarMPModal.disabled = false;
        }
    });

    // Evento al hacer click en el botón "Agregar a Producción" del modal.
    btnAgregarMPModal.addEventListener('click', () => {
        const cantidad = parseFloat(cantidadMateriaPrima.value);
        const selectedOption = selectMateriaPrima.options[selectMateriaPrima.selectedIndex];

        // La validación de cantidad > stock se hace en el evento 'input'

        const id = parseInt(selectedOption.value);
        const nombre = selectedOption.getAttribute('data-nombre');
        const stock = parseFloat(selectedOption.getAttribute('data-stock'));
        const presentacion = selectedOption.getAttribute('data-unidad');

        // Agregar o sumar
        const existingIndex = itemsProduccion.findIndex(item => item.id_materia_prima === id);
        if (existingIndex !== -1) {
            itemsProduccion[existingIndex].cantidad_requerida += cantidad;
        } else {
            itemsProduccion.push({
                id_materia_prima: id,
                nombre_mp: nombre,
                cantidad_requerida: cantidad,
                stock_actual: stock,
                presentacion: presentacion
            });
        }

        // Limpiar modal y cerrar
        searchMateriaPrima.value = '';
        selectMateriaPrima.value = '';
        cantidadMateriaPrima.value = '';
        stockDisponibleMP.textContent = 'N/A';
        unidadPresentacion.textContent = '';
        alertaStock.textContent = '';
        btnAgregarMPModal.disabled = true;
        cantidadMateriaPrima.disabled = true;

        const modalInstance = bootstrap.Modal.getInstance(modalMp);
        if (modalInstance) modalInstance.hide();

        renderItemsTable();
        mostrarAlerta('success', '¡Ítem Agregado!', `${nombre} añadido con éxito.`);
    });

    // Al abrir el modal de MP, cargamos la lista
    modalMp.addEventListener('show.bs.modal', cargarMateriaPrimaModal);

    // --- Lógica de Eliminación y Envío ---

    tablaBody.addEventListener('click', (e) => {
        if (e.target.closest('.btn-eliminar-item')) {
            const button = e.target.closest('.btn-eliminar-item');
            const indexToRemove = parseInt(button.getAttribute('data-index'));
            // Obtenemos el nombre para el mensaje de SweetAlert
            const mpNombre = itemsProduccion[indexToRemove].nombre_mp;

            // INICIO DE CAMBIO: SweetAlert de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: `¡La Materia Prima "${mpNombre}" se eliminará de la lista de requerimientos!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Rojo para confirmar eliminación
                cancelButtonColor: '#3085d6', // Azul para cancelar
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lógica para eliminar el ítem
                    itemsProduccion.splice(indexToRemove, 1);
                    renderItemsTable();
                    Swal.fire(
                        '¡Removido!',
                        `${mpNombre} ha sido removido de la lista.`,
                        'success'
                    );
                }
            });
            // FIN DE CAMBIO
        }
    });

    formNuevaProduccion.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Validación de campos principales
        if (!nombreProduccion.value.trim() || !idProductoProducir.value || parseFloat(cantidadProducida.value) <= 0 || itemsProduccion.length === 0) {
            mostrarAlerta('warning', 'Datos Incompletos', 'Asegúrese de llenar el nombre, seleccionar un producto, ingresar la cantidad y agregar al menos una Materia Prima.');
            return;
        }

        // Recolección de datos
        const data = {
            nombreProduccion: nombreProduccion.value.trim(),
            idProducto: parseInt(idProductoProducir.value),
            cantidadProducida: parseInt(cantidadProducida.value),
            descripcion: descripcionProduccion.value,
            estado: 'PENDIENTE', // Fijo para la creación
            // ID_USUARIO_FK_PRODUCCION se obtendrá de la sesión en el backend
            detalles: itemsProduccion.map(item => ({
                id_materia_prima: item.id_materia_prima,
                cantidad_requerida: item.cantidad_requerida
            }))
        };

        Swal.fire({
            title: 'Guardando Producción...',
            text: 'Registrando y actualizando stocks. Por favor espere.',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        try {
            const response = await fetch(`${appUrl}produccion/create`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: result.message,
                    confirmButtonText: 'Ver Producciones'
                }).then(() => {
                    window.location.href = `${appUrl}produccion/reports`;
                });
            } else {
                mostrarAlerta('error', 'Error al Guardar', result.message || 'Ocurrió un error desconocido.');
            }

        } catch (error) {
            console.error('Error de red/servidor:', error);
            mostrarAlerta('error', 'Error de Conexión', 'No se pudo conectar con el servidor.');
        }
    });

    // --- Inicialización y Eventos de Validación ---

    nombreProduccion.addEventListener('input', actualizarBotonGuardar);
    cantidadProducida.addEventListener('input', actualizarBotonGuardar);

    renderItemsTable();
});