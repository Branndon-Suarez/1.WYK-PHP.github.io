<!DOCTYPE html>
<html lang="es">

<body>
  <div class="app">
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <?php require_once __DIR__ . '/modalConsultas.php';
    ?>
    <main class="main">
      <!-- Topbar -->
      <header>
        <strong>PANADERIA WYK— Panel Control</strong>
        <div class="search">
          <lord-icon
              src="https://cdn.lordicon.com/vhdgmtyj.json"
              trigger="hover"
              stroke="bold"
              colors="primary:#933e0d"
              style="width:50px;height:50px">
          </lord-icon>
          <input id="buscarRapido" placeholder="Buscar…" />
          <button type="button" class="btn btn-ghost" data-bs-toggle="modal" data-bs-target="#filtroAvanzadoModal">
            <i data-feather="sliders" style="width:18px;height:18px;color:#94a3b8;"></i>
          </button>
        </div>
        <a href="<?php echo \config\APP_URL; ?>tareas/create" rel="noopener noreferrer"><button type="button" class="btn btn-primary">+ Nueva tarea</button></a>
      </header>

      <div class="layout">
        <section class="left">
          <!-- Hero -->
          <div class="hero">
            <div>
              <div class="hero-note">¡Buen día!</div>
              <h2>Bienvenido, <span style="color:var(--primary)"><?php echo $_SESSION['userName']; ?></span></h2>
              <div class="hero-note" style="font-style: 30px;">Que el aroma del pan recién horneado te acompañe hoy 🍞</div>
              <div style="margin-top:12px; display:flex; gap:10px;">
                <button class="btn btn-ghost">Ver agenda</button>
              </div>
            </div>
            <div class="illus">
              <div class="floaty"></div>
              <div class="bread">🥖</div>
              <div class="croissant">🥐</div>
            </div>
          </div>

          <!-- KPIs -->
          <section class="stats">
            <div class="stat">
              <div>
                <div class="muted">Tareas existentes</div>
                <div class="kpi"><?php echo $dashboardDataTareas['tareasExistentes']; ?></div>
              </div>
              <div class="icon">
                <lord-icon
                  src="https://cdn.lordicon.com/oqhqyeud.json"
                  trigger="hover"
                  stroke="bold"
                  colors="primary:#933e0d,secondary:#933e0d"
                  style="width:40px;height:40px">
                </lord-icon>
              </div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Tareas pendientes</div>
                <div class="kpi"><?php echo $dashboardDataTareas['tareasPendientes']; ?></div>
              </div>
              <div class="icon">
                <lord-icon
                  src="https://cdn.lordicon.com/oqhqyeud.json"
                  trigger="hover"
                  stroke="bold"
                  colors="primary:#933e0d,secondary:#933e0d"
                  style="width:40px;height:40px">
                </lord-icon>
              </div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Tareas completadas</div>
                <div class="kpi"><?php echo $dashboardDataTareas['tareasCopletadas']; ?></div>
              </div>
              <div class="icon">
                <lord-icon
                  src="https://cdn.lordicon.com/oqhqyeud.json"
                  trigger="hover"
                  stroke="bold"
                  colors="primary:#933e0d,secondary:#933e0d"
                  style="width:40px;height:40px">
                </lord-icon>
              </div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Tareas canceladas</div>
                <div class="kpi"><?php echo $dashboardDataTareas['tareasCanceladas']; ?></div>
              </div>
              <div class="icon">
                <lord-icon
                  src="https://cdn.lordicon.com/oqhqyeud.json"
                  trigger="hover"
                  stroke="bold"
                  colors="primary:#933e0d,secondary:#933e0d"
                  style="width:40px;height:40px">
                </lord-icon>
              </div>
            </div>
          </section><br><br>

          <!-- Tabla de Tareas -->
          <div class="section-reportes">
            <table id="tablaTareas" class="tabla-consultas">
              <tbody>
                <div class="table-header">
                  <strong>Tabla de Tareas</strong>
                  <div style="display:flex; gap:8px;">
                    <button id="generatePdfBtn" style="display:flex; align-items:center;" class="btn btn-ghost btp-personalizado">
                      <span>Generar PDF</span>
                      <lord-icon
                          src="https://cdn.lordicon.com/gyyhoycg.json"
                          trigger="hover"
                          stroke="bold"
                          colors="primary:#fff"
                          style="width:50px;height:50px">
                      </lord-icon>
                    </button>
                  </div>
                </div>
                <thead>
                  <tr>
                    <th>Tarea</th>
                    <th>Categoria</th>
                    <th>Descripción</th>
                    <th>Tiempo (horas)</th>
                    <th>Prioridad</th>
                    <th>Asignado a</th>
                    <th>Registrado por</th>
                    <th>Estado</th>
                    <th colspan="3" style="text-align:center">Acciones</th>
                  </tr>
                </thead>
                <?php

                if ($dashboardDataTareas['tareas']) {
                  foreach ($dashboardDataTareas['tareas'] as $tarea) {
                ?>
                    <tr>
                      <td> <?php echo htmlspecialchars($tarea['TAREA']); ?></td>
                      <td> <?php echo htmlspecialchars($tarea['CATEGORIA']); ?></td>
                      <td> <?php echo htmlspecialchars($tarea['DESCRIPCION']); ?></td>
                      <td> <?php echo htmlspecialchars($tarea['TIEMPO_ESTIMADO_HORAS']); ?></td>
                      <td> <?php echo htmlspecialchars($tarea['PRIORIDAD']); ?></td>
                      <td> <?php echo htmlspecialchars($tarea['USUARIO_ASIGNADO']); ?></td>
                      <td> <?php echo htmlspecialchars($tarea['USUARIO_CREADOR']); ?></td>
                      <td> <?php echo htmlspecialchars($tarea['ESTADO_TAREA']); ?></td>
                      <td>
                        <a href="<?php echo \config\APP_URL . 'tareas/viewEdit/' . htmlspecialchars($tarea['ID_TAREA']); ?>" class='btn btn-sm btn-primary btn-actualizar'>
                          <lord-icon
                            src="https://cdn.lordicon.com/ibckyoan.json"
                            trigger="hover"
                            colors="primary:#ffffff"
                            style="width:30px;height:30px">
                          </lord-icon>
                        </a>
                      </td>
                      <td><button data-id="<?= $tarea['ID_TAREA'] ?>" class='btn btn-sm btn-danger delete-tarea'>
                          <lord-icon
                            src="https://cdn.lordicon.com/oqeixref.json"
                            trigger="morph"
                            state="morph-trash-full"
                            colors="primary:#ffffff"
                            style="width:30px;height:30px">
                          </lord-icon>
                        </button></td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan='5' style="text-align:center;">No hay tareas disponibles.</td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
      </div>
      <?php require_once __DIR__ . '/../layouts/footers/footerDashboard.php'; ?>
    </main>

    <!-- LIBRERIAS -->
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"
      integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
      crossorigin="anonymous">
    </script>

    <!-- JS Toads y var global -->
    <script>
      const APP_URL = "<?php echo \config\APP_URL; ?>";

      const successMessage = "<?php echo $success_message; ?>";
      const errorMessage = "<?php echo $error_message; ?>";
    </script>
    <script src="<?php echo \config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>

    <!-- JS para CRUD -->
    <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script><!-- GRAFICAS -->
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/tarea/selectUserModal.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/tarea/confirmState.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/tarea/confirmDelete.js"></script>

    <!-- JS para busquedas personalizadas (y PDF) -->
    <script src="<?php echo \config\APP_URL; ?>public/js/tarea/busquedaFiltro.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/tarea/PDFgenerateFilter.js"></script>
</body>

</html>
