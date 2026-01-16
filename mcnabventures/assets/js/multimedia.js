/**
 * Multimedia Component - McNab Ventures
 *
 * Handles:
 * - Tab switching (Photos/Videos galleries)
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
      const tabs = Array.from(container.querySelectorAll('[data-tab-index]'));
      const galleries = Array.from(container.querySelectorAll('[data-gallery]'));
      const pagination = container.querySelector('[data-pagination]');
      const prevBtn = container.querySelector('[data-nav="prev"]');
      const nextBtn = container.querySelector('[data-nav="next"]');
      const playBtns = Array.from(container.querySelectorAll('.multimedia__play-btn'));

      if (!galleries.length) return;

      // State
      let currentTab = 0;
      let currentPage = 0;
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
       * Get current active gallery
       */
      function getActiveGallery() {
        return galleries[currentTab] || galleries[0];
      }

      /**
       * Get all items in active gallery
       */
      function getGalleryItems() {
        const gallery = getActiveGallery();
        return Array.from(gallery.querySelectorAll('.multimedia__item'));
      }

      /**
       * Get items for current page
       */
      function getPageItems() {
        const items = getGalleryItems();
        const start = currentPage * itemsPerPage;
        const end = start + itemsPerPage;
        return items.slice(start, end);
      }

      /**
       * Get total pages for active gallery
       */
      function getTotalPages() {
        const items = getGalleryItems();
        return Math.ceil(items.length / itemsPerPage);
      }

      /**
       * Update gallery visibility
       */
      function updateGalleryVisibility() {
        const items = getGalleryItems();
        const pageItems = getPageItems();
        const pageItemsSet = new Set(pageItems);

        items.forEach(item => {
          item.style.display = pageItemsSet.has(item) ? '' : 'none';
        });
      }

      /**
       * Update pagination dots
       */
      function updatePaginationDots() {
        const totalPages = getTotalPages();

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
       * Switch to specific tab
       */
      function switchTab(tabIndex) {
        currentTab = tabIndex;
        currentPage = 0;

        // Update active gallery visibility
        galleries.forEach((gallery, index) => {
          gallery.classList.toggle('is-active', index === tabIndex);
        });

        // Update active tab UI
        tabs.forEach((tab, index) => {
          tab.classList.toggle('is-active', index === tabIndex);
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
          const items = getGalleryItems();
          const item = items[index];
          if (!item) return;

          const media = item.querySelector('.multimedia__media');
          if (media && media.tagName === 'VIDEO') {
            media.play();
          }
          // Could trigger lightbox/modal here
        });
      }

      // Initialize tabs
      tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => switchTab(index));
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
      switchTab(0);
    });
  }

  // Initialize when DOM is ready
  document.addEventListener('DOMContentLoaded', initMultimedia);

  // Also allow manual re-initialization
  window.initMultimedia = initMultimedia;

})();
