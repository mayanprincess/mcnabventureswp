</main><!-- #main-content -->

<footer class="site-footer">
  <div class="footer-wave-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/waves.png');"></div>
  
  <div class="footer-container">
    <div class="footer-content">
      <!-- Footer Logo -->
      <div class="footer-brand">
        <?php 
        $footer_logo = get_theme_mod('mcnab_footer_logo');
        if ($footer_logo) : ?>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
            <img src="<?php echo esc_url($footer_logo); ?>" alt="<?php bloginfo('name'); ?>" class="footer-logo-img">
          </a>
        <?php elseif (has_custom_logo()) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
            <span class="footer-logo-text"><?php bloginfo('name'); ?></span>
        </a>
        <?php endif; ?>
      </div>
      
      <!-- Footer Navigation Columns -->
      <div class="footer-nav-columns">
        <?php if (has_nav_menu('footer-menu-1')) : ?>
        <div class="footer-nav-column">
          <h4 class="footer-nav-title">About Us</h4>
          <?php wp_nav_menu([
            'theme_location' => 'footer-menu-1',
            'container'      => false,
            'menu_class'     => 'footer-nav-list',
            'depth'          => 1,
          ]); ?>
        </div>
        <?php endif; ?>
        
        <?php if (has_nav_menu('footer-menu-2')) : ?>
        <div class="footer-nav-column">
          <h4 class="footer-nav-title">Company</h4>
          <?php wp_nav_menu([
            'theme_location' => 'footer-menu-2',
            'container'      => false,
            'menu_class'     => 'footer-nav-list',
            'depth'          => 1,
          ]); ?>
        </div>
        <?php endif; ?>
        
        <?php if (has_nav_menu('footer-menu-3')) : ?>
        <div class="footer-nav-column">
          <h4 class="footer-nav-title">Careers</h4>
          <?php wp_nav_menu([
            'theme_location' => 'footer-menu-3',
            'container'      => false,
            'menu_class'     => 'footer-nav-list',
            'depth'          => 1,
          ]); ?>
        </div>
        <?php endif; ?>
        
        <!-- Social Links -->
        <div class="footer-nav-column footer-social">
          <h4 class="footer-nav-title">Follow Us</h4>
          <div class="social-links">
            <?php 
            $linkedin = get_theme_mod('mcnab_linkedin_url');
            $twitter = get_theme_mod('mcnab_twitter_url');
            $facebook = get_theme_mod('mcnab_facebook_url');
            ?>
            <?php if ($linkedin) : ?>
            <a href="<?php echo esc_url($linkedin); ?>" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
            </a>
            <?php endif; ?>
            <?php if ($twitter) : ?>
            <a href="<?php echo esc_url($twitter); ?>" class="social-link" target="_blank" rel="noopener" aria-label="Twitter">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
            <?php endif; ?>
            <?php if ($facebook) : ?>
            <a href="<?php echo esc_url($facebook); ?>" class="social-link" target="_blank" rel="noopener" aria-label="Facebook">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <?php endif; ?>
            <?php if (!$linkedin && !$twitter && !$facebook) : ?>
            <!-- Default social links if none set -->
            <a href="#" class="social-link" aria-label="LinkedIn">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
            </a>
            <a href="#" class="social-link" aria-label="Twitter">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
            <a href="#" class="social-link" aria-label="Facebook">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <?php endif; ?>
          </div>
        </div>
    </div>
    </div>
  </div>
  
  <!-- Large decorative logo -->
  <div class="footer-decorative">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footerlogo.png" alt="" class="footer-decorative-logo" aria-hidden="true">
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
