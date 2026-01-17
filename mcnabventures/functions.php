<?php
if (!defined('ABSPATH')) exit;

/**
 * Load Composer dependencies (Timber)
 */
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
  require_once __DIR__ . '/vendor/autoload.php';
  
  // Initialize Timber
  if (class_exists('Timber\Timber')) {
    // Timber v2: constructor is protected; use init().
    if (is_callable(['Timber\\Timber', 'init'])) {
      Timber\Timber::init();
    }
  }
}

/**
 * Theme Setup
 */
add_action('after_setup_theme', function () {
  // Theme supports
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('wp-block-styles');
  add_theme_support('align-wide');
  add_theme_support('responsive-embeds');
  add_theme_support('editor-styles');
  add_theme_support('custom-logo', [
    'height'      => 60,
    'width'       => 200,
    'flex-height' => true,
    'flex-width'  => true,
  ]);
  add_editor_style('assets/css/main.css');
  add_editor_style('assets/css/editor.css');

  // Register Navigation Menus
  register_nav_menus([
    'header-menu'   => __('Header Menu', 'mcnabventures'),
    'footer-menu-1' => __('Footer Menu - About Us', 'mcnabventures'),
    'footer-menu-2' => __('Footer Menu - Company', 'mcnabventures'),
    'footer-menu-3' => __('Footer Menu - Careers', 'mcnabventures'),
  ]);
});

/**
 * Enqueue Google Fonts - Literata & Fustat
 * Cargadas una sola vez para frontend y editor, mejorando performance
 */
add_action('wp_enqueue_scripts', function () {
  // Google Fonts: Literata (Light 300, Regular 400, Medium 500) & Fustat (Medium 500, Bold 700, ExtraBold 800)
  wp_enqueue_style(
    'mcnabventures-google-fonts',
    'https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,300;0,7..72,400;0,7..72,500;1,7..72,300;1,7..72,400&family=Fustat:wght@400;500;700;800&display=swap',
    [],
    null
  );
}, 5);

/**
 * Reutilizar Google Fonts en Block Editor (sin duplicación)
 */
add_action('enqueue_block_editor_assets', function () {
  wp_enqueue_style('mcnabventures-google-fonts');
});

/**
 * Enqueue Scripts and Styles
 */
add_action('wp_enqueue_scripts', function () {
  // Main stylesheet
  wp_enqueue_style(
    'mcnabventures-main',
    get_template_directory_uri() . '/assets/css/main.css',
    ['mcnabventures-google-fonts'],
    '0.1.0'
  );

  // Main JavaScript
  wp_enqueue_script(
    'mcnabventures-main',
    get_template_directory_uri() . '/assets/js/main.js',
    [],
    '0.1.0',
    true
  );

  // Scroll Reveal Script
  wp_enqueue_script(
    'mcnabventures-scroll-reveal',
    get_template_directory_uri() . '/assets/js/scroll-reveal.js',
    [],
    '0.1.0',
    true
  );

  // Multimedia Component Script
  wp_enqueue_script(
    'mcnabventures-multimedia',
    get_template_directory_uri() . '/assets/js/multimedia.js',
    [],
    '0.1.0',
    true
  );
});

/**
 * Add defer attribute to main script
 */
add_filter('script_loader_tag', function($tag, $handle) {
  if ($handle === 'mcnabventures-main') {
    return str_replace('src=', 'defer src=', $tag);
  }
  return $tag;
}, 10, 2);


/**
 * Add preconnect for Google Fonts to improve performance
 */
