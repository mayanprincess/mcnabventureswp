/**
 * Scroll Reveal Animation
 * Elements with [data-scroll-reveal] fade-in cuando entran al viewport
 * Muy eficiente usando Intersection Observer API
 */

(function() {
  'use strict';

  // Detectar soporte de Intersection Observer
  if (!('IntersectionObserver' in window)) {
    // Fallback: mostrar todos los elementos inmediatamente
    document.querySelectorAll('[data-scroll-reveal]').forEach(el => {
      el.classList.add('revealed');
    });
    return;
  }

  const observerOptions = {
    threshold: 0.1, // Trigger cuando 10% visible
    rootMargin: '0px 0px -50px 0px' // Start revealing 50px antes de entrar
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        // Unobserve después de revelar para performance
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observar todos los elementos con data-scroll-reveal
  document.querySelectorAll('[data-scroll-reveal]').forEach((el) => {
    observer.observe(el);
  });
})();
