<!DOCTYPE html>
<html lang="es">
<title>Actualizar Producto</title>

<body>
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="principal">
        <button type="button" class="volver" onclick="history.back()">
            <i data-feather="arrow-left"></i> Volver
        </button>

        <form id="update-producto-form" class="formulario" action="<?php echo \config\APP_URL; ?>productos/update" method="POST">
            <h1>Actualizar Producto</h1>

            <div class="grupo-formulario">
                <input type="hidden" id="Id_Prod" name="Id_Prod" value="<?php echo $producto['ID_PRODUCTO']; ?>" required>

                <div class="campo">
                    <label for="name_prod">Nombre (Único)</label>
                    <div class="contenedor-input">
                        <input type="text" id="name_prod" name="name_prod" value="<?php echo $producto['NOMBRE_PRODUCTO']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="valor_unit_prod">Valor unitario</label>
                    <div class="contenedor-input">
                        <input type="number" id="valor_unit_prod" name="valor_unit_prod" value="<?php echo $producto['VALOR_UNITARIO_PRODUCTO']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="cant_exist_prod">Cantidad existente</label>
                    <div class="contenedor-input">
                        <input type="number" id="cant_exist_prod" name="cant_exist_prod" value="<?php echo $producto['CANT_EXIST_PRODUCTO']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="fech_venc_prod">Fecha Vencimiento</label>
                    <div class="contenedor-input">
                        <input type="date" id="fech_venc_prod" name="fech_venc_prod" value="<?php echo $producto['FECHA_VENCIMIENTO_PRODUCTO']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="tipo_prod">Tipo</label>
                    <div class="contenedor-input">
                        <select id="tipo_prod" name="tipo_prod" required>
                            <option value="<?php echo $producto['TIPO_PRODUCTO']; ?>"><?php echo $producto['TIPO_PRODUCTO']; ?></option>
                            <option value="PANADERIA">PANADERIA</option>
                            <option value="PASTELERIA">PASTELERIA</option>
                            <option value="ASEO">ASEO</option>
                        </select>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="usuario_fk">Registrado por</label>
                    <div class="contenedor-input">
                        <input type="text" id="usuario_fk" name="usuario_fk" value="<?php echo $producto['USUARIO_REGISTRO']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="estado_producto">Estado</label>
                    <div class="contenedor-input">
                        <select id="estado_producto" name="estado_producto" required>
                            <option value="1" <?php echo $producto['ESTADO_PRODUCTO'] == 1 ? 'selected' : ''; ?> class="estado-activo">✓ Activo</option>
                            <option value="0" <?php echo $producto['ESTADO_PRODUCTO'] == 0 ? 'selected' : ''; ?> class="estado-inactivo">✗ Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit">
                <i data-feather="refresh-cw" style="margin-right: 8px; width: 20px; height: 20px;"></i>
                Actualizar Producto
            </button>
        </form>

    </main>

    <script>
        const APP_URL = '<?php echo \config\APP_URL; ?>';
    </script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/producto/producto.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/producto/confirmUpdate.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/producto/selectRolModal.js"></script>
</body>

</html>
