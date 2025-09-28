<!DOCTYPE html>
<html lang="es">
<title>Actualizar Compra</title>

<body>
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="principal">

        <button type="button" class="volver" onclick="history.back()">
            <i data-feather="arrow-left"></i> Volver
        </button>

        <form id="update-compra-form" class="formulario" action="<?php echo \config\APP_URL; ?>compras/update" method="POST">
            <h1>Actualizar Compra</h1>

            <div class="grupo-formulario">
                <input type="hidden" id="idCompra" name="idCompra" value="<?php echo $compra['ID_COMPRA']; ?>" required>

                <div class="campo">
                    <label for="fecha">Fecha</label>
                    <div class="contenedor-input">
                        <input type="datetime-local" id="fecha" name="fecha" value="<?php echo $compra['FECHA_HORA_COMPRA']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="tipo">Tipo</label>
                    <div class="contenedor-input">
                        <input type="text" id="tipo" name="tipo" value="<?php echo $compra['TIPO']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="total">Total</label>
                    <div class="contenedor-input">
                        <input type="number" id="total" name="total" value="<?php echo $compra['TOTAL_COMPRA']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="proveedor">Proveedor</label>
                    <div class="contenedor-input">
                        <input type="text" id="proveedor" name="proveedor" value="<?php echo $compra['NOMBRE_PROVEEDOR']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="marca">Marca</label>
                    <div class="contenedor-input">
                        <input type="text" id="marca" name="marca" value="<?php echo $compra['MARCA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="tel">Teléfono</label>
                    <div class="contenedor-input">
                        <input type="number" id="tel" name="tel" value="<?php echo $compra['TEL_PROVEEDOR']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="email">Email</label>
                    <div class="contenedor-input">
                        <input type="email" id="email" name="email" value="<?php echo $compra['EMAIL_PROVEEDOR']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>


                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <div class="contenedor-input">
                        <input type="text" id="descripcion" name="descripcion" value="<?php echo $compra['DESCRIPCION_COMPRA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="estado">Estado de pago</label>
                    <div class="contenedor-input">
                        <select id="estado" name="estado" required>
                            <option value="<?php echo $compra['ESTADO_FACTURA_COMPRA']; ?>"><?php echo $compra['ESTADO_FACTURA_COMPRA']; ?></option>
                            <option value="PENDIENTE">PENDIENTE</option>
                            <option value="PAGADA">PAGADA</option>
                            <option value="CANCELADA">CANCELADA</option>
                        </select>
                        <div class="resalte-input"></div>
                    </div>
                </div>
            </div>

            <button type="submit">
                <i data-feather="refresh-cw" style="margin-right: 8px; width: 20px; height: 20px;"></i>
                Actualizar Compra
            </button>
        </form>

    </main>

    <div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="modalUsuariosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuariosLabel">Seleccionar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tablaUsuariosModal">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const APP_URL = '<?php echo \config\APP_URL; ?>';
    </script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/compra/confirmUpdate.js"></script>
</body>

</html>