# McNab Ventures - Ejemplos de Implementación

Ejemplos prácticos para integrar Figma designs con el sistema de diseño.

---

## 1. Crear un Nuevo Componente

### Paso 1: Crear Plantilla Twig

**Archivo:** `mcnabventures/views/components/my-component.twig`

```twig
{# My Component - Brief description #}
<div class="my-component">
  {% if title %}
    <h2 class="my-component__title">{{ title }}</h2>
  {% endif %}

  {% if content %}
    <div class="my-component__content">
      {{ content }}
    </div>
  {% endif %}

  {% if button_text and button_url %}
    <a class="my-component__button btn btn-primary" href="{{ button_url }}">
      {{ button_text }}
    </a>
  {% endif %}
</div>
```

### Paso 2: Crear Estilos SCSS

**Archivo:** `mcnabventures/assets/scss/components/_my-component.scss`

```scss
// ==========================================================================
// MY COMPONENT - McNab Ventures
// ==========================================================================

@use '../abstracts/variables' as *;
@use '../abstracts/mixins' as *;

.my-component {
  background: $color-white;
  border: 1px solid $color-sand;
  border-radius: $border-radius-lg;
  padding: $spacing-xl;
  transition: all $transition-base;

  &:hover {
    border-color: $color-teal;
    box-shadow: $shadow-md;
    transform: translateY(-4px);
  }
}

.my-component__title {
  @include heading-light;
  color: $color-navy;
  font-size: $font-size-2xl;
  margin-bottom: $spacing-lg;

  @include breakpoint-up('md') {
    font-size: $font-size-3xl;
  }
}

.my-component__content {
  color: $color-text-primary;
  font-family: $font-body;
  font-size: $font-size-base;
  line-height: $line-height-normal;
  margin-bottom: $spacing-lg;
}

.my-component__button {
  margin-top: $spacing-md;
  display: inline-block;
}

// Modificador para variante oscura
.my-component--dark {
  background: $color-navy;
  color: $color-white;

  .my-component__title {
    color: $color-gold;
  }

  .my-component__content {
    color: $color-white;
  }
}

// Responsive: full width en móvil
@include respond-to('md') {
  .my-component {
    padding: $spacing-lg;
  }

  .my-component__title {
    font-size: $font-size-xl;
  }
}
```

### Paso 3: Importar en Main SCSS

**Archivo:** `mcnabventures/assets/scss/main.scss`

Añadir import:
```scss
// Components
@use 'components/my-component';
```

### Paso 4: Compilar SCSS

```bash
npm run sass:build
```

### Paso 5: Usar en Twig Template

```twig
{% include 'components/my-component.twig' with {
  title: 'Mi Componente',
  content: 'Este es el contenido principal',
  button_text: 'Más Información',
  button_url: '/info'
} %}
```

---

## 2. Crear Variantes de Componentes

### Usando Modificadores BEM

```twig
{# Button Component with variants #}
<a class="btn btn-primary {% if variant %}btn--{{ variant }}{% endif %}" href="{{ url }}">
  {{ text }}
</a>
```

```scss
// Primary button (default)
.btn-primary {
  background: $color-navy;
  color: $color-white;

  &:hover {
    background: color.adjust($color-navy, $lightness: -5%);
  }
}

// Variant: secondary
.btn-primary--secondary {
  background: $color-teal;

  &:hover {
    background: color.adjust($color-teal, $lightness: -5%);
  }
}

// Variant: large
.btn-primary--large {
  padding: 1rem 2rem;
  font-size: $font-size-lg;
}

// Variant: block (full width)
.btn-primary--block {
  display: block;
  width: 100%;
}

// Variant: disabled
.btn-primary--disabled,
.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;

  &:hover {
    background: $color-navy;
    transform: none;
  }
}
```

**Uso:**
```twig
<a class="btn btn-primary btn-primary--large" href="/action">Acción Grande</a>
<a class="btn btn-primary btn-primary--block" href="/action">Acción a Ancho Completo</a>
<button class="btn btn-primary btn-primary--disabled" disabled>Deshabilitado</button>
```

---

## 3. Responsive Design Pattern

### Mobile-First Approach

