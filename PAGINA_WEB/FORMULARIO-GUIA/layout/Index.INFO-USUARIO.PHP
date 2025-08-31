<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DETALLES EMPLEADOS</title>
</head>
<body>
    <!---------------------------------------------------------------------- 🚀 Modal INFO EMPLEADOS ------------------------------------------------------------------------------->
    <div class="modal fade" id="modalInfousuario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalFormularioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="encabezado-modal">
                        <lord-icon
                            src="https://cdn.lordicon.com/szoiozyr.json"
                            trigger="loop"
                            delay="5000"
                            style="width:55px;height:55px">
                        </lord-icon><b>INFORMACIÓN PERSONAL</b></h2>
                    <button type="button" id="cerrar" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="contenedor-info-login" class="modal-body">   
                    <table id="TABLA_CONSULTAS_DETALLADAS" border="2">
                        <thead>
                            <tr id="h2_Consultas"><script src="https://cdn.lordicon.com/lordicon.js"></script>
                                <th colspan="7">
                                    <lord-icon
                                        src="https://cdn.lordicon.com/lsrcesku.json"
                                        trigger="loop"
                                        delay="5000"
                                        stroke="bold"
                                        style="width:50px;height:50px">
                                    </lord-icon><span>MI INFORMACIÓN PERSONAL</span>
                                </th>
                            </tr>
                                    
                            <tr id="Sub_Encabezado_Consultas">
                                <td>CÉDULA</td>
                                <td>USUARIO</td>
                                <td>NOMBRE</td>
                                <td>TELÉFONO</td>
                                <td>EMAIL</td>
                                <td>CARGO</td>
                                <td>ESTADO</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Papa de Forero</td>
                                <td>O-</td>
                                <td>3012602671</td>
                                <td>emial@gmail.com</td>
                                <td>ADMINISTRADOR</td>
                                <td>Activo</td>
                            </tr>
                        </tbody>
                    </table>
                    <!--🏁TERMINA TABLA MODAL-->
                </div>
                <!--FIN MODAL-BODY-->
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------- 🏁 Modal INFO EMEPLADOS ------------------------------------------------------------------------------->
</body>
</html>