document.querySelectorAll('#ACTUALIZAR').forEach(button=>
    {
        button.addEventListener('click', function(event)
        {
            event.preventDefault();

            const swalWithBootstrapButtons = Swal.mixin
            ({
                customClass:
                {
                    confirmButton: "btn btn-success",//Clase proveniente de "sweet alert"
                    cancelButton: "btn btn-danger",//Clase proveniente de "sweet alert"
                    popup: "aviso_alerta",
                    title: "titulo_personalizado"
                },
            });

            swalWithBootstrapButtons.fire
            ({
                title: "¿Está seguro de ACTUALIZAR los datos del empleado?",
                text: "¿Está seguro de los datos actualizados?",
                color: "#202023",
                icon: "warning",
                iconColor: "#e11a1a",
                showCancelButton: true,
                confirmButtonText: "¡Sí, actualizar!",
                confirmButtonColor: "#218838",
                cancelButtonText: "¡No, cancelar!",
                cancelButtonColor: "#c82333",
                backdrop: '#1a8ee14f',
                allowOutsideClick: false,
                reverseButtons: true
            }).then((result) => 
            {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire
                    ({
                        title: "¡ACTUALIZADO!",
                        text: "Se actualizó con éxito los datos del empleado",
                        color: "#202023",
                        icon: "success",
                        iconColor: "#39bd39",
                        confirmButtonColor: "#218838",
                        backdrop: '#37cb414d',
                        allowOutsideClick: false
                    }).then(() => {
                    // Realiza la actualización si el usuario confirma
                    const form = document.querySelector('form[data-actu="form_actu"]');
                    form.submit();
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) 
                {
                    swalWithBootstrapButtons.fire
                    ({
                        title: "¡CANCELADO!",
                        text: "El registro del empleado NO fue actualizado",
                        color: "#202023",
                        icon: "error",
                        iconColor: "#e11a1a",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#218838",
                        backdrop: '#a6375568',
                        allowOutsideClick: false
                    });
                }
            });
        });
    });