// En tu archivo toggleSwitches.js
document.addEventListener('DOMContentLoaded', () => {
    // Escucha los clics en cualquier switch
    const switches = document.querySelectorAll('.check-trail');
    switches.forEach(switchElement => {
        const checkbox = switchElement.previousElementSibling;
        
        checkbox.addEventListener('change', async (event) => {
            const cargoId = event.target.dataset.id;
            const nuevoEstado = event.target.checked ? 1 : 0;

            // Construye la URL de forma correcta
            const url = `${APP_URL}cargos/updateState`;

            // Envía la solicitud al controlador
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: cargoId,
                        estado: nuevoEstado
                    })
                });

                if (!response.ok) {
                    throw new Error('Error al actualizar el estado del cargo.');
                }

                const data = await response.json();
                console.log(data.message);
                
                // Aquí podrías mostrar un mensaje de éxito al usuario
                // toast.fire({ icon: 'success', title: data.message });

            } catch (error) {
                console.error('Error:', error);
                // Si hay un error, revertir el estado del switch
                event.target.checked = !event.target.checked;
                // Mostrar un mensaje de error al usuario
                // toast.fire({ icon: 'error', title: 'Hubo un problema. Inténtalo de nuevo.' });
            }
        });
    });
});