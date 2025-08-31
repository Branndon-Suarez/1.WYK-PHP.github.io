/**NOTA: The JavaScript confirm() method is used to display(mostrar) a specific message on a 
         * dialogue window with the OK and Cancel options to confirm the user action. 
         * For dealing(controlar) with some CRUD operations, it is necessary to use a confirmation 
         * message instead(en vez de...) of directly applying an action.
        function confirmacion_Eliminar(Var_id_emple){
            if (confirm("¿Desea eliminar este registro del EMPLEADO?")){
                window.location.href="PROCESOS-EMPLEADO/Eliminar_1.1.EMPLEADO.PHP?Id_Emple="+ Var_id_emple;
            }
        }*/
            document.querySelectorAll('#ELIMINAR').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault(); // Previene el comportamiento predeterminado del botón
            
                    const id_obtenido_registro = this.getAttribute('data-id'); // Obtiene el ID del atributo data-id del botón
            
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
                            title: "¿Está seguro de ELIMINAR el registro del empleado?",
                            text: "¡No podrás revertir esto!",
                            color: "#202023",
                            icon: "warning",
                            iconColor: "#e11a1a",
                            showCancelButton: true,
                            showDenyButton: true,
                            confirmButtonText: "¡Sí, eliminar!",
                            denyButtonText: "¡Inhabilitar!",
                            denyButtonColor: "#f06e11",
                            cancelButtonText: "¡No, cancelar!",
                            backdrop: '#a6375568',
                            boder: "3px",
                            allowOutsideClick: false,
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                
                                /*"fetch" hace una petición al servidor y devuelve una promesa que se ejecuta en segundo plano hasta que es resuelta como true o false.*/
                                fetch(`PROCESOS-EMPLEADO/Eliminar_1.1.EMPLEADO.PHP?Id_Emple=${id_obtenido_registro}`, {method: 'GET'})

                                /*A continucación, se guarda la respuesta de la petición hecha por fetch y procesada en el archivo "Eliminar_1.1.EMPLEADO.PHP" 
                                en el "objeto_respuesta". Luego ".text()" convierte la respuesta que es un objeto en una cadena de texto.*/
                                .then(objeto_respuesta => objeto_respuesta.text())

                                /*Luego, se hace otra petición donde "data" guarda la cadena de texto recibida. Es decir, representa en texto la respuesta JSON que envió PHP.*/
                                .then(data => {
                                    
                                    try {
                                        /*Aqui, la funcón "JSON.parse" convierte la cadena JSON (texto) guardada en "data" en un objeto de JavaScript para poder usarlo en js.*/
                                        const jsonData = JSON.parse(data);
                
                                        if (jsonData.success) {
                                            // Si la eliminación fue exitosa
                                            swalWithBootstrapButtons.fire({
                                                title: "¡ELIMINADO!",
                                                text: "Se eliminó con éxito el registro del empleado.",
                                                color: "#202023",
                                                icon: "success",
                                                iconColor: "#39bd39",
                                                backdrop: '#37cb414d',
                                                allowOutsideClick: false
                                            }).then(() => {
                                                window.location.reload();
                                            });
                                        }
                                    } catch (error) {
                                        console.error("Error al procesar la respuesta:", error);
                                        swalWithBootstrapButtons.fire({
                                            title: "¡ERROR!",
                                            html: "<center>La cédula del empleado está <b>siendo usada</b> en otros registros. <br> Si no es posible eliminar puede <b>inhabilitar</b> este registro.</center>",
                                            color: "#202023",
                                            icon: "error",
                                            iconColor: "#e11a1a",
                                            backdrop: '#a6375568',
                                            allowOutsideClick: false
                                        });
                                    }
                                });
                            }
                            else if (result.isDenied) {
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
                                    title: "¿Desea INHABILITAR el registro del empleado?",
                                    icon: "warning",
                                    iconColor: "#e11a1a",
                                    showCancelButton: true,
                                    confirmButtonText: "¡Sí!",
                                    cancelButtonText: "¡No!",
                                    backdrop: '#f06e1160',
                                    boder: "3px",
                                    allowOutsideClick: false,
                                    reverseButtons: true
                                }).then((result_estado) => {
            
                                    if (result_estado.isConfirmed) {
                                        swalWithBootstrapButtons.fire
                                        ({
                                            title: "INHABILITADO!",
                                            text: "Se inhabilitó con éxito el registro del empleado.",
                                            color: "#202023",
                                            icon: "success",
                                            iconColor: "#39bd39",
                                            backdrop: '#37cb414d',
                                            allowOutsideClick: false
                                        }).then(() => {
                                            // Actualiza el estado a inhabilitado si el usuario confirma, después de que la animación haya terminado
                                            window.location.href = "PROCESOS-EMPLEADO/Estado_1.1.EMPLEADO.PHP?Id_Emple=" + id_obtenido_registro;
                                        });
                                    }
                                    else if (result_estado.dismiss === Swal.DismissReason.cancel) {
                                        swalWithBootstrapButtons.fire
                                        ({
                                            title: "¡CANCELADO!",
                                            text: "El registro del empleado NO fue inhabilitado.",
                                            color: "#202023",
                                            icon: "error",
                                            iconColor: "#e11a1a",
                                            backdrop: '#a6375568',
                                            allowOutsideClick: false
                                        });
                                    }
            
                                });
                            }
                            else if (result.dismiss === Swal.DismissReason.cancel) {
                                swalWithBootstrapButtons.fire
                                ({
                                    title: "¡CANCELADO!",
                                    text: "El registro del empleado NO fue eliminado.",
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