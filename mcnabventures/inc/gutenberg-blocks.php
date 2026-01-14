<?php
/**
 * Gutenberg Blocks Registration
 * 
 * Register custom blocks that use our Twig components
 */

if (!defined('ABSPATH')) exit;

/**
 * Register custom Gutenberg blocks
 */
add_action('init', function() {
  // Check if Gutenberg is available
  if (!function_exists('register_block_type')) {
    return;
  }
  
  // Register Side Component Block
  register_block_type('mcnab/side-component', [
    'render_callback' => 'mcnab_render_side_component_block',
    'attributes' => [
      'badge' => [
        'type' => 'string',
        'default' => 'WHO WE ARE',
      ],
      'titlePart1' => [
        'type' => 'string',
        'default' => '',
      ],
      'titleHighlight' => [
        'type' => 'string',
        'default' => '',
      ],
      'description' => [
        'type' => 'string',
        'default' => '',
      ],
      'logoId' => [
        'type' => 'number',
        'default' => 0,
      ],
      'logoUrl' => [
        'type' => 'string',
        'default' => '',
      ],
    ],
  ]);
  
  // Register Hero Component Block
  register_block_type('mcnab/hero', [
    'render_callback' => 'mcnab_render_hero_block',
    'attributes' => [
      'title' => [
        'type' => 'string',
        'default' => '',
      ],
      'subtitle' => [
        'type' => 'string',
        'default' => '',
      ],
      'buttonText' => [
        'type' => 'string',
        'default' => '',
      ],
      'buttonUrl' => [
        'type' => 'string',
        'default' => '#',
      ],
      'backgroundImageId' => [
        'type' => 'number',
        'default' => 0,
      ],
      'backgroundImageUrl' => [
        'type' => 'string',
        'default' => '',
      ],
    ],
  ]);
  
  // Register Accordion Component Block
  register_block_type('mcnab/accordion', [
    'render_callback' => 'mcnab_render_accordion_block',
    'attributes' => [
      'title' => [
        'type' => 'string',
        'default' => 'Our Journey',
      ],
      'items' => [
        'type' => 'array',
        'default' => [],
      ],
    ],
  ]);
});

/**
 * Render Side Component Block
 */
function mcnab_render_side_component_block($attributes) {
  $args = [
    'badge' => $attributes['badge'] ?? '',
    'title_part1' => $attributes['titlePart1'] ?? '',
    'title_highlight' => $attributes['titleHighlight'] ?? '',
    'description' => $attributes['description'] ?? '',
    'logo' => $attributes['logoUrl'] ?? '',
  ];
  
  // If logo ID provided, get URL
  if (!empty($attributes['logoId']) && empty($args['logo'])) {
    $args['logo'] = wp_get_attachment_image_url($attributes['logoId'], 'full');
  }
  
  ob_start();
  if (function_exists('mcnab_render_twig_component')) {
    mcnab_render_twig_component('side-component', $args);
  }
  return ob_get_clean();
}

/**
 * Render Hero Component Block
 */
function mcnab_render_hero_block($attributes) {
  $args = [
    'title' => $attributes['title'] ?? '',
    'subtitle' => $attributes['subtitle'] ?? '',
    'button_text' => $attributes['buttonText'] ?? '',
    'button_url' => $attributes['buttonUrl'] ?? '#',
    'background_image' => $attributes['backgroundImageUrl'] ?? '',
  ];
  
  // If background image ID provided, get URL
  if (!empty($attributes['backgroundImageId']) && empty($args['background_image'])) {
    $args['background_image'] = wp_get_attachment_image_url($attributes['backgroundImageId'], 'full');
  }
  
  ob_start();
  if (function_exists('mcnab_render_twig_component')) {
    mcnab_render_twig_component('hero', $args);
  }
  return ob_get_clean();
}

/**
 * Render Accordion Component Block
 */
function mcnab_render_accordion_block($attributes) {
  $args = [
    'title' => $attributes['title'] ?? 'Our Journey',
    'items' => $attributes['items'] ?? [],
  ];
  
  ob_start();
  if (function_exists('mcnab_render_twig_component')) {
    mcnab_render_twig_component('accordion', $args);
  }
  return ob_get_clean();
}

/**
 * Enqueue block editor assets
 */
add_action('enqueue_block_editor_assets', function() {
  wp_enqueue_script(
    'mcnab-blocks',
    get_template_directory_uri() . '/assets/js/blocks.js',
    ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'],
    '1.0.0',
    true
  );
  
  wp_enqueue_style(
    'mcnab-blocks-editor',
    get_template_directory_uri() . '/assets/css/blocks-editor.css',
    ['wp-edit-blocks'],
    '1.0.0'
  );
});
