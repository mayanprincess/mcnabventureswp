/**
 * Medical 23andMe Theme - Main JavaScript
 */

(function() {
  'use strict';

  /**
   * Mobile Menu Toggle
   */
  function initMobileMenu() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const navigation = document.querySelector('.main-navigation');
    
    if (!menuToggle || !navigation) return;

    menuToggle.addEventListener('click', function() {
      const isExpanded = this.getAttribute('aria-expanded') === 'true';
      
      this.setAttribute('aria-expanded', !isExpanded);
      this.classList.toggle('is-active');
      navigation.classList.toggle('is-open');
      
      // Prevent body scroll when menu is open
      document.body.style.overflow = navigation.classList.contains('is-open') ? 'hidden' : '';
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
      if (!navigation.contains(e.target) && !menuToggle.contains(e.target)) {
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.classList.remove('is-active');
        navigation.classList.remove('is-open');
        document.body.style.overflow = '';
      }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && navigation.classList.contains('is-open')) {
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.classList.remove('is-active');
        navigation.classList.remove('is-open');
        document.body.style.overflow = '';
      }
    });
  }

  /**
   * Smooth Scroll for Anchor Links
   */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const target = document.querySelector(targetId);
        if (target) {
          e.preventDefault();
          const headerOffset = document.querySelector('.site-header')?.offsetHeight || 0;
          const elementPosition = target.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
          });
        }
      });
    });
  }

  /**
   * Header scroll behavior - frosted glass effect on scroll
   * Optimized with throttling using requestAnimationFrame
   */
  function initHeaderScroll() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    // Check initial scroll position
    if (window.pageYOffset > 10) {
      header.classList.add('is-scrolled');
    }

    let raf = 0;
    window.addEventListener('scroll', function() {
      if (raf) return;
      raf = window.requestAnimationFrame(() => {
        raf = 0;
        if (window.pageYOffset > 10) {
          header.classList.add('is-scrolled');
        } else {
          header.classList.remove('is-scrolled');
        }
      });
    }, { passive: true });
  }

  /**
   * Highlights slider (CSS scroll-snap + tiny JS)
   * Markup:
   *  - [data-highlights-viewport]
   *  - [data-highlights-slide]
   *  - [data-highlights-dot]
   *  - [data-highlights-prev] / [data-highlights-next]
   */
  function initHighlights() {
    const viewports = document.querySelectorAll('[data-highlights-viewport]');
    if (!viewports.length) return;

    viewports.forEach((viewport) => {
      const root = viewport.closest('.highlights');
      if (!root) return;

      const slides = Array.from(root.querySelectorAll('[data-highlights-slide]'));
      const dots = Array.from(root.querySelectorAll('[data-highlights-dot]'));
      const prevBtn = root.querySelector('[data-highlights-prev]');
      const nextBtn = root.querySelector('[data-highlights-next]');

      if (!slides.length) return;

      function getActiveIndex() {
        const left = viewport.scrollLeft;
        let bestIndex = 0;
        let bestDist = Infinity;
        slides.forEach((slide, idx) => {
          const dist = Math.abs(slide.offsetLeft - left);
          if (dist < bestDist) {
            bestDist = dist;
            bestIndex = idx;
          }
        });
        return bestIndex;
      }

      function scrollToIndex(index) {
        const slide = slides[index];
        if (!slide) return;
        viewport.scrollTo({ left: slide.offsetLeft, behavior: 'smooth' });
      }

      function setDisabled(btn, disabled) {
        if (!btn) return;
        btn.disabled = !!disabled;
        btn.setAttribute('aria-disabled', disabled ? 'true' : 'false');
      }

      function updateUI() {
        const idx = getActiveIndex();

        dots.forEach((dot, i) => {
          dot.setAttribute('aria-current', i === idx ? 'true' : 'false');
        });

        setDisabled(prevBtn, idx <= 0);
        setDisabled(nextBtn, idx >= slides.length - 1);
      }

      // Buttons
      if (prevBtn) {
        prevBtn.addEventListener('click', () => {
          const idx = getActiveIndex();
          scrollToIndex(Math.max(0, idx - 1));
        });
      }

      if (nextBtn) {
        nextBtn.addEventListener('click', () => {
          const idx = getActiveIndex();
          scrollToIndex(Math.min(slides.length - 1, idx + 1));
        });
      }

      // Dots
      dots.forEach((dot) => {
        dot.addEventListener('click', () => {
          const idx = parseInt(dot.getAttribute('data-index') || '0', 10);
          scrollToIndex(idx);
        });
      });

      // Scroll listener (rAF)
      let raf = 0;
      viewport.addEventListener('scroll', () => {
        if (raf) return;
        raf = window.requestAnimationFrame(() => {
          raf = 0;
          updateUI();
        });
      }, { passive: true });

      // Resize listener (simple)
      window.addEventListener('resize', updateUI);

      updateUI();
    });
  }

  /**
   * Initialize all functions when DOM is ready
   */
  document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initSmoothScroll();
    initHeaderScroll();
    initHighlights();
    // Multimedia component is initialized from multimedia.js
  });

})();