```scss
.card {
  // Mobile defaults
  display: block;
  width: 100%;
  padding: $spacing-md;
  margin-bottom: $spacing-md;
  font-size: $font-size-base;
  column-count: 1;
}

// Tablet and up
@include breakpoint-up('md') {
  .card {
    padding: $spacing-lg;
    margin-bottom: $spacing-lg;
  }
}

// Desktop and up
@include breakpoint-up('lg') {
  .card {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: $spacing-xl;
    padding: $spacing-xl;
    column-count: 2;
  }
}

// Large screens
@include breakpoint-up('xl') {
  .card {
    grid-template-columns: 1fr 1fr 1fr;
    column-count: 3;
  }
}
```

### Usar CSS Variables para Tamaños Dinámicos

```scss
.hero {
  // Mobile
  padding: $spacing-2xl $spacing-md;
  font-size: var(--font-size-2xl);
  min-height: 300px;

  @include breakpoint-up('md') {
    padding: $spacing-3xl $spacing-xl;
    font-size: var(--font-size-4xl);
    min-height: 500px;
  }

  @include breakpoint-up('lg') {
    padding: $spacing-4xl $spacing-2xl;
    font-size: var(--font-size-5xl);
    min-height: 600px;
  }
}
```

---

## 4. Color Utilities

### Crear Clases de Color Reutilizables

```scss
// Text colors
.text-navy {
  color: $color-navy;
}

.text-teal {
  color: $color-teal;
}

.text-gold {
  @include gold-text;
}

.text-muted {
  color: $color-text-muted;
}

// Background colors
.bg-navy {
  background: $color-navy;
  color: $color-white;
}

.bg-teal {
  background: $color-teal;
  color: $color-white;
}

.bg-sand {
  background: $color-sand;
}

.bg-light {
  background: $color-off-white;
}

// Gradient backgrounds
.bg-gradient-gold {
  background: $gradient-gold;
}

.bg-gradient-navy-teal {
  background: $gradient-navy-teal;
}

// Border colors
.border-teal {
  border-color: $color-teal;
}

.border-gold {
  border-color: $color-gold;
}
```

**Uso en Twig:**
```twig
<div class="card bg-light border-teal">
  <h2 class="text-navy">Título</h2>
  <p class="text-muted">Descripción</p>
  <span class="text-gold">Resaltado especial</span>
</div>
```

---

## 5. Animación & Transición

### Entrance Animations

```scss
// Reveal on scroll - fade up
.reveal-fade-up {
  animation: revealFadeUp 0.6s ease-out forwards;
  opacity: 0;
}

// Stagger effect
.reveal-fade-up:nth-child(1) { animation-delay: 0ms; }
.reveal-fade-up:nth-child(2) { animation-delay: 100ms; }
.reveal-fade-up:nth-child(3) { animation-delay: 200ms; }
.reveal-fade-up:nth-child(4) { animation-delay: 300ms; }

// Reveal from left
.reveal-fade-left {
  animation: revealFadeLeft 0.6s ease-out forwards;
  opacity: 0;
}
```

**Uso en Twig:**
```twig
{% for item in items %}
  <div class="card reveal-fade-up">
    {{ item.content }}
  </div>
{% endfor %}
```

### Button Animations

```scss
.btn {
  // Ripple on click (incluido en mixin)
  @include button-ripple;

  // Smooth hover transition
  transition: all $transition-base;

  &:hover {
    transform: translateY(-2px);
    box-shadow: $shadow-md;
  }

  &:active {
    transform: translateY(0);
  }
}

// CTA button with pulse effect
.btn--cta {
  animation: pulse 2s infinite;

  &:hover {
    animation: none;
  }
}
```

---

## 6. Accesibilidad

### Focus States Completos

```scss
// Visible focus para teclado
:focus-visible {
  outline: 3px solid $color-navy;
  outline-offset: 2px;
  border-radius: 4px;
}

// En botones específicamente
.btn:focus-visible {
  outline: 2px solid $color-gold;
  outline-offset: 4px;
}

// Skip link
.skip-link {
  position: absolute;
  top: -40px;
  left: 0;
  background: $color-navy;
  color: $color-white;
  padding: $spacing-sm $spacing-md;
  text-decoration: none;
  z-index: 100;

  &:focus {
    top: 0;
  }
}
```