add_action('wp_head', function () {
  echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
  echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1);

/**
 * Inline critical CSS for faster first render
 * Critical CSS includes: header, hero, typography, reset
 */
add_action('wp_head', function () {
  $critical_css_file = get_template_directory() . '/assets/css/critical.css';

  // Check if critical.css exists, if not use a basic inline version
  if (file_exists($critical_css_file)) {
    $critical_css = file_get_contents($critical_css_file);
    echo '<style>' . wp_strip_all_tags($critical_css) . '</style>' . "\n";
  }
}, 2);

/**
 * Customizer Settings for Footer
 */
add_action('customize_register', function ($wp_customize) {
  // Footer Section
  $wp_customize->add_section('mcnab_footer_section', [
    'title'    => __('Footer Settings', 'mcnabventures'),
    'priority' => 90,
  ]);

  // Footer Logo
  $wp_customize->add_setting('mcnab_footer_logo', [
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mcnab_footer_logo', [
    'label'    => __('Footer Logo', 'mcnabventures'),
    'section'  => 'mcnab_footer_section',
    'settings' => 'mcnab_footer_logo',
  ]));

  // Footer Decorative Logo (large background logo)
  $wp_customize->add_setting('mcnab_footer_decorative_logo', [
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mcnab_footer_decorative_logo', [
    'label'       => __('Footer Decorative Logo', 'mcnabventures'),
    'description' => __('Large logo displayed at the bottom of the footer', 'mcnabventures'),
    'section'     => 'mcnab_footer_section',
    'settings'    => 'mcnab_footer_decorative_logo',
  ]));

  // Footer Wave Background
  $wp_customize->add_setting('mcnab_footer_wave_bg', [
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mcnab_footer_wave_bg', [
    'label'       => __('Footer Wave Background', 'mcnabventures'),
    'description' => __('Wave pattern PNG for the footer background', 'mcnabventures'),
    'section'     => 'mcnab_footer_section',
    'settings'    => 'mcnab_footer_wave_bg',
  ]));

  // Social Links Section
  $wp_customize->add_section('mcnab_social_section', [
    'title'    => __('Social Links', 'mcnabventures'),
    'priority' => 91,
  ]);

  // LinkedIn
  $wp_customize->add_setting('mcnab_linkedin_url', [
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('mcnab_linkedin_url', [
    'label'   => __('LinkedIn URL', 'mcnabventures'),
    'section' => 'mcnab_social_section',
    'type'    => 'url',
  ]);

  // Twitter
  $wp_customize->add_setting('mcnab_twitter_url', [
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('mcnab_twitter_url', [
    'label'   => __('Twitter URL', 'mcnabventures'),
    'section' => 'mcnab_social_section',
    'type'    => 'url',
  ]);

  // Facebook
  $wp_customize->add_setting('mcnab_facebook_url', [
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('mcnab_facebook_url', [
    'label'   => __('Facebook URL', 'mcnabventures'),
    'section' => 'mcnab_social_section',
    'type'    => 'url',
  ]);
});

/**
 * Custom Walker for Header Navigation
 */
class McNabVentures_Header_Walker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $classes[] = 'nav-item';
    
    if (in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
    }

    $class_names = join(' ', array_filter($classes));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    $output .= '<li' . $class_names . '>';

    $attributes = '';
    if (!empty($item->url)) {
      $attributes .= ' href="' . esc_attr($item->url) . '"';
    }
    $attributes .= ' class="nav-link"';

    $output .= '<a' . $attributes . '>';
    $output .= apply_filters('the_title', $item->title, $item->ID);
    $output .= '</a>';
  }

  function end_el(&$output, $item, $depth = 0, $args = null) {
    $output .= '</li>';
  }
}

/**
 * Fallback menu if no menu is assigned
 */
function mcnabventures_fallback_menu() {
  echo '<ul class="nav-menu">';
  echo '<li class="nav-item"><a href="' . home_url('/') . '" class="nav-link">Home</a></li>';
  echo '</ul>';
}

/**
 * Output footer wave background CSS
 */
add_action('wp_head', function () {
  $wave_bg = get_theme_mod('mcnab_footer_wave_bg');
  if ($wave_bg) {
    echo '<style>.footer-wave-bg { background-image: url(' . esc_url($wave_bg) . '); }</style>' . "\n";
  }
}, 100);

/**
 * Load Timber setup
 */
if (file_exists(get_template_directory() . '/inc/timber-setup.php')) {
  require_once get_template_directory() . '/inc/timber-setup.php';
}

/**
 * Load Components Registry
 */
if (file_exists(get_template_directory() . '/inc/components-registry.php')) {
  require_once get_template_directory() . '/inc/components-registry.php';
}

/**
 * Load Gutenberg Blocks
 */
if (file_exists(get_template_directory() . '/inc/gutenberg-blocks.php')) {
  require_once get_template_directory() . '/inc/gutenberg-blocks.php';
}

/**
 * Load ACF Fields Registration
 */
if (file_exists(get_template_directory() . '/inc/acf-fields.php')) {
  require_once get_template_directory() . '/inc/acf-fields.php';
}
