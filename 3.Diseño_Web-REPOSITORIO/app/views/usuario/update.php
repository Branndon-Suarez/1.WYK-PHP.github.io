<!DOCTYPE html>
<html lang="es">
<title>Actualizar Usuario</title>

<body>
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="principal">
        <button type="button" class="volver" onclick="history.back()">
            <i data-feather="arrow-left"></i> Volver
        </button>

        <form id="update-usuario-form" class="formulario" action="<?php echo \config\APP_URL; ?>usuarios/update" method="POST">
            <h1>Actualizar Usuario</h1>

            <div class="grupo-formulario">
                <input type="hidden" id="Id_Usuario" name="Id_Usuario" value="<?php echo $usuario['ID_USUARIO']; ?>" required>

                <div class="campo">
                    <label for="num_doc_usuario">N° Documento (Único)</label>
                    <div class="contenedor-input">
                        <input type="number" id="num_doc_usuario" name="num_doc_usuario" value="<?php echo htmlspecialchars($usuario['NUM_DOC']); ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="nom_usuario">Nombre (Único)</label>
                    <div class="contenedor-input">
                        <input type="text" id="nom_usuario" name="nom_usuario" value="<?php echo htmlspecialchars($usuario['NOMBRE']); ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="password_usuario">Contraseña</label>
                    <div class="contenedor-input">
                        <input type="password" id="password_usuario" name="password_usuario" value="<?php echo htmlspecialchars($usuario['PASSWORD_USUARIO']); ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="tel_usuario">Teléfono</label>
                    <div class="contenedor-input">
                        <input type="number" id="tel_usuario" name="tel_usuario" value="<?php echo htmlspecialchars($usuario['TEL_USUARIO']); ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="email_usuario">Email</label>
                    <div class="contenedor-input">
                        <input type="email" id="email_usuario" name="email_usuario" value="<?php echo htmlspecialchars($usuario['EMAIL_USUARIO']); ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="fech_Reg_usuario">Fecha Registro</label>
                    <div class="contenedor-input">
                        <input type="datetime-local" id="fech_Reg_usuario" name="fech_Reg_usuario" value="<?php echo htmlspecialchars($usuario['FECHA_REGISTRO']); ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="rol_fk">Rol</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary input-group-text boton-busqueda-cafe" id="select-rol-btn" data-bs-toggle="modal" data-bs-target="#modalRoles">
                            <i data-feather="search"></i>
                        </button>
                        <input type="text" id="rol_display" class="form-control" value="<?php echo htmlspecialchars($usuario['NOMBRE_ROL']); ?>" readonly required>
                        <input type="hidden" id="rol_fk" name="rol_fk" value="<?php echo htmlspecialchars($usuario['ROL_FK_USUARIO']); ?>">
                    </div>
                </div>

                <div class="campo">
                    <label for="Estado_Usuario">Estado</label>
                    <div class="contenedor-input">
                        <select id="Estado_Usuario" name="Estado_Usuario" required>
                            <option value="1" <?php echo $usuario['ESTADO_USUARIO'] == 1 ? 'selected' : ''; ?> class="estado-activo">✓ Activo</option>
                            <option value="0" <?php echo $usuario['ESTADO_USUARIO'] == 0 ? 'selected' : ''; ?> class="estado-inactivo">✗ Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit">
                <i data-feather="refresh-cw" style="margin-right: 8px; width: 20px; height: 20px;"></i>
                Actualizar Usuario
            </button>
        </form>

    </main>

    <div class="modal fade" id="modalRoles" tabindex="-1" aria-labelledby="modalRolesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRolesLabel">Seleccionar Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tablaRolesModal">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Rol</th>
                                    <th>Clasificación</th>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/usuario/usuario.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/usuario/confirmUpdate.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/usuario/selectRolModal.js"></script>
</body>

</html>