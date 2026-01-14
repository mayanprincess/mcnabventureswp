# Cómo Crear un Nuevo Componente

## Proceso Paso a Paso

### 1. Crear el Template Twig

Crea un nuevo archivo en `views/components/` con el nombre de tu componente:

**Ejemplo:** `views/components/testimonial.twig`

```twig
{# Testimonial Component #}
<div class="testimonial-component">
  {% if image %}
    <img src="{{ image }}" alt="{{ name }}" class="testimonial-image">
  {% endif %}
  
  {% if quote %}
    <blockquote class="testimonial-quote">
      {{ quote }}
    </blockquote>
  {% endif %}
  
  {% if name %}
    <cite class="testimonial-author">{{ name }}</cite>
  {% endif %}
  
  {% if role %}
    <span class="testimonial-role">{{ role }}</span>
  {% endif %}
</div>
```

### 2. Registrar el Componente

Edita `inc/components-registry.php` y agrega tu componente al array:

```php
function mcnab_get_registered_components() {
  return [
    // ... componentes existentes ...
    
    'testimonial' => [
      'name' => 'Testimonial Component',
      'description' => 'Customer testimonial with image, quote, and author info',
      'file' => 'testimonial.twig',
      'fields' => [
        'image' => [
          'label' => 'Author Image',
          'type' => 'image',
          'required' => false,
        ],
        'quote' => [
          'label' => 'Testimonial Quote',
          'type' => 'textarea',
          'required' => true,
        ],
        'name' => [
          'label' => 'Author Name',
          'type' => 'text',
          'required' => true,
        ],
        'role' => [
          'label' => 'Author Role',
          'type' => 'text',
          'required' => false,
        ],
      ],
    ],
  ];
}
```

### 3. Crear los Estilos SCSS

Crea un archivo SCSS en `assets/scss/components/`:

**Ejemplo:** `assets/scss/components/_testimonial.scss`

```scss
// ==========================================================================
// TESTIMONIAL COMPONENT - McNab Ventures
// ==========================================================================

@use '../abstracts/variables' as *;
@use '../abstracts/mixins' as *;

.testimonial-component {
  padding: $spacing-xl;
  background: $color-off-white;
  border-radius: $border-radius-lg;
  
  .testimonial-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .testimonial-quote {
    font-family: $font-heading;
    font-style: italic;
    color: $color-navy;
  }
  
  .testimonial-author {
    font-weight: $font-weight-bold;
    color: $color-navy;
  }
  
  .testimonial-role {
    color: $color-gray;
    font-size: $font-size-sm;
  }
}
```

### 4. Importar el SCSS

Agrega el import en `assets/scss/main.scss`:

```scss
// Components
@use 'components/buttons';
@use 'components/header';
// ... otros componentes ...
@use 'components/testimonial'; // ← Agregar esta línea
```

### 5. Usar el Componente

Ahora puedes usar tu componente de varias formas:

#### En un Template PHP:

```php
mcnab_render_twig_component('testimonial', [
  'image' => get_template_directory_uri() . '/assets/images/testimonial.jpg',
  'quote' => 'This resort exceeded all our expectations!',
  'name' => 'John Doe',
  'role' => 'Happy Guest',
]);
```

#### Con ACF:

Si creas campos ACF con los mismos nombres, funciona automáticamente:

```php
mcnab_render_twig_component('testimonial'); // Lee ACF automáticamente
```

#### Como Shortcode:

Ya está registrado automáticamente:

```
[testimonial_component quote="Amazing experience!" name="Jane Smith" role="Traveler"]
```

#### En un Template Twig:

```twig
{% include 'components/testimonial.twig' with {
  image: theme.link ~ '/assets/images/testimonial.jpg',
  quote: 'This resort exceeded all our expectations!',
  name: 'John Doe',
  role: 'Happy Guest'
} %}
```

## Estructura de Archivos

```
mcnabventures/
├── views/
│   └── components/
│       └── your-component.twig      ← Template Twig
├── assets/
│   └── scss/
│       └── components/
│           └── _your-component.scss ← Estilos
├── inc/
│   └── components-registry.php      ← Registrar aquí
└── functions.php                    ← Ya configurado
```

## Mejores Prácticas

1. **Nombres consistentes:** Usa kebab-case para archivos (`testimonial-card.twig`)
2. **Variables opcionales:** Siempre usa `{% if variable %}` antes de mostrar datos
3. **Escapado automático:** Twig escapa automáticamente, pero usa `|raw` solo si es necesario
4. **Documentación:** Agrega comentarios en el template explicando qué hace
5. **Responsive:** Asegúrate de que los estilos sean responsive

## Ejemplo Completo

Ver los componentes existentes como referencia:
- `views/components/side-component.twig`
- `views/components/hero.twig`
- `views/components/accordion.twig`

## Ver Componentes Disponibles

Ve a **WordPress Admin → Appearance → Components** para ver todos los componentes registrados y sus campos.