### ARIA Labels

```twig
{# Icon button #}
<button class="btn-icon" aria-label="Cerrar menú">
  ×
</button>

{# Decorative element #}
<span class="decoration" aria-hidden="true">✨</span>

{# Dynamic region #}
<div id="messages" aria-live="polite" aria-label="Mensajes del sistema">
  {{ messages }}
</div>

{# Expandable content #}
<button aria-expanded="false" aria-controls="details">
  Más información
</button>
<div id="details" aria-hidden="true">
  {{ details }}
</div>
```

### Respetar Preferencias de Movimiento

```scss
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }

  // Disable specific animations
  .reveal-fade-up,
  .reveal-fade-left,
  .btn--cta {
    animation: none !important;
  }

  // Keep transitions minimal
  .btn {
    transition: color $transition-fast, background $transition-fast;
  }
}
```

---

## 7. Componente Flexible (Grid/Layout)

### Container System

```scss
.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 $spacing-lg;

  @include breakpoint-up('md') {
    padding: 0 $spacing-2xl;
  }
}

.container--narrow {
  max-width: 980px;
}

.container--wide {
  max-width: 100%;
}

.container--full {
  @include full-width;
}
```

### Grid System

```scss
.grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: $spacing-md;

  @include breakpoint-up('md') {
    grid-template-columns: repeat(2, 1fr);
    gap: $spacing-lg;
  }

  @include breakpoint-up('lg') {
    grid-template-columns: repeat(3, 1fr);
    gap: $spacing-xl;
  }
}

.grid--2-cols {
  @include breakpoint-up('md') {
    grid-template-columns: repeat(2, 1fr);
  }

  @include breakpoint-up('lg') {
    grid-template-columns: repeat(2, 1fr);
  }
}

.grid--4-cols {
  @include breakpoint-up('lg') {
    grid-template-columns: repeat(4, 1fr);
  }
}

// Gap modifiers
.grid--gap-sm {
  gap: $spacing-sm;
}

.grid--gap-lg {
  gap: $spacing-2xl;
}
```

---

## 8. Forma Correcta de Usar Filtros de Color

### Colores Ajustados Dinámicamente

```scss
// Usando la función color.adjust de SCSS
.btn-primary {
  background: $color-navy;

  &:hover {
    // Aclarar 5%
    background: color.adjust($color-navy, $lightness: 5%);
  }

  &:active {
    // Oscurecer 10%
    background: color.adjust($color-navy, $lightness: -10%);
  }
}

.btn-gold {
  background: $color-gold;

  &:hover {
    // Más saturación
    background: color.adjust($color-gold, $saturation: 10%);
  }
}

.text-muted {
  color: $color-text-muted;

  &.is-disabled {
    // Más transparente
    opacity: 0.6;
  }
}
```

---

## 9. Registro de ACF (Custom Fields)

### Ejemplo: My Component Fields

**Archivo:** `mcnabventures/inc/acf-fields.php`

```php
<?php

function register_my_component_fields() {
  if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
      'key'      => 'group_my_component',
      'title'    => 'My Component Fields',
      'fields'   => array(
        array(
          'key'        => 'field_my_component_title',
          'label'      => 'Title',
          'name'       => 'title',
          'type'       => 'text',
          'required'   => 1,
        ),
        array(
          'key'        => 'field_my_component_content',
          'label'      => 'Content',
          'name'       => 'content',
          'type'       => 'wysiwyg',
        ),
        array(
          'key'        => 'field_my_component_button',
          'label'      => 'Button Text',
          'name'       => 'button_text',
          'type'       => 'text',
        ),
        array(
          'key'        => 'field_my_component_button_url',
          'label'      => 'Button URL',
          'name'       => 'button_url',
          'type'       => 'link',
        ),
        array(
          'key'        => 'field_my_component_variant',
          'label'      => 'Variant',
          'name'       => 'variant',
          'type'       => 'select',
          'choices'    => array(
            'default' => 'Default',
            'dark'    => 'Dark',
            'light'   => 'Light',
          ),
          'default_value' => 'default',
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'page',
          ),
        ),
      ),
    ) );
  }
}

add_action( 'acf/init', 'register_my_component_fields' );
```

