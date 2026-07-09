<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ORATORIO Y LITURGIA</title>
  <link rel="shortcut icon" href="../assets/img/logo.jpg">
  <link rel="stylesheet" href="../chatbot/frontend/style.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="../css/menuu.css">

</head>

<body>
  <!-- Overlay para móviles -->
  <div class="overlay" id="overlay"></div>

  <!-- Botón hamburguesa moderno -->
  <button class="hamburger" id="hamburger">
    <span></span>
    <span></span>
    <span></span>
  </button>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <a href="../cliente/menu.php"><i class="fas fa-home"></i> Inicio</a>
    <a href="../cliente/Nosotros.php"><i class="fas fa-users"></i> Sobre Nosotros</a>

    <a href="#" class="has-submenu"><i class="fas fa-calendar-alt"></i> Actividades <i class="fas fa-chevron-down ms-auto"></i></a>
    <div class="submenu">
      <a href="#">Eventos</a>
      <a href="#">Talleres</a>
      <a href="#">Voluntariado</a>
    </div>

    <!-- Menú Informaciones -->
    <a href="#" class="has-submenu">
      <i class="fas fa-info-circle"></i> Informaciones
      <i class="fas fa-chevron-down ms-auto"></i>
    </a>
    <div class="submenu">
      <a href="#">Calendario de eventos</a>
      <a href="#">Contáctenos</a>
      <a href="#">Eventos</a>
      <a href="#">Noticias o Comunicados</a>
      <a href="#">Inscripciones</a>
    </div>

    <!-- Nuevo Menú Formularios -->
    <a href="#" class="has-submenu">
      <i class="fas fa-file-alt"></i> Formularios
      <i class="fas fa-chevron-down ms-auto"></i>
    </a>
    <div class="submenu">
      <a href="../cliente/actividades.php">Actividades</a>
      <a href="../cliente/asistencias.php">Asistencias</a>
      <a href="../cliente/eventos.php">Eventos</a>
      <a href="../cliente/inscripcion.php">Inscripción</a>
      <a href="../cliente/pagos.php">Pagos</a>
      <a href="../cliente/personas.php">Personas</a>
      <a href="../cliente/universidades.php">Universidades</a>
      <a href="../cliente/usuarios_sistema.php">Usuario</a>
      <a href="../cliente/FormacionSacramental.php">Formación Sacramental</a>
    </div>

    <!-- Botón Servicios -->
<a href="../cliente/Servicios.php" class="button-servicios">
  <i class="fas fa-concierge-bell"></i> Servicios
