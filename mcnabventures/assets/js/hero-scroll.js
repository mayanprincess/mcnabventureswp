/**
 * Hero Scroll Indicator - McNab Ventures
 *
 * Automatically detects the next section after the hero
 * and smoothly scrolls to it when the scroll indicator is clicked.
 */

(function() {
  'use strict';

  function initHeroScroll() {
    const scrollIndicators = document.querySelectorAll('.hero__scroll-indicator');

    if (!scrollIndicators.length) return;

    scrollIndicators.forEach(indicator => {
      // Ensure accessibility attributes
      if (!indicator.hasAttribute('tabindex')) {
        indicator.setAttribute('tabindex', '0');
      }
      if (!indicator.hasAttribute('role')) {
        indicator.setAttribute('role', 'button');
      }
      if (!indicator.hasAttribute('aria-label')) {
        indicator.setAttribute('aria-label', 'Scroll to next section');
      }

      indicator.addEventListener('click', function() {
        // Find the hero parent element
        const hero = this.closest('.groups-hero, .homepageHero, .heroGold, .feature-hero');

        if (!hero) return;

        // Find the next sibling element (the next section)
        let nextSection = hero.nextElementSibling;

        // Skip empty text nodes and comments
        while (nextSection && nextSection.nodeType !== 1) {
          nextSection = nextSection.nextElementSibling;
        }

        // If we found a next section, scroll to it
        if (nextSection) {
          nextSection.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });

      // Add keyboard support (Enter or Space)
      indicator.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.click();
        }
      });
    });
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroScroll);
  } else {
    initHeroScroll();
  }

  // Allow manual re-initialization
  window.initHeroScroll = initHeroScroll;

})();
