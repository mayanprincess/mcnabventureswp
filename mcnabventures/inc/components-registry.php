<?php
/**
 * Components Registry
 * 
 * Register and manage available components
 */

if (!defined('ABSPATH')) exit;

/**
 * Register all available components
 * 
 * @return array
 */
function mcnab_get_registered_components() {
  return [
    'side-component' => [
      'slug' => 'side-component',
      'location' => 'page', // Options: 'page', 'post', ['page', 'post'], 'page_template:template-name.php', 'custom_post_type'
      'name' => 'Side Component',
      'description' => 'Two-column layout with logo pill (left) and content (right)',
      'file' => 'side-component.twig',
      'fields' => [
        'badge' => [
          'label' => 'Badge Text',
          'type' => 'text',
          'default' => 'WHO WE ARE',
          'required' => false,
        ],
        'content' => [
          'label' => 'Content',
          'type' => 'wysiwyg',
          'required' => false,
        ],
        'description' => [
          'label' => 'Description',
          'type' => 'textarea',
          'required' => false,
        ],
        'logo' => [
          'label' => 'Logo',
          'type' => 'image',
          'required' => false,
        ],
      ],
    ],
    'hero' => [
      'slug' => 'hero',
      'location' => 'page', // Options: 'page', 'post', ['page', 'post'], 'page_template:template-name.php', 'custom_post_type'
      'name' => 'Hero Component',
      'description' => 'Full-width hero section with background image',
      'file' => 'hero.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'button_text' => [
          'label' => 'Button Text',
          'type' => 'text',
          'required' => false,
        ],
        'button_url' => [
          'label' => 'Button URL',
          'type' => 'url',
          'default' => '#',
          'required' => false,
        ],
        'background_image' => [
          'label' => 'Background Image',
          'type' => 'image',
          'required' => false,
        ],
      ],
    ],
    'accordion' => [
      'slug' => 'accordion',
      'location' => 'page', // Options: 'page', 'post', ['page', 'post'], 'page_template:template-name.php', 'custom_post_type'
      'name' => 'Accordion Component',
      'description' => 'Expandable accordion menu with multiple items',
      'file' => 'accordion.twig',
      'fields' => [
        'title' => [
          'label' => 'Accordion Title',
          'type' => 'text',
          'default' => 'Our Journey',
          'required' => false,
        ],
        'items' => [
          'label' => 'Accordion Items',
          'type' => 'repeater',
          'sub_fields' => [
            'title' => [
              'label' => 'Item Title',
              'type' => 'text',
            ],
            'content' => [
              'label' => 'Item Content',
              'type' => 'wysiwyg',
            ],
          ],
          'required' => false,
        ],
      ],
    ],
    'highlights' => [
      'slug' => 'highlights',
      'location' => 'page',
      'name' => 'Highlight Component',
      'description' => 'Horizontal slider of highlight cards (image + rich text).',
      'file' => 'highlights.twig',
      'fields' => [
        'title' => [
          'label' => 'Section Title',
          'type' => 'text',
          'default' => 'Get the highlights.',
          'required' => false,
        ],
        'items' => [
          'label' => 'Highlight Items',
          'type' => 'repeater',
          'required' => false,
          'sub_fields' => [
            'image' => [
              'label' => 'Image',
              'type' => 'image',
              'required' => false,
            ],
            'content' => [
              'label' => 'Text (WYSIWYG)',
              'type' => 'wysiwyg',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
  ];
}

/**
 * Add Components submenu to WordPress admin
 */
add_action('admin_menu', function() {
  add_submenu_page(
    'themes.php',
    'Components',
    'Components',
    'manage_options',
    'mcnab-components',
    'mcnab_components_admin_page'
  );
});

/**
 * Components Admin Page
 */
function mcnab_components_admin_page() {
  $components = mcnab_get_registered_components();
  ?>
  <div class="wrap">
    <h1>McNab Ventures - Components</h1>
    <p class="description">Available reusable components for your theme.</p>
    
    <div class="components-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
      <?php foreach ($components as $slug => $component) : ?>
        <div class="component-card" style="border: 1px solid #ddd; padding: 20px; border-radius: 4px; background: #fff;">
          <h2 style="margin-top: 0;"><?php echo esc_html($component['name']); ?></h2>
          <p style="color: #666;"><?php echo esc_html($component['description']); ?></p>
          
          <h3 style="font-size: 14px; margin-top: 15px;">Usage:</h3>
          <code style="display: block; background: #f5f5f5; padding: 10px; border-radius: 3px; margin: 10px 0; font-size: 12px;">
            mcnab_render_twig_component('<?php echo esc_html($slug); ?>');
          </code>
          
          <h3 style="font-size: 14px; margin-top: 15px;">Shortcode:</h3>
          <code style="display: block; background: #f5f5f5; padding: 10px; border-radius: 3px; margin: 10px 0; font-size: 12px;">
            [<?php echo esc_html(str_replace('-', '_', $slug)); ?>]
          </code>
          
          <details style="margin-top: 15px;">
            <summary style="cursor: pointer; font-weight: 600; color: #2271b1;">View Fields</summary>
            <ul style="margin-top: 10px; padding-left: 20px;">
              <?php foreach ($component['fields'] as $field_key => $field) : ?>
                <li>
                  <strong><?php echo esc_html($field['label']); ?></strong>
                  <span style="color: #666;">(<?php echo esc_html($field['type']); ?>)</span>
                  <?php if (isset($field['default'])) : ?>
                    <br><small style="color: #999;">Default: <?php echo esc_html($field['default']); ?></small>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </details>
        </div>
      <?php endforeach; ?>
    </div>
    
    <div style="margin-top: 40px; padding: 20px; background: #f0f6fc; border-left: 4px solid #2271b1;">
      <h2>How to Create a New Component</h2>
      <ol>
        <li>Create a new <code>.twig</code> file in <code>views/components/</code></li>
        <li>Add the component to the registry in <code>inc/components-registry.php</code></li>
        <li>Use it with: <code>mcnab_render_twig_component('your-component-name')</code></li>
      </ol>
      <p><strong>Example:</strong> See <code>views/components/side-component.twig</code> for reference.</p>
    </div>
  </div>
  <?php
}
