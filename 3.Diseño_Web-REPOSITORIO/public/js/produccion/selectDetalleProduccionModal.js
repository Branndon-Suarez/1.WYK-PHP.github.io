document.addEventListener('DOMContentLoaded', function () {
    const tabla = document.getElementById('tablaProducciones');
    const tbodyDetalle = document.getElementById('cuerpoTablaDetalleProduccion');
    const modal = new bootstrap.Modal(document.getElementById('detalleProduccionModal'));

    if (tabla) {
        tabla.addEventListener('click', function (e) {
            // Usamos el nuevo selector CSS
            const button = e.target.closest('.btn-detalle-produccion');

            if (button) {
                // Obtenemos el ID del nuevo atributo de datos
                const idProduccion = button.getAttribute('data-id-produccion');

                tbodyDetalle.innerHTML = '<tr><td colspan="3" style="text-align:center;">Cargando detalles...</td></tr>';

                fetch(APP_URL + 'produccion/getDetalleProduccionAjax?id=' + idProduccion)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error de red o ID de producción no encontrado.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.detalle.length > 0) {
                            let html = '';

                            data.detalle.forEach(item => {
                                html += `
                                    <tr>
                                        <td>${item.NOMBRE_ITEM || 'N/A'}</td>
                                        <td>${item.CANTIDAD || '0'} ${item.UNIDAD_MEDIDA || ''}</td>
                                        <td>${item.TIPO_ITEM || 'N/A'}</td>
                                    </tr>
                                `;
                            });
                            tbodyDetalle.innerHTML = html;
                            modal.show();
                        } else {
                            tbodyDetalle.innerHTML = '<tr><td colspan="3" style="text-align:center;">No se encontraron detalles para esta producción.</td></tr>';
                            Swal.fire('Error', data.message || 'No se encontraron detalles para esta producción.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener detalle:', error);
                        tbodyDetalle.innerHTML = '<tr><td colspan="3" style="text-align:center;">Error al cargar los datos.</td></tr>';
                        Swal.fire('Error', 'No se pudo cargar el detalle de la producción.', 'error');
                    });
            }
        });
    }
});