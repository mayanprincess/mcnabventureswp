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
   */
  function initHeaderScroll() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    // Check initial scroll position
    if (window.pageYOffset > 10) {
      header.classList.add('is-scrolled');
    }

    window.addEventListener('scroll', function() {
      if (window.pageYOffset > 10) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    }, { passive: true });
  }

  /**
   * Initialize all functions when DOM is ready
   */
  document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initSmoothScroll();
    initHeaderScroll();
  });

})();
