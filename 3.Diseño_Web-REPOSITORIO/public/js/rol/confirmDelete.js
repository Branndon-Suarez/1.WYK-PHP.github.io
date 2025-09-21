document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.delete-rol');
    deleteButtons.forEach(button => {
        button.addEventListener('click', async (event) => {
            const targetButton = event.target.closest('.delete-rol');
            const cargoId = targetButton.dataset.id;
            
            const result = await Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, ¡eliminar!',
                cancelButtonText: 'Cancelar'
            });

            if (result.isConfirmed) {
                const url = `${APP_URL}roles/delete`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: cargoId
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        Swal.fire('Error', data.error || 'No se pudo eliminar el rol.', 'error');
                    } else {
                        Swal.fire('¡Eliminado!', data.message, 'success')
                            .then(() => {
                                window.location.reload();
                            });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire('Error de Conexión', 'No se pudo conectar con el servidor.', 'error');
                }
            }
        });
    });
});