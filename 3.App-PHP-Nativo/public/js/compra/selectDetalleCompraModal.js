document.addEventListener('DOMContentLoaded', function () {
    const detalleCompraModal = document.getElementById('detalleCompraModal'); 
    const detalleCompraBody = document.getElementById('detalleCompraBody');
    const compraTotalDisplay = document.getElementById('compraTotalDisplay');

    const modalTitle = document.getElementById('detalleCompraModalLabel');
    if (modalTitle) {
        modalTitle.textContent = 'Detalle de Compra';
    }
    
    const modalTableHead = detalleCompraModal.querySelector('.modal-body table thead tr');
    if (modalTableHead) {
        modalTableHead.innerHTML = `
            <th>Tipo</th>
            <th>Item</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        `;
    }

    detalleCompraModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const compraId = button.getAttribute('data-id-compra'); 
        
        // Inicializar
        detalleCompraBody.innerHTML = '<tr><td colspan="5" class="text-center">Cargando detalle de compra...</td></tr>';
        compraTotalDisplay.textContent = '...';

        // Realizar la petición AJAX al controlador de compras, usando la función corregida
        fetch(`${APP_URL}compras/getDetalleCompraAjax?id=${compraId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener el detalle de la compra.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.detalle.length > 0) {
                    detalleCompraBody.innerHTML = ''; 
                    let totalGeneral = 0;

                    data.detalle.forEach(item => {
                        // Formatear a moneda
                        const subTotalFormateado = new Intl.NumberFormat('es-CO', {
                            style: 'currency',
                            currency: 'COP',
                            minimumFractionDigits: 0
                        }).format(item.SUB_TOTAL);
                        const precioUnitarioFormateado = new Intl.NumberFormat('es-CO', {
                            style: 'currency',
                            currency: 'COP',
                            minimumFractionDigits: 0
                        }).format(item.PRECIO_UNITARIO);

                        // Se añaden las columnas para TIPO_ITEM y NOMBRE_ITEM
                        detalleCompraBody.innerHTML += `
                                <tr>
                                    <td>${item.TIPO_ITEM}</td>
                                    <td>${item.NOMBRE_ITEM}</td>
                                    <td>${item.CANTIDAD}</td>
                                    <td>${precioUnitarioFormateado}</td>
                                    <td>${subTotalFormateado}</td>
                                </tr>
                            `;
                        totalGeneral += parseInt(item.SUB_TOTAL);
                    });

                    // Muestra el total general de la compra
                    compraTotalDisplay.textContent = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 0
                    }).format(totalGeneral);

                } else {
                    detalleCompraBody.innerHTML = '<tr><td colspan="5" class="text-center">No se encontraron detalles para esta compra.</td></tr>';
                    compraTotalDisplay.textContent = 'N/A';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                detalleCompraBody.innerHTML = '<tr><td colspan="5" class="text-center">Error al cargar los datos.</td></tr>';
                compraTotalDisplay.textContent = 'Error';
            });
    });
});