<!DOCTYPE html>
<html lang="es">

<body>
  <div class="app">
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <?php require_once __DIR__ . '/modalConsultas.php';
    ?>

    <?php
    $tareas = $dashboardDataVentas['tareas'] ?? [];
    $rol = $_SESSION['rol'] ?? '';

    if ($rol === 'MESERO' || $rol === 'CAJERO') {
      require_once __DIR__ . '/../layouts/floatingIcon.php';
    }
    ?>
    <main class="main">
      <!-- Lista de tareas para empleados -->
      <div class="tasks-panel" id="tasksPanel">
        <div class="tasks-header">
          <h2 class="tasks-title">Mis Tareas</h2>
          <button class="close-tasks-btn" id="closeTasksBtn">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div id="tareas-content" class="tasks-content-wrapper">
          <?php include 'app/views/tarea/viewTareaEmpleado.php'; ?>
        </div>
      </div>
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
        <a href="<?php echo \config\APP_URL; ?>pedidos" rel="noopener noreferrer"><button type="button" class="btn btn-primary">+ Nuevo pedido</button></a>
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

          <?php if ($_SESSION['rol'] == 'ADMINISTRADOR') {
          ?>
            <!-- KPIs -->
            <section class="stats">
              <div class="stat">
                <div>
                  <div class="muted">Ventas existentes</div>
                  <div class="kpi"><?php echo $dashboardDataVentas['ventasExistentes']; ?></div>
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
          <?php
          }
          ?>

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
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>N° Mesa</th>
                    <th>Descripción</th>
                    <th>Registrado por</th>
                    <?php if ($_SESSION['rol'] !== 'CAJERO') {
                    ?>
                    <th>Estado Pedido</th>
                    <?php
                    }
                    ?>
                    <th>Estado Venta</th>
                    <th colspan="3" style="text-align:center">Acciones</th>
                  </tr>
                </thead>
                <?php

                if ($dashboardDataVentas['ventas']) {
                  foreach ($dashboardDataVentas['ventas'] as $venta) {
                ?>
                    <tr>
                      <td> <?php echo htmlspecialchars($venta['FECHA_HORA_VENTA']); ?></td>
                      <td> <?php echo htmlspecialchars($venta['TOTAL_VENTA']); ?></td>
                      <td> <?php echo ($venta['NUMERO_MESA'] === null) ? 'No se usó' : htmlspecialchars($venta['NUMERO_MESA']); ?></td>
                      <td> <?php echo htmlspecialchars($venta['DESCRIPCION']); ?></td>
                      <td> <?php echo htmlspecialchars($venta['USUARIO_VENTA']); ?></td>
                        <?php if ($_SESSION['rol'] !== 'CAJERO') {
                        ?>
                          <td>
                          <?php echo htmlspecialchars($venta['ESTADO_PEDIDO']); ?>
                          </td>
                        <?php
                        }?>
                      <td> <?php echo htmlspecialchars($venta['ESTADO_PAGO']); ?></td>
                      <td>
                        <a href="<?php echo \config\APP_URL . 'ventas/viewEdit/' . htmlspecialchars($venta['ID_VENTA']); ?>" class='btn btn-sm btn-primary btn-actualizar'>
                          <lord-icon
                            src="https://cdn.lordicon.com/ibckyoan.json"
                            trigger="hover"
                            colors="primary:#ffffff"
                            style="width:30px;height:30px">
                          </lord-icon>
                        </a>
                      </td>
                      <td>
                        <button
                          type="button"
                          class='btn btn-sm btn-primary btn-detalle-venta'
                          data-bs-toggle="modal"
                          data-bs-target="#detalleVentaModal"
                          data-id-venta="<?= htmlspecialchars($venta['ID_VENTA']); ?>">
                          Detalle
                        </button>
                      </td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan='8' style="text-align:center;">No hay registros de ventas disponibles.</td>
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

    <div class="modal fade" id="detalleVentaModal" tabindex="-1" aria-labelledby="detalleVentaModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detalleVentaModalLabel">Detalle de Venta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody id="detalleVentaBody">
              </tbody>
            </table>
            <div class="text-end">
              <strong>Total General:</strong> <span id="ventaTotalDisplay"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

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
    <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/venta/selectDetalleVentaModal.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/venta/confirmDelete.js"></script>

    <!-- JS para busquedas personalizadas (y PDF) -->
    <script src="<?php echo \config\APP_URL; ?>public/js/venta/busquedaFiltro.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/venta/PDFgenerateFilter.js"></script>
</body>

</html>