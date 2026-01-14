/**
 * Gutenberg Blocks - JavaScript
 * 
 * Register custom blocks for the block editor
 */

(function() {
  const { registerBlockType } = wp.blocks;
  const { RichText, MediaUpload, InspectorControls } = wp.blockEditor;
  const { PanelBody, TextControl, TextareaControl, Button } = wp.components;
  const { Fragment } = wp.element;
  const { __ } = wp.i18n;

  // Side Component Block
  registerBlockType('mcnab/side-component', {
    title: __('Side Component', 'mcnabventures'),
    icon: 'columns',
    category: 'design',
    description: __('Two-column layout with logo pill and content', 'mcnabventures'),
    attributes: {
      badge: {
        type: 'string',
        default: 'WHO WE ARE',
      },
      titlePart1: {
        type: 'string',
        default: '',
      },
      titleHighlight: {
        type: 'string',
        default: '',
      },
      description: {
        type: 'string',
        default: '',
      },
      logoId: {
        type: 'number',
        default: 0,
      },
      logoUrl: {
        type: 'string',
        default: '',
      },
    },
    edit: function(props) {
      const { attributes, setAttributes } = props;
      
      function onSelectLogo(media) {
        setAttributes({
          logoId: media.id,
          logoUrl: media.url,
        });
      }

      return (
        <Fragment>
          <InspectorControls>
            <PanelBody title={__('Side Component Settings', 'mcnabventures')}>
              <TextControl
                label={__('Badge Text', 'mcnabventures')}
                value={attributes.badge}
                onChange={(value) => setAttributes({ badge: value })}
              />
              <TextControl
                label={__('Title Part 1', 'mcnabventures')}
                value={attributes.titlePart1}
                onChange={(value) => setAttributes({ titlePart1: value })}
              />
              <TextControl
                label={__('Title Highlight (Teal)', 'mcnabventures')}
                value={attributes.titleHighlight}
                onChange={(value) => setAttributes({ titleHighlight: value })}
              />
              <TextareaControl
                label={__('Description', 'mcnabventures')}
                value={attributes.description}
                onChange={(value) => setAttributes({ description: value })}
              />
              <MediaUpload
                onSelect={onSelectLogo}
                allowedTypes={['image']}
                value={attributes.logoId}
                render={({ open }) => (
                  <Button onClick={open} isSecondary>
                    {attributes.logoUrl ? __('Change Logo', 'mcnabventures') : __('Select Logo', 'mcnabventures')}
                  </Button>
                )}
              />
            </PanelBody>
          </InspectorControls>
          
          <div className="mcnab-side-component-preview" style={{ padding: '20px', border: '1px dashed #ccc' }}>
            <h3>{__('Side Component', 'mcnabventures')}</h3>
            <p><strong>{attributes.badge || 'WHO WE ARE'}</strong></p>
            {attributes.logoUrl && (
              <img src={attributes.logoUrl} alt="Logo" style={{ maxWidth: '100px', height: 'auto' }} />
            )}
            <p>{attributes.titlePart1 || 'Title part 1...'}</p>
            <p style={{ color: '#2FBFB3' }}>{attributes.titleHighlight || 'Highlighted text...'}</p>
            <p>{attributes.description || 'Description...'}</p>
          </div>
        </Fragment>
      );
    },
    save: function() {
      // Server-side rendering
      return null;
    },
  });

  // Hero Component Block
  registerBlockType('mcnab/hero', {
    title: __('Hero Component', 'mcnabventures'),
    icon: 'cover-image',
    category: 'design',
    description: __('Full-width hero section with background image', 'mcnabventures'),
    attributes: {
      title: {
        type: 'string',
        default: '',
      },
      subtitle: {
        type: 'string',
        default: '',
      },
      buttonText: {
        type: 'string',
        default: '',
      },
      buttonUrl: {
        type: 'string',
        default: '#',
      },
      backgroundImageId: {
        type: 'number',
        default: 0,
      },
      backgroundImageUrl: {
        type: 'string',
        default: '',
      },
    },
    edit: function(props) {
      const { attributes, setAttributes } = props;
      
      function onSelectBackground(media) {
        setAttributes({
          backgroundImageId: media.id,
          backgroundImageUrl: media.url,
        });
      }

      return (
        <Fragment>
          <InspectorControls>
            <PanelBody title={__('Hero Settings', 'mcnabventures')}>
              <TextControl
                label={__('Title', 'mcnabventures')}
                value={attributes.title}
                onChange={(value) => setAttributes({ title: value })}
              />
              <TextControl
                label={__('Subtitle', 'mcnabventures')}
                value={attributes.subtitle}
                onChange={(value) => setAttributes({ subtitle: value })}
              />
              <TextControl
                label={__('Button Text', 'mcnabventures')}
                value={attributes.buttonText}
                onChange={(value) => setAttributes({ buttonText: value })}
              />
              <TextControl
                label={__('Button URL', 'mcnabventures')}
                value={attributes.buttonUrl}
                onChange={(value) => setAttributes({ buttonUrl: value })}
              />
              <MediaUpload
                onSelect={onSelectBackground}
                allowedTypes={['image']}
                value={attributes.backgroundImageId}
                render={({ open }) => (
                  <Button onClick={open} isSecondary>
                    {attributes.backgroundImageUrl ? __('Change Background', 'mcnabventures') : __('Select Background Image', 'mcnabventures')}
                  </Button>
                )}
              />
            </PanelBody>
          </InspectorControls>
          
          <div className="mcnab-hero-preview" style={{ 
            padding: '40px', 
            border: '1px dashed #ccc',
            backgroundImage: attributes.backgroundImageUrl ? `url(${attributes.backgroundImageUrl})` : 'none',
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            minHeight: '300px',
            color: '#fff',
            textShadow: '0 2px 4px rgba(0,0,0,0.5)'
          }}>
            <h2>{attributes.title || 'Hero Title'}</h2>
            <p>{attributes.subtitle || 'Hero subtitle...'}</p>
            {attributes.buttonText && (
              <button style={{ 
                padding: '10px 20px', 
                background: '#2FBFB3', 
                color: '#fff', 
                border: 'none', 
                borderRadius: '20px',
                cursor: 'pointer'
              }}>
                {attributes.buttonText}
              </button>
            )}
          </div>
        </Fragment>
      );
    },
    save: function() {
      return null;
    },
  });

  // Accordion Component Block
  registerBlockType('mcnab/accordion', {
    title: __('Accordion Component', 'mcnabventures'),
    icon: 'list-view',
    category: 'design',
    description: __('Expandable accordion menu', 'mcnabventures'),
    attributes: {
      title: {
        type: 'string',
        default: 'Our Journey',
      },
      items: {
        type: 'array',
        default: [],
      },
    },
    edit: function(props) {
      const { attributes, setAttributes } = props;
      
      function addItem() {
        const newItems = [...(attributes.items || []), { title: '', content: '' }];
        setAttributes({ items: newItems });
      }
      
      function updateItem(index, field, value) {
        const newItems = [...attributes.items];
        newItems[index][field] = value;
        setAttributes({ items: newItems });
      }
      
      function removeItem(index) {
        const newItems = attributes.items.filter((_, i) => i !== index);
        setAttributes({ items: newItems });
      }

      return (
        <Fragment>
          <InspectorControls>
            <PanelBody title={__('Accordion Settings', 'mcnabventures')}>
              <TextControl
                label={__('Accordion Title', 'mcnabventures')}
                value={attributes.title}
                onChange={(value) => setAttributes({ title: value })}
              />
              <Button onClick={addItem} isPrimary>
                {__('Add Item', 'mcnabventures')}
              </Button>
              {(attributes.items || []).map((item, index) => (
                <div key={index} style={{ marginTop: '15px', padding: '10px', border: '1px solid #ddd' }}>
                  <TextControl
                    label={__('Item Title', 'mcnabventures')}
                    value={item.title || ''}
                    onChange={(value) => updateItem(index, 'title', value)}
                  />
                  <TextareaControl
                    label={__('Item Content', 'mcnabventures')}
                    value={item.content || ''}
                    onChange={(value) => updateItem(index, 'content', value)}
                  />
                  <Button onClick={() => removeItem(index)} isDestructive isSmall>
                    {__('Remove', 'mcnabventures')}
                  </Button>
                </div>
              ))}
            </PanelBody>
          </InspectorControls>
          
          <div className="mcnab-accordion-preview" style={{ padding: '20px', border: '1px dashed #ccc' }}>
            <h3>{attributes.title || 'Our Journey'}</h3>
            {(attributes.items || []).map((item, index) => (
              <div key={index} style={{ marginTop: '10px', padding: '10px', background: '#f5f5f5' }}>
                <strong>{item.title || 'Item Title'}</strong>
                <p style={{ fontSize: '12px', color: '#666' }}>{item.content || 'Item content...'}</p>
              </div>
            ))}
            {(!attributes.items || attributes.items.length === 0) && (
              <p style={{ color: '#999', fontStyle: 'italic' }}>No items yet. Add items in the sidebar.</p>
            )}
          </div>
        </Fragment>
      );
    },
    save: function() {
      return null;
    },
  });

})();
