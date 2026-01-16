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
      
      if ($field_config['type'] === 'textarea') {
        $acf_field['rows'] = 4;
      }
      
      if ($field_config['type'] === 'wysiwyg') {
        $acf_field['tabs'] = 'all';
        $acf_field['toolbar'] = 'full';
        $acf_field['media_upload'] = 1;
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
              'label' => $sub_field['label'],
              'name' => $sub_key,
              'type' => mcnab_convert_field_type($sub_field['type']),
              'required' => $sub_field['required'] ?? false,
            ];
            
            if ($sub_field['type'] === 'wysiwyg') {
              $sub_acf_field['tabs'] = 'all';
              $sub_acf_field['toolbar'] = 'full';
              $sub_acf_field['media_upload'] = 1;
            }
            
            if ($sub_field['type'] === 'textarea') {
              $sub_acf_field['rows'] = 4;
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
    'url' => 'url',
    'repeater' => 'repeater',
    'wysiwyg' => 'wysiwyg',
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
  
  // Get Flexible Content data
  $page_components = get_field('page_components');
  
  if (empty($page_components) || !is_array($page_components)) {
    return $content;
  }
  
  $components = mcnab_get_registered_components();
  $all_components_html = '';
  
  /**
   * Normalize ACF values recursively (supports repeater rows + image arrays)
   */
  $normalize_value = function($value) use (&$normalize_value) {
    if (is_array($value)) {
      // ACF image array
      if (isset($value['url']) && is_string($value['url'])) {
        return $value; // keep full array (url/alt/id/etc)
      }

      // ACF image with ID only
      if (isset($value['ID']) && is_numeric($value['ID'])) {
        $id = (int) $value['ID'];
        $url = wp_get_attachment_image_url($id, 'full') ?: '';
        $alt = get_post_meta($id, '_wp_attachment_image_alt', true) ?: '';
        $value['url'] = $url;
        $value['alt'] = $value['alt'] ?? $alt;
        return $value;
      }

      // Repeater rows / nested arrays
      foreach ($value as $k => $v) {
        $value[$k] = $normalize_value($v);
      }
      return $value;
    }

    // Attachment ID provided as number (rare in our setup)
    return $value;
  };

  // Render each component in order
  foreach ($page_components as $component_data) {
    $layout = $component_data['acf_fc_layout'] ?? '';
    
    if (empty($layout) || !isset($components[$layout])) {
      continue;
    }
    
    // Prepare component data (remove ACF internal fields)
    $args = [];
    foreach ($component_data as $key => $value) {
      if ($key === 'acf_fc_layout') {
        continue;
      }

      $args[$key] = $normalize_value($value);
    }
    
    // Render component with data
    ob_start();
    mcnab_render_twig_component($layout, $args);
    $component_html = ob_get_clean();
    $all_components_html .= $component_html;
  }
  
  // Prepend components to content
  return $all_components_html . $content;
}, 10);
