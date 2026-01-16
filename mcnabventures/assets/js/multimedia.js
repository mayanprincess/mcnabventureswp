/**
 * Multimedia Component - McNab Ventures
 *
 * Handles:
 * - Tab filtering (Photos/Videos)
 * - Gallery carousel with pagination
 * - Navigation buttons (prev/next)
 * - Responsive grid adjustments
 */

(function() {
  'use strict';

  function initMultimedia() {
    const multimediaContainers = document.querySelectorAll('[data-multimedia]');
    if (!multimediaContainers.length) return;

    multimediaContainers.forEach(container => {
      const gallery = container.querySelector('[data-gallery]');
      const tabs = Array.from(container.querySelectorAll('[data-tab]'));
      const pagination = container.querySelector('[data-pagination]');
      const dots = Array.from(container.querySelectorAll('[data-pagination] [data-page]'));
      const prevBtn = container.querySelector('[data-nav="prev"]');
      const nextBtn = container.querySelector('[data-nav="next"]');
      const playBtns = Array.from(container.querySelectorAll('.multimedia__play-btn'));

      if (!gallery) return;

      // State
      let currentPage = 0;
      let activeTabType = null;
      let itemsPerPage = getItemsPerPage();

      /**
       * Get items per page based on screen size
       */
      function getItemsPerPage() {
        const width = window.innerWidth;
        if (width < 768) return 2;   // mobile: 2 items
        if (width < 1024) return 6;  // tablet: 6 items
        return 12;                    // desktop: 12 items
      }

      /**
       * Get all items and apply filters
       */
      function getFilteredItems() {
        const items = Array.from(gallery.querySelectorAll('.multimedia__item'));

        if (activeTabType) {
          return items.filter(item => {
            const itemType = item.getAttribute('data-item-type');
            return itemType === activeTabType || activeTabType === 'all';
          });
        }

        return items;
      }

      /**
       * Get items for current page
       */
      function getPageItems() {
        const filtered = getFilteredItems();
        const start = currentPage * itemsPerPage;
        const end = start + itemsPerPage;
        return filtered.slice(start, end);
      }

      /**
       * Get total pages
       */
      function getTotalPages() {
        const filtered = getFilteredItems();
        return Math.ceil(filtered.length / itemsPerPage);
      }

      /**
       * Update gallery visibility
       */
      function updateGalleryVisibility() {
        const filtered = getFilteredItems();
        const pageItems = getPageItems();
        const pageItemsIndices = pageItems.map(item =>
          filtered.indexOf(item)
        );

        gallery.querySelectorAll('.multimedia__item').forEach(item => {
          const index = getFilteredItems().indexOf(item);
          item.style.display = pageItemsIndices.includes(index) ? '' : 'none';
        });
      }

      /**
       * Update pagination dots
       */
      function updatePaginationDots() {
        const totalPages = getTotalPages();

        // Create dots dynamically if needed
        if (dots.length !== totalPages && pagination) {
          pagination.innerHTML = '';
          for (let i = 0; i < totalPages; i++) {
            const dot = document.createElement('div');
            dot.className = 'multimedia__dot';
            dot.setAttribute('data-page', i);
            dot.setAttribute('role', 'button');
            dot.setAttribute('tabindex', '0');
            dot.setAttribute('aria-label', `Página ${i + 1}`);

            if (i === currentPage) {
              dot.classList.add('is-active');
            }

            dot.addEventListener('click', () => goToPage(i));
            dot.addEventListener('keydown', (e) => {
              if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                goToPage(i);
              }
            });

            pagination.appendChild(dot);
          }
        } else {
          dots.forEach((dot, index) => {
            if (index === currentPage) {
              dot.classList.add('is-active');
            } else {
              dot.classList.remove('is-active');
            }
          });
        }
      }

      /**
       * Update navigation buttons
       */
      function updateNavigationButtons() {
        const totalPages = getTotalPages();

        if (prevBtn) {
          prevBtn.disabled = currentPage <= 0;
          prevBtn.setAttribute('aria-disabled', currentPage <= 0 ? 'true' : 'false');
        }

        if (nextBtn) {
          nextBtn.disabled = currentPage >= totalPages - 1;
          nextBtn.setAttribute('aria-disabled', currentPage >= totalPages - 1 ? 'true' : 'false');
        }
      }

      /**
       * Go to specific page
       */
      function goToPage(pageNum) {
        const totalPages = getTotalPages();

        if (pageNum < 0 || pageNum >= totalPages) return;

        currentPage = pageNum;
        updateGalleryVisibility();
        updatePaginationDots();
        updateNavigationButtons();
      }

      /**
       * Next page
       */
      function nextPage() {
        const totalPages = getTotalPages();
        if (currentPage < totalPages - 1) {
          goToPage(currentPage + 1);
        }
      }

      /**
       * Previous page
       */
      function prevPage() {
        if (currentPage > 0) {
          goToPage(currentPage - 1);
        }
      }

      /**
       * Switch tab and reset pagination
       */
      function switchTab(tabType) {
        activeTabType = tabType;
        currentPage = 0;

        // Update active tab UI
        tabs.forEach(tab => {
          if (tab.getAttribute('data-tab') === tabType) {
            tab.classList.add('is-active');
          } else {
            tab.classList.remove('is-active');
          }
        });

        updateGalleryVisibility();
        updatePaginationDots();
        updateNavigationButtons();
      }

      /**
       * Handle window resize
       */
      function handleResize() {
        const newItemsPerPage = getItemsPerPage();
        if (newItemsPerPage !== itemsPerPage) {
          itemsPerPage = newItemsPerPage;
          currentPage = 0;
          updateGalleryVisibility();
          updatePaginationDots();
          updateNavigationButtons();
        }
      }

      /**
       * Play button handler - modal or expand
       */
      function handlePlayClick(btn, index) {
        btn.addEventListener('click', () => {
          const item = gallery.querySelectorAll('.multimedia__item')[index];
          if (!item) return;

          const media = item.querySelector('.multimedia__media');
          if (media && media.tagName === 'VIDEO') {
            media.play();
          }
          // Could trigger lightbox/modal here
        });
      }

      // Initialize tabs
      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          switchTab(tab.getAttribute('data-tab'));
        });
      });

      // Initialize pagination
      dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToPage(index));
        dot.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            goToPage(index);
          }
        });
      });

      // Initialize navigation buttons
      if (prevBtn) {
        prevBtn.addEventListener('click', prevPage);
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', nextPage);
      }

      // Initialize play buttons
      playBtns.forEach((btn, index) => {
        handlePlayClick(btn, index);
      });

      // Handle resize
      let resizeRaf = 0;
      window.addEventListener('resize', () => {
        if (resizeRaf) return;
        resizeRaf = window.requestAnimationFrame(() => {
          resizeRaf = 0;
          handleResize();
        });
      }, { passive: true });

      // Keyboard navigation
      document.addEventListener('keydown', (e) => {
        if (!container.contains(document.activeElement)) return;

        if (e.key === 'ArrowRight') {
          e.preventDefault();
          nextPage();
        } else if (e.key === 'ArrowLeft') {
          e.preventDefault();
          prevPage();
        }
      });

      // Initial render
      updateGalleryVisibility();
      updatePaginationDots();
      updateNavigationButtons();
    });
  }

  // Initialize when DOM is ready
  document.addEventListener('DOMContentLoaded', initMultimedia);

  // Also allow manual re-initialization
  window.initMultimedia = initMultimedia;

})();
