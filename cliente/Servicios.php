<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Oratorio y Liturgia</title>
    <link rel="shortcut icon" href="../assets/img/logo.jpg">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --dark-blue: #003366;
            --medium-blue: #0056b3;
            --gold: #FFD700;
            --light-gold: #FFED4E;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--white);
            color: #333;
            line-height: 1.6;
            padding: 20px 0 0 0;
        }

        .simple-header {
            background-color: var(--dark-blue);
            color: var(--white);
            text-align: center;
            padding: 40px 20px;
            margin-bottom: 40px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .simple-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .simple-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Sección de Servicios */
        .services-section {
            padding: 40px 0 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }

        .section-title h2 {
            color: var(--dark-blue);
            font-weight: 700;
            margin-bottom: 15px;
            display: inline-block;
        }

        .section-title h2:after {
            content: '';
            position: absolute;
            width: 70px;
            height: 4px;
            background-color: var(--gold);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .service-card {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            border: 1px solid rgba(0, 51, 102, 0.1);
            margin-bottom: 30px;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .service-icon {
            background: linear-gradient(135deg, var(--gold), var(--light-gold));
            color: var(--dark-blue);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 25px auto 15px;
            font-size: 1.8rem;
        }

        .service-card-body {
            padding: 0 20px 25px;
            text-align: center;
        }

        .service-card-title {
            color: var(--dark-blue);
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .service-card-text {
            color: #555;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .service-btn {
            background-color: var(--dark-blue);
            border: none;
            color: var(--white);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 15px;
            display: inline-block;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .service-btn:hover {
            background-color: var(--medium-blue);
            transform: scale(1.05);
            color: var(--white);
        }

        /* Footer simplificado */
        .simple-footer {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 40px 0 20px;
            text-align: center;
            border-radius: 15px 15px 0 0;
            margin-top: 40px;
        }

        .simple-footer h5 {
            color: var(--gold);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .simple-footer p {
            color: rgba(255, 255, 255, 0.8);
            max-width: 500px;
            margin: 0 auto 25px;
        }

        .footer-contact {
            margin-bottom: 20px;
        }

        .footer-contact div {
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.8);
        }

        .social-links {
            margin-top: 20px;
        }

        .social-links a {
            color: var(--white);
            margin: 0 10px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: var(--gold);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .service-card {
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .service-card:nth-child(1) { animation-delay: 0.1s; }
        .service-card:nth-child(2) { animation-delay: 0.2s; }
        .service-card:nth-child(3) { animation-delay: 0.3s; }
        .service-card:nth-child(4) { animation-delay: 0.4s; }
        .service-card:nth-child(5) { animation-delay: 0.5s; }
        .service-card:nth-child(6) { animation-delay: 0.6s; }

        /* Responsive */
        @media (max-width: 768px) {
            .simple-header h1 { font-size: 1.8rem; }
            .simple-header p { font-size: 1rem; }
            .section-title h2 { font-size: 1.8rem; }
            .service-card { margin-bottom: 20px; }
        }
    </style>
</head>

<body>
    <!-- Header simple -->
    <header class="simple-header">
        <div class="container">
            <h1><i class="fas fa-church"></i> Oratorio y Liturgia</h1>
            <p>Servicios para el crecimiento espiritual y comunitario</p>
        </div>
    </header>

    <!-- Sección de Servicios -->
    <section class="services-section">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
                <p>Descubre todas las actividades que ofrecemos</p>
            </div>

            <div class="row">
                <!-- Formación Sacramental -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card" id="formacion">
                        <div class="service-icon">
                            <i class="fas fa-bible"></i>
                        </div>
                        <div class="service-card-body">
                            <h3 class="service-card-title">Formación Sacramental</h3>
                            <p class="service-card-text">
                                Preparación para sacramentos: Bautismo, Primera Comunión, Confirmación y Matrimonio.
                            </p>
                            <a href="#" class="service-btn" data-bs-toggle="modal" data-bs-target="#modalFormacion">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Voluntariado Social -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card" id="voluntariado">
                        <div class="service-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <div class="service-card-body">
                            <h3 class="service-card-title">Voluntariado Social</h3>
                            <p class="service-card-text">
                                Iniciativas de servicio comunitario para ayudar a quienes más lo necesitan.
                            </p>
                            <a href="#" class="service-btn" data-bs-toggle="modal" data-bs-target="#modalVoluntariado">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Musical -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card" id="musical">
                        <div class="service-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="service-card-body">
                            <h3 class="service-card-title">Musical</h3>
                            <p class="service-card-text">
                                Coros, grupos instrumentales y talleres de música sacra para la liturgia.
                            </p>
                            <a href="#" class="service-btn" data-bs-toggle="modal" data-bs-target="#modalMusical">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Talleres Universitarios -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card" id="talleres">
                        <div class="service-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="service-card-body">
                            <h3 class="service-card-title">Talleres Universitarios</h3>
                            <p class="service-card-text">
                                Espacios de reflexión y crecimiento personal para estudiantes universitarios.
                            </p>
                            <a href="#" class="service-btn" data-bs-toggle="modal" data-bs-target="#modalTalleres">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Asociacionismo -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card" id="asociacionismo">
                        <div class="service-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="service-card-body">
                            <h3 class="service-card-title">Asociacionismo</h3>
                            <p class="service-card-text">
                                Grupos y asociaciones para desarrollar liderazgo y construir comunidad.
                            </p>
                            <a href="#" class="service-btn" data-bs-toggle="modal" data-bs-target="#modalAsociacionismo">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Próximamente -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="service-card-body">
                            <h3 class="service-card-title">Nuevos Programas</h3>
                            <p class="service-card-text">
                                Estamos trabajando en nuevos servicios para nuestra comunidad.
                            </p>
                            <a href="#" class="service-btn" data-bs-toggle="modal" data-bs-target="#modalProximamente">Informarse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer simplificado -->
    <footer class="simple-footer">
        <div class="container">
            <h5>Oratorio y Liturgia</h5>
            <p>Un espacio dedicado al crecimiento espiritual, la comunidad y el servicio.</p>
            
            <div class="footer-contact">
                <div><i class="fas fa-map-marker-alt me-2"></i> La Paz: Av.Chacaltaya Nro.1258, Zona Achachicala.</div>
                <div><i class="fas fa-phone me-2"></i> Celular: (591) 72002192</div>
                <div><i class="fas fa-envelope me-2"></i> www.usalesiana.edu.bo</div>
            </div>
            
            <div class="social-links">
                <a href="https://www.facebook.com/share/19hQUo9Yht/"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/pastoraluniversitariausb?igsh=YzVlcW9uNDM3aHJm"><i class="fab fa-instagram"></i></a>
                <a href="https://www.tiktok.com/@pastoraluniversitariausb?_t=ZM-8zZknjhgwL8&_r=1"><i class= "fab fa-tiktok"></i></a> 
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 Oratorio y Liturgia. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Modales de cada servicio -->
    <!-- Formación Sacramental -->
    <div class="modal fade" id="modalFormacion" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Formación Sacramental</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>Ofrecemos preparación completa para sacramentos: Bautismo, Primera Comunión, Confirmación y Matrimonio. Clases personalizadas, acompañamiento espiritual y recursos online para estudiantes y familias.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Voluntariado Social -->
    <div class="modal fade" id="modalVoluntariado" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Voluntariado Social</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>Participa en actividades de servicio comunitario: apoyo a personas vulnerables, campañas de solidaridad, talleres educativos y más.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Musical -->
    <div class="modal fade" id="modalMusical" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Musical</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>Clases de coro, talleres de instrumentos y música sacra para liturgia, desarrollando habilidades musicales y espirituales.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Talleres Universitarios -->
    <div class="modal fade" id="modalTalleres" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Talleres Universitarios</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>Espacios de reflexión, crecimiento personal y formación espiritual especialmente diseñados para estudiantes universitarios.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Asociacionismo -->
    <div class="modal fade" id="modalAsociacionismo" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Asociacionismo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>Grupos y asociaciones para desarrollar liderazgo, fomentar la colaboración y construir comunidad en el oratorio.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Próximamente -->
    <div class="modal fade" id="modalProximamente" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nuevos Programas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>Estamos trabajando en nuevos servicios para nuestra comunidad. ¡Mantente atento a nuestras novedades y próximos programas!</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        // Animaciones de scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.service-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(card);
            });

            // Suavizar desplazamiento para enlaces internos
            document.querySelectorAll('a[href^="#"]').forEach(item => {
                item.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        e.preventDefault();
                        window.scrollTo({
                            top: targetElement.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
