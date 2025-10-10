<!DOCTYPE html>
<html lang="es">
<title>Crear Tarea</title>

<body>
  <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

  <main class="principal">
    <button type="button" class="volver" onclick="history.back()">
      <i data-feather="arrow-left"></i> Volver
    </button>

    <form id="create-tarea-form" class="formulario" action="<?php echo \config\APP_URL; ?>tareas/create" method="POST">
      <h1>Crear Tarea</h1>

      <div class="grupo-formulario">
        <div class="campo">
          <label for="tarea">Tarea</label>
          <div class="contenedor-input">
            <input type="text" id="tarea" name="tarea" placeholder="Ingresa el nombre de la tarea" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="categoria">Categoría</label>
          <div class="contenedor-input">
            <input type="text" id="categoria" name="categoria" placeholder="Ingresa la categoría" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="descripcion">Descripción</label>
          <div class="contenedor-input">
            <input type="text" id="descripcion" name="descripcion" placeholder="Ingresa la descripción" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="tiempo">Tiempo (horas)</label>
          <div class="contenedor-input">
            <input type="number" id="tiempo" name="tiempo" placeholder="Ingresa el tiempo estimado" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="prioridad">Prioridad</label>
          <div class="contenedor-input">
            <select id="prioridad" name="prioridad" required>
              <option value="">Seleccione la prioridad</option>
              <option value="BAJA">BAJA</option>
              <option value="MEDIA">MEDIA</option>
              <option value="ALTA">ALTA</option>
            </select>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="usuario_asignado_display">Asignado a</label>
          <div class="input-group">
            <button type="button" class="btn btn-outline-secondary input-group-text boton-busqueda-cafe" data-bs-toggle="modal" data-bs-target="#modalUsuarios" data-input-target="user_asignado" data-display-target="usuario_asignado_display">
              <i data-feather="search"></i>
            </button>
            <input type="text" id="usuario_asignado_display" class="form-control" placeholder="Selecciona un usuario" readonly required>
            <input type="hidden" id="user_asignado" name="user_asignado">
          </div>
        </div>

        <div class="campo">
          <label for="estado_tarea">Estado</label>
          <div class="contenedor-input">
            <select id="estado_tarea" name="estado_tarea" required>
              <option value="">Seleccione un estado</option>
              <option value="PENDIENTE">PENDIENTE</option>
              <option value="COMPLETADA">COMPLETADA</option>
            </select>
            <div class="resalte-input"></div>
          </div>
        </div>
      </div>

      <button type="submit">
        <i data-feather="plus-circle" style="margin-right: 8px; width: 20px; height: 20px;"></i>
        Crear tarea
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/tarea/selectUserModal.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/tarea/confirmCreate.js"></script>
</body>

</html>