 // JavaScript para el menú responsive
    document.addEventListener('DOMContentLoaded', function() {
      const hamburger = document.getElementById('hamburger');
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      const overlay = document.getElementById('overlay');
      const hasSubmenu = document.querySelectorAll('.has-submenu');
      
      // Toggle sidebar
      hamburger.addEventListener('click', function() {
        this.classList.toggle('active');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        
        if (window.innerWidth >= 992) {
          content.classList.toggle('expanded');
        }
      });
      
      // Cerrar sidebar al hacer clic en el overlay
      overlay.addEventListener('click', function() {
        hamburger.classList.remove('active');
        sidebar.classList.remove('active');
        this.classList.remove('active');
      });
      
      // Toggle submenús
      hasSubmenu.forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          this.classList.toggle('active');
          this.nextElementSibling.classList.toggle('active');
        });
      });
      
      // Ajustar contenido en carga
      if (window.innerWidth >= 992) {
        content.classList.add('expanded');
      }
      
      // Animaciones de elementos al hacer scroll
      const animatedElements = document.querySelectorAll('.animate-fadeIn, .staggered-animation > *');
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.animationPlayState = 'running';
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });
      
      animatedElements.forEach(el => {
        observer.observe(el);
      });
    });

    // JavaScript para el slider personalizado
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const progressBars = document.querySelectorAll('.slider-progress-bar');
    const totalSlides = slides.length;
    let slideInterval;

    function showSlide(n) {
      // Ocultar todas las slides
      slides.forEach(slide => {
        slide.classList.remove('active');
      });
      
      // Remover clase active de todos los dots
      dots.forEach(dot => {
        dot.classList.remove('active');
      });
      
      // Reiniciar barras de progreso
      progressBars.forEach(bar => {
        bar.style.width = '0%';
      });
      
      // Ajustar el índice si es necesario
      if (n >= totalSlides) {
        currentSlide = 0;
      } else if (n < 0) {
        currentSlide = totalSlides - 1;
      } else {
        currentSlide = n;
      }
      
      // Mostrar la slide actual
      slides[currentSlide].classList.add('active');
      dots[currentSlide].classList.add('active');
      
      // Iniciar la barra de progreso
      if (slides[currentSlide].classList.contains('active')) {
        progressBars[currentSlide].style.width = '100%';
      }
      
      // Reiniciar el intervalo
      restartSlideInterval();
    }

    function changeSlide(n) {
      showSlide(currentSlide + n);
    }

    function goToSlide(n) {
      showSlide(n);
    }

    function restartSlideInterval() {
      clearInterval(slideInterval);
      slideInterval = setInterval(() => {
        changeSlide(1);
      }, 5000);
    }

    // Inicializar el slider
    showSlide(currentSlide);
    
    // Pausar el slider al pasar el ratón por encima
    const slider = document.querySelector('.hero-slider');
    slider.addEventListener('mouseenter', () => {
      clearInterval(slideInterval);
    });
    
    slider.addEventListener('mouseleave', () => {
      restartSlideInterval();
    });