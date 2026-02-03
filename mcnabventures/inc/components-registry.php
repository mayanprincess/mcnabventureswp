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
    'multimedia' => [
      'slug' => 'multimedia',
      'location' => 'page',
      'name' => 'Multimedia Component',
      'description' => 'Photo and video collections for a multimedia gallery.',
      'file' => 'multimedia.twig',
      'fields' => [
        'title' => [
          'label' => 'Section Title',
          'type' => 'text',
          'default' => 'Multimedia',
          'required' => false,
        ],
        'photos' => [
          'label' => 'Photos',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Photo ID',
              'type' => 'text',
              'required' => false,
            ],
            'src' => [
              'label' => 'Photo',
              'type' => 'image',
              'required' => false,
            ],
            'alt' => [
              'label' => 'Alt Text',
              'type' => 'text',
              'required' => false,
            ],
            'size' => [
              'label' => 'Size',
              'type' => 'select',
              'choices' => [
                'large' => 'Large',
                'tall' => 'Tall',
                'medium' => 'Medium',
                'small' => 'Small',
              ],
              'default' => 'medium',
              'required' => false,
            ],
          ],
        ],
        'videos' => [
          'label' => 'Videos',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Video ID',
              'type' => 'text',
              'required' => false,
            ],
            'thumbnail' => [
              'label' => 'Thumbnail',
              'type' => 'image',
              'required' => false,
            ],
            'video_url' => [
              'label' => 'Video URL',
              'type' => 'url',
              'placeholder' => 'https://example.com/video.mp4',
              'required' => false,
            ],
            'alt' => [
              'label' => 'Alt Text',
              'type' => 'text',
              'required' => false,
            ],
            'size' => [
              'label' => 'Size',
              'type' => 'select',
              'choices' => [
                'large' => 'Large',
                'tall' => 'Tall',
                'medium' => 'Medium',
                'small' => 'Small',
              ],
              'default' => 'medium',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'primary-hero' => [
      'slug' => 'primary-hero',
      'location' => 'page',
      'name' => 'Primary Hero',
      'description' => 'Primary hero with heading, MP4 background video, and two CTAs.',
      'file' => 'primary-hero.twig',
      'fields' => [
        'heading' => [
          'label' => 'Heading',
          'type' => 'text',
          'required' => false,
        ],
        'video_src' => [
          'label' => 'Video (MP4)',
          'type' => 'file',
          'mime_types' => 'mp4',
          'required' => false,
        ],
        'primary_button' => [
          'label' => 'Primary Button',
          'type' => 'group',
          'sub_fields' => [
            'label' => [
              'label' => 'Label',
              'type' => 'text',
              'required' => false,
            ],
            'href' => [
              'label' => 'URL',
              'type' => 'url',
              'required' => false,
            ],
          ],
        ],
        'secondary_button' => [
          'label' => 'Secondary Button',
          'type' => 'group',
          'sub_fields' => [
            'label' => [
              'label' => 'Label',
              'type' => 'text',
              'required' => false,
            ],
            'href' => [
              'label' => 'URL',
              'type' => 'url',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'secondary-hero' => [
      'slug' => 'secondary-hero',
      'location' => 'page',
      'name' => 'Secondary Hero',
      'description' => 'Hero with background image and optional vector design.',
      'file' => 'secondary-hero.twig',
      'fields' => [
        'image' => [
          'label' => 'Image',
          'type' => 'image',
          'required' => false,
        ],
        'heading' => [
          'label' => 'Heading',
          'type' => 'text',
          'required' => false,
        ],
        'linkLabel' => [
          'label' => 'Link Label',
          'type' => 'text',
          'required' => false,
        ],
        'linkUrl' => [
          'label' => 'Link URL',
          'type' => 'url',
          'required' => false,
        ],
        'useVectorDesign' => [
          'label' => 'Use Vector Design',
          'type' => 'true_false',
          'default' => 0,
          'required' => false,
        ],
      ],
    ],
    'mission-statement' => [
      'slug' => 'mission-statement',
      'location' => 'page',
      'name' => 'Mission Statement',
      'description' => 'Single text with optional highlight phrases.',
      'file' => 'mission-statement.twig',
      'fields' => [
        'text' => [
          'label' => 'Text',
          'type' => 'textarea',
          'required' => false,
        ],
        'highlights' => [
          'label' => 'Highlights',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'text' => [
              'label' => 'Highlight',
              'type' => 'text',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'video-player' => [
      'slug' => 'video-player',
      'location' => 'page',
      'name' => 'Video Player',
      'description' => 'Standalone video with poster image.',
      'file' => 'video-player.twig',
      'fields' => [
        'video_src' => [
          'label' => 'Video (MP4)',
          'type' => 'file',
          'mime_types' => 'mp4',
          'required' => false,
        ],
        'poster_image' => [
          'label' => 'Poster Image',
          'type' => 'image',
          'required' => false,
        ],
      ],
    ],
    'group-snapshot' => [
      'slug' => 'group-snapshot',
      'location' => 'page',
      'name' => 'Group Snapshot',
      'description' => 'Snapshot slides with highlights and company logos.',
      'file' => 'group-snapshot.twig',
      'fields' => [
        'slides' => [
          'label' => 'Slides',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Slide ID',
              'type' => 'text',
              'required' => false,
            ],
            'main_image' => [
              'label' => 'Main Image',
              'type' => 'image',
              'required' => false,
            ],
            'circle_image' => [
              'label' => 'Circle Image',
              'type' => 'image',
              'required' => false,
            ],
            'badge' => [
              'label' => 'Badge',
              'type' => 'text',
              'required' => false,
            ],
            'title' => [
              'label' => 'Title',
              'type' => 'text',
              'required' => false,
            ],
            'description' => [
              'label' => 'Description',
              'type' => 'textarea',
              'required' => false,
            ],
            'highlights' => [
              'label' => 'Highlights',
              'type' => 'repeater',
              'required' => false,
              'default' => [],
              'sub_fields' => [
                'text' => [
                  'label' => 'Highlight',
                  'type' => 'text',
                  'required' => false,
                ],
              ],
            ],
          ],
        ],
        'company_logos' => [
          'label' => 'Company Logos',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'name' => [
              'label' => 'Name',
              'type' => 'text',
              'required' => false,
            ],
            'logo' => [
              'label' => 'Logo (SVG)',
              'type' => 'file',
              'mime_types' => 'svg',
              'required' => false,
            ],
            'width' => [
              'label' => 'Width',
              'type' => 'number',
              'required' => false,
            ],
            'height' => [
              'label' => 'Height',
              'type' => 'number',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'our-partners' => [
      'slug' => 'our-partners',
      'location' => 'page',
      'name' => 'Our Partners',
      'description' => 'Partner logos with badge and title.',
      'file' => 'our-partners.twig',
      'fields' => [
        'badge' => [
          'label' => 'Badge',
          'type' => 'text',
          'required' => false,
        ],
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'partners' => [
          'label' => 'Partners',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'name' => [
              'label' => 'Name',
              'type' => 'text',
              'required' => false,
            ],
            'logo' => [
              'label' => 'Logo (SVG)',
              'type' => 'file',
              'mime_types' => 'svg',
              'required' => false,
            ],
            'width' => [
              'label' => 'Width',
              'type' => 'number',
              'required' => false,
            ],
            'height' => [
              'label' => 'Height',
              'type' => 'number',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'featured-experiences' => [
      'slug' => 'featured-experiences',
      'location' => 'page',
      'name' => 'Featured Experiences',
      'description' => 'Grid of mixed media tiles.',
      'file' => 'featured-experiences.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'description' => [
          'label' => 'Description',
          'type' => 'textarea',
          'required' => false,
        ],
        'grid_items' => [
          'label' => 'Grid Items',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'type' => [
              'label' => 'Item Type',
              'type' => 'select',
              'choices' => [
                'image' => 'Image',
                'text' => 'Text',
                'icon' => 'Icon',
              ],
              'default' => 'image',
              'required' => false,
            ],
            'image' => [
              'label' => 'Image',
              'type' => 'image',
              'required' => false,
              'conditional_logic' => [
                [
                  [
                    'field' => 'type',
                    'operator' => '==',
                    'value' => 'image',
                  ],
                ],
              ],
            ],
            'text' => [
              'label' => 'Text',
              'type' => 'text',
              'required' => false,
              'conditional_logic' => [
                [
                  [
                    'field' => 'type',
                    'operator' => '==',
                    'value' => 'text',
                  ],
                ],
              ],
            ],
            'icon' => [
              'label' => 'Icon (SVG)',
              'type' => 'file',
              'mime_types' => 'svg',
              'required' => false,
              'conditional_logic' => [
                [
                  [
                    'field' => 'type',
                    'operator' => '==',
                    'value' => 'icon',
                  ],
                ],
              ],
            ],
            'background_color' => [
              'label' => 'Background Color',
              'type' => 'select',
              'choices' => [
                'navy' => 'Navy',
                'gold' => 'Gold',
                'turquoise' => 'Turquoise',
                'sand' => 'Sand',
              ],
              'default' => 'navy',
              'required' => false,
            ],
            'text_color' => [
              'label' => 'Text Color',
              'type' => 'select',
              'choices' => [
                'white' => 'White',
                'navy' => 'Navy',
              ],
              'default' => 'white',
              'required' => false,
            ],
            'grid_column' => [
              'label' => 'Grid Column',
              'type' => 'text',
              'required' => false,
            ],
            'grid_row' => [
              'label' => 'Grid Row',
              'type' => 'text',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'stay-in-the-loop' => [
      'slug' => 'stay-in-the-loop',
      'location' => 'page',
      'name' => 'Stay In The Loop',
      'description' => 'News or article teaser cards.',
      'file' => 'stay-in-the-loop.twig',
      'fields' => [
        'section_title' => [
          'label' => 'Section Title',
          'type' => 'text',
          'required' => false,
        ],
        'view_all_url' => [
          'label' => 'View All URL',
          'type' => 'url',
          'required' => false,
        ],
        'items' => [
          'label' => 'Items',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Item ID',
              'type' => 'text',
              'required' => false,
            ],
            'category' => [
              'label' => 'Category',
              'type' => 'text',
              'required' => false,
            ],
            'title' => [
              'label' => 'Title',
              'type' => 'text',
              'required' => false,
            ],
            'date' => [
              'label' => 'Date',
              'type' => 'date',
              'required' => false,
            ],
            'image' => [
              'label' => 'Image',
              'type' => 'image',
              'required' => false,
            ],
            'href' => [
              'label' => 'Link',
              'type' => 'url',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'diversified' => [
      'slug' => 'diversified',
      'location' => 'page',
      'name' => 'Diversified',
      'description' => 'Image section with title.',
      'file' => 'diversified.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'image' => [
          'label' => 'Image',
          'type' => 'image',
          'required' => false,
        ],
      ],
    ],
    'join-our-team' => [
      'slug' => 'join-our-team',
      'location' => 'page',
      'name' => 'Join Our Team',
      'description' => 'Recruiting section with CTA and image.',
      'file' => 'join-our-team.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'description' => [
          'label' => 'Description',
          'type' => 'textarea',
          'required' => false,
        ],
        'button_text' => [
          'label' => 'Button Text',
          'type' => 'text',
          'required' => false,
        ],
        'button_href' => [
          'label' => 'Button URL',
          'type' => 'url',
          'required' => false,
        ],
        'image' => [
          'label' => 'Image',
          'type' => 'image',
          'required' => false,
        ],
      ],
    ],
    'who-we-are' => [
      'slug' => 'who-we-are',
      'location' => 'page',
      'name' => 'Who We Are',
      'description' => 'Badge + split title with highlight and description.',
      'file' => 'who-we-are.twig',
      'fields' => [
        'badge' => [
          'label' => 'Badge',
          'type' => 'text',
          'required' => false,
        ],
        'title_part_1' => [
          'label' => 'Title Part 1',
          'type' => 'text',
          'required' => false,
        ],
        'title_highlight' => [
          'label' => 'Title Highlight',
          'type' => 'text',
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
    'our-journey' => [
      'slug' => 'our-journey',
      'location' => 'page',
      'name' => 'Our Journey',
      'description' => 'Accordion timeline of milestones.',
      'file' => 'our-journey.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'default_open' => [
          'label' => 'Default Open (ID or Title)',
          'type' => 'text',
          'required' => false,
        ],
        'items' => [
          'label' => 'Items',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Item ID',
              'type' => 'text',
              'required' => false,
            ],
            'title' => [
              'label' => 'Title',
              'type' => 'text',
              'required' => false,
            ],
            'content' => [
              'label' => 'Content',
              'type' => 'textarea',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'get-highlights' => [
      'slug' => 'get-highlights',
      'location' => 'page',
      'name' => 'Get Highlights',
      'description' => 'Highlight cards with image, title, description, and link.',
      'file' => 'get-highlights.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'items' => [
          'label' => 'Items',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Item ID',
              'type' => 'text',
              'required' => false,
            ],
            'image' => [
              'label' => 'Image',
              'type' => 'image',
              'required' => false,
            ],
            'title' => [
              'label' => 'Title',
              'type' => 'text',
              'required' => false,
            ],
            'description' => [
              'label' => 'Description',
              'type' => 'textarea',
              'required' => false,
            ],
            'href' => [
              'label' => 'Link',
              'type' => 'url',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'our-industries' => [
      'slug' => 'our-industries',
      'location' => 'page',
      'name' => 'Our Industries',
      'description' => 'Industry cards with image and link.',
      'file' => 'our-industries.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'items' => [
          'label' => 'Items',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Item ID',
              'type' => 'text',
              'required' => false,
            ],
            'title' => [
              'label' => 'Title',
              'type' => 'text',
              'required' => false,
            ],
            'image' => [
              'label' => 'Image',
              'type' => 'image',
              'required' => false,
            ],
            'description' => [
              'label' => 'Description',
              'type' => 'textarea',
              'required' => false,
            ],
            'href' => [
              'label' => 'Link',
              'type' => 'url',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'contact-card' => [
      'slug' => 'contact-card',
      'location' => 'page',
      'name' => 'Contact Card',
      'description' => 'Contact card with social links.',
      'file' => 'contact-card.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'contact_type' => [
          'label' => 'Contact Type',
          'type' => 'text',
          'required' => false,
        ],
        'name' => [
          'label' => 'Name',
          'type' => 'text',
          'required' => false,
        ],
        'position' => [
          'label' => 'Position',
          'type' => 'text',
          'required' => false,
        ],
        'email' => [
          'label' => 'Email',
          'type' => 'email',
          'required' => false,
        ],
        'phone' => [
          'label' => 'Phone',
          'type' => 'text',
          'required' => false,
        ],
        'website' => [
          'label' => 'Website',
          'type' => 'url',
          'required' => false,
        ],
        'address' => [
          'label' => 'Address',
          'type' => 'textarea',
          'required' => false,
        ],
        'image' => [
          'label' => 'Image',
          'type' => 'image',
          'required' => false,
        ],
        'social_links' => [
          'label' => 'Social Links',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'name' => [
              'label' => 'Name',
              'type' => 'text',
              'required' => false,
            ],
            'icon' => [
              'label' => 'Icon (SVG)',
              'type' => 'file',
              'mime_types' => 'svg',
              'required' => false,
            ],
            'href' => [
              'label' => 'URL',
              'type' => 'url',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'useful-links' => [
      'slug' => 'useful-links',
      'location' => 'page',
      'name' => 'Useful Links',
      'description' => 'Icon links list.',
      'file' => 'useful-links.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'links' => [
          'label' => 'Links',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'label' => [
              'label' => 'Label',
              'type' => 'text',
              'required' => false,
            ],
            'href' => [
              'label' => 'URL',
              'type' => 'url',
              'required' => false,
            ],
            'icon' => [
              'label' => 'Icon (SVG)',
              'type' => 'file',
              'mime_types' => 'svg',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'driven-by-progress' => [
      'slug' => 'driven-by-progress',
      'location' => 'page',
      'name' => 'Driven By Progress',
      'description' => 'Stats with icon and supporting image.',
      'file' => 'driven-by-progress.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'description' => [
          'label' => 'Description',
          'type' => 'textarea',
          'required' => false,
        ],
        'image' => [
          'label' => 'Image',
          'type' => 'image',
          'required' => false,
        ],
        'stats' => [
          'label' => 'Stats',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'icon' => [
              'label' => 'Icon (SVG)',
              'type' => 'file',
              'mime_types' => 'svg',
              'required' => false,
            ],
            'value' => [
              'label' => 'Value',
              'type' => 'text',
              'required' => false,
            ],
            'label' => [
              'label' => 'Label',
              'type' => 'text',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'experiences-gallery' => [
      'slug' => 'experiences-gallery',
      'location' => 'page',
      'name' => 'Experiences Gallery',
      'description' => 'Gallery slides with split text.',
      'file' => 'experiences-gallery.twig',
      'fields' => [
        'slides' => [
          'label' => 'Slides',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Slide ID',
              'type' => 'number',
              'required' => false,
            ],
            'backgroundImage' => [
              'label' => 'Background Image',
              'type' => 'image',
              'required' => false,
            ],
            'leftText' => [
              'label' => 'Left Text',
              'type' => 'text',
              'required' => false,
            ],
            'rightText' => [
              'label' => 'Right Text',
              'type' => 'text',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'sustainability-in-action' => [
      'slug' => 'sustainability-in-action',
      'location' => 'page',
      'name' => 'Sustainability In Action',
      'description' => 'Card grid with background image.',
      'file' => 'sustainability-in-action.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'backgroundImage' => [
          'label' => 'Background Image',
          'type' => 'image',
          'required' => false,
        ],
        'cards' => [
          'label' => 'Cards',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Card ID',
              'type' => 'number',
              'required' => false,
            ],
            'title' => [
              'label' => 'Title',
              'type' => 'text',
              'required' => false,
            ],
            'image' => [
              'label' => 'Image',
              'type' => 'image',
              'required' => false,
            ],
            'href' => [
              'label' => 'Link',
              'type' => 'url',
              'required' => false,
            ],
          ],
        ],
      ],
    ],
    'the-experiences' => [
      'slug' => 'the-experiences',
      'location' => 'page',
      'name' => 'The Experiences',
      'description' => 'Experience layouts with single or dual image formats.',
      'file' => 'the-experiences.twig',
      'fields' => [
        'title' => [
          'label' => 'Title',
          'type' => 'text',
          'required' => false,
        ],
        'items' => [
          'label' => 'Items',
          'type' => 'repeater',
          'required' => false,
          'default' => [],
          'sub_fields' => [
            'id' => [
              'label' => 'Item ID',
              'type' => 'number',
              'required' => false,
            ],
            'layout' => [
              'label' => 'Layout',
              'type' => 'select',
              'choices' => [
                'single' => 'Single',
                'two-images' => 'Two Images',
              ],
              'default' => 'single',
              'required' => false,
            ],
            'mainImage' => [
              'label' => 'Main Image',
              'type' => 'image',
              'required' => false,
            ],
            'secondaryImage' => [
              'label' => 'Secondary Image',
              'type' => 'image',
              'required' => false,
              'conditional_logic' => [
                [
                  [
                    'field' => 'layout',
                    'operator' => '==',
                    'value' => 'two-images',
                  ],
                ],
              ],
            ],
            'circularImage' => [
              'label' => 'Circular Image',
              'type' => 'image',
              'required' => false,
              'conditional_logic' => [
                [
                  [
                    'field' => 'layout',
                    'operator' => '==',
                    'value' => 'two-images',
                  ],
                ],
              ],
            ],
            'title' => [
              'label' => 'Title',
              'type' => 'text',
              'required' => false,
            ],
            'description' => [
              'label' => 'Description',
              'type' => 'textarea',
              'required' => false,
            ],
            'buttonText' => [
              'label' => 'Button Text',
              'type' => 'text',
              'required' => false,
            ],
            'buttonHref' => [
              'label' => 'Button URL',
              'type' => 'url',
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
