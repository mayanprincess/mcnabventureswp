# McNab Ventures - Guía Completa de ACF Backend

**Guía oficial para crear componentes SOLO en el backend (ACF) sin tocar frontend**

Esta guía te permite definir **todos los campos** de tus componentes para que el sistema los genere automáticamente en WordPress. No necesitas preocuparte por Twig, SCSS o JavaScript.

---

## 📋 Tabla de Contenidos

1. [Arquitectura del Sistema ACF](#1-arquitectura-del-sistema-acf)
2. [Estructura de un Componente](#2-estructura-de-un-componente)
3. [Tipos de Campos Disponibles](#3-tipos-de-campos-disponibles)
4. [Campos Simples](#4-campos-simples)
5. [Campos de Medios](#5-campos-de-medios)
6. [Campos de Selección](#6-campos-de-selección)
7. [Campos Repetidores](#7-campos-repetidores)
8. [Campos Anidados](#8-campos-anidados)
9. [Lógica Condicional](#9-lógica-condicional)
10. [Validaciones y Configuraciones](#10-validaciones-y-configuraciones)
11. [Ejemplos Completos](#11-ejemplos-completos)
12. [Referencia Rápida](#12-referencia-rápida)

---

## 1. Arquitectura del Sistema ACF

### ¿Cómo Funciona?

Este proyecto usa un sistema automatizado donde:

1. **Defines el componente** en `mcnabventures/inc/components-registry.php`
2. **El sistema genera automáticamente** los campos ACF en WordPress
3. **Los usuarios agregan el componente** desde el editor de páginas
4. **El frontend renderiza automáticamente** (Twig se encarga)

### Archivos Clave

```
mcnabventures/
├── inc/
│   ├── components-registry.php    ← AQUÍ defines componentes
│   ├── acf-fields.php             ← Sistema automático (NO tocar)
│   └── timber-setup.php           ← Renderizado (NO tocar)
```

**IMPORTANTE:** Solo editas `components-registry.php`. Los demás archivos funcionan automáticamente.

---

## 2. Estructura de un Componente

### Plantilla Base

```php
'component-slug' => [
  'slug' => 'component-slug',           // Identificador único
  'location' => 'page',                 // Dónde aparece (page, post, etc.)
  'name' => 'Component Name',           // Nombre legible en admin
  'description' => 'Brief description', // Descripción para admin
  'file' => 'component-slug.twig',     // Archivo Twig (frontend)
  'fields' => [
    // AQUÍ van los campos
  ],
],
```

### Ejemplo Mínimo

```php
'simple-text' => [
  'slug' => 'simple-text',
  'location' => 'page',
  'name' => 'Simple Text',
  'description' => 'Componente con solo un campo de texto',
  'file' => 'simple-text.twig',
  'fields' => [
    'title' => [
      'label' => 'Title',
      'type' => 'text',
      'required' => false,
    ],
  ],
],
```

---

## 3. Tipos de Campos Disponibles

### Mapeo de Tipos

El sistema convierte automáticamente estos tipos:

| Tipo en Registry | Tipo ACF Real | Uso |
|-----------------|---------------|-----|
| `text` | `text` | Texto corto |
| `textarea` | `textarea` | Texto largo (sin formato) |
| `wysiwyg` | `wysiwyg` | Editor rico (HTML) |
| `email` | `email` | Email con validación |
| `url` | `url` | URL con validación |
| `number` | `number` | Número (int/float) |
| `image` | `image` | Imagen única |
| `gallery` | `gallery` | Galería de imágenes |
| `select` | `select` | Dropdown selector |
| `repeater` | `repeater` | Campos repetibles |

**Función de conversión** (en `acf-fields.php`):
```php
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
```

---

## 4. Campos Simples

### Text (Texto Corto)

```php
'title' => [
  'label' => 'Title',
  'type' => 'text',
  'default' => 'Default Title',
  'required' => false,
],
```

**Configuraciones disponibles:**
- `label`: Texto visible en admin
- `type`: `'text'`
- `default`: Valor por defecto
- `required`: `true` o `false`
- `placeholder`: Texto de ayuda (opcional)

### Textarea (Texto Largo)

```php
'description' => [
  'label' => 'Description',
  'type' => 'textarea',
  'required' => false,
],
```

**Nota:** El sistema automáticamente configura `rows: 4` para textareas.

### WYSIWYG (Editor Rico)

```php
'content' => [
  'label' => 'Content',
  'type' => 'wysiwyg',
  'required' => false,
],
```

**Configuración automática:**
- Toolbar: `'full'`
- Media upload: Habilitado
- Tabs: Todos (`visual` + `text`)

### Email

```php
'email' => [
  'label' => 'Email Address',
  'type' => 'email',
  'required' => true,
  'placeholder' => 'example@domain.com',
],
```

### URL

```php
'link' => [
  'label' => 'Link URL',
  'type' => 'url',
  'default' => '#',
  'required' => false,
  'placeholder' => 'https://example.com',
],
```

### Number

```php
'quantity' => [
  'label' => 'Quantity',
  'type' => 'number',
  'default' => 1,
  'required' => false,
],
```

---

## 5. Campos de Medios

### Image (Imagen Única)

```php
'background_image' => [
  'label' => 'Background Image',
  'type' => 'image',
  'required' => false,
],
```

**Configuración automática:**
- Return format: `'array'` (devuelve `url`, `alt`, `ID`, etc.)
- Preview size: `'medium'`
- Library: `'all'`

**Datos que recibes en frontend:**
```php
[
  'ID' => 123,
  'url' => 'https://example.com/wp-content/uploads/image.jpg',
  'alt' => 'Image description',
  'title' => 'Image Title',
  'width' => 1920,
  'height' => 1080,
  // ... más metadatos
]
```

### Gallery (Galería)

```php
'photos' => [
  'label' => 'Photo Gallery',
  'type' => 'gallery',
  'required' => false,
],
```

**Configuración automática:**
- Return format: `'array'`
- Preview size: `'medium'`
- Insert: `'append'`

**Datos que recibes en frontend:**
```php
[
  [
    'ID' => 123,
    'url' => 'image1.jpg',
    'alt' => 'Alt text 1',
  ],
  [
    'ID' => 124,
    'url' => 'image2.jpg',
    'alt' => 'Alt text 2',
  ],
  // ...
]
```

---

## 6. Campos de Selección

### Select (Dropdown)

```php
'alignment' => [
  'label' => 'Alignment',
  'type' => 'select',
  'choices' => [
    'left' => 'Left',
    'center' => 'Center',
    'right' => 'Right',
  ],
  'default' => 'left',
  'required' => false,
],
```

**Configuraciones:**
- `choices`: Array asociativo `['value' => 'Label']`
- `default`: Valor por defecto (debe coincidir con una key de `choices`)

---

## 7. Campos Repetidores

### Repeater Simple

```php
'items' => [
  'label' => 'Items',
  'type' => 'repeater',
  'required' => false,
  'sub_fields' => [
    'title' => [
      'label' => 'Item Title',
      'type' => 'text',
      'required' => false,
    ],
    'description' => [
      'label' => 'Item Description',
      'type' => 'textarea',
      'required' => false,
    ],
  ],
],
```

**Configuración automática:**
- Layout: `'block'`
- Button label: `'Add Item'`
- Min: `0` (sin mínimo)
- Max: `0` (sin máximo)

### Repeater con Imagen

```php
'highlights' => [
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
      'label' => 'Content',
      'type' => 'wysiwyg',
      'required' => false,
    ],
  ],
],
```

### Repeater con Select

```php
'tabs' => [
  'label' => 'Tabs',
  'type' => 'repeater',
  'required' => false,
  'sub_fields' => [
    'name' => [
      'label' => 'Tab Name',
      'type' => 'text',
      'placeholder' => 'e.g., Photos, Videos',
      'required' => true,
    ],
    'gallery_type' => [
      'label' => 'Gallery Type',
      'type' => 'select',
      'choices' => [
        'gallery' => 'Photo Gallery',
        'videos' => 'Video Gallery',
      ],
      'default' => 'gallery',
    ],
  ],
],
```

---

## 8. Campos Anidados

### Repeater dentro de Repeater

```php
'sections' => [
  'label' => 'Sections',
  'type' => 'repeater',
  'sub_fields' => [
    'section_title' => [
      'label' => 'Section Title',
      'type' => 'text',
    ],
    'items' => [
      'label' => 'Items',
      'type' => 'repeater',
      'sub_fields' => [
        'item_title' => [
          'label' => 'Item Title',
          'type' => 'text',
        ],
        'item_content' => [
          'label' => 'Item Content',
          'type' => 'wysiwyg',
        ],
      ],
    ],
  ],
],
```

**Estructura de datos resultante:**
```php
[
  [
    'section_title' => 'Section 1',
    'items' => [
      ['item_title' => 'Item 1.1', 'item_content' => '<p>Content</p>'],
      ['item_title' => 'Item 1.2', 'item_content' => '<p>Content</p>'],
    ],
  ],
  [
    'section_title' => 'Section 2',
    'items' => [
      ['item_title' => 'Item 2.1', 'item_content' => '<p>Content</p>'],
    ],
  ],
]
```

### Repeater con Gallery

```php
'albums' => [
  'label' => 'Photo Albums',
  'type' => 'repeater',
  'sub_fields' => [
    'album_name' => [
      'label' => 'Album Name',
      'type' => 'text',
    ],
    'photos' => [
      'label' => 'Photos',
      'type' => 'gallery',
    ],
  ],
],
```

---

## 9. Lógica Condicional

### Mostrar campo según Select

```php
'display_type' => [
  'label' => 'Display Type',
  'type' => 'select',
  'choices' => [
    'text' => 'Text Only',
    'image' => 'Image Only',
    'both' => 'Text + Image',
  ],
  'default' => 'both',
],

// Campo que solo aparece si display_type = 'image' o 'both'
'image' => [
  'label' => 'Image',
  'type' => 'image',
  'conditional_logic' => [
    [
      [
        'field' => 'display_type',
        'operator' => '==',
        'value' => 'image',
      ],
    ],
    [
      [
        'field' => 'display_type',
        'operator' => '==',
        'value' => 'both',
      ],
    ],
  ],
],
```

**Estructura de conditional_logic:**
- Nivel 1: Array de grupos (OR)
- Nivel 2: Array de condiciones en cada grupo (AND)
- Condición: `['field' => 'field_name', 'operator' => '==', 'value' => 'expected']`

**Operadores disponibles:**
- `'=='`: Igual a
- `'!='`: Diferente de
- `'>'`: Mayor que
- `'<'`: Menor que
- `'>='`: Mayor o igual que
- `'<='`: Menor o igual que

### Ejemplo Real: Multimedia Component

```php
'tabs' => [
  'label' => 'Multimedia Tabs',
  'type' => 'repeater',
  'sub_fields' => [
    'name' => [
      'label' => 'Tab Name',
      'type' => 'text',
    ],
    'gallery_type' => [
      'label' => 'Gallery Type',
      'type' => 'select',
      'choices' => [
        'gallery' => 'Photo Gallery',
        'videos' => 'Video Gallery',
      ],
      'default' => 'gallery',
    ],

    // Solo aparece si gallery_type = 'gallery'
    'gallery' => [
      'label' => 'Photo Gallery',
      'type' => 'gallery',
      'conditional_logic' => [
        [
          [
            'field' => 'gallery_type',
            'operator' => '==',
            'value' => 'gallery',
          ],
        ],
      ],
    ],

    // Solo aparece si gallery_type = 'videos'
    'videos' => [
      'label' => 'Video Gallery',
      'type' => 'repeater',
      'conditional_logic' => [
        [
          [
            'field' => 'gallery_type',
            'operator' => '==',
            'value' => 'videos',
          ],
        ],
      ],
      'sub_fields' => [
        'video_url' => [
          'label' => 'Video URL',
          'type' => 'url',
          'placeholder' => 'https://example.com/video.mp4',
        ],
        'video_title' => [
          'label' => 'Video Title',
          'type' => 'text',
        ],
      ],
    ],
  ],
],
```

---

## 10. Validaciones y Configuraciones

### Campos Requeridos

```php
'email' => [
  'label' => 'Email Address',
  'type' => 'email',
  'required' => true, // ← Usuario no puede guardar sin llenar
],
```

### Valores por Defecto

```php
'items_per_page' => [
  'label' => 'Items Per Page',
  'type' => 'number',
  'default' => 4, // ← Valor inicial
  'required' => false,
],
```

### Placeholders

```php
'video_url' => [
  'label' => 'Video URL',
  'type' => 'url',
  'placeholder' => 'https://yourdomain.com/video.mp4', // ← Texto de ayuda
],
```

### Configuración de Number

```php
'quantity' => [
  'label' => 'Quantity',
  'type' => 'number',
  'default' => 1,
  'min' => 0,
  'max' => 100,
  'step' => 1,
],
```

**Nota:** `min`, `max`, `step` requieren agregar configuración manual en `acf-fields.php`.

---

## 11. Ejemplos Completos

### Ejemplo 1: Card Component (Simple)

```php
'card' => [
  'slug' => 'card',
  'location' => 'page',
  'name' => 'Card',
  'description' => 'Tarjeta con imagen, título y descripción',
  'file' => 'card.twig',
  'fields' => [
    'image' => [
      'label' => 'Image',
      'type' => 'image',
      'required' => false,
    ],
    'title' => [
      'label' => 'Title',
      'type' => 'text',
      'required' => true,
    ],
    'description' => [
      'label' => 'Description',
      'type' => 'textarea',
      'required' => false,
    ],
    'link' => [
      'label' => 'Link URL',
      'type' => 'url',
      'required' => false,
    ],
  ],
],
```

### Ejemplo 2: Team Component (Repeater)

```php
'team' => [
  'slug' => 'team',
  'location' => 'page',
  'name' => 'Team Members',
  'description' => 'Sección de equipo con miembros',
  'file' => 'team.twig',
  'fields' => [
    'section_title' => [
      'label' => 'Section Title',
      'type' => 'text',
      'default' => 'Our Team',
    ],
    'members' => [
      'label' => 'Team Members',
      'type' => 'repeater',
      'sub_fields' => [
        'photo' => [
          'label' => 'Photo',
          'type' => 'image',
          'required' => false,
        ],
        'name' => [
          'label' => 'Name',
          'type' => 'text',
          'required' => true,
        ],
        'position' => [
          'label' => 'Position',
          'type' => 'text',
          'required' => false,
        ],
        'bio' => [
          'label' => 'Bio',
          'type' => 'wysiwyg',
          'required' => false,
        ],
        'email' => [
          'label' => 'Email',
          'type' => 'email',
          'required' => false,
        ],
      ],
    ],
  ],
],
```

### Ejemplo 3: Pricing Component (Anidado + Condicional)

```php
'pricing' => [
  'slug' => 'pricing',
  'location' => 'page',
  'name' => 'Pricing Plans',
  'description' => 'Tabla de precios con planes',
  'file' => 'pricing.twig',
  'fields' => [
    'title' => [
      'label' => 'Section Title',
      'type' => 'text',
      'default' => 'Pricing Plans',
    ],
    'plans' => [
      'label' => 'Plans',
      'type' => 'repeater',
      'sub_fields' => [
        'plan_name' => [
          'label' => 'Plan Name',
          'type' => 'text',
          'required' => true,
          'placeholder' => 'e.g., Basic, Pro, Enterprise',
        ],
        'price' => [
          'label' => 'Price',
          'type' => 'number',
          'required' => true,
          'placeholder' => '99',
        ],
        'currency' => [
          'label' => 'Currency',
          'type' => 'select',
          'choices' => [
            'usd' => 'USD ($)',
            'eur' => 'EUR (€)',
            'gbp' => 'GBP (£)',
          ],
          'default' => 'usd',
        ],
        'is_featured' => [
          'label' => 'Featured Plan',
          'type' => 'select',
          'choices' => [
            'no' => 'No',
            'yes' => 'Yes',
          ],
          'default' => 'no',
        ],
        'featured_badge' => [
          'label' => 'Featured Badge Text',
          'type' => 'text',
          'default' => 'Most Popular',
          'conditional_logic' => [
            [
              [
                'field' => 'is_featured',
                'operator' => '==',
                'value' => 'yes',
              ],
            ],
          ],
        ],
        'features' => [
          'label' => 'Features',
          'type' => 'repeater',
          'sub_fields' => [
            'feature_text' => [
              'label' => 'Feature',
              'type' => 'text',
              'placeholder' => 'e.g., Unlimited storage',
            ],
            'is_included' => [
              'label' => 'Included',
              'type' => 'select',
              'choices' => [
                'yes' => 'Yes',
                'no' => 'No',
              ],
              'default' => 'yes',
            ],
          ],
        ],
        'cta_text' => [
          'label' => 'CTA Button Text',
          'type' => 'text',
          'default' => 'Get Started',
        ],
        'cta_url' => [
          'label' => 'CTA Button URL',
          'type' => 'url',
          'required' => false,
        ],
      ],
    ],
  ],
],
```

### Ejemplo 4: FAQ Component (Accordion)

```php
'faq' => [
  'slug' => 'faq',
  'location' => 'page',
  'name' => 'FAQ (Accordion)',
  'description' => 'Preguntas frecuentes en formato accordion',
  'file' => 'faq.twig',
  'fields' => [
    'title' => [
      'label' => 'Section Title',
      'type' => 'text',
      'default' => 'Frequently Asked Questions',
    ],
    'questions' => [
      'label' => 'Questions',
      'type' => 'repeater',
      'sub_fields' => [
        'question' => [
          'label' => 'Question',
          'type' => 'text',
          'required' => true,
          'placeholder' => 'e.g., How do I get started?',
        ],
        'answer' => [
          'label' => 'Answer',
          'type' => 'wysiwyg',
          'required' => true,
        ],
      ],
    ],
  ],
],
```

### Ejemplo 5: Testimonials Component (Repeater con Imagen y Rating)

```php
'testimonials' => [
  'slug' => 'testimonials',
  'location' => 'page',
  'name' => 'Testimonials',
  'description' => 'Testimonios de clientes',
  'file' => 'testimonials.twig',
  'fields' => [
    'title' => [
      'label' => 'Section Title',
      'type' => 'text',
      'default' => 'What Our Clients Say',
    ],
    'testimonials' => [
      'label' => 'Testimonials',
      'type' => 'repeater',
      'sub_fields' => [
        'photo' => [
          'label' => 'Client Photo',
          'type' => 'image',
          'required' => false,
        ],
        'name' => [
          'label' => 'Client Name',
          'type' => 'text',
          'required' => true,
        ],
        'position' => [
          'label' => 'Position/Company',
          'type' => 'text',
          'required' => false,
          'placeholder' => 'e.g., CEO at Company Inc.',
        ],
        'rating' => [
          'label' => 'Rating (stars)',
          'type' => 'select',
          'choices' => [
            '5' => '5 stars',
            '4' => '4 stars',
            '3' => '3 stars',
            '2' => '2 stars',
            '1' => '1 star',
          ],
          'default' => '5',
        ],
        'testimonial' => [
          'label' => 'Testimonial',
          'type' => 'textarea',
          'required' => true,
        ],
      ],
    ],
  ],
],
```

---

## 12. Referencia Rápida

### Plantilla Copy-Paste

```php
'my-component' => [
  'slug' => 'my-component',
  'location' => 'page',
  'name' => 'My Component',
  'description' => 'Component description',
  'file' => 'my-component.twig',
  'fields' => [

    // TEXT FIELD
    'title' => [
      'label' => 'Title',
      'type' => 'text',
      'default' => '',
      'required' => false,
      'placeholder' => '',
    ],

    // TEXTAREA
    'description' => [
      'label' => 'Description',
      'type' => 'textarea',
      'required' => false,
    ],

    // WYSIWYG (Rich Editor)
    'content' => [
      'label' => 'Content',
      'type' => 'wysiwyg',
      'required' => false,
    ],

    // EMAIL
    'email' => [
      'label' => 'Email',
      'type' => 'email',
      'required' => false,
    ],

    // URL
    'link' => [
      'label' => 'Link',
      'type' => 'url',
      'default' => '#',
      'required' => false,
    ],

    // NUMBER
    'quantity' => [
      'label' => 'Quantity',
      'type' => 'number',
      'default' => 1,
      'required' => false,
    ],

    // IMAGE
    'image' => [
      'label' => 'Image',
      'type' => 'image',
      'required' => false,
    ],

    // GALLERY
    'gallery' => [
      'label' => 'Gallery',
      'type' => 'gallery',
      'required' => false,
    ],

    // SELECT
    'variant' => [
      'label' => 'Variant',
      'type' => 'select',
      'choices' => [
        'default' => 'Default',
        'dark' => 'Dark',
        'light' => 'Light',
      ],
      'default' => 'default',
    ],

    // REPEATER
    'items' => [
      'label' => 'Items',
      'type' => 'repeater',
      'sub_fields' => [
        'item_title' => [
          'label' => 'Item Title',
          'type' => 'text',
        ],
        'item_content' => [
          'label' => 'Item Content',
          'type' => 'wysiwyg',
        ],
      ],
    ],

    // CONDITIONAL FIELD
    'show_button' => [
      'label' => 'Show Button',
      'type' => 'select',
      'choices' => ['no' => 'No', 'yes' => 'Yes'],
      'default' => 'no',
    ],
    'button_text' => [
      'label' => 'Button Text',
      'type' => 'text',
      'conditional_logic' => [
        [
          [
            'field' => 'show_button',
            'operator' => '==',
            'value' => 'yes',
          ],
        ],
      ],
    ],

  ],
],
```

### Checklist de Validación

Antes de guardar tu componente, verifica:

- [ ] `slug` es único y usa guiones (no guiones bajos)
- [ ] `name` es legible para admin
- [ ] `file` coincide con `slug` + `.twig`
- [ ] Todos los campos tienen `label` y `type`
- [ ] Campos requeridos tienen `required: true`
- [ ] Selects tienen `choices` definidos
- [ ] Repeaters tienen `sub_fields`
- [ ] Conditional logic usa nombres de campo correctos

### Comandos Útiles

```bash
# Verificar que el archivo existe
cat mcnabventures/inc/components-registry.php | grep "my-component"

# Listar todos los componentes registrados
grep "'slug'" mcnabventures/inc/components-registry.php

# Ver estructura de un componente específico
grep -A 50 "'my-component'" mcnabventures/inc/components-registry.php
```

---

## 🎯 Flujo de Trabajo Completo

### Paso 1: Definir Componente

Edita `mcnabventures/inc/components-registry.php`:

```php
return [
  // ... componentes existentes ...

  'my-new-component' => [
    'slug' => 'my-new-component',
    'location' => 'page',
    'name' => 'My New Component',
    'description' => 'Brief description',
    'file' => 'my-new-component.twig',
    'fields' => [
      // Define tus campos aquí
    ],
  ],
];
```

### Paso 2: Guardar Archivo

Guarda `components-registry.php`.

### Paso 3: Verificar en WordPress

1. Ve a WordPress Admin
2. Edita cualquier página
3. Busca el field group **"Page Components"**
4. Click en **"Add Component"**
5. Deberías ver tu componente nuevo

### Paso 4: Llenar Datos

1. Selecciona tu componente
2. Llena los campos
3. Guarda la página
4. Ve al frontend (el Twig renderiza automáticamente)

---

## ❓ Troubleshooting

### "No veo mi componente en el editor"

✅ **Solución:**
1. Verifica que ACF Pro esté activo
2. Revisa que `inc/acf-fields.php` esté cargado en `functions.php`
3. Verifica sintaxis PHP (sin comas faltantes)

### "Los campos no aparecen"

✅ **Solución:**
1. Verifica que `fields` esté definido como array
2. Cada campo debe tener `label` y `type`
3. Revisa que no haya errores de sintaxis

### "Repeater no funciona"

✅ **Solución:**
1. Verifica que `sub_fields` esté definido
2. Cada sub_field debe tener estructura completa
3. No uses `required: true` en repeaters (solo en sub_fields)

### "Conditional logic no funciona"

✅ **Solución:**
1. Verifica que el nombre del campo en `field` sea exacto
2. Usa `operator: '=='` (dos signos igual)
3. El campo condicional debe estar **después** del campo de referencia

---

## 📚 Recursos

### Archivos del Proyecto

- **Registry:** `mcnabventures/inc/components-registry.php`
- **ACF System:** `mcnabventures/inc/acf-fields.php`
- **Functions:** `mcnabventures/functions.php`

### Documentación Relacionada

- **CLAUDE.md** - Quick Reference completa
- **DESIGN_SYSTEM_RULES.md** - Sistema de diseño
- **IA_COMPONENT_CREATION_GUIDE.md** - Guía fullstack

### ACF Documentation

- [ACF Field Types](https://www.advancedcustomfields.com/resources/)
- [Conditional Logic](https://www.advancedcustomfields.com/resources/conditional-logic/)
- [Repeater Field](https://www.advancedcustomfields.com/resources/repeater/)

---

## 🎓 Ejemplos por Casos de Uso

### Caso 1: Hero con Imagen de Fondo

```php
'hero' => [
  'slug' => 'hero',
  'location' => 'page',
  'name' => 'Hero Component',
  'description' => 'Hero section with background',
  'file' => 'hero.twig',
  'fields' => [
    'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
    'button_text' => ['label' => 'Button Text', 'type' => 'text'],
    'button_url' => ['label' => 'Button URL', 'type' => 'url', 'default' => '#'],
    'background_image' => ['label' => 'Background Image', 'type' => 'image'],
  ],
],
```

### Caso 2: Slider de Imágenes

```php
'slider' => [
  'slug' => 'slider',
  'location' => 'page',
  'name' => 'Image Slider',
  'description' => 'Carousel of images',
  'file' => 'slider.twig',
  'fields' => [
    'title' => ['label' => 'Title', 'type' => 'text'],
    'slides' => [
      'label' => 'Slides',
      'type' => 'repeater',
      'sub_fields' => [
        'image' => ['label' => 'Image', 'type' => 'image', 'required' => true],
        'caption' => ['label' => 'Caption', 'type' => 'text'],
      ],
    ],
  ],
],
```

### Caso 3: Grid de Servicios

```php
'services' => [
  'slug' => 'services',
  'location' => 'page',
  'name' => 'Services Grid',
  'description' => 'Grid of service cards',
  'file' => 'services.twig',
  'fields' => [
    'title' => ['label' => 'Section Title', 'type' => 'text', 'default' => 'Our Services'],
    'services' => [
      'label' => 'Services',
      'type' => 'repeater',
      'sub_fields' => [
        'icon' => ['label' => 'Icon Image', 'type' => 'image'],
        'title' => ['label' => 'Service Title', 'type' => 'text', 'required' => true],
        'description' => ['label' => 'Description', 'type' => 'textarea'],
        'link' => ['label' => 'Learn More Link', 'type' => 'url'],
      ],
    ],
  ],
],
```

### Caso 4: Formulario de Contacto Info

```php
'contact-info' => [
  'slug' => 'contact-info',
  'location' => 'page',
  'name' => 'Contact Information',
  'description' => 'Display contact details',
  'file' => 'contact-info.twig',
  'fields' => [
    'title' => ['label' => 'Title', 'type' => 'text', 'default' => 'Get In Touch'],
    'email' => ['label' => 'Email', 'type' => 'email', 'required' => true],
    'phone' => ['label' => 'Phone', 'type' => 'text'],
    'address' => ['label' => 'Address', 'type' => 'textarea'],
    'show_map' => [
      'label' => 'Show Map',
      'type' => 'select',
      'choices' => ['no' => 'No', 'yes' => 'Yes'],
      'default' => 'no',
    ],
    'map_embed' => [
      'label' => 'Map Embed Code',
      'type' => 'textarea',
      'placeholder' => '<iframe src="..."></iframe>',
      'conditional_logic' => [
        [['field' => 'show_map', 'operator' => '==', 'value' => 'yes']],
      ],
    ],
  ],
],
```

---

**Versión:** 1.0
**Fecha:** Enero 2026
**Proyecto:** McNab Ventures WordPress Theme
**Autor:** McNab Ventures Team

---

**¡Ahora puedes crear componentes completos sin tocar frontend!** 🎉
