<?php
$success_message = '';
if (isset($_SESSION['success_message'])) {
  $success_message = $_SESSION['success_message'];
  unset($_SESSION['success_message']);
}

$error_message = '';
if (isset($_SESSION['error_message'])) {
  $error_message = $_SESSION['error_message'];
  unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="es">

<body>
  <div class="app">
    <!-- Sidebar -->
    <nav aria-label="Menú de navegación" class="sidebar">
      <div class="logo">🥐</div>
      <ul>
        <li title="Inicio">
          <a href="<?php echo \config\APP_URL; ?>dashboard" class="nav-btn active" aria-label="Inicio">
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
          <button class="nav-btn" aria-label="Empleados" aria-expanded="false">
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
        <a href="<?php echo \config\APP_URL; ?>cargos/create" rel="noopener noreferrer"><button type="button" class="btn btn-primary">+ Nuevo cargo</button></a>
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
          <div class="stats">
            <div class="stat">
              <div>
                <div class="muted">Ventas hoy</div>
                <div class="kpi">$ 2.580</div>
              </div>
              <div class="icon"><i data-feather="bar-chart-2"></i></div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Pedidos</div>
                <div class="kpi">145</div>
              </div>
              <div class="icon"><i data-feather="shopping-cart"></i></div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Productos</div>
                <div class="kpi">38</div>
              </div>
              <div class="icon"><i data-feather="package"></i></div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Clientes</div>
                <div class="kpi">120</div>
              </div>
              <div class="icon"><i data-feather="users"></i></div>
            </div>
          </div>

          <!-- Tabla de cargos -->
          <div class="pedidos-container">
            <h2>Mis pedidos</h2>
            
            <div class="filter-buttons">
              <button class="active" onclick="filterTable('today')">Hoy</button>
              <button onclick="filterTable('week')">Esta semana</button>
            </div>
            
            <table id="pedidos-table" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Cargo</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once __DIR__ . '/../../autoload.php';
                use \models\CargoModel;

                $cargoModel = new CargoModel();
                $cargos = $cargoModel->getCargos();

                if ($cargos) {
                    foreach ($cargos as $cargo) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($cargo['NOMBRE_CARGO']) . "</td>";
                        echo "<td>" . ($cargo['ESTADO_CARGO'] ? 'Activo' : 'Inactivo') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No hay cargos disponibles.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          

          <!-- Charts -->
          <div class="grid grid-col-12">
            <div class="p-20" style="grid-column: span 12; height: 800px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                <strong>Ventas vs. Pedidos (semana)</strong>
                <span class="pill" style="background:#eef2ff; color:#3730a3;">Última semana</span>
              </div>
              <canvas id="barChart" style="width:100%; height:100%"></canvas>
            </div>
          </div>
        </section>

        <!-- Columna derecha -->
        <aside class="right grid">
          <div class="p-20">
            <div style="display:flex; align-items:center; gap:8px;">
              <i data-feather="calendar" style="color:var(--primary)"></i>
              <strong>Agenda</strong>
              <span class="pill" style="margin-left:auto;background:#eef2ff;color:#3730a3;">Jun</span>
            </div>
            <div class="calendar">
              <div class="d">L</div>
              <div class="d">M</div>
              <div class="d">M</div>
              <div class="d">J</div>
              <div class="d">V</div>
              <div class="d">S</div>
              <div class="d">D</div>
              <!-- simple 30 days -->
              <script>
                for (let i = 1; i <= 30; i++) document.write(`<button class="${i===26?'today':''}">${i}</button>`)
              </script>
            </div>
            <div class="list">
              <div class="li"><i data-feather="check-circle" style="color:#16a34a"></i>
                <div>
                  <div style="font-weight:600;">Entrega mayorista</div>
                  <div class="hero-note">26 Jun · 5:00 AM</div>
                </div>
              </div>
              <div class="li"><i data-feather="clock" style="color:#f59e0b"></i>
                <div>
                  <div style="font-weight:600;">Horneado de pandebono</div>
                  <div class="hero-note">26 Jun · 9:00 AM</div>
                </div>
              </div>
              <div class="li"><i data-feather="x-circle" style="color:#f43f5e"></i>
                <div>
                  <div style="font-weight:600;">Pedido cancelado</div>
                  <div class="hero-note">26 Jun · 11:45 AM</div>
                </div>
              </div>
            </div>
          </div>

          <div class="card p-20">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
              <strong>Top productos (mes)</strong>
            </div>
            <canvas id="pieChart" height="160"></canvas>
          </div>

          <div class="card p-20">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
              <strong>Tendencia de ventas (30 días)</strong>
            </div>
            <canvas id="lineChart" height="110"></canvas>
          </div>
        </aside>
      </div>

      <footer style="text-align:center; color:#64748b; font-size:13px; margin-top: 18px;">
        © <span id="year"></span> PANADERIA WYK-PROYECTO SENA
      </footer>
    </main>
  </div>

  <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <script>
    const successMessage = "<?php echo $success_message; ?>";
    const errorMessage = "<?php echo $error_message; ?>";
  </script>
  <!-- <script src="https://unpkg.com/feather-icons"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.lordicon.com/lordicon.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"
    integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
    crossorigin="anonymous">
  </script>
  <script src="<?php echo \config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>
</body>

</html>