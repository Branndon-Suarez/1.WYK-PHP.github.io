<!DOCTYPE html>
<html lang="es">
<title>Actualizar Materia Prima</title>

<body>
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="principal">
        <button type="button" class="volver" onclick="history.back()">
            <i data-feather="arrow-left"></i> Volver
        </button>

        <form id="update-matPrima-form" class="formulario" action="<?php echo \config\APP_URL; ?>materiasPrimas/update" method="POST">
            <h1>Actualizar Materia Prima</h1>

            <div class="grupo-formulario">
                <input type="hidden" id="id" name="id" value="<?php echo $materiaPrima['ID_MATERIA_PRIMA']; ?>" required>

                <div class="campo">
                    <label for="nombre">Nombre (Único)</label>
                    <div class="contenedor-input">
                        <input type="text" id="nombre" name="nombre" value="<?php echo $materiaPrima['NOMBRE_MATERIA_PRIMA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="valorUnit">Valor unitario</label>
                    <div class="contenedor-input">
                        <input type="number" id="valorUnit" name="valorUnit" value="<?php echo $materiaPrima['VALOR_UNITARIO_MAT_PRIMA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="fechVenc">Fecha Vencimiento</label>
                    <div class="contenedor-input">
                        <input type="date" id="fechVenc" name="fechVenc" value="<?php echo $materiaPrima['FECHA_VENCIMIENTO_MATERIA_PRIMA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="cantExist">Cantidad existente</label>
                    <div class="contenedor-input">
                        <input type="number" id="cantExist" name="cantExist" value="<?php echo $materiaPrima['CANTIDAD_EXIST_MATERIA_PRIMA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="presentacion">Presentación</label>
                    <div class="contenedor-input">
                        <input type="text" id="presentacion" name="presentacion" value="<?php echo $materiaPrima['PRESENTACION_MATERIA_PRIMA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <div class="contenedor-input">
                        <input type="text" id="descripcion" name="descripcion" value="<?php echo $materiaPrima['DESCRIPCION_MATERIA_PRIMA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="usuario_fk">Registrado por</label>
                    <div class="contenedor-input">
                        <input type="text" id="usuario_fk" name="usuario_fk" value="<?php echo $materiaPrima['USUARIO_REGISTRO']; ?>" readonly required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="estado">Estado</label>
                    <div class="contenedor-input">
                        <select id="estado" name="estado" required>
                            <option value="1" <?php echo $materiaPrima['ESTADO_MATERIA_PRIMA'] == 1 ? 'selected' : ''; ?> class="estado-activo">✓ Activo</option>
                            <option value="0" <?php echo $materiaPrima['ESTADO_MATERIA_PRIMA'] == 0 ? 'selected' : ''; ?> class="estado-inactivo">✗ Inactivo</option>
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
    <script src="<?php echo \config\APP_URL; ?>public/js/materiaPrima/materiaPrima.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/materiaPrima/confirmUpdate.js"></script>
</body>

</html>