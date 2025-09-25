document.addEventListener('DOMContentLoaded', () => {
    const switches = document.querySelectorAll('.check-trail');
    switches.forEach(switchElement => {
        const checkbox = switchElement.previousElementSibling;
        
        checkbox.addEventListener('change', async (event) => {
            const Id = event.target.dataset.id;
            const nuevoEstado = event.target.checked ? 1 : 0;

            const result = await Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Quieres ${nuevoEstado === 1 ? 'activar' : 'desactivar'} esta materia prima?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡cambiar estado!',
                cancelButtonText: 'Cancelar'
            });

            if (result.isConfirmed) {
                const url = `${APP_URL}materiasPrimas/updateState`;

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: Id,
                            estado: nuevoEstado
                        })
                    });

                    if (!response.ok) {
                        // Si la respuesta no es OK (ej. 404, 500), maneja el error.
                        const errorData = await response.json();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de Servidor',
                            text: errorData.error || `Error: ${response.status} ${response.statusText}`
                        });
                        event.target.checked = !event.target.checked;
                    } else {
                        // Si la respuesta es exitosa (código 200).
                        const data = await response.json();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: data.message
                        });
                    }
                } catch (error) {
                    console.error('Error en la petición fetch:', error);
                    // Si la petición falla por problemas de conexión.
                    event.target.checked = !event.target.checked;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor. Por favor, revisa la consola del navegador para más detalles.'
                    });
                }
            } else {
                // Si el usuario cancela, revierte el estado del switch.
                event.target.checked = !event.target.checked;
            }
        });
    });
});