</a>


    <a href="#"><i class="fas fa-newspaper"></i> Noticias</a>
    <!--<a href="#"><i class="fas fa-bell"></i> Notificaciones</a> -->
    <!--<a href="#"><i class="fas fa-cogs"></i> Configuración</a> -->
    <a href="../cliente/Contacto.php"><i class="fas fa-phone"></i> Contacto</a>
    <a href="#"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
    <a href="../cliente/login.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
  </div>

  <!-- Redes sociales flotantes -->
  <div class="social-float">
    <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
    <a href="#" class="tiktok"><i class="fab fa-tiktok"></i></a>
    <a href="#" class="whatsapp"><i class="fab fa-whatsapp"></i></a>
  </div>


  <!-- Contenido principal -->
  <div class="content" id="content">
    <div class="container-box my-5 text-center">
      <h2 class="welcome-title mb-4 animate__animated animate__fadeInDown">BIENVENIDO AL ORATORIO Y LITURGIA</h2>

      <div class="container">
        <!-- Nuestro Equipo -->
        <a href="../cliente/Equipo.php"
          class="btn btn-success btn-acerca fw-bold d-inline-flex align-items-center justify-content-center animate__animated animate__fadeInLeft">
          <i class="fas fa-users me-2"></i> Nuestro Equipo
        </a>

        <!-- Galeria -->
        <a href="../cliente/Galeria.php"
          class="btn btn-danger btn-acerca fw-bold d-inline-flex align-items-center justify-content-center animate__animated animate__fadeInRight">
          <i class="fas fa-images me-2"></i> Galeria
        </a>
        <!-- Actividades -->
        <a href="../cliente/actividades_oratorio.php"
          class="btn btn-primary btn-acerca fw-bold d-inline-flex align-items-center justify-content-center animate__animated animate__fadeInRight">
          <i class="fas fa-calendar-alt me-2"></i> Actividades
        </a>

      </div>
    </div>

    <!-- Slider mejorado con estilo de caja -->
    <div class="hero-slider-container">
      <div class="hero-slider">
        <div class="slide active">
          <img src="../assets/img/carousel/img3.jpg" alt="Evento Cultural" class="slide-image">
          <div class="slide-content">
            <h2 class="slide-title">Evento Cultural</h2>
            <p class="slide-description">Descubre la riqueza de nuestras tradiciones y participa en nuestras actividades culturales.</p>
            <a href="#" class="slide-btn">Ver más</a>
          </div>
          <div class="slider-progress">
            <div class="slider-progress-bar"></div>
          </div>
        </div>

        <div class="slide">
          <img src="../assets/img/carousel/img1.jpg" alt="Formación Sacramental" class="slide-image">
          <div class="slide-content">
            <h2 class="slide-title">Formación Sacramental</h2>
            <p class="slide-description">Profundiza en tu fe y participa en nuestras actividades de formación espiritual.</p>
            <a href="#" class="slide-btn">Ver más</a>
          </div>
          <div class="slider-progress">
            <div class="slider-progress-bar"></div>
          </div>
        </div>

        <div class="slide">
          <img src="../assets/img/carousel/img2.jpg" alt="Reunión Comunitaria" class="slide-image">
          <div class="slide-content">
            <h2 class="slide-title">Reunión Comunitaria</h2>
            <p class="slide-description">Conecta con nuestra comunidad universitaria y comparte experiencias enriquecedoras.</p>
            <a href="#" class="slide-btn">Ver más</a>
          </div>
          <div class="slider-progress">
            <div class="slider-progress-bar"></div>
          </div>
        </div>

        <div class="slider-arrow prev" onclick="changeSlide(-1)">
          <i class="fas fa-chevron-left"></i>
        </div>
        <div class="slider-arrow next" onclick="changeSlide(1)">
          <i class="fas fa-chevron-right"></i>
        </div>

        <div class="slider-controls">
          <div class="slider-dot active" onclick="goToSlide(0)"></div>
          <div class="slider-dot" onclick="goToSlide(1)"></div>
          <div class="slider-dot" onclick="goToSlide(2)"></div>
        </div>
      </div>
    </div>

    <!-- Eventos Destacados -->
    <div class="events-container">
      <h2 class="mb-4 text-center animate__animated animate__fadeIn">Eventos Destacados</h2>
      <div class="row g-4 mb-5 staggered-animation">
        <div class="col-md-4">
          <div class="card event-card">
            <img src="../assets/img/IMG1.png" class="card-img-top" alt="Evento A">
            <div class="card-body">
              <h5 class="card-title">Noche de Talento <span class="badge bg-success">Nuevo</span></h5>
              <p class="card-text">Una velada llena de música, danza y creatividad donde brillan los talentos locales.</p>
              <a href="#" class="btn btn-primary">Más Información</a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card event-card">
            <img src="../assets/img/IMG2.1.jpg" class="card-img-top" alt="Evento B">
            <div class="card-body">
              <h5 class="card-title">Taller de Oratoria <span class="badge bg-warning text-dark">Popular</span></h5>
              <p class="card-text">Mejora tus habilidades de comunicación y liderazgo.</p>
              <a href="#" class="btn btn-primary">Más Información</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card event-card">
            <img src="https://source.unsplash.com/400x200/?community,activity" class="card-img-top" alt="Evento C">
            <div class="card-body">
              <h5 class="card-title">Voluntariado Comunitario <span class="badge bg-info text-dark">Inscripción Abierta</span></h5>
              <p class="card-text">Participa en actividades de apoyo y servicio social.</p>
              <a href="#" class="btn btn-primary">Más Información</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <!-- Efecto de ola decorativa -->
    <div class="footer-wave">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
      </svg>
    </div>

    <div class="footer-container">
      <div class="footer-content">
        <!-- Columna 1: Sobre nosotros -->
        <div class="footer-column">
          <h3>Oratorio Universitario</h3>
          <p>Conectando con nuestra comunidad universitaria y fomentando valores salesianos a través de actividades espirituales, culturales y sociales.</p>
          <div class="footer-social">
            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <!-- Columna 2: Instalaciones -->
        <div class="footer-column">
          <h3>Instalaciones</h3>
          <ul class="footer-links">
            <li><a href="#"><i class="fas fa-info-circle"></i> Informaciones</a></li>
            <li><a href="#"><i class="fas fa-file-alt"></i> Formularios</a></li>
            <li><a href="#"><i class="fas fa-concierge-bell"></i> Servicios</a></li>
            <li><a href="#"><i class="fas fa-newspaper"></i> Noticias</a></li>
            <li><a href="#"><i class="fas fa-bell"></i> Notificaciones</a></li>
            <li><a href="#"><i class="fas fa-cogs"></i> Configuración</a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
          </ul>
        </div>

        <!-- Columna 3: Enlaces rápidos -->
        <div class="footer-column">
          <h3>Enlaces Rápidos</h3>
          <ul class="footer-links">
            <li><a href="#"><i class="fas fa-home"></i> Inicio <span class="footer-badge">2.0</span></a></li>
            <li><a href="#"><i class="fas fa-calendar-alt"></i> Eventos <span class="footer-badge">3.0</span></a></li>
            <li><a href="#"><i class="fas fa-newspaper"></i> Noticias <span class="footer-badge">4.0</span></a></li>
            <li><a href="#"><i class="fas fa-images"></i> Galería <span class="footer-badge">5.0</span></a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Contacto <span class="footer-badge">6.0</span></a></li>
            <li><a href="#"><i class="fas fa-calendar"></i> Abril <span class="footer-badge">1.0</span></a></li>
          </ul>
        </div>

        <!-- Columna 4: Contacto -->
        <div class="footer-column">
          <h3>Contacto</h3>
          <ul class="footer-links footer-contact">
            <li><i class="fas fa-map-marker-alt"></i>
              <div>Av. Principal 123, Ciudad</div>
            </li>
            <li><i class="fas fa-phone"></i>
              <div>+123 456 7890</div>
            </li>
            <li><i class="fas fa-envelope"></i>
              <div>info@oratorio.edu</div>
            </li>
            <li><i class="fas fa-clock"></i>
              <div>Lun-Vie: 9:00 AM - 6:00 PM</div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Oratorio y Liturgia - Todos los derechos reservados</p>
      <div class="footer-bottom-links">
        <a href="#">Política de Privacidad</a>
        <a href="#">Términos de Uso</a>
        <a href="#">Mapa del Sitio</a>
      </div>
    </div>
  </footer>



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="../js/menu.js"> </script>

  <!--Chatbot-->
  <script>
    (function() {
      if (!window.chatbase || window.chatbase("getState") !== "initialized") {
        window.chatbase = (...arguments) => {
          if (!window.chatbase.q) {
            window.chatbase.q = []
          }
          window.chatbase.q.push(arguments)
        };
        window.chatbase = new Proxy(window.chatbase, {
          get(target, prop) {
            if (prop === "q") {
              return target.q
            }
            return (...args) => target(prop, ...args)
          }
        })
      }
      const onLoad = function() {
        const script = document.createElement("script");
        script.src = "https://www.chatbase.co/embed.min.js";
        script.id = "0MJJ4vCJqVVjsqSb4KmAi";
        script.domain = "www.chatbase.co";
        document.body.appendChild(script)
      };
      if (document.readyState === "complete") {
        onLoad()
      } else {
        window.addEventListener("load", onLoad)
      }
    })();

    const crypto = require('crypto');
    const secret = 'y37cqdomdrgvbliyfnjgbq83ukgtsw3d'; // Your verification secret key
    const userId = current_user.id // A string UUID to identify your user

    const hash = crypto.createHmac('sha256', secret).update(userId).digest('hex');
  </script>
</body>

</html>