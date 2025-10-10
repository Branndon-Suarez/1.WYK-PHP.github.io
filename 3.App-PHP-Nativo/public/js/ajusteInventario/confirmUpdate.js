document.getElementById('update-ajusteInventario-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;

    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Se actualizarán los datos de este ajuste de inventario.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData(form);

            fetch(APP_URL + 'ajusteInventario/update', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La respuesta de la red no fue exitosa');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message
                    }).then(() => {
                        window.location.href = APP_URL + 'ajusteInventario';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo contactar al servidor: ' + error.message
                });
            });
        }
    });
});