/**
 * Multimedia Component - McNab Ventures
 *
 * Handles:
 * - Tab switching (Photos/Videos galleries)
 * - Masonry gallery display
 * - Simple video grid
 */

(function() {
  'use strict';

  function initMultimedia() {
    const multimediaContainers = document.querySelectorAll('[data-multimedia]');
    if (!multimediaContainers.length) return;

    multimediaContainers.forEach(container => {
      const tabs = Array.from(container.querySelectorAll('[data-tab-index]'));
      const galleries = Array.from(container.querySelectorAll('[data-gallery]'));

      if (!galleries.length) return;

      /**
       * Switch to specific tab
       */
      function switchTab(tabIndex) {
        // Update active gallery visibility
        galleries.forEach((gallery, index) => {
          gallery.classList.toggle('is-active', index === tabIndex);
        });

        // Update active tab UI
        tabs.forEach((tab, index) => {
          tab.classList.toggle('is-active', index === tabIndex);
          tab.setAttribute('aria-selected', index === tabIndex ? 'true' : 'false');
        });
      }

      // Initialize tabs click handlers
      tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => switchTab(index));

        // Keyboard navigation
        tab.addEventListener('keydown', (e) => {
          let targetIndex = index;

          if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
            e.preventDefault();
            targetIndex = (index + 1) % tabs.length;
          } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
            e.preventDefault();
            targetIndex = (index - 1 + tabs.length) % tabs.length;
          } else if (e.key === 'Home') {
            e.preventDefault();
            targetIndex = 0;
          } else if (e.key === 'End') {
            e.preventDefault();
            targetIndex = tabs.length - 1;
          } else {
            return;
          }

          switchTab(targetIndex);
          tabs[targetIndex].focus();
        });
      });

      // Initial state - first tab active
      if (tabs.length > 0) {
        switchTab(0);
      }
    });
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMultimedia);
  } else {
    initMultimedia();
  }

  // Also allow manual re-initialization
  window.initMultimedia = initMultimedia;

})();
