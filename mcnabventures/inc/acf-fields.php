<?php
/**
 * ACF Fields Registration - Flexible Content
 * 
 * Uses ACF Flexible Content for a clean, drag-and-drop component system
 * Each component is a "layout" that users can add, reorder, and configure
 */

if (!defined('ABSPATH')) exit;

// Check if ACF PRO is available
if (!function_exists('acf_add_local_field_group')) {
  return;
}

/**
 * Build an ACF field (supports nested repeaters/groups) with stable keys
 */
function mcnab_build_acf_field($slug, $field_key, $field_config, $parent_keys = []) {
  $key_parts = array_merge([$slug], $parent_keys, [$field_key]);
  $stable_key = 'field_' . substr(md5('mcnab_flex_' . implode('_', $key_parts)), 0, 13);

  $acf_field = [
    'key' => $stable_key,
    'label' => $field_config['label'] ?? ucfirst(str_replace('_', ' ', $field_key)),
    'name' => $field_key,
    'type' => mcnab_convert_field_type($field_config['type']),
    'required' => $field_config['required'] ?? false,
    'show_in_rest' => 1,
  ];

  if (isset($field_config['placeholder'])) {
    $acf_field['placeholder'] = $field_config['placeholder'];
  }

  if (isset($field_config['default']) && !in_array($field_config['type'], ['repeater', 'group'], true)) {
    $acf_field['default_value'] = $field_config['default'];
  }

  if ($field_config['type'] === 'select') {
    $acf_field['choices'] = $field_config['choices'] ?? [];
    if (isset($field_config['default'])) {
      $acf_field['default_value'] = $field_config['default'];
    }
  }

  if ($field_config['type'] === 'image') {
    $acf_field['return_format'] = $field_config['return_format'] ?? 'array';
    $acf_field['preview_size'] = 'medium';
    $acf_field['library'] = 'all';
  }

  if ($field_config['type'] === 'gallery') {
    $acf_field['return_format'] = $field_config['return_format'] ?? 'array';
    $acf_field['preview_size'] = 'medium';
    $acf_field['library'] = 'all';
    $acf_field['min_height'] = '';
    $acf_field['min_width'] = '';
    $acf_field['min_size'] = '';
    $acf_field['max_size'] = '';
    $acf_field['mime_types'] = '';
    $acf_field['insert'] = 'append';
  }

  if ($field_config['type'] === 'file') {
    $acf_field['return_format'] = 'array';
    $acf_field['library'] = 'all';
    if (isset($field_config['mime_types'])) {
      $acf_field['mime_types'] = $field_config['mime_types'];
    }
  }

  if ($field_config['type'] === 'textarea') {
    $acf_field['rows'] = 4;
  }

  if ($field_config['type'] === 'wysiwyg') {
    $acf_field['tabs'] = 'all';
    $acf_field['toolbar'] = 'full';
    $acf_field['media_upload'] = 1;
  }

  if ($field_config['type'] === 'true_false') {
    $acf_field['ui'] = 1;
    if (isset($field_config['default'])) {
      $acf_field['default_value'] = $field_config['default'] ? 1 : 0;
    }
  }

  if ($field_config['type'] === 'date') {
    $acf_field['display_format'] = 'Y-m-d';
    $acf_field['return_format'] = 'Y-m-d';
    $acf_field['first_day'] = 1;
  }

  if (isset($field_config['conditional_logic'])) {
    $acf_field['conditional_logic'] = $field_config['conditional_logic'];
  }

  if ($field_config['type'] === 'repeater') {
    $acf_field['layout'] = 'block';
    $acf_field['button_label'] = 'Add Item';
    $acf_field['min'] = 0;
    $acf_field['max'] = 0;

    if (isset($field_config['sub_fields'])) {
      $acf_field['sub_fields'] = [];
      foreach ($field_config['sub_fields'] as $sub_key => $sub_field) {
        $acf_field['sub_fields'][] = mcnab_build_acf_field(
          $slug,
          $sub_key,
          $sub_field,
          array_merge($parent_keys, [$field_key])
        );
      }
    }
  }

  if ($field_config['type'] === 'group') {
    if (isset($field_config['sub_fields'])) {
      $acf_field['sub_fields'] = [];
      foreach ($field_config['sub_fields'] as $sub_key => $sub_field) {
        $acf_field['sub_fields'][] = mcnab_build_acf_field(
          $slug,
          $sub_key,
          $sub_field,
          array_merge($parent_keys, [$field_key])
        );
      }
    }
  }

  return $acf_field;
}

