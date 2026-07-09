<?php
session_start();

if (
  !isset($_SESSION['usuario']) ||
  $_SESSION['tipo_persona'] != 'Administrativo'
) {
  header("Location: IniciarSesion.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Panel de Administración - Todo Incluido</title>

  <!-- Bootstrap, FontAwesome, ChartJS, Export libs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

  <style>
    :root {
      --primary: #0d6efd;
      --sidebar-bg: #343a40;
      --sidebar-hover: #495057;
      --sidebar-active: #0d6efd;
      --card-bg: #ffffff;
      --muted: #6c757d;
    }

    /* DARK THEME VARS (applied when body.dark) */
    body.dark {
      --primary: #4e73df;
      --sidebar-bg: #1f2428;
      --sidebar-hover: #2b3136;
      --card-bg: #111315;
      --muted: #aeb6bd;
      background: #0b0d0f;
      color: #e6eef6;
    }

    html,
    body {
      height: 100%;
      margin: 0;
      font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
      background: var(--card-bg);
    }

    /* SIDEBAR */
    #sidebar {
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      width: 250px;
      background: var(--sidebar-bg);
      color: #fff;
      z-index: 1100;
      transition: transform .28s ease, box-shadow .28s;
      box-shadow: 0 0 12px rgba(0, 0, 0, .12);
    }

    #sidebar.hidden {
      transform: translateX(-260px)
    }

    #sidebar .sidebar-header {
      padding: 16px;
      border-bottom: 1px solid rgba(255, 255, 255, .06);
      display: flex;
      align-items: center;
      justify-content: space-between
    }

    #sidebar .sidebar-header h3 {
      margin: 0;
      font-size: 1rem
    }

    #sidebar .close-sidebar {
      background: transparent;
      border: 0;
      color: inherit
    }

    #sidebar .components {
      padding: 12px 0;
      overflow: auto;
      height: calc(100vh - 220px)
    }

    #sidebar .components li a {
      display: block;
      padding: 10px 18px;
      color: rgba(255, 255, 255, .9);
      text-decoration: none;
      border-left: 3px solid transparent;
      transition: all .18s ease
    }

    #sidebar .components li a i {
      width: 20px;
      margin-right: 10px;
      text-align: center
    }

    #sidebar .components li a:hover {
      background: var(--sidebar-hover);
      color: #fff;
      border-left: 3px solid var(--sidebar-active)
    }

    #sidebar .components li.active>a {
      background: var(--sidebar-active);
      color: #fff;
      border-left: 3px solid #fff
    }

    /* Submenu improved */
    .has-submenu>.submenu-toggle {
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 18px;
      color: rgba(255, 255, 255, .9)
    }

    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height .28s ease;
      padding-left: 0;
      background: rgba(255, 255, 255, .02)
    }

    .submenu.show {
      max-height: 1000px;
      padding-top: 6px;
      padding-bottom: 6px
    }

    .submenu li a {
      padding: 10px 45px;
      display: block;
      color: rgba(255, 255, 255, .92)
    }

    .rotate-icon {
      transition: transform .28s ease
    }

    .has-submenu.open .rotate-icon {
      transform: rotate(90deg)
    }

    /* overlay */
    #overlaySidebar {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      z-index: 1050;
      opacity: 0;
      visibility: hidden;
      transition: opacity .18s ease, visibility .18s
    }

    #overlaySidebar.show {
      opacity: 1;
      visibility: visible
    }

    /* main content */
    #content {
      margin-left: 250px;
      padding: 18px;
      transition: margin-left .28s ease;
      min-height: 100vh;
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), transparent)
    }

    #content.fullwidth {
      margin-left: 0
    }

    .navbar {
      margin-bottom: 18px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, .06);
      background: var(--card-bg)
    }

    .card {
      border-radius: 10px;
      background: var(--card-bg);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04)
    }

    .stats-card {
      padding: 16px;
      color: #fff;
      text-align: center;
      border-radius: 10px
    }

    .bg-custom-primary {
      background: linear-gradient(45deg, #4e73df, #224abe)
    }

    .bg-custom-success {
      background: linear-gradient(45deg, #1cc88a, #13855c)
    }

    .bg-custom-info {
      background: linear-gradient(45deg, #36b9cc, #258391)
    }

    .bg-custom-warning {
      background: linear-gradient(45deg, #f6c23e, #dda20a)
    }

    .bg-custom-purple {
      background: linear-gradient(45deg, #6f42c1, #523592)
    }

    .bg-custom-pink {
      background: linear-gradient(45deg, #e83e8c, #c2176a)
    }

    .bg-custom-cyan {
      background: linear-gradient(45deg, #17a2b8, #117a8b)
    }

    /* Secciones de contenido */
    .content-section {
      display: none;
      animation: fadeIn 0.5s;
    }

    .content-section.active {
      display: block;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    /* responsive toggles - MEJORADO */
    #sidebarToggle {
      background: transparent;
      border: 0;
      color: var(--sidebar-bg);
      font-size: 1.15rem
    }

    @media (max-width:992px) {
      #sidebar {
        transform: translateX(-260px)
      }

      #sidebar.visible {
        transform: translateX(0)
      }

      #content {
        margin-left: 0
      }

      #overlaySidebar {
        display: block
      }
    }

    .table th {
      background-color: #4e73df;
      color: #fff
    }

    .section-title {
      border-left: 4px solid var(--primary);
      padding-left: 10px;
      margin: 14px 0
    }

    .small-muted {
      color: var(--muted);
      font-size: .9rem
    }

    /* search boxes */
    .search-input {
      max-width: 360px
    }

    /* toast container */
    #toasts {
      position: fixed;
      right: 18px;
      top: 18px;
      z-index: 2000;
    }

    /* subtle focus */
    a:focus,
    button:focus,
    input:focus {
      outline: 3px solid rgba(78, 115, 223, 0.12);
      outline-offset: 2px;
    }

    /* Export dropdown improvements */
    .export-dropdown .dropdown-menu {
      width: 200px;
    }

    .export-dropdown .dropdown-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .export-dropdown .dropdown-item i {
      width: 16px;
      text-align: center;
    }

    /* Mejoras adicionales */
    .sidebar-toggle-desktop {
      background: transparent;
      border: 0;
      color: var(--sidebar-bg);
      font-size: 1.15rem;
      transition: transform 0.3s ease;
    }

    .sidebar-toggle-desktop.rotated {
      transform: rotate(90deg);
    }

    .btn-action {
      transition: all 0.2s ease;
    }

    .btn-action:hover {
      transform: scale(1.05);
    }

    .stats-card {
      transition: transform 0.3s ease;
    }

    .stats-card:hover {
      transform: translateY(-5px);
    }

    .nav-tabs .nav-link {
      border: none;
      color: var(--muted);
      font-weight: 500;
    }

    .nav-tabs .nav-link.active {
      border-bottom: 3px solid var(--primary);
      color: var(--primary);
      background: transparent;
    }

    /* Botones de exportación mejorados */
    .export-buttons {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .export-buttons .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 100px;
      transition: all 0.3s ease;
      border-radius: 6px;
      font-weight: 500;
    }

    .export-buttons .btn i {
      margin-right: 6px;
    }

    .export-all-btn {
      background: linear-gradient(45deg, #6c757d, #495057);
      border: none;
      color: white;
    }

    .export-all-btn:hover {
      background: linear-gradient(45deg, #5a6268, #3d4449);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Estilos para las nuevas secciones */
    .action-buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .info-card {
      border-left: 4px solid #4e73df;
      background: var(--card-bg);
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .info-card.warning {
      border-left-color: #f6c23e;
    }

    .info-card.success {
      border-left-color: #1cc88a;
    }

    .info-card.purple {
      border-left-color: #6f42c1;
    }

    .quick-stats {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
      margin-bottom: 25px;
    }

    .quick-stat-item {
      background: var(--card-bg);
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      border-top: 4px solid #4e73df;
      transition: transform 0.3s ease;
    }

    .quick-stat-item:hover {
      transform: translateY(-5px);
    }

    .quick-stat-item .stat-icon {
      font-size: 2rem;
      margin-bottom: 10px;
      color: #4e73df;
    }

    .quick-stat-item .stat-value {
      font-size: 1.8rem;
      font-weight: bold;
    }

    .quick-stat-item .stat-label {
      font-size: 0.9rem;
      color: var(--muted);
    }

    /* Badge personalizados */
    .badge-status {
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    .badge-status.active {
      background-color: rgba(28, 200, 138, 0.2);
      color: #1cc88a;
    }

    .badge-status.upcoming {
      background-color: rgba(78, 115, 223, 0.2);
      color: #4e73df;
    }

    .badge-status.completed {
      background-color: rgba(108, 117, 125, 0.2);
      color: #6c757d;
    }

    .badge-status.cancelled {
      background-color: rgba(220, 53, 69, 0.2);
      color: #dc3545;
    }

    /* Filtros y búsqueda */
    .filters-container {
      background: var(--card-bg);
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      border: 1px solid rgba(0, 0, 0, 0.08);
    }

    /* Mejoras para tablas */
    .table-hover tbody tr {
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .table-hover tbody tr:hover {
      background-color: rgba(78, 115, 223, 0.05);
    }

    /* Panel de ayuda */
    .help-category {
      margin-bottom: 25px;
    }

    .help-category h5 {
      border-bottom: 2px solid var(--primary);
      padding-bottom: 8px;
      margin-bottom: 15px;
    }

    .help-item {
      margin-bottom: 12px;
      padding: 12px;
      background: var(--card-bg);
      border-radius: 8px;
      border-left: 3px solid var(--primary);
    }

    .help-item:hover {
      background: rgba(78, 115, 223, 0.05);
    }
  </style>
</head>

<body>
  <!-- Overlay (mobile) -->
  <div id="overlaySidebar" tabindex="-1" aria-hidden="true"></div>

  <!-- SIDEBAR -->
  <nav id="sidebar" aria-label="Sidebar">
    <div class="sidebar-header">
      <h3><i class="fas fa-gauge-high me-2"></i>Dashboard</h3>
      <div>
        <button id="themeToggle" class="btn btn-sm btn-outline-light me-2" title="Cambiar tema"><i class="fas fa-sun"></i></button>
        <button class="close-sidebar d-lg-none" id="closeSidebar" aria-label="Cerrar menú"><i class="fas fa-times"></i></button>
      </div>
    </div>

    <ul class="list-unstyled components">
      <li><a href="../cliente/PaginaInicio.php"><i class="fas fa-home"></i> Inicio</a></li>
      <li><a href="#"><i class="fas fa-chart-bar"></i> Estadísticas</a></li>
      <li><a href="../cliente/Calendario.php"><i class="fas fa-calendar-alt"></i> Calendario</a></li>
      <li><a href="../cliente/Panel_actividades.php"><i class="fas fa-tachometer-alt"></i> Panel de Actividades</a></li>

      <!-- Gestión -->
      <li class="has-submenu">
        <div class="submenu-toggle" aria-expanded="false">
          <span><i class="fas fa-folder-tree me-2"></i> Gestión</span>
          <i class="fas fa-chevron-right rotate-icon"></i>
        </div>
        <ul class="submenu list-unstyled">
          <li><a href="../cliente/usuarios.php"><i class="fas fa-users me-2"></i> Usuarios</a></li>
          <li><a href="../cliente/personas1.php"><i class="fas fa-id-card me-2"></i> Personas</a></li>
          <li><a href="#"><i class="fas fa-user-friends me-2"></i> Participantes</a></li>
        </ul>
      </li>

      <!-- Eventos y Actividades -->
      <li class="has-submenu">
        <div class="submenu-toggle" aria-expanded="false">
          <span><i class="fas fa-calendar-days me-2"></i> Eventos y Actividades</span>
          <i class="fas fa-chevron-right rotate-icon"></i>
        </div>

        <ul class="submenu list-unstyled">
          <li><a href="#"><i class="fas fa-calendar-check me-2"></i> Eventos</a></li>
          <li><a href="#"><i class="fas fa-tasks me-2"></i> Actividades</a></li>
          <li><a href="#"><i class="fas fa-church me-2"></i> Formación Sacramental</a></li>
          <li><a href="#"><i class="fas fa-user-plus me-2"></i> Inscripciones</a></li>
          <li><a href="#"><i class="fas fa-clipboard-check me-2"></i> Asistencias</a></li>
          <li><a href="#"><i class="fas fa-money-check-alt me-2"></i> Pagos</a></li>
        </ul>
      </li>

      <!-- Reportes -->
      <li class="has-submenu">
        <div class="submenu-toggle" aria-expanded="false">
          <span><i class="fas fa-chart-pie me-2"></i> Reportes</span>
          <i class="fas fa-chevron-right rotate-icon"></i>
        </div>

        <ul class="submenu list-unstyled">
          <li><a href="#"><i class="fas fa-calendar-days me-2"></i> Reporte de Eventos</a></li>
          <li><a href="#"><i class="fas fa-clipboard-list me-2"></i> Reporte de Actividades</a></li>
          <li><a href="#"><i class="fas fa-users-viewfinder me-2"></i> Reporte de Participantes</a></li>
          <li><a href="#"><i class="fas fa-place-of-worship me-2"></i> Reporte de Formación Sacramental</a></li>
          <li><a href="#"><i class="fas fa-square-check me-2"></i> Reporte de Asistencias</a></li>
          <li><a href="#"><i class="fas fa-file-invoice-dollar me-2"></i> Reporte de Pagos</a></li>
        </ul>
      </li>

      <!-- Improved submenu -->
      <li class="has-submenu">
        <div class="submenu-toggle" aria-expanded="false">
          <span><i class="fas fa-file-alt me-2"></i> Formularios</span>
          <i class="fas fa-chevron-right rotate-icon"></i>
        </div>
        <ul class="submenu list-unstyled">
          <li><a href="../cliente/actividades.php"><i class="fas fa-hands-helping me-2"></i> Actividades</a></li>
          <li><a href="../cliente/asistencias.php"><i class="fas fa-user-check me-2"></i> Asistencias</a></li>
          <li><a href="../cliente/eventos.php"><i class="fas fa-calendar-alt me-2"></i> Eventos</a></li>
          <li><a href="../cliente/inscripcion.php"><i class="fas fa-clipboard-list me-2"></i> Inscripción</a></li>
          <li><a href="../cliente/pagos.php"><i class="fas fa-credit-card me-2"></i> Pagos</a></li>
          <li><a href="../cliente/personas.php"><i class="fas fa-user-friends me-2"></i> Personas</a></li>
          <li><a href="../cliente/universidades.php"><i class="fas fa-university me-2"></i> Universidades</a></li>
          <li><a href="../cliente/usuarios_sistema.php"><i class="fas fa-user-cog me-2"></i> Usuario</a></li>
          <li><a href="../cliente/FormacionSacramental.php"><i class="fas fa-book-reader me-2"></i> Formación Sacramental</a></li>
        </ul>
      </li>


      <li data-section="mis-eventos"><a href="#"><i class="fas fa-calendar-check"></i> Mis Eventos</a></li>
      <li data-section="participantes"><a href="#"><i class="fas fa-users"></i> Participantes</a></li>
      <li data-section="reportes"><a href="#"><i class="fas fa-chart-bar"></i> Reportes</a></li>
      <li data-section="ayuda"><a href="#"><i class="fas fa-question-circle"></i> Ayuda</a></li>
    </ul>

    <div class="p-3 text-white mt-auto">
      <div class="d-flex align-items-center">
        <img src="https://ui-avatars.com/api/?name=Admin+User&background=0D8ABC&color=fff" class="rounded-circle" width="40" height="40" alt="Usuario">
        <div class="ms-3">
          <h6 class="mb-0">Administrador</h6>
          <small class="small-muted">Favio@gmail.com</small>
        </div>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <div id="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid d-flex align-items-center">
        <button id="sidebarToggle" class="me-3 btn sidebar-toggle-desktop" aria-label="Abrir menú"><i class="fas fa-bars"></i></button>
        <a class="navbar-brand" href="#"><i class="fas fa-calendar-alt me-2"></i>Panel de Eventos</a>

        <div class="ms-auto d-flex align-items-center gap-2">
          <input id="searchGlobal" class="form-control form-control-sm search-input" placeholder="Buscar eventos/usuarios..." title="Buscar en tablas">
          <div class="dropdown export-dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Exportar</button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#" id="expExcel"><i class="fas fa-file-excel"></i> Exportar Excel</a></li>
              <li><a class="dropdown-item" href="#" id="expPdf"><i class="fas fa-file-pdf"></i> Exportar PDF</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#" id="expAll"><i class="fas fa-file-archive"></i> Exportar Todo</a></li>
            </ul>
          </div>
          <div class="vr d-none d-md-block"></div>
          <div class="dropdown">
            <a class="nav-link dropdown-toggle p-0" href="#" data-bs-toggle="dropdown"><i class="fas fa-user-circle fa-2x"></i></a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Perfil</a></li>
              <li><a class="dropdown-item" href="../cliente/login.php"><i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- Sección Dashboard (Actual) -->
    <div id="dashboard" class="content-section active">
      <div class="container-fluid py-3">
        <div class="row align-items-center mb-2">
          <div class="col-md-6">
            <h2 class="section-title">Resumen Estadístico</h2>
          </div>
        </div>

        <!-- STATS -->
        <div class="row mb-4">
          <div class="col-md-4 mb-3">
            <div class="card stats-card bg-custom-primary">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Próximos Eventos</h6>
                  <div id="proximos-eventos" class="stats-number">0</div>
                </div>
                <i class="fas fa-calendar-check fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card stats-card bg-custom-success">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Usuarios Inscritos</h6>
                  <div id="usuarios-inscritos" class="stats-number">0</div>
                </div>
                <i class="fas fa-users fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card stats-card bg-custom-info">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Participación Promedio</h6>
                  <div id="participacion" class="stats-number">0%</div>
                </div>
                <i class="fas fa-chart-bar fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- CHART -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="m-0">Participación en Eventos</h5>
                <div class="small-muted">Últimos eventos</div>
              </div>
              <div class="card-body">
                <div class="chart-container" style="height:360px"><canvas id="grafico-participacion"></canvas></div>
              </div>
            </div>
          </div>
        </div>

        <!-- ACTIONS -->
        <div class="row mb-3">
          <div class="col-12 d-flex flex-wrap justify-content-between gap-2">
            <div>
              <button class="btn btn-primary" onclick="mostrarFormularioAgregar()"><i class="fas fa-plus me-1"></i> Agregar Evento</button>
              <button class="btn btn-success" onclick="mostrarFormularioInscripcion()"><i class="fas fa-user-plus me-1"></i> Nueva Inscripción</button>
            </div>
            <div>
              <input id="filterEventos" class="form-control form-control-sm d-inline-block search-input" placeholder="Filtrar eventos..." style="width:260px">
            </div>
          </div>
        </div>

        <!-- TABS: Eventos / Inscripciones -->
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
          <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#eventos">Eventos</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#inscripciones">Inscripciones</button></li>
        </ul>

        <div class="tab-content">
          <!-- EVENTOS -->
          <div class="tab-pane fade show active" id="eventos">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="m-0">Lista de Eventos</h5>
                <div class="export-section">
                  <div class="export-buttons">
                    <button class="btn btn-outline-success btn-sm" onclick="exportEventos('excel')"><i class="fas fa-file-excel me-1"></i>Excel</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="exportEventos('pdf')"><i class="fas fa-file-pdf me-1"></i>PDF</button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" id="table-eventos">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Lugar</th>
                        <th>Participación</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody id="tabla-eventos">
                      <tr>
                        <td colspan="6" class="text-center">No hay eventos registrados</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- INSCRIPCIONES -->
          <div class="tab-pane fade" id="inscripciones">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="m-0">Lista de Inscripciones</h5>
                <div class="export-section">
                  <div class="export-buttons">
                    <button class="btn btn-outline-success btn-sm" onclick="exportInscripciones('excel')"><i class="fas fa-file-excel me-1"></i>Excel</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="exportInscripciones('pdf')"><i class="fas fa-file-pdf me-1"></i>PDF</button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" id="table-inscripciones">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Evento</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody id="tabla-inscripciones">
                      <tr>
                        <td colspan="5" class="text-center">No hay inscripciones registradas</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- container -->
    </div> <!-- dashboard -->

    <!-- Sección MIS EVENTOS (Nueva) -->
    <div id="mis-eventos" class="content-section">
      <div class="container-fluid py-3">
        <div class="row align-items-center mb-4">
          <div class="col-md-8">
            <h2 class="section-title">Mis Eventos</h2>
            <p class="small-muted">Gestiona todos tus eventos activos y pasados</p>
          </div>
          <div class="col-md-4 text-end">
            <button class="btn btn-primary" onclick="mostrarFormularioAgregar()"><i class="fas fa-plus me-1"></i> Crear Nuevo Evento</button>
          </div>
        </div>

        <!-- Filtros -->
        <div class="filters-container">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Buscar evento</label>
              <input type="text" class="form-control" id="searchMisEventos" placeholder="Nombre del evento...">
            </div>
            <div class="col-md-4">
              <label class="form-label">Filtrar por estado</label>
              <select class="form-select" id="filterEstado">
                <option value="">Todos los eventos</option>
                <option value="activo">Activos</option>
                <option value="proximo">Próximos</option>
                <option value="finalizado">Finalizados</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Ordenar por</label>
              <select class="form-select" id="sortEventos">
                <option value="fecha">Fecha (más reciente)</option>
                <option value="participacion">Participación</option>
                <option value="nombre">Nombre (A-Z)</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="quick-stats">
          <div class="quick-stat-item">
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-value" id="total-eventos">0</div>
            <div class="stat-label">Total Eventos</div>
          </div>
          <div class="quick-stat-item">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-value" id="eventos-activos">0</div>
            <div class="stat-label">Eventos Activos</div>
          </div>
          <div class="quick-stat-item">
            <div class="stat-icon"><i class="fas fa-calendar-times"></i></div>
            <div class="stat-value" id="eventos-finalizados">0</div>
            <div class="stat-label">Eventos Finalizados</div>
          </div>
          <div class="quick-stat-item">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <div class="stat-value" id="participacion-promedio">0%</div>
            <div class="stat-label">Participación Promedio</div>
          </div>
        </div>

        <!-- Tabla de eventos -->
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="m-0">Lista de Mis Eventos</h5>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-secondary" onclick="actualizarListaEventos()"><i class="fas fa-sync-alt"></i></button>
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">Acciones</button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" onclick="exportarMisEventos('excel')"><i class="fas fa-file-excel me-2"></i>Exportar Excel</a></li>
                  <li><a class="dropdown-item" href="#" onclick="exportarMisEventos('pdf')"><i class="fas fa-file-pdf me-2"></i>Exportar PDF</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#" onclick="enviarRecordatorioTodos()"><i class="fas fa-envelope me-2"></i>Enviar Recordatorios</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre del Evento</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Participación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody id="tabla-mis-eventos">
                  <!-- Los eventos se cargarán aquí dinámicamente -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Detalles del evento seleccionado -->
        <div class="card mt-4" id="evento-detalle-card" style="display: none;">
          <div class="card-header">
            <h5 class="m-0">Detalles del Evento</h5>
          </div>
          <div class="card-body" id="evento-detalle-content">
            <!-- Los detalles se cargarán aquí dinámicamente -->
          </div>
        </div>
      </div>
    </div>

    <!-- Sección PARTICIPANTES (Nueva) -->
    <div id="participantes" class="content-section">
      <div class="container-fluid py-3">
        <div class="row align-items-center mb-4">
          <div class="col-md-8">
            <h2 class="section-title">Gestión de Participantes</h2>
            <p class="small-muted">Administra los participantes de todos tus eventos</p>
          </div>
          <div class="col-md-4 text-end">
            <button class="btn btn-primary" onclick="mostrarFormularioInscripcion()"><i class="fas fa-user-plus me-1"></i> Agregar Participante</button>
          </div>
        </div>

        <!-- Filtros -->
        <div class="filters-container">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Buscar participante</label>
              <input type="text" class="form-control" id="searchParticipantes" placeholder="Nombre o email...">
            </div>
            <div class="col-md-4">
              <label class="form-label">Filtrar por evento</label>
              <select class="form-select" id="filterEventoParticipante">
                <option value="">Todos los eventos</option>
                <!-- Las opciones se cargarán dinámicamente -->
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Estado</label>
              <select class="form-select" id="filterEstadoParticipante">
                <option value="">Todos los estados</option>
                <option value="confirmado">Confirmado</option>
                <option value="pendiente">Pendiente</option>
                <option value="asistio">Asistió</option>
                <option value="cancelado">Cancelado</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
          <div class="col-md-3 mb-3">
            <div class="card stats-card bg-custom-primary">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Total Participantes</h6>
                  <div class="stats-number" id="total-participantes">0</div>
                </div>
                <i class="fas fa-users fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card stats-card bg-custom-success">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Confirmados</h6>
                  <div class="stats-number" id="participantes-confirmados">0</div>
                </div>
                <i class="fas fa-user-check fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card stats-card bg-custom-warning">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Pendientes</h6>
                  <div class="stats-number" id="participantes-pendientes">0</div>
                </div>
                <i class="fas fa-user-clock fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card stats-card bg-custom-purple">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Asistieron</h6>
                  <div class="stats-number" id="participantes-asistieron">0</div>
                </div>
                <i class="fas fa-calendar-check fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabla de participantes -->
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="m-0">Lista de Participantes</h5>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-secondary" onclick="actualizarListaParticipantes()"><i class="fas fa-sync-alt"></i></button>
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">Acciones</button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" onclick="exportarParticipantes('excel')"><i class="fas fa-file-excel me-2"></i>Exportar Excel</a></li>
                  <li><a class="dropdown-item" href="#" onclick="exportarParticipantes('pdf')"><i class="fas fa-file-pdf me-2"></i>Exportar PDF</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#" onclick="enviarEmailMasivo()"><i class="fas fa-envelope me-2"></i>Enviar Email Masivo</a></li>
                  <li><a class="dropdown-item" href="#" onclick="marcarAsistenciaMasiva()"><i class="fas fa-user-check me-2"></i>Marcar Asistencia</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="selectAllParticipantes"></th>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th>Evento</th>
                    <th>Fecha Inscripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody id="tabla-participantes">
                  <!-- Los participantes se cargarán aquí dinámicamente -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Acciones masivas -->
        <div class="card mt-4" id="acciones-masivas" style="display: none;">
          <div class="card-body">
            <h6>Acciones para participantes seleccionados (<span id="count-selected">0</span>)</h6>
            <div class="d-flex gap-2 mt-3">
              <button class="btn btn-sm btn-outline-primary" onclick="cambiarEstadoSeleccionados('confirmado')"><i class="fas fa-check me-1"></i>Confirmar</button>
              <button class="btn btn-sm btn-outline-success" onclick="cambiarEstadoSeleccionados('asistio')"><i class="fas fa-user-check me-1"></i>Marcar Asistencia</button>
              <button class="btn btn-sm btn-outline-warning" onclick="cambiarEstadoSeleccionados('pendiente')"><i class="fas fa-clock me-1"></i>Marcar Pendiente</button>
              <button class="btn btn-sm btn-outline-danger" onclick="eliminarParticipantesSeleccionados()"><i class="fas fa-trash me-1"></i>Eliminar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sección REPORTES (Nueva) -->
    <div id="reportes" class="content-section">
      <div class="container-fluid py-3">
        <div class="row align-items-center mb-4">
          <div class="col-md-8">
            <h2 class="section-title">Reportes y Análisis</h2>
            <p class="small-muted">Visualiza métricas y análisis de desempeño de tus eventos</p>
          </div>
          <div class="col-md-4 text-end">
            <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-download me-1"></i> Exportar Reportes</button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="exportarReporteCompleto()"><i class="fas fa-file-archive me-2"></i>Reporte Completo</a></li>
                <li><a class="dropdown-item" href="#" onclick="generarReportePDF()"><i class="fas fa-file-pdf me-2"></i>Reporte en PDF</a></li>
                <li><a class="dropdown-item" href="#" onclick="exportarDatosAnaliticos()"><i class="fas fa-file-excel me-2"></i>Datos Analíticos</a></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Filtros de reportes -->
        <div class="filters-container mb-4">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label">Período</label>
              <select class="form-select" id="reportPeriod">
                <option value="7">Últimos 7 días</option>
                <option value="30" selected>Últimos 30 días</option>
                <option value="90">Últimos 3 meses</option>
                <option value="365">Último año</option>
                <option value="custom">Personalizado</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Tipo de Evento</label>
              <select class="form-select" id="reportEventType">
                <option value="">Todos los eventos</option>
                <option value="conferencia">Conferencias</option>
                <option value="taller">Talleres</option>
                <option value="seminario">Seminarios</option>
                <option value="webinar">Webinars</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Métrica Principal</label>
              <select class="form-select" id="reportMetric">
                <option value="participacion">Participación</option>
                <option value="asistencia">Asistencia</option>
                <option value="ingresos">Ingresos</option>
                <option value="satisfaccion">Satisfacción</option>
              </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
              <button class="btn btn-primary w-100" onclick="generarReporte()"><i class="fas fa-chart-bar me-1"></i> Generar Reporte</button>
            </div>
          </div>
        </div>

        <!-- Gráficos principales -->
        <div class="row mb-4">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Tendencias de Participación</h5>
              </div>
              <div class="card-body">
                <div class="chart-container" style="height: 350px;">
                  <canvas id="grafico-tendencias"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-header">
                <h5 class="m-0">Distribución por Evento</h5>
              </div>
              <div class="card-body">
                <div class="chart-container" style="height: 300px;">
                  <canvas id="grafico-distribucion"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Métricas clave -->
        <div class="row mb-4">
          <div class="col-md-3 mb-3">
            <div class="card stats-card bg-custom-primary">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Tasa de Participación</h6>
                  <div class="stats-number" id="tasa-participacion">0%</div>
                </div>
                <i class="fas fa-chart-line fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card stats-card bg-custom-success">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Participantes Únicos</h6>
                  <div class="stats-number" id="participantes-unicos">0</div>
                </div>
                <i class="fas fa-user-friends fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card stats-card bg-custom-warning">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Tasa de Asistencia</h6>
                  <div class="stats-number" id="tasa-asistencia">0%</div>
                </div>
                <i class="fas fa-user-check fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card stats-card bg-custom-purple">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Evento Más Popular</h6>
                  <div class="stats-number" id="evento-popular">-</div>
                </div>
                <i class="fas fa-star fa-2x opacity-75"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabla de eventos con métricas -->
        <div class="card">
          <div class="card-header">
            <h5 class="m-0">Métricas por Evento</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Evento</th>
                    <th>Participantes</th>
                    <th>Tasa Participación</th>
                    <th>Tasa Asistencia</th>
                    <th>Satisfacción</th>
                    <th>Ingresos</th>
                  </tr>
                </thead>
                <tbody id="tabla-metricas-eventos">
                  <!-- Las métricas se cargarán aquí dinámicamente -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sección AYUDA (Nueva) -->
    <div id="ayuda" class="content-section">
      <div class="container-fluid py-3">
        <div class="row mb-4">
          <div class="col-12">
            <h2 class="section-title">Centro de Ayuda</h2>
            <p class="small-muted">Encuentra respuestas a tus preguntas y soporte técnico</p>
          </div>
        </div>

        <!-- Tarjetas de ayuda -->
        <div class="row mb-4">
          <div class="col-md-4 mb-3">
            <div class="card h-100 text-center">
              <div class="card-body d-flex flex-column">
                <div class="mb-3">
                  <i class="fas fa-book fa-3x text-primary mb-3"></i>
                  <h5>Base de Conocimiento</h5>
                  <p class="small-muted">Artículos y tutoriales para aprender a usar la plataforma</p>
                </div>
                <div class="mt-auto">
                  <button class="btn btn-outline-primary w-100" onclick="abrirBaseConocimiento()"><i class="fas fa-external-link-alt me-1"></i> Acceder</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card h-100 text-center">
              <div class="card-body d-flex flex-column">
                <div class="mb-3">
                  <i class="fas fa-question-circle fa-3x text-success mb-3"></i>
                  <h5>Preguntas Frecuentes</h5>
                  <p class="small-muted">Respuestas a las preguntas más comunes de los usuarios</p>
                </div>
                <div class="mt-auto">
                  <button class="btn btn-outline-success w-100" onclick="mostrarFAQs()"><i class="fas fa-search me-1"></i> Ver FAQs</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card h-100 text-center">
              <div class="card-body d-flex flex-column">
                <div class="mb-3">
                  <i class="fas fa-headset fa-3x text-warning mb-3"></i>
                  <h5>Soporte en Vivo</h5>
                  <p class="small-muted">Chatea con nuestro equipo de soporte técnico</p>
                </div>
                <div class="mt-auto">
                  <button class="btn btn-outline-warning w-100" onclick="iniciarChatSoporte()"><i class="fas fa-comments me-1"></i> Iniciar Chat</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Categorías de ayuda -->
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="help-category">
              <h5><i class="fas fa-calendar-alt me-2"></i> Gestión de Eventos</h5>
              <div class="help-item" onclick="mostrarAyuda('crear-evento')">
                <strong>¿Cómo crear un nuevo evento?</strong>
                <p class="small-muted mb-0">Aprende a crear y configurar eventos paso a paso</p>
              </div>
              <div class="help-item" onclick="mostrarAyuda('invitar-participantes')">
                <strong>¿Cómo invitar participantes?</strong>
                <p class="small-muted mb-0">Métodos para invitar y gestionar participantes</p>
              </div>
              <div class="help-item" onclick="mostrarAyuda('exportar-datos')">
                <strong>¿Cómo exportar datos de eventos?</strong>
                <p class="small-muted mb-0">Guía para exportar información en diferentes formatos</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="help-category">
              <h5><i class="fas fa-chart-bar me-2"></i> Reportes y Análisis</h5>
              <div class="help-item" onclick="mostrarAyuda('generar-reportes')">
                <strong>¿Cómo generar reportes?</strong>
                <p class="small-muted mb-0">Crea reportes personalizados con tus métricas</p>
              </div>
              <div class="help-item" onclick="mostrarAyuda('interpretar-metricas')">
                <strong>¿Cómo interpretar las métricas?</strong>
                <p class="small-muted mb-0">Guía para entender los datos y gráficos</p>
              </div>
              <div class="help-item" onclick="mostrarAyuda('compartir-reportes')">
                <strong>¿Cómo compartir reportes?</strong>
                <p class="small-muted mb-0">Comparte reportes con tu equipo o clientes</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Formulario de contacto -->
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Contactar Soporte</h5>
              </div>
              <div class="card-body">
                <form id="formSoporte">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="nombreSoporte" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" id="emailSoporte" required>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Asunto</label>
                    <select class="form-select" id="asuntoSoporte">
                      <option>Problema Técnico</option>
                      <option>Pregunta sobre Facturación</option>
                      <option>Sugerencia</option>
                      <option>Reportar un Error</option>
                      <option>Otro</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Mensaje</label>
                    <textarea class="form-control" id="mensajeSoporte" rows="4" placeholder="Describe tu consulta en detalle..." required></textarea>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <small class="text-muted">Respuesta en menos de 24 horas</small>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="enviarSolicitudSoporte()"><i class="fas fa-paper-plane me-1"></i> Enviar Mensaje</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Información de Contacto</h5>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <h6><i class="fas fa-phone me-2 text-primary"></i> Teléfono</h6>
                  <p class="small-muted mb-0">+1 (555) 123-4567</p>
                  <small class="text-muted">Lunes a Viernes, 9am - 6pm</small>
                </div>
                <div class="mb-3">
                  <h6><i class="fas fa-envelope me-2 text-success"></i> Email</h6>
                  <p class="small-muted mb-0">soporte@eventos.com</p>
                  <small class="text-muted">Respuesta en 24 horas</small>
                </div>
                <div>
                  <h6><i class="fas fa-comments me-2 text-warning"></i> Chat en Vivo</h6>
                  <p class="small-muted mb-0">Disponible 24/7</p>
                  <small class="text-muted">Haz clic en "Iniciar Chat" arriba</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- content -->

  <!-- MODALES EXISTENTES -->
  <div class="modal fade" id="eventoModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalTitle">Agregar Evento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form id="formEvento" class="needs-validation" novalidate>
            <input type="hidden" id="eventoId">
            <div class="mb-3"><label class="form-label">Nombre</label><input type="text" id="nombre" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Fecha</label><input type="date" id="fecha" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Lugar</label><input type="text" id="lugar" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Participación (%)</label><input type="number" id="participacionInput" class="form-control" min="0" max="100" value="0" required></div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" id="saveEventoBtn">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="inscripcionModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Nueva Inscripción</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="formInscripcion" class="needs-validation" novalidate>
            <div class="mb-3">
              <label class="form-label">Evento</label>
              <select id="id_evento" class="form-select" required>
                <option value="" disabled selected>Seleccionar evento...</option>
              </select>
            </div>
            <div class="mb-3"><label class="form-label">Nombre de Usuario</label><input id="nombre_usuario" class="form-control" required></div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" id="saveInscripcionBtn">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de ayuda -->
  <div class="modal fade" id="ayudaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="ayudaModalTitle">Ayuda</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="ayudaModalContent">
          <!-- El contenido de ayuda se cargará aquí -->
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast container -->
  <div id="toasts" class="position-fixed top-0 end-0 p-3"></div>

  <!-- Bootstrap bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    /****************************
     *  Variables & references
     ****************************/
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlaySidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const themeToggle = document.getElementById('themeToggle');
    const toastContainer = document.getElementById('toasts');

    const modalEvento = new bootstrap.Modal(document.getElementById('eventoModal'));
    const modalInscripcion = new bootstrap.Modal(document.getElementById('inscripcionModal'));
    const modalAyuda = new bootstrap.Modal(document.getElementById('ayudaModal'));
    const saveEventoBtn = document.getElementById('saveEventoBtn');
    const saveInscripcionBtn = document.getElementById('saveInscripcionBtn');

    let eventosData = JSON.parse(localStorage.getItem('eventosData')) || [];
    let inscripcionesData = JSON.parse(localStorage.getItem('inscripcionesData')) || [];
    let participantesData = JSON.parse(localStorage.getItem('participantesData')) || [];

    // Si no hay participantesData, crearlo a partir de inscripcionesData
    if (!participantesData || participantesData.length === 0) {
      participantesData = inscripcionesData.map(ins => ({
        id: ins.id,
        nombre: ins.nombre_usuario,
        email: `${ins.nombre_usuario.toLowerCase().replace(/\s+/g, '.')}@email.com`,
        telefono: '55' + Math.floor(10000000 + Math.random() * 90000000),
        id_evento: ins.id_evento,
        evento_nombre: ins.evento_nombre,
        fecha_inscripcion: ins.fecha_inscripcion,
        estado: ['confirmado', 'pendiente', 'asistio', 'cancelado'][Math.floor(Math.random() * 4)]
      }));
      localStorage.setItem('participantesData', JSON.stringify(participantesData));
    }

    let chart = null;
    let chartTendencias = null;
    let chartDistribucion = null;

    // Estado inicial del sidebar - visible por defecto en desktop
    let sidebarState = localStorage.getItem('sidebarState') || 'open';

    /****************************
     * Navegación entre secciones
     ****************************/
    function initNavigation() {
      const navItems = document.querySelectorAll('#sidebar .components li[data-section]');
      const contentSections = document.querySelectorAll('.content-section');

      navItems.forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();

          // Obtener la sección objetivo
          const targetSection = this.getAttribute('data-section');

          // Remover clase active de todos los items
          navItems.forEach(nav => nav.classList.remove('active'));

          // Añadir clase active al item clickeado
          this.classList.add('active');

          // Ocultar todas las secciones
          contentSections.forEach(section => {
            section.classList.remove('active');
          });

          // Mostrar la sección objetivo
          document.getElementById(targetSection).classList.add('active');

          // Actualizar datos de la sección activa
          switch (targetSection) {
            case 'dashboard':
              cargarResumen();
              cargarEventos();
              cargarInscripciones();
              break;
            case 'mis-eventos':
              actualizarListaEventos();
              actualizarEstadisticasMisEventos();
              break;
            case 'participantes':
              actualizarListaParticipantes();
              actualizarEstadisticasParticipantes();
              cargarSelectEventosParticipantes();
              break;
            case 'reportes':
              generarReporte();
              break;
            case 'ayuda':
              // No necesita actualización
              break;
          }

          // Cerrar sidebar en móvil
          if (window.innerWidth < 992) {
            closeSidebarMobile();
          }
        });
      });
    }

    /****************************
     * Utility: Toasts
     ****************************/
    function showToast(message, type = 'success', timeout = 3000) {
      const id = 't' + Date.now();
      const klass = type === 'error' ? 'bg-danger text-white' : 'bg-dark text-white';
      const el = document.createElement('div');
      el.className = `toast ${klass}`;
      el.role = 'alert';
      el.ariaLive = 'polite';
      el.ariaAtomic = 'true';
      el.innerHTML = `<div class="d-flex"><div class="toast-body">${message}</div><button type="button" class="btn-close btn-close-white ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button></div>`;
      toastContainer.appendChild(el);
      const bs = new bootstrap.Toast(el, {
        delay: timeout
      });
      bs.show();
      el.addEventListener('hidden.bs.toast', () => el.remove());
    }

    /****************************
     * Sidebar open/close behavior
     ****************************/
    function toggleSidebar() {
      if (window.innerWidth < 992) {
        // Comportamiento móvil
        sidebar.classList.toggle('visible');
        overlay.classList.toggle('show');
      } else {
        // Comportamiento desktop
        sidebar.classList.toggle('hidden');
        document.getElementById('content').classList.toggle('fullwidth');
        sidebarToggle.classList.toggle('rotated');

        // Guardar estado
        sidebarState = sidebar.classList.contains('hidden') ? 'closed' : 'open';
        localStorage.setItem('sidebarState', sidebarState);
      }
    }

    function closeSidebarMobile() {
      sidebar.classList.remove('visible');
      overlay.classList.remove('show');
    }

    sidebarToggle.addEventListener('click', toggleSidebar);
    closeSidebarBtn.addEventListener('click', closeSidebarMobile);
    overlay.addEventListener('click', closeSidebarMobile);

    /****************************
     * Theme: dark / light toggle
     ****************************/
    // Restore theme
    const savedTheme = localStorage.getItem('panelTheme') || 'light';
    if (savedTheme === 'dark') document.body.classList.add('dark');
    updateThemeIcon();

    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark');
      localStorage.setItem('panelTheme', document.body.classList.contains('dark') ? 'dark' : 'light');
      updateThemeIcon();
      showToast('Tema cambiado', 'success', 1500);
    });

    function updateThemeIcon() {
      themeToggle.innerHTML = document.body.classList.contains('dark') ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
    }

    /****************************
     * Submenu improved
     ****************************/
    document.querySelectorAll('.has-submenu').forEach(li => {
      const toggle = li.querySelector('.submenu-toggle');
      const submenu = li.querySelector('.submenu');
      toggle.addEventListener('click', (e) => {
        e.preventDefault();
        const isOpen = submenu.classList.contains('show');
        // close others
        document.querySelectorAll('.submenu.show').forEach(s => {
          if (s !== submenu) {
            s.classList.remove('show');
            s.parentElement.classList.remove('open');
          }
        });
        submenu.classList.toggle('show', !isOpen);
        li.classList.toggle('open', !isOpen);
      });
    });

    /****************************
     * LocalStorage helpers
     ****************************/
    function guardarEnLocalStorage() {
      localStorage.setItem('eventosData', JSON.stringify(eventosData));
      localStorage.setItem('inscripcionesData', JSON.stringify(inscripcionesData));
      localStorage.setItem('participantesData', JSON.stringify(participantesData));
    }

    /****************************
     * Funciones para MIS EVENTOS
     ****************************/
    function actualizarEstadisticasMisEventos() {
      const totalEventos = eventosData.length;
      const hoy = new Date();

      const eventosActivos = eventosData.filter(e => {
        const fechaEvento = new Date(e.fecha);
        return fechaEvento >= hoy;
      }).length;

      const eventosFinalizados = eventosData.filter(e => {
        const fechaEvento = new Date(e.fecha);
        return fechaEvento < hoy;
      }).length;

      const participacionPromedio = eventosData.length > 0 ?
        (eventosData.reduce((sum, e) => sum + (e.participacion || 0), 0) / eventosData.length).toFixed(1) :
        0;

      document.getElementById('total-eventos').textContent = totalEventos;
      document.getElementById('eventos-activos').textContent = eventosActivos;
      document.getElementById('eventos-finalizados').textContent = eventosFinalizados;
      document.getElementById('participacion-promedio').textContent = participacionPromedio + '%';
    }

    function actualizarListaEventos() {
      const tabla = document.getElementById('tabla-mis-eventos');
      const searchTerm = document.getElementById('searchMisEventos').value.toLowerCase();
      const filterEstado = document.getElementById('filterEstado').value;
      const sortBy = document.getElementById('sortEventos').value;

      let eventosFiltrados = [...eventosData];

      // Aplicar filtro de búsqueda
      if (searchTerm) {
        eventosFiltrados = eventosFiltrados.filter(e =>
          e.nombre.toLowerCase().includes(searchTerm) ||
          e.lugar.toLowerCase().includes(searchTerm)
        );
      }

      // Aplicar filtro de estado
      if (filterEstado) {
        const hoy = new Date();
        eventosFiltrados = eventosFiltrados.filter(e => {
          const fechaEvento = new Date(e.fecha);
          if (filterEstado === 'activo') return fechaEvento >= hoy;
          if (filterEstado === 'proximo') {
            const diferenciaDias = (fechaEvento - hoy) / (1000 * 60 * 60 * 24);
            return fechaEvento >= hoy && diferenciaDias <= 7;
          }
          if (filterEstado === 'finalizado') return fechaEvento < hoy;
          return true;
        });
      }

      // Aplicar ordenamiento
      eventosFiltrados.sort((a, b) => {
        if (sortBy === 'fecha') {
          return new Date(b.fecha) - new Date(a.fecha);
        } else if (sortBy === 'participacion') {
          return (b.participacion || 0) - (a.participacion || 0);
        } else if (sortBy === 'nombre') {
          return a.nombre.localeCompare(b.nombre);
        }
        return 0;
      });

      // Renderizar tabla
      tabla.innerHTML = '';

      if (eventosFiltrados.length === 0) {
        tabla.innerHTML = `<tr><td colspan="7" class="text-center">No hay eventos que coincidan con los filtros</td></tr>`;
      } else {
        eventosFiltrados.forEach(ev => {
          const fechaEvento = new Date(ev.fecha);
          const hoy = new Date();
          const diferenciaDias = (fechaEvento - hoy) / (1000 * 60 * 60 * 24);

          let estado = '';
          let estadoClass = '';

          if (fechaEvento < hoy) {
            estado = 'Finalizado';
            estadoClass = 'completed';
          } else if (diferenciaDias <= 7) {
            estado = 'Próximo';
            estadoClass = 'upcoming';
          } else {
            estado = 'Activo';
            estadoClass = 'active';
          }

          const tr = document.createElement('tr');
          tr.setAttribute('data-event-id', ev.id);
          tr.addEventListener('click', (e) => {
            if (!e.target.closest('td:last-child')) {
              mostrarDetallesEvento(ev.id);
            }
          });

          tr.innerHTML = `
            <td>${ev.id}</td>
            <td><strong>${ev.nombre}</strong></td>
            <td>${ev.fecha}</td>
            <td>${ev.lugar}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                  <div class="progress-bar" role="progressbar" style="width: ${ev.participacion || 0}%"></div>
                </div>
                <span>${ev.participacion || 0}%</span>
              </div>
            </td>
            <td><span class="badge-status ${estadoClass}">${estado}</span></td>
            <td>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary" onclick="editarEvento(${ev.id})"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-success" onclick="verParticipantesEvento(${ev.id})"><i class="fas fa-users"></i></button>
                <button class="btn btn-sm btn-outline-info" onclick="enviarRecordatorio(${ev.id})"><i class="fas fa-envelope"></i></button>
                <button class="btn btn-sm btn-outline-danger" onclick="eliminarEvento(${ev.id})"><i class="fas fa-trash"></i></button>
              </div>
            </td>
          `;
          tabla.appendChild(tr);
        });
      }
    }

    function mostrarDetallesEvento(id) {
      const ev = eventosData.find(e => e.id == id);
      if (!ev) return;

      const participantesEvento = participantesData.filter(p => p.id_evento == id);
      const confirmados = participantesEvento.filter(p => p.estado === 'confirmado').length;
      const asistieron = participantesEvento.filter(p => p.estado === 'asistio').length;

      const contenido = `
        <div class="row">
          <div class="col-md-6">
            <h6>Información del Evento</h6>
            <p><strong>Nombre:</strong> ${ev.nombre}</p>
            <p><strong>Fecha:</strong> ${ev.fecha}</p>
            <p><strong>Lugar:</strong> ${ev.lugar}</p>
            <p><strong>Participación:</strong> ${ev.participacion || 0}%</p>
          </div>
          <div class="col-md-6">
            <h6>Estadísticas</h6>
            <p><strong>Total Participantes:</strong> ${participantesEvento.length}</p>
            <p><strong>Confirmados:</strong> ${confirmados}</p>
            <p><strong>Asistieron:</strong> ${asistieron}</p>
            <p><strong>Tasa de Asistencia:</strong> ${participantesEvento.length > 0 ? ((asistieron / participantesEvento.length) * 100).toFixed(1) : 0}%</p>
          </div>
        </div>
        <div class="mt-3">
          <h6>Acciones</h6>
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-primary" onclick="verParticipantesEvento(${ev.id})"><i class="fas fa-users me-1"></i>Ver Participantes</button>
            <button class="btn btn-sm btn-success" onclick="editarEvento(${ev.id})"><i class="fas fa-edit me-1"></i>Editar Evento</button>
            <button class="btn btn-sm btn-info" onclick="enviarRecordatorio(${ev.id})"><i class="fas fa-envelope me-1"></i>Enviar Recordatorio</button>
            <button class="btn btn-sm btn-warning" onclick="exportarListaParticipantes(${ev.id})"><i class="fas fa-download me-1"></i>Exportar Lista</button>
          </div>
        </div>
      `;

      document.getElementById('evento-detalle-content').innerHTML = contenido;
      document.getElementById('evento-detalle-card').style.display = 'block';
    }

    function verParticipantesEvento(id) {
      const ev = eventosData.find(e => e.id == id);
      if (!ev) return;

      const participantesEvento = participantesData.filter(p => p.id_evento == id);

      if (participantesEvento.length === 0) {
        showToast('No hay participantes para este evento', 'info');
        return;
      }

      // Cambiar a sección de participantes y filtrar por este evento
      document.querySelector('#sidebar li[data-section="participantes"]').click();
      setTimeout(() => {
        document.getElementById('filterEventoParticipante').value = id;
        actualizarListaParticipantes();
      }, 100);
    }

    function enviarRecordatorio(id) {
      const ev = eventosData.find(e => e.id == id);
      if (!ev) return;

      showToast(`Recordatorio enviado para el evento: ${ev.nombre}`, 'success');
    }

    function enviarRecordatorioTodos() {
      const eventosActivos = eventosData.filter(e => {
        const fechaEvento = new Date(e.fecha);
        return fechaEvento >= new Date();
      });

      if (eventosActivos.length === 0) {
        showToast('No hay eventos activos para enviar recordatorios', 'info');
        return;
      }

      showToast(`Recordatorios enviados para ${eventosActivos.length} eventos activos`, 'success');
    }

    function exportarListaParticipantes(id) {
      const ev = eventosData.find(e => e.id == id);
      if (!ev) return;

      const participantesEvento = participantesData.filter(p => p.id_evento == id);

      if (participantesEvento.length === 0) {
        showToast('No hay participantes para exportar', 'info');
        return;
      }

      const data = participantesEvento.map(p => ({
        ID: p.id,
        Nombre: p.nombre,
        Email: p.email,
        Teléfono: p.telefono,
        Estado: p.estado,
        'Fecha Inscripción': p.fecha_inscripcion
      }));

      exportToExcel(data, `Participantes_${ev.nombre}`, `Participantes_${ev.nombre}.xlsx`);
    }

    function exportarMisEventos(format) {
      const data = eventosData.map(ev => {
        const fechaEvento = new Date(ev.fecha);
        const hoy = new Date();
        let estado = '';

        if (fechaEvento < hoy) {
          estado = 'Finalizado';
        } else if ((fechaEvento - hoy) / (1000 * 60 * 60 * 24) <= 7) {
          estado = 'Próximo';
        } else {
          estado = 'Activo';
        }

        return {
          ID: ev.id,
          Nombre: ev.nombre,
          Fecha: ev.fecha,
          Lugar: ev.lugar,
          Participación: `${ev.participacion || 0}%`,
          Estado: estado
        };
      });

      if (format === 'excel') {
        exportToExcel(data, 'Mis_Eventos', 'Mis_Eventos.xlsx');
      } else if (format === 'pdf') {
        exportToPDF(data, 'Mis_Eventos', 'Mis_Eventos.pdf');
      }
    }

    /****************************
     * Funciones para PARTICIPANTES
     ****************************/
    function actualizarEstadisticasParticipantes() {
      const totalParticipantes = participantesData.length;
      const confirmados = participantesData.filter(p => p.estado === 'confirmado').length;
      const pendientes = participantesData.filter(p => p.estado === 'pendiente').length;
      const asistieron = participantesData.filter(p => p.estado === 'asistio').length;

      document.getElementById('total-participantes').textContent = totalParticipantes;
      document.getElementById('participantes-confirmados').textContent = confirmados;
      document.getElementById('participantes-pendientes').textContent = pendientes;
      document.getElementById('participantes-asistieron').textContent = asistieron;
    }

    function cargarSelectEventosParticipantes() {
      const select = document.getElementById('filterEventoParticipante');
      select.innerHTML = '<option value="">Todos los eventos</option>';

      eventosData.forEach(ev => {
        const option = document.createElement('option');
        option.value = ev.id;
        option.textContent = ev.nombre;
        select.appendChild(option);
      });
    }

    function actualizarListaParticipantes() {
      const tabla = document.getElementById('tabla-participantes');
      const searchTerm = document.getElementById('searchParticipantes').value.toLowerCase();
      const filterEvento = document.getElementById('filterEventoParticipante').value;
      const filterEstado = document.getElementById('filterEstadoParticipante').value;

      let participantesFiltrados = [...participantesData];

      // Aplicar filtro de búsqueda
      if (searchTerm) {
        participantesFiltrados = participantesFiltrados.filter(p =>
          p.nombre.toLowerCase().includes(searchTerm) ||
          p.email.toLowerCase().includes(searchTerm)
        );
      }

      // Aplicar filtro de evento
      if (filterEvento) {
        participantesFiltrados = participantesFiltrados.filter(p => p.id_evento == filterEvento);
      }

      // Aplicar filtro de estado
      if (filterEstado) {
        participantesFiltrados = participantesFiltrados.filter(p => p.estado === filterEstado);
      }

      // Renderizar tabla
      tabla.innerHTML = '';

      if (participantesFiltrados.length === 0) {
        tabla.innerHTML = `<tr><td colspan="8" class="text-center">No hay participantes que coincidan con los filtros</td></tr>`;
        document.getElementById('acciones-masivas').style.display = 'none';
      } else {
        participantesFiltrados.forEach(p => {
          const ev = eventosData.find(e => e.id == p.id_evento);
          const eventoNombre = ev ? ev.nombre : `Evento ${p.id_evento}`;

          const tr = document.createElement('tr');
          tr.setAttribute('data-participante-id', p.id);

          tr.innerHTML = `
            <td><input type="checkbox" class="participante-checkbox" value="${p.id}" onchange="actualizarSeleccionParticipantes()"></td>
            <td>${p.id}</td>
            <td>${p.nombre}</td>
            <td>${p.email}</td>
            <td>${eventoNombre}</td>
            <td>${p.fecha_inscripcion}</td>
            <td>
              <span class="badge-status ${p.estado}">
                ${p.estado.charAt(0).toUpperCase() + p.estado.slice(1)}
              </span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary" onclick="editarParticipante(${p.id})"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-success" onclick="cambiarEstadoParticipante(${p.id}, 'confirmado')"><i class="fas fa-check"></i></button>
                <button class="btn btn-sm btn-outline-warning" onclick="cambiarEstadoParticipante(${p.id}, 'pendiente')"><i class="fas fa-clock"></i></button>
                <button class="btn btn-sm btn-outline-danger" onclick="eliminarParticipante(${p.id})"><i class="fas fa-trash"></i></button>
              </div>
            </td>
          `;
          tabla.appendChild(tr);
        });

        // Actualizar selección
        actualizarSeleccionParticipantes();
      }
    }

    function actualizarSeleccionParticipantes() {
      const checkboxes = document.querySelectorAll('.participante-checkbox');
      const selectAll = document.getElementById('selectAllParticipantes');
      const countSelected = document.getElementById('count-selected');
      const accionesMasivas = document.getElementById('acciones-masivas');

      let selectedCount = 0;
      checkboxes.forEach(cb => {
        if (cb.checked) selectedCount++;
      });

      // Actualizar contador
      countSelected.textContent = selectedCount;

      // Mostrar/ocultar panel de acciones masivas
      if (selectedCount > 0) {
        accionesMasivas.style.display = 'block';
      } else {
        accionesMasivas.style.display = 'none';
      }

      // Actualizar estado de "Seleccionar todos"
      selectAll.checked = selectedCount > 0 && selectedCount === checkboxes.length;
      selectAll.indeterminate = selectedCount > 0 && selectedCount < checkboxes.length;
    }

    document.getElementById('selectAllParticipantes').addEventListener('change', function() {
      const checkboxes = document.querySelectorAll('.participante-checkbox');
      checkboxes.forEach(cb => cb.checked = this.checked);
      actualizarSeleccionParticipantes();
    });

    function editarParticipante(id) {
      const p = participantesData.find(part => part.id == id);
      if (!p) return;

      // Aquí podrías mostrar un modal para editar el participante
      showToast(`Editando participante: ${p.nombre}`, 'info');
    }

    function cambiarEstadoParticipante(id, nuevoEstado) {
      const p = participantesData.find(part => part.id == id);
      if (!p) return;

      p.estado = nuevoEstado;
      guardarEnLocalStorage();
      actualizarListaParticipantes();
      actualizarEstadisticasParticipantes();

      showToast(`Estado cambiado a: ${nuevoEstado}`, 'success');
    }

    function eliminarParticipante(id) {
      if (!confirm('¿Seguro quieres eliminar este participante?')) return;

      const idx = participantesData.findIndex(p => p.id === id);
      if (idx !== -1) {
        participantesData.splice(idx, 1);
        guardarEnLocalStorage();
        actualizarListaParticipantes();
        actualizarEstadisticasParticipantes();
        showToast('Participante eliminado', 'success');
      }
    }

    function cambiarEstadoSeleccionados(nuevoEstado) {
      const checkboxes = document.querySelectorAll('.participante-checkbox:checked');
      if (checkboxes.length === 0) return;

      checkboxes.forEach(cb => {
        const id = parseInt(cb.value);
        const p = participantesData.find(part => part.id == id);
        if (p) p.estado = nuevoEstado;
      });

      guardarEnLocalStorage();
      actualizarListaParticipantes();
      actualizarEstadisticasParticipantes();

      showToast(`${checkboxes.length} participantes actualizados a: ${nuevoEstado}`, 'success');
    }

    function eliminarParticipantesSeleccionados() {
      const checkboxes = document.querySelectorAll('.participante-checkbox:checked');
      if (checkboxes.length === 0) return;

      if (!confirm(`¿Seguro quieres eliminar ${checkboxes.length} participantes?`)) return;

      const ids = Array.from(checkboxes).map(cb => parseInt(cb.value));
      participantesData = participantesData.filter(p => !ids.includes(p.id));

      guardarEnLocalStorage();
      actualizarListaParticipantes();
      actualizarEstadisticasParticipantes();

      showToast(`${ids.length} participantes eliminados`, 'success');
    }

    function enviarEmailMasivo() {
      const checkboxes = document.querySelectorAll('.participante-checkbox:checked');
      if (checkboxes.length === 0) {
        showToast('Selecciona al menos un participante', 'warning');
        return;
      }

      showToast(`Enviando email a ${checkboxes.length} participantes...`, 'info');

      // Simular envío
      setTimeout(() => {
        showToast('Emails enviados correctamente', 'success');
      }, 1500);
    }

    function marcarAsistenciaMasiva() {
      const checkboxes = document.querySelectorAll('.participante-checkbox:checked');
      if (checkboxes.length === 0) {
        showToast('Selecciona al menos un participante', 'warning');
        return;
      }

      checkboxes.forEach(cb => {
        const id = parseInt(cb.value);
        cambiarEstadoParticipante(id, 'asistio');
      });
    }

    function exportarParticipantes(format) {
      const data = participantesData.map(p => {
        const ev = eventosData.find(e => e.id == p.id_evento);
        return {
          ID: p.id,
          Nombre: p.nombre,
          Email: p.email,
          Teléfono: p.telefono,
          Evento: ev ? ev.nombre : `Evento ${p.id_evento}`,
          'Fecha Inscripción': p.fecha_inscripcion,
          Estado: p.estado.charAt(0).toUpperCase() + p.estado.slice(1)
        };
      });

      if (format === 'excel') {
        exportToExcel(data, 'Participantes', 'Participantes.xlsx');
      } else if (format === 'pdf') {
        exportToPDF(data, 'Participantes', 'Participantes.pdf');
      }
    }

    /****************************
     * Funciones para REPORTES
     ****************************/
    function generarReporte() {
      const periodo = document.getElementById('reportPeriod').value;
      const tipoEvento = document.getElementById('reportEventType').value;
      const metrica = document.getElementById('reportMetric').value;

      // Calcular métricas
      const totalParticipantes = participantesData.length;
      const participantesUnicos = new Set(participantesData.map(p => p.email)).size;

      const eventosConMetricas = eventosData.map(ev => {
        const participantesEvento = participantesData.filter(p => p.id_evento == ev.id);
        const asistieron = participantesEvento.filter(p => p.estado === 'asistio').length;
        const tasaAsistencia = participantesEvento.length > 0 ? (asistieron / participantesEvento.length) * 100 : 0;

        return {
          evento: ev.nombre,
          participantes: participantesEvento.length,
          tasaParticipacion: ev.participacion || 0,
          tasaAsistencia: tasaAsistencia,
          satisfaccion: 70 + Math.random() * 25, // Simulado
          ingresos: participantesEvento.length * 50 // Simulado
        };
      });

      // Actualizar métricas clave
      document.getElementById('tasa-participacion').textContent =
        eventosConMetricas.length > 0 ?
        (eventosConMetricas.reduce((sum, e) => sum + e.tasaParticipacion, 0) / eventosConMetricas.length).toFixed(1) + '%' :
        '0%';

      document.getElementById('participantes-unicos').textContent = participantesUnicos;

      document.getElementById('tasa-asistencia').textContent =
        eventosConMetricas.length > 0 ?
        (eventosConMetricas.reduce((sum, e) => sum + e.tasaAsistencia, 0) / eventosConMetricas.length).toFixed(1) + '%' :
        '0%';

      const eventoMasPopular = eventosConMetricas.reduce((max, e) => e.participantes > max.participantes ? e : max, {
        participantes: 0
      });
      document.getElementById('evento-popular').textContent = eventoMasPopular.participantes > 0 ? eventoMasPopular.evento.substring(0, 15) + '...' : '-';

      // Actualizar tabla de métricas
      const tablaMetricas = document.getElementById('tabla-metricas-eventos');
      tablaMetricas.innerHTML = '';

      eventosConMetricas.forEach(em => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${em.evento}</td>
          <td>${em.participantes}</td>
          <td>${em.tasaParticipacion.toFixed(1)}%</td>
          <td>${em.tasaAsistencia.toFixed(1)}%</td>
          <td>${em.satisfaccion.toFixed(1)}/100</td>
          <td>$${em.ingresos}</td>
        `;
        tablaMetricas.appendChild(tr);
      });

      // Generar gráficos
      generarGraficoTendencias(eventosConMetricas);
      generarGraficoDistribucion(eventosConMetricas);
    }

    function generarGraficoTendencias(eventosConMetricas) {
      const ctx = document.getElementById('grafico-tendencias').getContext('2d');

      if (chartTendencias) chartTendencias.destroy();

      // Datos para el gráfico de tendencias
      const nombres = eventosConMetricas.map(e => e.evento.substring(0, 10) + '...');
      const participantes = eventosConMetricas.map(e => e.participantes);
      const participacion = eventosConMetricas.map(e => e.tasaParticipacion);
      const asistencia = eventosConMetricas.map(e => e.tasaAsistencia);

      chartTendencias = new Chart(ctx, {
        type: 'line',
        data: {
          labels: nombres,
          datasets: [{
              label: 'Participantes',
              data: participantes,
              borderColor: 'rgb(78, 115, 223)',
              backgroundColor: 'rgba(78, 115, 223, 0.1)',
              tension: 0.4,
              fill: true
            },
            {
              label: 'Participación (%)',
              data: participacion,
              borderColor: 'rgb(28, 200, 138)',
              backgroundColor: 'rgba(28, 200, 138, 0.1)',
              tension: 0.4,
              fill: true
            },
            {
              label: 'Asistencia (%)',
              data: asistencia,
              borderColor: 'rgb(246, 194, 62)',
              backgroundColor: 'rgba(246, 194, 62, 0.1)',
              tension: 0.4,
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Valores'
              }
            }
          }
        }
      });
    }

    function generarGraficoDistribucion(eventosConMetricas) {
      const ctx = document.getElementById('grafico-distribucion').getContext('2d');

      if (chartDistribucion) chartDistribucion.destroy();

      // Datos para el gráfico de distribución
      const nombres = eventosConMetricas.map(e => e.evento.substring(0, 10) + '...');
      const participantes = eventosConMetricas.map(e => e.participantes);

      // Colores aleatorios para cada barra
      const backgroundColors = nombres.map(() =>
        `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.7)`
      );

      chartDistribucion = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: nombres,
          datasets: [{
            label: 'Participantes por Evento',
            data: participantes,
            backgroundColor: backgroundColors,
            borderColor: backgroundColors.map(c => c.replace('0.7', '1')),
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Número de Participantes'
              }
            }
          }
        }
      });
    }

    function exportarReporteCompleto() {
      const data = eventosData.map(ev => {
        const participantesEvento = participantesData.filter(p => p.id_evento == ev.id);
        const asistieron = participantesEvento.filter(p => p.estado === 'asistio').length;
        const tasaAsistencia = participantesEvento.length > 0 ? (asistieron / participantesEvento.length) * 100 : 0;

        return {
          ID: ev.id,
          Evento: ev.nombre,
          Fecha: ev.fecha,
          Lugar: ev.lugar,
          'Participación (%)': ev.participacion || 0,
          'Total Participantes': participantesEvento.length,
          'Asistieron': asistieron,
          'Tasa Asistencia (%)': tasaAsistencia.toFixed(1),
          'Ingresos Estimados': `$${participantesEvento.length * 50}`
        };
      });

      exportToExcel(data, 'Reporte_Completo', 'Reporte_Completo.xlsx');
    }

    function generarReportePDF() {
      const {
        jsPDF
      } = window.jspdf;
      const doc = new jsPDF();

      // Título
      doc.setFontSize(16);
      doc.text('Reporte de Eventos', 14, 16);

      // Fecha
      doc.setFontSize(10);
      const fecha = new Date().toLocaleDateString('es-ES');
      doc.text(`Generado el: ${fecha}`, 14, 24);

      // Resumen
      doc.setFontSize(12);
      doc.text('Resumen Estadístico', 14, 36);

      const totalEventos = eventosData.length;
      const totalParticipantes = participantesData.length;
      const participacionPromedio = eventosData.length > 0 ?
        (eventosData.reduce((sum, e) => sum + (e.participacion || 0), 0) / eventosData.length).toFixed(1) :
        0;

      doc.setFontSize(10);
      doc.text(`- Total Eventos: ${totalEventos}`, 20, 46);
      doc.text(`- Total Participantes: ${totalParticipantes}`, 20, 54);
      doc.text(`- Participación Promedio: ${participacionPromedio}%`, 20, 62);

      // Tabla de eventos
      let startY = 72;
      const headers = [
        ['Evento', 'Fecha', 'Participantes', 'Participación']
      ];
      const body = eventosData.map(ev => {
        const participantesEvento = participantesData.filter(p => p.id_evento == ev.id);
        return [
          ev.nombre.substring(0, 20),
          ev.fecha,
          participantesEvento.length.toString(),
          `${ev.participacion || 0}%`
        ];
      });

      doc.autoTable({
        startY: startY,
        head: headers,
        body: body,
        styles: {
          fontSize: 9,
          cellPadding: 3
        },
        headStyles: {
          fillColor: [78, 115, 223],
          textColor: 255,
          fontStyle: 'bold'
        }
      });

      doc.save('Reporte_Eventos.pdf');
      showToast('Reporte PDF generado', 'success');
    }

    function exportarDatosAnaliticos() {
      const data = participantesData.map(p => {
        const ev = eventosData.find(e => e.id == p.id_evento);
        return {
          'ID Participante': p.id,
          Nombre: p.nombre,
          Email: p.email,
          Teléfono: p.telefono,
          Evento: ev ? ev.nombre : `Evento ${p.id_evento}`,
          'ID Evento': p.id_evento,
          'Fecha Inscripción': p.fecha_inscripcion,
          Estado: p.estado.charAt(0).toUpperCase() + p.estado.slice(1),
          'Fecha Estado': new Date().toISOString().split('T')[0]
        };
      });

      exportToExcel(data, 'Datos_Analiticos', 'Datos_Analiticos.xlsx');
    }

    /****************************
     * Funciones para AYUDA
     ****************************/
    function abrirBaseConocimiento() {
      window.open('https://ejemplo.com/base-conocimiento', '_blank');
    }

    function mostrarFAQs() {
      const contenido = `
        <h5>Preguntas Frecuentes</h5>
        <div class="accordion mt-3" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                ¿Cómo creo un nuevo evento?
              </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Para crear un nuevo evento, ve a la sección "Dashboard" y haz clic en el botón "Agregar Evento". Completa el formulario con la información del evento y haz clic en "Guardar".
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                ¿Cómo invito participantes a un evento?
              </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Puedes agregar participantes individualmente desde la sección "Participantes" o importar una lista completa usando la opción "Importar Lista". También puedes enviar invitaciones por email usando la función "Enviar Email Masivo".
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                ¿Cómo genero reportes?
              </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Ve a la sección "Reportes" y selecciona los filtros deseados (período, tipo de evento, métrica). Luego haz clic en "Generar Reporte". Puedes exportar los reportes en diferentes formatos usando las opciones de exportación.
              </div>
            </div>
          </div>
        </div>
      `;

      document.getElementById('ayudaModalTitle').textContent = 'Preguntas Frecuentes';
      document.getElementById('ayudaModalContent').innerHTML = contenido;
      modalAyuda.show();
    }

    function iniciarChatSoporte() {
      showToast('Iniciando chat con soporte...', 'info');
      // Aquí integrarías con tu servicio de chat en vivo
      setTimeout(() => {
        showToast('Chat iniciado. Un agente te atenderá pronto.', 'success');
      }, 1000);
    }

    function mostrarAyuda(tema) {
      const temas = {
        'crear-evento': {
          titulo: 'Cómo Crear un Nuevo Evento',
          contenido: `
            <h5>Paso a paso para crear un evento</h5>
            <ol>
              <li>Ve a la sección "Dashboard" o "Mis Eventos"</li>
              <li>Haz clic en el botón "Agregar Evento" o "Crear Nuevo Evento"</li>
              <li>Completa el formulario con:
                <ul>
                  <li>Nombre del evento</li>
                  <li>Fecha y hora</li>
                  <li>Lugar (presencial o virtual)</li>
                  <li>Descripción (opcional)</li>
                </ul>
              </li>
              <li>Configura las opciones adicionales si es necesario</li>
              <li>Haz clic en "Guardar"</li>
            </ol>
            <p class="mt-3"><strong>Consejo:</strong> Puedes duplicar eventos existentes para ahorrar tiempo.</p>
          `
        },
        'invitar-participantes': {
          titulo: 'Cómo Invitar Participantes',
          contenido: `
            <h5>Métodos para invitar participantes</h5>
            <div class="row mt-3">
              <div class="col-md-6">
                <h6>Individualmente</h6>
                <p>Ve a "Participantes" → "Agregar Participante"</p>
                <p>Completa los datos del participante manualmente</p>
              </div>
              <div class="col-md-6">
                <h6>Importar Lista</h6>
                <p>Prepara un archivo Excel o CSV con los datos</p>
                <p>Usa la opción "Importar Lista" para cargarlo</p>
              </div>
            </div>
            <div class="mt-3">
              <h6>Envío de Invitaciones</h6>
              <p>Puedes enviar invitaciones por email usando:</p>
              <ul>
                <li>Invitaciones individuales</li>
                <li>Email masivo a todos los participantes</li>
                <li>Recordatorios automáticos</li>
              </ul>
            </div>
          `
        },
        'exportar-datos': {
          titulo: 'Cómo Exportar Datos',
          contenido: `
            <h5>Formatos de exportación disponibles</h5>
            <div class="row mt-3">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h6><i class="fas fa-file-excel text-success"></i> Excel (.xlsx)</h6>
                    <p>Ideal para análisis y manipulación de datos</p>
                    <p>Mantiene formatos y fórmulas</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h6><i class="fas fa-file-pdf text-danger"></i> PDF</h6>
                    <p>Perfecto para compartir y imprimir</p>
                    <p>Mantiene el formato visual</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <h6>Qué datos puedes exportar:</h6>
              <ul>
                <li>Lista completa de eventos</li>
                <li>Participantes por evento</li>
                <li>Reportes estadísticos</li>
                <li>Datos analíticos completos</li>
              </ul>
            </div>
          `
        }
      };

      if (temas[tema]) {
        document.getElementById('ayudaModalTitle').textContent = temas[tema].titulo;
        document.getElementById('ayudaModalContent').innerHTML = temas[tema].contenido;
        modalAyuda.show();
      }
    }

    function enviarSolicitudSoporte() {
      const nombre = document.getElementById('nombreSoporte').value;
      const email = document.getElementById('emailSoporte').value;
      const asunto = document.getElementById('asuntoSoporte').value;
      const mensaje = document.getElementById('mensajeSoporte').value;

      if (!nombre || !email || !mensaje) {
        showToast('Por favor completa todos los campos requeridos', 'error');
        return;
      }

      // Aquí normalmente enviarías los datos a tu backend
      showToast('Solicitud de soporte enviada. Te contactaremos pronto.', 'success');

      // Limpiar formulario
      document.getElementById('formSoporte').reset();
    }

    /****************************
     * Funciones existentes (CRUD Eventos & Inscripciones)
     ****************************/
    function mostrarFormularioAgregar() {
      document.getElementById('formEvento').reset();
      document.getElementById('eventoId').value = '';
      document.getElementById('modalTitle').textContent = 'Agregar Evento';
      modalEvento.show();
    }

    function editarEvento(id) {
      const ev = eventosData.find(e => e.id == id);
      if (!ev) return;
      document.getElementById('eventoId').value = ev.id;
      document.getElementById('nombre').value = ev.nombre;
      document.getElementById('fecha').value = ev.fecha;
      document.getElementById('lugar').value = ev.lugar;
      document.getElementById('participacionInput').value = ev.participacion || 0;
      document.getElementById('modalTitle').textContent = 'Editar Evento';
      modalEvento.show();
    }

    function eliminarEvento(id) {
      if (!confirm('¿Seguro quieres eliminar este evento?')) return;
      const idx = eventosData.findIndex(e => e.id === id);
      if (idx !== -1) eventosData.splice(idx, 1);
      guardarEnLocalStorage();
      cargarEventos();
      cargarResumen();
      actualizarListaEventos();
      actualizarEstadisticasMisEventos();
      showToast('Evento eliminado', 'success');
    }

    function actualizarParticipacion(id, nuevoValor) {
      const idx = eventosData.findIndex(e => e.id == id);
      if (idx !== -1) {
        eventosData[idx].participacion = parseInt(nuevoValor) || 0;
        guardarEnLocalStorage();
        cargarResumen();
        cargarEventos();
        actualizarListaEventos();
        actualizarEstadisticasMisEventos();
      }
    }

    saveEventoBtn.addEventListener('click', () => {
      const form = document.getElementById('formEvento');
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      const id = document.getElementById('eventoId').value;
      const nombre = document.getElementById('nombre').value.trim();
      const fecha = document.getElementById('fecha').value;
      const lugar = document.getElementById('lugar').value.trim();
      const participacion = parseInt(document.getElementById('participacionInput').value) || 0;

      if (id) {
        const i = eventosData.findIndex(e => e.id == id);
        if (i !== -1) eventosData[i] = {
          id: Number(id),
          nombre,
          fecha,
          lugar,
          participacion
        };
        showToast('Evento actualizado', 'success');
      } else {
        const newId = eventosData.length > 0 ? Math.max(...eventosData.map(e => e.id)) + 1 : 1;
        eventosData.push({
          id: newId,
          nombre,
          fecha,
          lugar,
          participacion
        });
        showToast('Evento creado', 'success');
      }
      guardarEnLocalStorage();
      modalEvento.hide();
      cargarEventos();
      cargarResumen();
      actualizarListaEventos();
      actualizarEstadisticasMisEventos();
    });

    function mostrarFormularioInscripcion() {
      document.getElementById('formInscripcion').reset();
      cargarSelectEventos();
      modalInscripcion.show();
    }

    saveInscripcionBtn.addEventListener('click', () => {
      const form = document.getElementById('formInscripcion');
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      const id_evento = document.getElementById('id_evento').value;
      const ev = eventosData.find(e => e.id == id_evento);
      if (!ev) {
        alert('Evento no válido');
        return;
      }
      const nombre_usuario = document.getElementById('nombre_usuario').value.trim();
      const newId = participantesData.length > 0 ? Math.max(...participantesData.map(i => i.id)) + 1 : 1;
      const fecha_inscripcion = new Date().toISOString().split('T')[0];

      // Crear nuevo participante
      const nuevoParticipante = {
        id: newId,
        nombre: nombre_usuario,
        email: `${nombre_usuario.toLowerCase().replace(/\s+/g, '.')}@email.com`,
        telefono: '55' + Math.floor(10000000 + Math.random() * 90000000),
        id_evento: parseInt(id_evento),
        evento_nombre: ev.nombre,
        fecha_inscripcion: fecha_inscripcion,
        estado: 'pendiente'
      };

      participantesData.push(nuevoParticipante);

      // También agregar a inscripcionesData para compatibilidad
      inscripcionesData.push({
        id: newId,
        id_evento,
        evento_nombre: ev.nombre,
        nombre_usuario,
        fecha_inscripcion
      });

      guardarEnLocalStorage();
      modalInscripcion.hide();
      cargarInscripciones();
      cargarResumen();
      actualizarListaParticipantes();
      actualizarEstadisticasParticipantes();
      showToast('Inscripción creada', 'success');
    });

    function eliminarInscripcion(id) {
      if (!confirm('¿Seguro quieres eliminar esta inscripción?')) return;
      const idx = inscripcionesData.findIndex(i => i.id === id);
      if (idx !== -1) inscripcionesData.splice(idx, 1);

      // También eliminar de participantesData
      const idxPart = participantesData.findIndex(p => p.id === id);
      if (idxPart !== -1) participantesData.splice(idxPart, 1);

      guardarEnLocalStorage();
      cargarInscripciones();
      cargarResumen();
      actualizarListaParticipantes();
      actualizarEstadisticasParticipantes();
      showToast('Inscripción eliminada', 'success');
    }

    /****************************
     * Funciones existentes (Load / render)
     ****************************/
    function cargarResumen() {
      const pe = document.getElementById('proximos-eventos');
      const ui = document.getElementById('usuarios-inscritos');
      const part = document.getElementById('participacion');

      const totalEventos = eventosData.length;
      const totalIns = participantesData.length;
      const promedio = totalEventos > 0 ? (eventosData.reduce((a, e) => a + Number(e.participacion || 0), 0) / totalEventos).toFixed(1) : 0;

      pe.textContent = totalEventos;
      ui.textContent = totalIns;
      part.textContent = promedio + '%';
    }

    function cargarSelectEventos() {
      const select = document.getElementById('id_evento');
      if (!select) return;
      select.innerHTML = `<option value="" disabled selected>Seleccionar evento...</option>`;
      eventosData.forEach(ev => {
        const opt = document.createElement('option');
        opt.value = ev.id;
        opt.textContent = ev.nombre;
        select.appendChild(opt);
      });
    }

    function actualizarGrafico(labels, data) {
      const ctx = document.getElementById('grafico-participacion').getContext('2d');
      if (chart) chart.destroy();
      chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels,
          datasets: [{
            label: 'Participación (%)',
            data,
            backgroundColor: 'rgba(78,115,223,0.8)',
            borderColor: 'rgba(78,115,223,1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              max: 100,
              title: {
                display: true,
                text: 'Porcentaje'
              }
            }
          },
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });
    }

    function cargarEventos() {
      const tabla = document.getElementById('tabla-eventos');
      tabla.innerHTML = '';
      const nombres = [];
      const participaciones = [];
      if (eventosData.length === 0) {
        tabla.innerHTML = `<tr><td colspan="6" class="text-center">No hay eventos registrados</td></tr>`;
      } else {
        eventosData.forEach(ev => {
          nombres.push(ev.nombre);
          participaciones.push(ev.participacion || 0);
          const tr = document.createElement('tr');
          tr.innerHTML = `
          <td>${ev.id}</td>
          <td>${ev.nombre}</td>
          <td>${ev.fecha}</td>
          <td>${ev.lugar}</td>
          <td>
            <div class="d-flex align-items-center">
              <input type="number" min="0" max="100" value="${ev.participacion||0}" class="form-control form-control-sm w-auto me-2" onchange="actualizarParticipacion(${ev.id}, this.value)">
              <span class="small">%</span>
            </div>
          </td>
          <td>
            <button class="btn btn-sm btn-primary btn-action" onclick="editarEvento(${ev.id})"><i class="fas fa-edit"></i></button>
            <button class="btn btn-sm btn-danger btn-action" onclick="eliminarEvento(${ev.id})"><i class="fas fa-trash"></i></button>
          </td>`;
          tabla.appendChild(tr);
        });
      }
      actualizarGrafico(nombres, participaciones);
      cargarSelectEventos();
    }

    function cargarInscripciones() {
      const tabla = document.getElementById('tabla-inscripciones');
      tabla.innerHTML = '';
      if (inscripcionesData.length === 0) tabla.innerHTML = `<tr><td colspan="5" class="text-center">No hay inscripciones registradas</td></tr>`;
      else inscripcionesData.forEach(ins => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${ins.id}</td><td>${ins.evento_nombre}</td><td>${ins.nombre_usuario}</td><td>${ins.fecha_inscripcion}</td>
        <td><button class="btn btn-sm btn-danger btn-action" onclick="eliminarInscripcion(${ins.id})"><i class="fas fa-trash"></i></button></td>`;
        tabla.appendChild(tr);
      });
    }

    /****************************
     * Funciones de exportación
     ****************************/
    function exportEventos(format) {
      if (format === 'excel') {
        exportToExcel(eventosData, 'Eventos', 'Eventos.xlsx');
      } else if (format === 'pdf') {
        exportToPDF(eventosData, 'Eventos', 'Eventos.pdf');
      }
    }

    function exportInscripciones(format) {
      if (format === 'excel') {
        exportToExcel(inscripcionesData, 'Inscripciones', 'Inscripciones.xlsx');
      } else if (format === 'pdf') {
        exportToPDF(inscripcionesData, 'Inscripciones', 'Inscripciones.pdf');
      }
    }

    function exportAll() {
      showToast('Exportando todos los datos...', 'success', 2000);

      const wb = XLSX.utils.book_new();

      if (eventosData.length > 0) {
        const wsEventos = createFormattedWorksheet(eventosData, 'Eventos');
        XLSX.utils.book_append_sheet(wb, wsEventos, 'Eventos');
      }

      if (inscripcionesData.length > 0) {
        const wsInscripciones = createFormattedWorksheet(inscripcionesData, 'Inscripciones');
        XLSX.utils.book_append_sheet(wb, wsInscripciones, 'Inscripciones');
      }

      XLSX.writeFile(wb, 'Datos_Completos.xlsx');
      showToast('Archivo Excel con todos los datos descargado', 'success');
    }

    function createFormattedWorksheet(data, title) {
      const ws = XLSX.utils.json_to_sheet(data);
      const range = XLSX.utils.decode_range(ws['!ref']);

      for (let R = range.s.r; R <= range.e.r; R++) {
        for (let C = range.s.c; C <= range.e.c; C++) {
          const cell_address = {
            c: C,
            r: R
          };
          const cell_ref = XLSX.utils.encode_cell(cell_address);

          if (!ws[cell_ref]) continue;

          if (R === 0) {
            ws[cell_ref].s = {
              fill: {
                fgColor: {
                  rgb: "4E73DF"
                }
              },
              font: {
                bold: true,
                color: {
                  rgb: "FFFFFF"
                }
              },
              alignment: {
                horizontal: "center",
                vertical: "center"
              },
              border: {
                top: {
                  style: "thin",
                  color: {
                    rgb: "000000"
                  }
                },
                left: {
                  style: "thin",
                  color: {
                    rgb: "000000"
                  }
                },
                bottom: {
                  style: "thin",
                  color: {
                    rgb: "000000"
                  }
                },
                right: {
                  style: "thin",
                  color: {
                    rgb: "000000"
                  }
                }
              }
            };
          } else {
            ws[cell_ref].s = {
              font: {
                color: {
                  rgb: "2E2E2E"
                }
              },
              alignment: {
                vertical: "center"
              },
              border: {
                top: {
                  style: "thin",
                  color: {
                    rgb: "D0D0D0"
                  }
                },
                left: {
                  style: "thin",
                  color: {
                    rgb: "D0D0D0"
                  }
                },
                bottom: {
                  style: "thin",
                  color: {
                    rgb: "D0D0D0"
                  }
                },
                right: {
                  style: "thin",
                  color: {
                    rgb: "D0D0D0"
                  }
                }
              }
            };

            if (R % 2 === 0) {
              ws[cell_ref].s.fill = {
                fgColor: {
                  rgb: "F8F9FA"
                }
              };
            } else {
              ws[cell_ref].s.fill = {
                fgColor: {
                  rgb: "FFFFFF"
                }
              };
            }
          }
        }
      }

      const colWidths = [];
      const headers = Object.keys(data[0]);

      headers.forEach(header => {
        let maxLength = header.length;
        data.forEach(row => {
          const cellValue = row[header] ? String(row[header]) : '';
          if (cellValue.length > maxLength) maxLength = cellValue.length;
        });
        colWidths.push({
          wch: Math.min(maxLength + 2, 50)
        });
      });

      ws['!cols'] = colWidths;
      ws['!freeze'] = {
        x: 0,
        y: 1
      };

      return ws;
    }

    function exportToExcel(data, title, filename = 'export.xlsx') {
      if (!data || data.length === 0) {
        showToast(`No hay datos de ${title} para exportar`, 'error');
        return;
      }

      const wb = XLSX.utils.book_new();
      const ws = createFormattedWorksheet(data, title);
      XLSX.utils.book_append_sheet(wb, ws, title);
      XLSX.writeFile(wb, filename);
      showToast(`${title} Excel descargado`, 'success');
    }

    function exportToPDF(data, title, filename = 'export.pdf') {
      if (!data || data.length === 0) {
        showToast(`No hay datos de ${title} para exportar`, 'error');
        return;
      }

      const {
        jsPDF
      } = window.jspdf;
      const doc = new jsPDF();

      doc.setFontSize(16);
      doc.setTextColor(40, 40, 40);
      doc.text(title, 14, 16);

      doc.setFontSize(10);
      doc.setTextColor(100, 100, 100);
      const exportDate = new Date().toLocaleDateString('es-ES');
      doc.text(`Exportado el: ${exportDate}`, 14, 24);

      const headers = Object.keys(data[0]);
      const body = data.map(item => headers.map(header => item[header]));

      doc.autoTable({
        startY: 30,
        head: [headers],
        body: body,
        styles: {
          fontSize: 9,
          cellPadding: 3,
          lineColor: [78, 115, 223],
          lineWidth: 0.1
        },
        headStyles: {
          fillColor: [78, 115, 223],
          textColor: 255,
          fontStyle: 'bold'
        },
        alternateRowStyles: {
          fillColor: [245, 245, 245]
        },
        margin: {
          top: 30
        }
      });

      doc.save(filename);
      showToast(`${title} PDF descargado`, 'success');
    }

    // Event listeners para exportación general
    document.getElementById('expExcel').addEventListener('click', (e) => {
      e.preventDefault();
      exportEventos('excel');
    });
    document.getElementById('expPdf').addEventListener('click', (e) => {
      e.preventDefault();
      exportEventos('pdf');
    });
    document.getElementById('expAll').addEventListener('click', (e) => {
      e.preventDefault();
      exportAll();
    });

    /****************************
     * Search & Filter
     ****************************/
    document.getElementById('searchGlobal').addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      filterTables(q);
    });

    document.getElementById('filterEventos').addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      filterEventos(q);
    });

    // Agregar event listeners para filtros de nuevas secciones
    document.getElementById('searchMisEventos')?.addEventListener('input', () => actualizarListaEventos());
    document.getElementById('filterEstado')?.addEventListener('change', () => actualizarListaEventos());
    document.getElementById('sortEventos')?.addEventListener('change', () => actualizarListaEventos());

    document.getElementById('searchParticipantes')?.addEventListener('input', () => actualizarListaParticipantes());
    document.getElementById('filterEventoParticipante')?.addEventListener('change', () => actualizarListaParticipantes());
    document.getElementById('filterEstadoParticipante')?.addEventListener('change', () => actualizarListaParticipantes());

    function filterTables(query) {
      filterEventos(query);
      filterInscripciones(query);
    }

    function filterEventos(query) {
      const tbody = document.getElementById('tabla-eventos');
      if (!tbody) return;
      Array.from(tbody.children).forEach(tr => {
        const text = tr.textContent.toLowerCase();
        tr.style.display = text.includes(query) ? '' : 'none';
      });
    }

    function filterInscripciones(query) {
      const tbody = document.getElementById('tabla-inscripciones');
      if (!tbody) return;
      Array.from(tbody.children).forEach(tr => {
        const text = tr.textContent.toLowerCase();
        tr.style.display = text.includes(query) ? '' : 'none';
      });
    }

    /****************************
     * Initialization & window resize handlers
     ****************************/
    function init() {
      // Aplicar estado del sidebar según el tamaño de pantalla
      if (window.innerWidth >= 992) {
        // Desktop - aplicar estado guardado
        if (sidebarState === 'closed') {
          sidebar.classList.add('hidden');
          document.getElementById('content').classList.add('fullwidth');
          sidebarToggle.classList.add('rotated');
        } else {
          sidebar.classList.remove('hidden');
          document.getElementById('content').classList.remove('fullwidth');
          sidebarToggle.classList.remove('rotated');
        }
      } else {
        // Mobile - sidebar siempre oculto inicialmente
        sidebar.classList.add('hidden');
      }

      // Inicializar navegación
      initNavigation();

      // Cargar datos existentes
      cargarResumen();
      cargarEventos();
      cargarInscripciones();
      cargarSelectEventos();

      // Inicializar nuevas secciones
      actualizarEstadisticasMisEventos();
      actualizarListaEventos();
      actualizarEstadisticasParticipantes();
      actualizarListaParticipantes();
      cargarSelectEventosParticipantes();

      // Generar reporte inicial
      generarReporte();
    }

    window.addEventListener('resize', () => {
      if (window.innerWidth >= 992) {
        // Desktop
        overlay.classList.remove('show');
        sidebar.classList.remove('visible');
        // Aplicar estado guardado
        if (sidebarState === 'closed') {
          sidebar.classList.add('hidden');
          document.getElementById('content').classList.add('fullwidth');
          sidebarToggle.classList.add('rotated');
        } else {
          sidebar.classList.remove('hidden');
          document.getElementById('content').classList.remove('fullwidth');
          sidebarToggle.classList.remove('rotated');
        }
      } else {
        // Mobile
        sidebar.classList.add('hidden');
        document.getElementById('content').classList.remove('fullwidth');
        sidebarToggle.classList.remove('rotated');
      }
    });

    // Exponer funciones globalmente
    window.mostrarFormularioAgregar = mostrarFormularioAgregar;
    window.mostrarFormularioInscripcion = mostrarFormularioInscripcion;
    window.actualizarParticipacion = actualizarParticipacion;
    window.editarEvento = editarEvento;
    window.eliminarEvento = eliminarEvento;
    window.eliminarInscripcion = eliminarInscripcion;
    window.exportEventos = exportEventos;
    window.exportInscripciones = exportInscripciones;

    // Inicializar
    init();

    /****************************
     * Accessibility: close sidebar with ESC
     ****************************/
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        if (sidebar.classList.contains('visible')) closeSidebarMobile();
      }
    });
  </script>
</body>

</html>