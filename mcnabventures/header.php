<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
  <div class="header-container">
    <!-- Logo -->
    <div class="site-branding">
      <?php if (has_custom_logo()) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
          <span class="logo-text"><?php bloginfo('name'); ?></span>
        </a>
      <?php endif; ?>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
    </button>

    <!-- Navigation -->
    <nav class="main-navigation" role="navigation" aria-label="Primary Menu">
      <?php
      if (has_nav_menu('header-menu')) {
        wp_nav_menu([
          'theme_location' => 'header-menu',
          'container'      => false,
          'menu_class'     => 'nav-menu',
          'walker'         => new McNabVentures_Header_Walker(),
          'fallback_cb'    => 'mcnabventures_fallback_menu',
        ]);
      } else {
        mcnabventures_fallback_menu();
      }
      ?>
    </nav>
  </div>
</header>

<main id="main-content" class="site-main">
