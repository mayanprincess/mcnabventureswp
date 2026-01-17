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
      // Generate stable field key
      $stable_key = 'field_' . substr(md5('mcnab_flex_' . $slug . '_' . $field_key), 0, 13);
      
      $acf_field = [
        'key' => $stable_key,
        'label' => $field_config['label'],
        'name' => $field_key, // Simple name without prefix (Flexible Content handles namespacing)
        'type' => mcnab_convert_field_type($field_config['type']),
        'required' => $field_config['required'] ?? false,
      ];
      
      // Add default value
      if (isset($field_config['default'])) {
        $acf_field['default_value'] = $field_config['default'];
      }
      
      // Handle special field types
      if ($field_config['type'] === 'image') {
        $acf_field['return_format'] = 'array';
        $acf_field['preview_size'] = 'medium';
        $acf_field['library'] = 'all';
      }

      if ($field_config['type'] === 'gallery') {
        $acf_field['return_format'] = 'array';
        $acf_field['preview_size'] = 'medium';
        $acf_field['library'] = 'all';
        $acf_field['min_height'] = '';
        $acf_field['min_width'] = '';
        $acf_field['min_size'] = '';
        $acf_field['max_size'] = '';
        $acf_field['mime_types'] = '';
        $acf_field['insert'] = 'append';
      }

      if ($field_config['type'] === 'textarea') {
        $acf_field['rows'] = 4;
      }

      if ($field_config['type'] === 'wysiwyg') {
        $acf_field['tabs'] = 'all';
        $acf_field['toolbar'] = 'full';
        $acf_field['media_upload'] = 1;
      }

      // Add conditional logic if present
      if (isset($field_config['conditional_logic'])) {
        $acf_field['conditional_logic'] = $field_config['conditional_logic'];
      }

      if ($field_config['type'] === 'repeater') {
        $acf_field['layout'] = 'block';
        $acf_field['button_label'] = 'Add Item';
        $acf_field['min'] = 0;
        $acf_field['max'] = 0;
        
        // Add sub fields for repeater
        if (isset($field_config['sub_fields'])) {
          $acf_field['sub_fields'] = [];
          foreach ($field_config['sub_fields'] as $sub_key => $sub_field) {
            $sub_stable_key = 'field_' . substr(md5('mcnab_flex_' . $slug . '_' . $field_key . '_' . $sub_key), 0, 13);

            $sub_acf_field = [
              'key' => $sub_stable_key,
              'label' => $sub_field['label'] ?? ucfirst(str_replace('_', ' ', $sub_key)),
              'name' => $sub_key,
              'type' => mcnab_convert_field_type($sub_field['type']),
              'required' => $sub_field['required'] ?? false,
            ];

            // Handle choices for select fields
            if ($sub_field['type'] === 'select' && isset($sub_field['choices'])) {
              $sub_acf_field['choices'] = $sub_field['choices'];
              if (isset($sub_field['default'])) {
                $sub_acf_field['default_value'] = $sub_field['default'];
              }
            }

            // Handle default values
            if (isset($sub_field['default']) && $sub_field['type'] !== 'select') {
              $sub_acf_field['default_value'] = $sub_field['default'];
            }

            // Handle placeholder
            if (isset($sub_field['placeholder'])) {
              $sub_acf_field['placeholder'] = $sub_field['placeholder'];
            }

            if ($sub_field['type'] === 'wysiwyg') {
              $sub_acf_field['tabs'] = 'all';
              $sub_acf_field['toolbar'] = 'full';
              $sub_acf_field['media_upload'] = 1;
            }

            if ($sub_field['type'] === 'textarea') {
              $sub_acf_field['rows'] = 4;
            }

            if ($sub_field['type'] === 'gallery') {
              $sub_acf_field['return_format'] = 'array';
              $sub_acf_field['preview_size'] = 'medium';
              $sub_acf_field['library'] = 'all';
              $sub_acf_field['min_height'] = '';
              $sub_acf_field['min_width'] = '';
              $sub_acf_field['min_size'] = '';
              $sub_acf_field['max_size'] = '';
              $sub_acf_field['mime_types'] = '';
              $sub_acf_field['insert'] = 'append';
            }

            // Add conditional logic if present in sub field
            if (isset($sub_field['conditional_logic'])) {
              $sub_acf_field['conditional_logic'] = $sub_field['conditional_logic'];
            }

            // Handle nested repeater
            if ($sub_field['type'] === 'repeater' && isset($sub_field['sub_fields'])) {
              $sub_acf_field['layout'] = 'block';
              $sub_acf_field['button_label'] = 'Add Item';
              $sub_acf_field['min'] = 0;
              $sub_acf_field['max'] = 0;
              $sub_acf_field['sub_fields'] = [];

              foreach ($sub_field['sub_fields'] as $nested_key => $nested_field) {
                $nested_stable_key = 'field_' . substr(md5('mcnab_flex_' . $slug . '_' . $field_key . '_' . $sub_key . '_' . $nested_key), 0, 13);

                $nested_acf_field = [
                  'key' => $nested_stable_key,
                  'label' => $nested_field['label'] ?? ucfirst(str_replace('_', ' ', $nested_key)),
                  'name' => $nested_key,
                  'type' => mcnab_convert_field_type($nested_field['type']),
                  'required' => $nested_field['required'] ?? false,
                ];

                if (isset($nested_field['placeholder'])) {
                  $nested_acf_field['placeholder'] = $nested_field['placeholder'];
                }

                if ($nested_field['type'] === 'wysiwyg') {
                  $nested_acf_field['tabs'] = 'all';
                  $nested_acf_field['toolbar'] = 'full';
                  $nested_acf_field['media_upload'] = 1;
                }

                $sub_acf_field['sub_fields'][] = $nested_acf_field;
              }
            }

            $acf_field['sub_fields'][] = $sub_acf_field;
          }
        }
      }
      
      $sub_fields[] = $acf_field;
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
