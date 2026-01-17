<?php
/**
 * Timber Setup
 * 
 * Timber is installed via Composer (see composer.json)
 * This file sets up component helpers and Twig integration
 */

if (!defined('ABSPATH')) exit;

// Check if Timber is available
if (!class_exists('Timber\Timber')) {
  return;
}

use Timber\Timber;

/**
 * Configure Timber locations (Timber 2.0+ format)
 */
Timber::$locations = get_template_directory() . '/views';

/**
 * Static cache for image URLs (memoization)
 */
$mcnab_image_url_cache = [];

/**
 * Get attachment image URL with memoization
 */
function mcnab_get_attachment_image_url($image_id, $size = 'full') {
  global $mcnab_image_url_cache;

  if (empty($image_id)) {
    return '';
  }

  $cache_key = $image_id . ':' . $size;

  if (isset($mcnab_image_url_cache[$cache_key])) {
    return $mcnab_image_url_cache[$cache_key];
  }

  $url = wp_get_attachment_image_url($image_id, $size) ?: '';
  $mcnab_image_url_cache[$cache_key] = $url;

  return $url;
}

/**
 * Normalize ACF values recursively
 * Handles images, galleries, repeaters, and nested structures
 */
function mcnab_normalize_acf_values($value) {
  if (is_array($value)) {
    // Check if this is an image array (has 'url' key)
    if (isset($value['url']) && is_string($value['url'])) {
      return $value; // Keep full image array for Twig to access properties
    }

    // Check if this is an image ID array (has 'ID' key)
    if (isset($value['ID']) && is_numeric($value['ID'])) {
      $id = (int) $value['ID'];
      $url = mcnab_get_attachment_image_url($id, 'full');
      $value['url'] = $url;
      $value['alt'] = $value['alt'] ?? get_post_meta($id, '_wp_attachment_image_alt', true) ?: '';
      return $value;
    }

    // Recursively normalize nested arrays (galleries, repeaters)
    $normalized = [];
    foreach ($value as $k => $v) {
      $normalized[$k] = mcnab_normalize_acf_values($v);
    }
    return $normalized;
  }

  // Single image ID as number
  if (is_numeric($value)) {
    return mcnab_get_attachment_image_url((int) $value, 'full');
  }

  return $value;
}

/**
 * Render a component using Twig
 *
 * @param string $component_name Component name (file name without .twig)
 * @param array  $args           Component data (passed directly from Flexible Content)
 * @return void
 */
function mcnab_render_twig_component($component_name, $args = []) {
  $context = [];

  // Normalize all values recursively
  foreach ($args as $key => $value) {
    $context[$key] = mcnab_normalize_acf_values($value);
  }

  $template = 'components/' . sanitize_file_name($component_name) . '.twig';

  try {
    Timber::render($template, $context);
  } catch (\Exception $e) {
    // Log error but don't break the page
    if (defined('WP_DEBUG') && WP_DEBUG) {
      error_log('Timber Component Error (' . $component_name . '): ' . $e->getMessage());
    }
  }
}

/**
 * Get component HTML (for shortcodes, templates, etc.)
 */
function mcnab_get_twig_component($component_name, $args = []) {
  ob_start();
  mcnab_render_twig_component($component_name, $args);
  return ob_get_clean();
}

/**
 * Register Timber context
 */
add_filter('timber/context', function($context) {
  // Add site-wide data
  $context['site'] = new Timber\Site();
  $context['menu'] = new Timber\Menu('header-menu');
  
  return $context;
});

/**
 * Register Twig functions for components
 */
add_filter('timber/twig', function($twig) {
  // Component render function
  $twig->addFunction(new \Twig\TwigFunction('component', function($name, $args = []) {
    return mcnab_get_twig_component($name, $args);
  }));
  
  return $twig;
});

/**
 * Register shortcodes using Timber
 * These allow manual insertion of components via shortcode
 */
add_action('init', function() {
  $components = function_exists('mcnab_get_registered_components') ? mcnab_get_registered_components() : [];
  
  foreach ($components as $slug => $component) {
    // Create shortcode name: side-component -> side_component
    $shortcode_name = str_replace('-', '_', $slug) . '_component';
    
    add_shortcode($shortcode_name, function($atts) use ($slug, $component) {
      // Get default values from component definition
      $defaults = [];
      foreach ($component['fields'] as $field_key => $field_config) {
        $defaults[$field_key] = $field_config['default'] ?? '';
      }
      
      $atts = shortcode_atts($defaults, $atts);
      
      return mcnab_get_twig_component($slug, $atts);
    });
  }
});
