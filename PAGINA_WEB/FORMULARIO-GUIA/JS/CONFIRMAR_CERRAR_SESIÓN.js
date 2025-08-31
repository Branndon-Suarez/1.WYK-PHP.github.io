document.querySelectorAll('#CERRAR_SESION').forEach(button => 
    {
        button.addEventListener('click', function(event) 
        {
            event.preventDefault(); // Previene el comportamiento predeterminado del botón
            
            const obtener_nom_usuario= button.getAttribute('data-nombre');
            
            const swalWithBootstrapButtons = Swal.mixin
            ({
                customClass: 
                {
                    /**NOTA: Las variables definidas a continuación deben llamarse así para que "sweet alert" reconozca a que nos referimos.
                     * En este caso, al boton de confirmar, eliminar y el contenido del aviso como tal
                     */
                    confirmButton: "btn btn-success",//Clase proveniente de "sweet alert"
                    cancelButton: "btn btn-danger",//Clase proveniente de "sweet alert"
                    popup: "aviso_alerta",
                    title: "titulo_personalizado"
                },
            });
            
            swalWithBootstrapButtons.fire
            ({
                /**NOTA: Aquí utilizo los backticks o plantillas literales `` y no las comas. Esto porque las comas dobles y las simples sólo reciben
                    *cadena de texto y no variables directamente. Para esto los `` ayudan a recibir expresiones incrustadas como LLAMAR UNA VARIABLE.
                    *LLAMAR UNA VARIABLE EN JS: ${nom_variable}
                */
                title: `${obtener_nom_usuario} está seguro(a) de cerrar sesión?`,
                color: "#202023",
                icon: "warning",
                iconColor: "#e11a1a",
                showCancelButton: true,
                confirmButtonText: "¡Sí!",
                cancelButtonText: "¡No!",
                backdrop: '#a6375568',
                boder: "3px",
                allowOutsideClick: false,
                reverseButtons: true
            }).then((result) => 
            {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire
                    ({
                        title: "HAS CERRADO SESIÓN CON ÉXITO!",
                        text: "Podrás iniciar sesión nuevamente en el menú",
                        color: "#202023",
                        icon: "success",
                        iconColor: "#39bd39",
                        backdrop: '#37cb414d',
                        allowOutsideClick: false,
                        /*En el caso que quiera que el modal se quite solo y sin necesidad del boton "OK"
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,*/
                    }).then(() => {
                    // Realiza la eliminación si el usuario confirma, después de que la animación haya terminado
                    window.location.href = "../0.INICIO_SESION/Index.php";
                    });
                }
                else if (result.dismiss === Swal.DismissReason.cancel) 
                {
                    swalWithBootstrapButtons.fire
                    ({
                        title: "¡CANCELADO!",
                        text: "No has cerrado la sesión",
                        color: "#202023",
                        icon: "error",
                        iconColor: "#e11a1a",
                        backdrop: '#a6375568',
                        allowOutsideClick: false
                    });
                }
            }); 

        });
    });