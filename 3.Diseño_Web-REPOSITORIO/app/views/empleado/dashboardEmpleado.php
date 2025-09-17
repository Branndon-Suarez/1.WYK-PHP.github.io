<!DOCTYPE html>
<html lang="es">

<body>
  <div class="app">
    <!-- Sidebar -->
    <nav aria-label="Menú de navegación" class="sidebar">
      <div class="logo">🥐</div>
      <ul>
        <li title="Inicio">
          <a href="<?php echo \config\APP_URL; ?>dashboard" class="nav-btn" aria-label="Inicio">
            <lord-icon
              src="https://cdn.lordicon.com/oeotfwsx.json"
              colors="primary:#ffffff"
              trigger="hover"
              style="width:40px;height:40px">
            </lord-icon>
          </a>
        </li>

        <li class="has-submenu" title="Usuarios">
          <button class="nav-btn" aria-label="Usuarios" aria-expanded="false">
            <lord-icon
              src="https://cdn.lordicon.com/bushiqea.json"
              trigger="hover"
              colors="primary:#ffffff"
              style="width:45px;height:45px">
            </lord-icon>
          </button>
          <ul class="submenu">
            <li>
              <a href="<?php echo \config\APP_URL; ?>usuarios">
                <lord-icon
                  src="https://cdn.lordicon.com/bushiqea.json"
                  trigger="hover"
                  colors="primary:#ffffff"
                  style="width:45px;height:45px">
                </lord-icon>
                Usuarios Generales
              </a>
            </li>
            <li>
              <a href="<?php echo \config\APP_URL; ?>usuarios_empleados">
                <lord-icon
                  src="https://cdn.lordicon.com/yanwuwms.json"
                  trigger="hover"
                  colors="primary:#ffffff,secondary:#ffffff"
                  style="width:60px;height:60px">
                </lord-icon>
                Usuarios de Empleados
              </a>
            </li>
            <li>
              <a href="<?php echo \config\APP_URL; ?>usuarios_clientes">
                <lord-icon
                  src="https://cdn.lordicon.com/jdgfsfzr.json"
                  trigger="hover"
                  colors="primary:#ffffff,secondary:#ffffff"
                  style="width:60px;height:60px">
                </lord-icon>
                Usuarios de Clientes
              </a>
            </li>
          </ul>
        </li>

        <li class="has-submenu" title="Empleados">
          <button class="nav-btn active" aria-label="Empleados" aria-expanded="false">
            <lord-icon
              src="https://cdn.lordicon.com/yanwuwms.json"
              trigger="hover"
              colors="primary:#ffffff,secondary:#ffffff"
              style="width:50px;height:50px">
            </lord-icon>
          </button>
          <ul class="submenu">
            <li>
              <a href="<?php echo \config\APP_URL; ?>cargos">
                <lord-icon
                  src="https://cdn.lordicon.com/zhiiqoue.json"
                  trigger="morph"
                  state="morph-open"
                  colors="primary:#ffffff,secondary:#ffffff"
                  style="width:50px;height:50px">
                </lord-icon>
                Cargos
              </a>
            </li>
            <li>
              <a href="<?php echo \config\APP_URL; ?>empleados">
                <lord-icon
                  src="https://cdn.lordicon.com/yanwuwms.json"
                  trigger="hover"
                  colors="primary:#ffffff,secondary:#ffffff"
                  style="width:50px;height:50px">
                </lord-icon>
                Empleados
              </a>
            </li>
          </ul>
        </li>

        <li title="Clientes">
          <a href="<?php echo \config\APP_URL; ?>clientes" class="nav-btn" aria-label="Clientes">
            <lord-icon
              src="https://cdn.lordicon.com/jdgfsfzr.json"
              trigger="hover"
              colors="primary:#ffffff,secondary:#ffffff"
              style="width:50px;height:50px">
            </lord-icon>
          </a>
        </li>

        <li title="Pedidos">
          <a href="<?php echo \config\APP_URL; ?>pedidos" class="nav-btn" aria-label="Pedidos">
            <lord-icon
              src="https://cdn.lordicon.com/uisoczqi.json"
              trigger="hover"
              colors="primary:#ffffff,secondary:#ffffff"
              style="width:50px;height:50px">
            </lord-icon>
          </a>
        </li>

        <li class="has-submenu" title="Productos">
          <button class="nav-btn" aria-label="Productos" aria-expanded="false">
            <lord-icon
              src="https://cdn.lordicon.com/sbrvirwc.json"
              trigger="hover"
              colors="primary:#ffffff,secondary:#ffffff"
              style="width:50px;height:50px">
            </lord-icon>
          </button>
          <ul class="submenu">
            <li>
              <a href="<?php echo \config\APP_URL; ?>productos">
                <lord-icon
                  src="https://cdn.lordicon.com/sbrvirwc.json"
                  trigger="hover"
                  colors="primary:#ffffff,secondary:#ffffff"
                  style="width:50px;height:50px">
                </lord-icon>
                Productos
              </a>
            </li>
            <li>
              <a href="<?php echo \config\APP_URL; ?>materia_prima">
                <lord-icon
                  src="https://cdn.lordicon.com/jhiqqftv.json"
                  trigger="hover"
                  colors="primary:#ffffff,secondary:#ffffff"
                  style="width:50px;height:50px">
                </lord-icon>
                Materia Prima
              </a>
            </li>
            <li>
              <a href="<?php echo \config\APP_URL; ?>produccion">
                <lord-icon
                  src="https://cdn.lordicon.com/asyunleq.json"
                  trigger="hover"
                  state="hover-cog-4"
                  colors="primary:#ffffff"
                  style="width:40px;height:40px">
                </lord-icon>
                Producción
              </a>
            </li>
          </ul>
        </li>

        <li class="has-submenu" title="Facturas">
          <button class="nav-btn" aria-label="Facturas" aria-expanded="false">
            <lord-icon
              src="https://cdn.lordicon.com/yraqammt.json"
              trigger="hover"
              colors="primary:#ffffff"
              style="width:40px;height:40px">
            </lord-icon>
          </button>
          <ul class="submenu">
            <li>
              <a href="<?php echo \config\APP_URL; ?>facturas_Ventas">
                <lord-icon
                  src="https://cdn.lordicon.com/bsdkzyjd.json"
                  trigger="hover"
                  state="hover-spending"
                  colors="primary:#ffffff,secondary:#ffffff"
                  style="width:60px;height:60px">
                </lord-icon>
                Facturas de Ventas
              </a>
            </li>
            <li>
              <a href="<?php echo \config\APP_URL; ?>facturas_Compras">
                <lord-icon
                  src="https://cdn.lordicon.com/eeuqpnwy.json"
                  trigger="hover"
                  colors="primary:#ffffff"
                  style="width:60px;height:60px">
                </lord-icon>
                Facturas de Compras
              </a>
            </li>
          </ul>
        </li>

        <li title="Proveedores">
          <a href="<?php echo \config\APP_URL; ?>proveedores" class="nav-btn" aria-label="Proveedores">
            <lord-icon
              src="https://cdn.lordicon.com/byupthur.json"
              trigger="hover"
              colors="primary:#ffffff,secondary:#ffffff"
              style="width:50px;height:50px">
            </lord-icon>
          </a>
        </li>

        <div class="spacer"></div>

        <li title="Cerrar sesión">
          <a href="<?php echo \config\APP_URL; ?>logout" class="nav-btn" aria-label="Cerrar sesión">
            <lord-icon
              src="https://cdn.lordicon.com/vfiwitrm.json"
              trigger="hover"
              colors="primary:#ffffff,secondary:#ffffff"
              style="width:50px;height:50px">
            </lord-icon>
          </a>
        </li>
      </ul>
    </nav>

    <main class="main">
      <!-- Topbar -->
      <header>
        <strong>PANADERIA WYK— Panel Control</strong>
        <div class="search">
          <i data-feather="search" style="width:18px;height:18px;color:#94a3b8"></i>
          <input placeholder="Buscar…" />
        </div>
        <a href="<?php echo \config\APP_URL; ?>empleados/create" rel="noopener noreferrer"><button type="button" class="btn btn-primary">+ Nuevo Empleado</button></a>
      </header>

      <div class="layout">
        <section class="left">
          <!-- Hero -->
          <div class="hero">
            <div>
              <div class="hero-note">¡Buen día!</div>
              <h2>Bienvenido, <span style="color:var(--primary)"><?php echo $_SESSION['username']; ?></span></h2>
              <div class="hero-note">Que el aroma del pan recién horneado te acompañe hoy 🍞</div>
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
                <div class="muted">Empleados existentes</div>
                <div class="kpi"><?php echo $dashboardDataEmpleados['empleadosExistentes']; ?></div>
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
                <div class="muted">Empleados activos</div>
                <div class="kpi"><?php echo $dashboardDataEmpleados['empleadosActivos']; ?></div>
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
                <div class="muted">Empleados inactivos</div>
                <div class="kpi"><?php echo $dashboardDataEmpleados['empleadosInactivos']; ?></div>
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

          <!-- Tabla de empleados -->
          <div class="section-reportes">
            <table class="tabla-consultas">
              <tbody>
                <div class="table-header">
                  <strong>Tabla de Empleados</strong>
                  <div style="display:flex; gap:8px;">
                    <a href="<?php echo \config\APP_URL . 'empleados/generateReportPDF'; ?>" style="display:flex; align-items:center;" class="btn btn-ghost btp-personalizado">
                      <span>Generar PDF</span>
                      <lord-icon
                        src="https://cdn.lordicon.com/gyyhoycg.json"
                        trigger="hover"
                        stroke="bold"
                        colors="primary:#fff"
                        style="width:50px;height:50px">
                      </lord-icon>
                    </a>
                  </div>
                </div>
                <thead>
                  <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>RH</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Cargo</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th colspan="3" style="text-align:center">Acciones</th>
                  </tr>
                </thead>
                <?php

                if ($dashboardDataEmpleados['empleados']) {
                  foreach ($dashboardDataEmpleados['empleados'] as $empleado) {
                    $switchIdCargo = "switch_" . $empleado['ID_EMPLEADO'];
                    $estado = $empleado['ESTADO_EMPLEADO'] == 1 ? true : false;
                ?>
                    <tr>
                      <td> <?php echo htmlspecialchars($empleado['CC_EMPLEADO']); ?></td>
                      <td> <?php echo htmlspecialchars($empleado['NOMBRE_EMPLEADO']); ?></td>
                      <td> <?php echo htmlspecialchars($empleado['RH_EMPLEADO']); ?></td>
                      <td> <?php echo htmlspecialchars($empleado['TEL_EMPLEADO']); ?></td>
                      <td> <?php echo htmlspecialchars($empleado['EMAIL_EMPLEADO']); ?></td>
                      <td> <?php echo htmlspecialchars($empleado['NOMBRE_CARGO']); ?></td>
                      <td> <?php echo htmlspecialchars($empleado['NOMBRE_USUARIO']); ?></td>
                      <td>
                        <input id="<?php echo $switchIdCargo; ?>" type="checkbox" <?php echo $estado ? 'checked' : ''; ?>
                           data-id="<?php echo htmlspecialchars($empleado['ID_EMPLEADO']); ?>";>
                        <label for="<?php echo $switchIdCargo; ?>" class="check-trail">
                          <span class="check-handler"></span>
                        </label>
                      </td>
                      <td>
                        <a href="<?php echo \config\APP_URL . 'empleados/viewEdit/' . htmlspecialchars($empleado['ID_EMPLEADO']); ?>" class='btn btn-sm btn-primary btn-actualizar'>
                          <lord-icon
                              src="https://cdn.lordicon.com/ibckyoan.json"
                              trigger="hover"
                              colors="primary:#ffffff"
                              style="width:30px;height:30px">
                          </lord-icon>
                        </a>
                      </td>
                      <td><button data-id="<?= $empleado['ID_EMPLEADO'] ?>" class='btn btn-sm btn-danger delete-empleado'>
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
                  <tr><td colspan='5' style="text-align:center;">No hay empleados disponibles.</td></tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
      </div>
      <?php require_once __DIR__ . '/../layouts/footers/footerDashboard.php'; ?>
    </main>

  <!-- JS Toads y var global -->
  <script>
    const APP_URL = "<?php echo \config\APP_URL; ?>";

    const successMessage = "<?php echo $success_message; ?>";
    const errorMessage = "<?php echo $error_message; ?>";
  </script>
  <script src="<?php echo \config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>

  <!-- JS para CRUD -->
  <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script> <!-- GRAFICAS -->
  <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/empleado/confirmState.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/empleado/confirmDelete.js"></script>
  
  <!-- LIBRERIAS -->
  <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <!-- <script src="https://unpkg.com/feather-icons"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.lordicon.com/lordicon.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"
    integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
    crossorigin="anonymous">
  </script>
</body>

</html>
