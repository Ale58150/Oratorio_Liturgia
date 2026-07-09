<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nuestro Equipo</title>
  <link rel="shortcut icon" href="../assets/img/logo.jpg" />
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  
  <!-- Estilos personalizados -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    header {
      background: linear-gradient(135deg, #0066cc, #00bfff);
      color: white;
      text-align: center;
      padding: 60px 20px;
      border-bottom: 4px solid #004080;
    }
    header h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }
    header p {
      font-size: 1.2rem;
    }

    /* Cards de equipo */
    .team-card {
      border-radius: 15px;
      transition: transform 0.3s, box-shadow 0.3s;
      background: linear-gradient(145deg, #ffffff, #f0f0f0);
      text-align: center;
      overflow: hidden;
    }
    .team-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .team-card img {
      width: 100%;
      height: auto;
      display: block;
      object-fit: cover;
      border-bottom: 4px solid #0056b3;
      transition: transform 0.3s;
    }
    .team-card img:hover {
      transform: scale(1.05);
    }
    .team-card .card-body {
      padding: 20px;
    }
    .team-card .card-title {
      margin-top: 15px;
      font-size: 1.25rem;
      font-weight: 600;
    }
    .team-card .card-text {
      font-size: 0.95rem;
      color: #6c757d;
      margin-top: 10px;
    }

    /* Footer */
    footer {
      background-color: #343a40;
      color: white;
      padding: 30px 20px;
      text-align: center;
    }
    footer a.social-icon {
      font-size: 1.5rem;
      margin: 0 10px;
      display: inline-block;
      transition: transform 0.3s, filter 0.3s;
    }
    footer a.social-icon:hover {
      transform: translateY(-3px);
      filter: brightness(1.2);
    }
    .social-icon.whatsapp { color: #25D366; }
    .social-icon.tiktok { color: #000000; }
    .social-icon.facebook { color: #1877F2; }
    .social-icon.instagram { color: #E1306C; }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <h1><i class="fas fa-users"></i> Nuestro Equipo</h1>
    <p>Conoce a los encargados del Oratorio y Liturgia – Universidad Salesiana de Bolivia</p>
  </header>

  <!-- Sección: Nuestro Equipo -->
  <section class="container py-5">
    <div class="row g-4 justify-content-center">

      <!-- Padre Máxima Autoridad -->
      <div class="col-md-4">
        <div class="team-card shadow-lg h-100">
          <img src="../assets/img/P._Marcelo_Escalante.jpg" alt="Padre Máxima Autoridad">
          <div class="card-body">
            <h5 class="card-title text-primary">Padre Máxima Autoridad</h5>
            <p class="card-text">Supervisa y guía todas las actividades pastorales del Oratorio, asegurando que se cumpla con los valores salesianos.</p>
          </div>
        </div>
      </div>

      <!-- Responsable -->
      <div class="col-md-4">
        <div class="team-card shadow-lg h-100">
          <img src="../assets/img/responsable.jpg" alt="Responsable">
          <div class="card-body">
            <h5 class="card-title text-success">Responsable</h5>
            <p class="card-text">Coordina las actividades del equipo y mantiene la comunicación con los jóvenes, asegurando el correcto funcionamiento del Oratorio.</p>
          </div>
        </div>
      </div>

      <!-- Encargado -->
      <div class="col-md-4">
        <div class="team-card shadow-lg h-100">
          <img src="" alt="Encargado">
          <div class="card-body">
            <h5 class="card-title text-warning">Encargado</h5>
            <p class="card-text">Apoya en la organización de actividades, logística y recursos, asegurando que cada evento se desarrolle correctamente.</p>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer profesional con redes sociales -->
  <footer>
    <p>&copy; 2025 Oratorio y Liturgia - Universidad Salesiana de Bolivia</p>
    <p>Desarrollado con <i class="fas fa-heart text-danger"></i></p>
    <div>
      <a href="https://wa.me/59112345678" target="_blank" class="social-icon whatsapp" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
      <a href="https://www.tiktok.com/@tuusuario" target="_blank" class="social-icon tiktok" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
      <a href="https://www.facebook.com/tuusuario" target="_blank" class="social-icon facebook" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.instagram.com/tuusuario" target="_blank" class="social-icon instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
