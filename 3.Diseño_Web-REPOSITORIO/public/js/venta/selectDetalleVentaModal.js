
document.addEventListener('DOMContentLoaded', function () {
    const detalleVentaModal = document.getElementById('detalleVentaModal');
    const detalleVentaBody = document.getElementById('detalleVentaBody');
    const ventaTotalDisplay = document.getElementById('ventaTotalDisplay');

    detalleVentaModal.addEventListener('show.bs.modal', function (event) {
        // Botón que disparó el modal
        const button = event.relatedTarget;
        const ventaId = button.getAttribute('data-id-venta');

        // Realizar la petición AJAX
        fetch(`${APP_URL}ventas/getDetalleVentaAjax?id=${ventaId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener el detalle de la venta.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.detalle.length > 0) {
                    detalleVentaBody.innerHTML = ''; // Limpiar el mensaje de carga
                    let totalGeneral = 0;

                    data.detalle.forEach(item => {
                        // Formatear a moneda (opcional, si usas una librería o función)
                        const subTotalFormateado = new Intl.NumberFormat('es-CO', {
                            style: 'currency',
                            currency: 'COP',
                            minimumFractionDigits: 0
                        }).format(item.SUB_TOTAL);
                        const precioUnitarioFormateado = new Intl.NumberFormat('es-CO', {
                            style: 'currency',
                            currency: 'COP',
                            minimumFractionDigits: 0
                        }).format(item.VALOR_UNITARIO_PRODUCTO);

                        detalleVentaBody.innerHTML += `
                                <tr>
                                    <td>${item.NOMBRE_PRODUCTO}</td>
                                    <td>${item.CANTIDAD}</td>
                                    <td>${precioUnitarioFormateado}</td>
                                    <td>${subTotalFormateado}</td>
                                </tr>
                            `;
                        totalGeneral += parseInt(item.SUB_TOTAL);
                    });

                    // Muestra el total general de la venta
                    ventaTotalDisplay.textContent = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 0
                    }).format(totalGeneral);

                } else {
                    detalleVentaBody.innerHTML = '<tr><td colspan="4" class="text-center">No se encontraron detalles para esta venta.</td></tr>';
                    ventaTotalDisplay.textContent = 'N/A';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                detalleVentaBody.innerHTML = '<tr><td colspan="4" class="text-center">Error al cargar los datos.</td></tr>';
                ventaTotalDisplay.textContent = 'Error';
            });
    });
});
