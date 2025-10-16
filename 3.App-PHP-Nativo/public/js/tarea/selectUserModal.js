document.addEventListener('DOMContentLoaded', function () {
    const modalUsuarios = document.getElementById('modalUsuarios');
    const tablaUsuariosBody = document.querySelector('#tablaUsuariosModal tbody');
    let inputTargetId = '';
    let displayTargetId = '';

    // Maneja la apertura del modal y la carga de datos
    modalUsuarios.addEventListener('show.bs.modal', async function (event) {
        // Obtiene qué campos del formulario deben ser actualizados
        const button = event.relatedTarget;
        inputTargetId = button.getAttribute('data-input-target');
        displayTargetId = button.getAttribute('data-display-target');

        // Limpia la tabla antes de cargar nuevos datos
        tablaUsuariosBody.innerHTML = '';

        try {
            const response = await fetch(`${APP_URL}usuarios/getUsuariosAjax`);
            if (!response.ok) {
                throw new Error('Error al cargar los usuarios.');
            }
            const data = await response.json();

            if (data.success) {
                data.data.forEach(user => {
                    const row = `
                        <tr>
                            <td>${user.NOMBRE}</td>
                            <td>${user.NOMBRE_ROL}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info btn-seleccionar-usuario" 
                                    data-id="${user.ID_USUARIO}"
                                    data-nombre="${user.NOMBRE}">
                                    Seleccionar
                                </button>
                            </td>
                        </tr>
                    `;
                    tablaUsuariosBody.innerHTML += row;
                });
            } else {
                Swal.fire('Error', data.message || 'Error al obtener usuarios.', 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'No se pudo cargar la lista de usuarios. ' + error.message, 'error');
        }
    });

    // Maneja la selección de un usuario
    tablaUsuariosBody.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-seleccionar-usuario')) {
            const button = event.target;
            const userId = button.getAttribute('data-id');      // <-- Captura el ID del usuario
            const userName = button.getAttribute('data-nombre'); // <-- Captura el nombre del usuario

            // Actualiza los campos ocultos (ID) y de visualización (NOMBRE)
            document.getElementById(inputTargetId).value = userId;
            document.getElementById(displayTargetId).value = userName;

            // Cierra el modal
            const modal = bootstrap.Modal.getInstance(modalUsuarios);
            modal.hide();
        }
    });
});