/**
 * Register ACF Flexible Content Field Group
 */
add_action('acf/init', function() {
  $components = mcnab_get_registered_components();
  
  // Build layouts array from registered components
  $layouts = [];
  
  foreach ($components as $slug => $component) {
    // Generate stable layout key
    $layout_key = 'layout_' . substr(md5('mcnab_layout_' . $slug), 0, 13);
    
    // Build sub_fields for this layout
    $sub_fields = [];
    
    foreach ($component['fields'] as $field_key => $field_config) {
      $sub_fields[] = mcnab_build_acf_field($slug, $field_key, $field_config);
    }
    
    // Add layout for this component
    $layouts[$layout_key] = [
      'key' => $layout_key,
      'name' => $slug,
      'label' => $component['name'],
      'display' => 'block',
      'sub_fields' => $sub_fields,
      'min' => '',
      'max' => '',
    ];
  }
  
  // Register the Flexible Content field group
  acf_add_local_field_group([
    'key' => 'group_mcnab_page_components',
    'title' => 'Page Components',
    'fields' => [
      [
        'key' => 'field_mcnab_components_flex',
        'label' => 'Components',
        'name' => 'page_components',
        'type' => 'flexible_content',
        'instructions' => 'Add components and drag to reorder. Each component has its own settings.',
        'required' => 0,
        'layouts' => $layouts,
        'button_label' => 'Add Component',
        'min' => '',
        'max' => '',
        'show_in_rest' => 1,
      ],
    ],
    'location' => [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
        ],
      ],
    ],
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => ['the_content'],
    'active' => true,
    'description' => 'Drag and drop components to build your page.',
    'show_in_rest' => 1,
  ]);
});

/**
 * Convert component field type to ACF field type
 */
function mcnab_convert_field_type($type) {
  $mapping = [
    'text' => 'text',
    'textarea' => 'textarea',
    'image' => 'image',
    'gallery' => 'gallery',
    'url' => 'url',
    'select' => 'select',
    'repeater' => 'repeater',
    'wysiwyg' => 'wysiwyg',
    'number' => 'number',
    'file' => 'file',
    'true_false' => 'true_false',
    'date' => 'date_picker',
    'group' => 'group',
  ];

  return $mapping[$type] ?? 'text';
}

/**
 * Auto-render components from Flexible Content
 * Renders components in the order defined by the user
 */
add_filter('the_content', function($content) {
  // Only run on frontend, not in admin
  if (is_admin()) {
    return $content;
  }

  if (!function_exists('mcnab_render_twig_component')) {
    return $content;
  }

  // Get Flexible Content data with caching (1 hour TTL)
  $post_id = get_the_ID();
  $cache_key = 'mcnab_page_components_' . $post_id;
  $page_components = get_transient($cache_key);

  if (false === $page_components) {
    $page_components = get_field('page_components');
    if (!empty($page_components)) {
      set_transient($cache_key, $page_components, 3600); // Cache por 1 hora
    }
  }
  
  if (empty($page_components) || !is_array($page_components)) {
    return $content;
  }
  
  $components = mcnab_get_registered_components();
  $all_components_html = '';

  // Render each component in order
  foreach ($page_components as $component_data) {
    $layout = $component_data['acf_fc_layout'] ?? '';

    if (empty($layout) || !isset($components[$layout])) {
      continue;
    }

    // Prepare component data (remove ACF internal fields, normalization happens in mcnab_render_twig_component)
    $args = [];
    foreach ($component_data as $key => $value) {
      if ($key === 'acf_fc_layout') {
        continue;
      }

      $args[$key] = $value;
    }

    // Render component with data (normalization handled inside)
    ob_start();
    mcnab_render_twig_component($layout, $args);
    $component_html = ob_get_clean();
    $all_components_html .= $component_html;
  }
  
  // Prepend components to content
  return $all_components_html . $content;
}, 10);

/**
 * Invalidate component cache when page is updated
 */
add_action('save_post_page', function($post_id) {
  $cache_key = 'mcnab_page_components_' . $post_id;
  delete_transient($cache_key);
});