---

## 10. Bloque Gutenberg Personalizado

### Ejemplo: My Component Block

**Archivo:** `mcnabventures/inc/gutenberg-blocks.php`

```php
<?php

function register_my_component_block() {
  register_block_type( 'mcnab/my-component', array(
    'editor_script'   => 'mcnab-blocks',
    'editor_style'    => 'mcnab-block-styles',
    'render_callback' => 'render_my_component_block',
    'attributes'      => array(
      'title'       => array(
        'type'    => 'string',
        'default' => 'Título Predeterminado',
      ),
      'content'     => array(
        'type'    => 'string',
        'default' => '',
      ),
      'buttonText'  => array(
        'type'    => 'string',
        'default' => '',
      ),
      'buttonUrl'   => array(
        'type'    => 'string',
        'default' => '',
      ),
      'variant'     => array(
        'type'    => 'string',
        'enum'    => array( 'default', 'dark', 'light' ),
        'default' => 'default',
      ),
    ),
  ) );
}

add_action( 'init', 'register_my_component_block' );

function render_my_component_block( $attributes ) {
  $context = array(
    'title'       => $attributes['title'] ?? '',
    'content'     => $attributes['content'] ?? '',
    'button_text' => $attributes['buttonText'] ?? '',
    'button_url'  => $attributes['buttonUrl'] ?? '',
    'variant'     => $attributes['variant'] ?? 'default',
  );

  return Timber::compile( 'components/my-component.twig', $context );
}
```

---

## 11. Patrones Twig Comunes

### Condicionales

```twig
{# Simple if #}
{% if title %}
  <h1>{{ title }}</h1>
{% endif %}

{# If-else #}
{% if featured %}
  <div class="featured">{{ content }}</div>
{% else %}
  <div class="normal">{{ content }}</div>
{% endif %}

{# Multiple conditions #}
{% if title and not empty %}
  <h1>{{ title }}</h1>
{% endif %}
```

### Loops

```twig
{# Basic loop #}
{% for item in items %}
  <div class="item">{{ item.title }}</div>
{% endfor %}

{# With index #}
{% for item in items %}
  <div class="item item-{{ loop.index }}">
    {{ item.title }}
  </div>
{% endfor %}

{# Staggered animation #}
{% for item in items %}
  <div class="card reveal-fade-up" style="animation-delay: {{ loop.index0 * 100 }}ms;">
    {{ item.content }}
  </div>
{% endfor %}

{# Empty fallback #}
{% for item in items %}
  <div>{{ item.title }}</div>
{% else %}
  <p>No items found</p>
{% endfor %}
```

### Incluir Componentes

```twig
{# Simple include #}
{% include 'components/my-component.twig' %}

{# With context #}
{% include 'components/my-component.twig' with {
  title: 'Custom Title',
  content: 'Custom content',
  variant: 'dark'
} %}

{# Only pass specific vars #}
{% include 'components/my-component.twig' with {
  title: section.title
} only %}
```

### Clases Condicionales

```twig
<div class="component {% if variant %}component--{{ variant }}{% endif %} {% if active %}is-active{% endif %}">
  {{ content }}
</div>

{# Resultante: class="component component--dark is-active" #}
```

---

## 12. Debugging y Testing

### Ver Datos en Template

```twig
{# Dump variable #}
{{ dump(item) }}

{# Debug message #}
<!-- DEBUG: {{ title }} -->

{# Print JSON #}
<pre>{{ item|json_encode(constant('JSON_PRETTY_PRINT')) }}</pre>
```

### Testing de Responsive

```bash
# En navegador - DevTools
# Ctrl+Shift+M (Windows) o Cmd+Shift+M (Mac)
# Probar en: 480px, 768px, 1024px, 1200px

# Testing manual
# Verificar hover states
# Probar navegación teclado (Tab)
# Verificar mobile menu
# Comprobar contraste de colores
```

### Validación HTML

```bash
# Usar validador W3C
# https://validator.w3.org/

# Validar accesibilidad WAVE
# https://wave.webaim.org/
```

---

**Última actualización:** Enero 2026
**Versión:** 1.0
