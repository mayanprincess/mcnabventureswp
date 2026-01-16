# IA Component Creation Guide (McNab Ventures)

**Documento oficial** para crear componentes nuevos en este theme. Cubre **arquitectura, accesibilidad, buenas prácticas, animaciones, y pixel-perfect design**.

## 🎯 Filosofía del sistema

- **Sin Gutenberg markup**: los componentes Twig NO dependen de clases `wp-block-*`.
- **ACF Flexible Content** controla el orden y permite repetir componentes en una página.
- **Performance-first**: CSS scroll-snap + JS vanilla mínimo. Sin librerías innecesarias.
- **Datos → Twig**: ACF entrega arrays, Twig renderiza HTML semántico y limpio.
- **Accessibility-first**: WCAG AA/AAA compliant, inclusive por defecto.
- **Mobile-first**: responsive desde los 320px, desktop enhancement (no degradación).
- **Design system**: Spacing, typography, colors, y breakpoints consistentes.

---

## Arquitectura (cómo fluye todo)

1. **Registras el componente** en `mcnabventures/inc/components-registry.php`
2. Automáticamente se crea un **layout** en ACF Flexible Content (por `mcnabventures/inc/acf-fields.php`)
3. En el editor de la página: `Page Components → Add Component → tu componente`
4. En frontend: `the_content` renderiza cada layout llamando `mcnab_render_twig_component($layout, $args)`

Archivos clave:

- **Registry**: `mcnabventures/inc/components-registry.php`
- **ACF Flexible**: `mcnabventures/inc/acf-fields.php`
- **Twig templates**: `mcnabventures/views/components/*.twig`
- **Styles**: `mcnabventures/assets/scss/components/*.scss` (importados en `mcnabventures/assets/scss/main.scss`)
- **JS**: `mcnabventures/assets/js/main.js`

---

## Naming / reglas IMPORTANTES

- **Slug = nombre del layout = nombre del template Twig**:
  - slug: `highlights`
  - twig: `views/components/highlights.twig`
  - layout name: `highlights` (ACF Flexible lo usa como `acf_fc_layout`)
- **WYSIWYG**: siempre renderiza como `{{ value|raw }}` (si el contenido viene de ACF).
- **Image (ACF)**: normalmente llega como array `{ url, alt, ID, ... }`.
  - Twig recomendado:
    - `{{ image.url ?? image }}`
    - `{{ image.alt ?? '' }}`

---

## Paso a paso: crear un componente nuevo

### 1) Define el componente en el Registry

Edita:
- `mcnabventures/inc/components-registry.php`

Agrega una entrada como esta:

```php
'my-component' => [
  'slug' => 'my-component',
  'location' => 'page',
  'name' => 'My Component',
  'description' => 'Short description of what it does.',
  'file' => 'my-component.twig',
  'fields' => [
    'title' => [
      'label' => 'Title',
      'type' => 'text',
      'required' => false,
    ],
    'content' => [
      'label' => 'Content',
      'type' => 'wysiwyg',
      'required' => false,
    ],
    'items' => [
      'label' => 'Items',
      'type' => 'repeater',
      'required' => false,
      'sub_fields' => [
        'image' => [
          'label' => 'Image',
          'type' => 'image',
          'required' => false,
        ],
        'text' => [
          'label' => 'Text',
          'type' => 'wysiwyg',
          'required' => false,
        ],
      ],
    ],
  ],
],
```

Tipos soportados:
- `text`
- `textarea`
- `wysiwyg`
- `url`
- `image`
- `repeater` (con `sub_fields`)

> Nota: `inc/acf-fields.php` convierte esto a ACF automáticamente.

---

### 2) Crea el template Twig

Crea:
- `mcnabventures/views/components/my-component.twig`

Ejemplo base (sin Gutenberg classes):

```twig
<section class="my-component">
  {% if title %}
    <h2 class="my-component__title">{{ title }}</h2>
  {% endif %}

  {% if content %}
    <div class="my-component__content">
      {{ content|raw }}
    </div>
  {% endif %}

  {% set rows = items ?? [] %}
  {% if rows|length %}
    <div class="my-component__items">
      {% for row in rows %}
        {% set img = row.image ?? null %}
        {% set imgUrl = img.url ?? img %}
        <article class="my-component__item">
          {% if imgUrl %}
            <img src="{{ imgUrl }}" alt="{{ (img.alt ?? '')|e }}" loading="lazy" decoding="async">
          {% endif %}
          {% if row.text %}
            <div class="my-component__text">{{ row.text|raw }}</div>
          {% endif %}
        </article>
      {% endfor %}
    </div>
  {% endif %}
</section>
```

---

### 3) Agrega estilos (SCSS)

Crea:
- `mcnabventures/assets/scss/components/_my-component.scss`

Ejemplo:

```scss
@use '../abstracts/variables' as *;
@use '../abstracts/mixins' as *;

.my-component {
  padding: $spacing-3xl 0;
}
```

Importa el archivo en:
- `mcnabventures/assets/scss/main.scss`

```scss
@use 'components/my-component';
```

Luego compila:
- `npm run sass:build`
o usa watch:
- `npm run sass`

---

### 4) JS (solo si lo necesitas)

Si el componente necesita interacción (slider, tabs, accordion custom):

Edita:
- `mcnabventures/assets/js/main.js`

Regla: **vanilla JS** y sin dependencias si se puede. Usa `data-*` selectors, por ejemplo:

```js
function initMyComponent() {
  document.querySelectorAll('[data-my-component]').forEach((el) => {
    // ...
  });
}
```

Y lo llamas en `DOMContentLoaded`.

---

## Cómo probar el componente en WordPress

1. WP Admin → Pages → Edit
2. Busca el field group **Page Components**
3. **Add Component** → selecciona tu componente
4. Llena campos
5. Guarda → ve frontend

---

## Ejemplo real: Highlights (slider)

Este repo incluye `highlights` con:
- CSS scroll-snap (sin librerías)
- JS mínimo para dots/flechas
- ACF repeater con `image` + `content (wysiwyg)`

Archivos:
- `mcnabventures/inc/components-registry.php` → `highlights`
- `mcnabventures/views/components/highlights.twig`
- `mcnabventures/assets/scss/components/_highlights.scss`
- `mcnabventures/assets/js/main.js` → `initHighlights()`

---

## Troubleshooting

### “No veo el componente en el editor”
- Verifica que esté en `components-registry.php`
- Verifica que ACF Pro esté activo
- Revisa que `inc/acf-fields.php` se esté cargando en `functions.php`

### “No renderiza imágenes”
- En Twig usa `{{ image.url ?? image }}`
- Asegúrate que el field sea `type: image`

### “Contenido WYSIWYG no muestra HTML”
- Usa `{{ content|raw }}`

---

## Checklist final (antes de commit)

- [ ] Registry actualizado
- [ ] Twig template creado
- [ ] SCSS creado e importado en `main.scss`
- [ ] JS (si aplica)
- [ ] `npm run sass:build` ejecutado (o watch corriendo)
- [ ] Accesibilidad: semantic HTML, ARIA, alt text, focus states
- [ ] Mobile-first: breakpoints, responsive images, touch targets
- [ ] Animations: entrance animation o scroll-reveal si aplica
- [ ] Performance: lazy loading, image optimization, critical CSS
- [ ] Design: spacing, typography, colors según design system

---

## 🎨 GUÍA DE ACCESIBILIDAD (WCAG AA/AAA)

### Semantic HTML (Obligatorio)

Usa elementos semánticos, NO divs genéricos:

```twig
{# ✅ CORRECTO #}
<section class="my-component">
  <h2 class="my-component__title">Title</h2>
  <article class="my-component__item">Content</article>
  <button aria-label="Close">×</button>
</section>

{# ❌ INCORRECTO #}
<div class="my-component">
  <div class="my-component__title">Title</div>
  <div class="my-component__item">Content</div>
  <div class="my-component__button" role="button">×</div>
</div>
```

**Elementos semánticos a usar:**
- `<section>` para agrupaciones lógicas
- `<article>` para contenido independiente
- `<button>` para acciones interactivas (NO `<div onclick>`)
- `<a>` para navegación (NO `<span>` o `<button>` como link)
- `<header>`, `<main>`, `<footer>` para layout
- `<nav>` para navegación
- `<figure>` + `<figcaption>` para imágenes con caption

---

### ARIA Attributes (cuando sea necesario)

```twig
{# Slider con ARIA #}
<div class="highlights" aria-labelledby="highlights-title" role="region">
  <h2 id="highlights-title">Featured Items</h2>

  <div role="tablist" aria-label="Slide navigation">
    {% for item in items %}
      <button
        role="tab"
        aria-label="Go to slide {{ loop.index }}"
        aria-current="{{ loop.first ? 'true' : 'false' }}"
        data-index="{{ loop.index0 }}"
      >
        {{ loop.index }}
      </button>
    {% endfor %}
  </div>
</div>

{# Modal #}
<div aria-modal="true" role="dialog" aria-labelledby="modal-title">
  <h2 id="modal-title">Modal Title</h2>
  <!-- content -->
</div>

{# Accordion #}
<div role="region" aria-labelledby="accordion-title">
  <h2 id="accordion-title">Accordion</h2>
  <details>
    <summary>Item Title</summary>
    Content
  </details>
</details>
```

---

### Alt Text para imágenes (Crítico)

```twig
{# ✅ CORRECTO - Alt descriptivo #}
<img src="image.jpg" alt="Product screenshot showing dashboard metrics">

{# ✅ CORRECTO - Alt vacío si es decorativa #}
<img src="decoration.svg" alt="">

{# ❌ INCORRECTO - Alt genérico #}
<img src="image.jpg" alt="image">

{# ❌ INCORRECTO - Sin alt #}
<img src="image.jpg">

{# ACF Image - Usar alt del admin #}
{% set img = item.image ?? null %}
<img src="{{ img.url ?? img }}" alt="{{ (img.alt ?? '')|e }}">
```

**Regla alt text:**
- Describe el contenido, no "image" o "photo"
- Vacío (`alt=""`) si es solo decorativa
- Máximo 125 caracteres
- Escapa con `|e` filter en Twig para seguridad

---

### Focus States (Imprescindible para keyboard nav)

Ya implementado en `_focus-states.scss`, pero asegúrate de:

```scss
// ✅ Focus visible en botones
button:focus-visible {
  outline: 2px solid $color-teal;
  outline-offset: 4px;
}

// ✅ Focus en links
a:focus-visible {
  outline: 2px solid $color-teal;
  outline-offset: 3px;
}

// ❌ NUNCA hagas esto:
*:focus {
  outline: none; // Elimina focus es acceso-violación
}
```

---

### Touch Targets (48px mínimo)

```scss
// ✅ CORRECTO - 48px button (accessibility standard)
.my-component__button {
  padding: 12px 16px; // 48px height total
  min-height: 48px;
  min-width: 48px;
}

// ❌ INCORRECTO - Muy pequeño
.my-component__button {
  padding: 4px 8px; // 24px, difícil de hacer click
}
```

---

### Color & Contrast (WCAG AA = 4.5:1 para text)

Usa herramienta: https://webaim.org/resources/contrastchecker/

```scss
// ✅ Navy on white = 9.5:1 (WCAG AAA)
.text { color: $color-navy; background: $color-white; }

// ✅ Teal on white = 4.8:1 (WCAG AA)
.text { color: $color-teal; background: $color-white; }

// ❌ Sand on white = 2.1:1 (FAIL)
.text { color: $color-sand; background: $color-white; }
```

---

### Keyboard Navigation

Asegúrate que los componentes funcionan SIN mouse:

```twig
{# ✅ Tab order correcto #}
<button>First</button>
<button>Second</button>
<button>Third</button>

{# ✅ Escape key para cerrar modal #}
<!-- JavaScript manejará Escape key -->

{# ✅ Enter/Space en botones #}
<button onclick="doSomething()">Click me</button>

{# ❌ NO: Skip focus en elementos importantes #}
<button tabindex="-1">Don't skip me</button> <!-- Solo para elementos no-focusables -->
```

---

### Motion & Animations (prefers-reduced-motion)

**SIEMPRE** incluye:

```scss
// En todas tus animaciones
@media (prefers-reduced-motion: reduce) {
  .my-component,
  .my-component__item {
    animation: none;
    transition: none;
    transform: none;
  }
}
```

---

## 🎯 BUENAS PRÁCTICAS

### BEM Naming Convention

```twig
{# Block = componente principal #}
<section class="card">

  {# Element = parte del bloque #}
  <div class="card__header">
    <h2 class="card__title">Title</h2>
  </div>

  {# Modifier = variación #}
  <div class="card__body card__body--featured">
    Content
  </div>
</section>
```

```scss
.card {
  background: white;
}

.card__header {
  padding: 1rem;
  border-bottom: 1px solid #ddd;
}

.card__title {
  font-size: 1.5rem;
}

.card__body--featured {
  background: #fff9e6;
}
```

---

### Data Normalization (Validación)

```php
// En components-registry.php, defina defaults:
'items' => [
  'label' => 'Items',
  'type' => 'repeater',
  'default' => [], // Fallback si no hay items
]
```

```twig
{# En Twig, siempre valida #}

{# ✅ Safe - usa default operator #}
{% set items = items ?? [] %}
{% if items|length %}
  {% for item in items %}
    {{ item.title ?? 'Untitled' }}
  {% endfor %}
{% endif %}

{# ❌ UNSAFE - puede tirar error #}
{% if items %}
  {% for item in items %}
    {{ item.title }} {# Error si no existe #}
  {% endfor %}
{% endif %}
```

---

### Sanitización & Escaping (Security)

```twig
{# ✅ CORRECTO - Escape por defecto #}
<h2>{{ title }}</h2>
{# Twig escapa automáticamente: & → &amp; < → &lt; #}

{# ✅ CORRECTO - Raw solo para contenido trusted (ACF WYSIWYG) #}
<div class="content">
  {{ content|raw }}
</div>

{# ✅ CORRECTO - Escape atributos HTML #}
<img src="{{ image.url }}" alt="{{ (image.alt ?? '')|e }}">

{# ❌ INCORRECTO - Sin escape #}
<h2>{{ title|raw }}</h2> {# VULNERABLE a XSS #}
```

---

### Error Handling

```twig
{# ✅ Handle missing images #}
{% set img = item.image ?? null %}
{% if img %}
  <img src="{{ img.url ?? img }}" alt="{{ (img.alt ?? '')|e }}">
{% else %}
  <div class="placeholder" role="img" aria-label="No image available">
    📷
  </div>
{% endif %}

{# ✅ Handle empty arrays #}
{% if items|length > 0 %}
  <ul>
  {% for item in items %}
    <li>{{ item.title }}</li>
  {% endfor %}
  </ul>
{% else %}
  <p>No items to display.</p>
{% endif %}
```

---

## 📱 PIXEL PERFECT & RESPONSIVE DESIGN

### Design Tokens (Sistema de Diseño)

**Spacing** (8px base):
```scss
// Ya definidos en abstracts/_variables.scss
$spacing-xs: 0.25rem;   // 4px
$spacing-sm: 0.5rem;    // 8px
$spacing-md: 1rem;      // 16px
$spacing-lg: 1.5rem;    // 24px
$spacing-xl: 2rem;      // 32px
$spacing-2xl: 3rem;     // 48px
$spacing-3xl: 4rem;     // 64px
$spacing-4xl: 6rem;     // 96px

// ✅ CORRECTO - Usa tokens
.my-component {
  padding: $spacing-lg;
  margin-bottom: $spacing-2xl;
}

// ❌ INCORRECTO - Números mágicos
.my-component {
  padding: 24px;
  margin-bottom: 48px;
}
```

**Typography** (Literata + Fustat):
```scss
// Headings: Literata (serif, light)
h1, h2, h3 {
  font-family: $font-heading;
  font-weight: $font-weight-light;
}

// Body: Fustat (sans, regular)
p, span {
  font-family: $font-body;
  font-weight: $font-weight-regular;
}

// Font sizes (responsives con clamp)
h1 {
  font-size: clamp(2rem, 6vw, 3rem);
  line-height: $line-height-tight;
}

p {
  font-size: $font-size-base;
  line-height: $line-height-normal;
}
```

**Colors**:
```scss
// ✅ CORRECTO - Usa variables
.text { color: $color-navy; }
.link { color: $color-teal; }
.bg { background: $color-off-white; }

// ❌ INCORRECTO - Hard-coded
.text { color: #0E5573; }
```

---

### Mobile-First Breakpoints

```scss
// Mobile first (no breakpoint = mobile)
.my-component {
  display: flex;
  flex-direction: column;
}

// Tablet 640px+
@include breakpoint-up('sm') {
  .my-component {
    flex-direction: row;
  }
}

// Desktop 1024px+
@include breakpoint-up('lg') {
  .my-component {
    gap: 2rem;
  }
}

// ✅ También disponible:
@include respond-to('md') { } // max-width 768px (mobile DOWN)
@include breakpoint-up('lg') { } // min-width 1024px (desktop UP)
```

---

### Responsive Images

```twig
{# ✅ CORRECTO - Lazy loading + decoding #}
<img
  src="{{ image.url }}"
  alt="{{ (image.alt ?? '')|e }}"
  loading="lazy"
  decoding="async"
>

{# ✅ CORRECTO - Srcset para diferentes tamaños #}
<img
  src="{{ image.url }}"
  srcset="
    {{ image.url }}?w=320 320w,
    {{ image.url }}?w=640 640w,
    {{ image.url }}?w=1200 1200w
  "
  sizes="(max-width: 768px) 100vw, 50vw"
  alt="{{ (image.alt ?? '')|e }}"
  loading="lazy"
  decoding="async"
>

{# ❌ INCORRECTO - Sin optimización #}
<img src="{{ image.url }}" alt="">
```

---

### Pixel Perfect Guidelines

```scss
// ✅ Respeta el grid (8px)
.my-component {
  padding: 16px;    // 2 * 8px ✓
  margin: 24px;     // 3 * 8px ✓
  gap: 12px;        // 1.5 * 8px ✓
}

// ❌ Números aleatorios
.my-component {
  padding: 15px;    // ✗
  margin: 23px;     // ✗
  gap: 11px;        // ✗
}

// ✅ Border radius consistente
.my-component {
  border-radius: $border-radius-md; // 8px
}

.my-component--large {
  border-radius: $border-radius-lg; // 16px
}

// ✅ Box shadow system
.my-component {
  box-shadow: $shadow-md; // 0 4px 6px rgba(0,0,0, 0.07)
}

.my-component:hover {
  box-shadow: $shadow-lg; // 0 10px 15px rgba(0,0,0, 0.1)
}
```

---

## ✨ ANIMACIONES (7 Mejoras Implementadas)

Tenemos **7 animaciones PRO** ya implementadas. Úsalas en tus componentes:

### 1. Entrance Animations (Fade-in)

```twig
{# El hero.twig ya tiene esto, cópialo para otros componentes #}
<section class="my-component">
  <h2 class="my-component__title">Title</h2>
  {# Automáticamente entra con fadeInUp (0.1s) #}
</section>
```

```scss
// En _my-component.scss, haz lo mismo:
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(24px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.my-component__title {
  animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.1s both;
}
```

### 2. Scroll Reveal Animation

```twig
{# Cualquier elemento con data-scroll-reveal entra al scroll #}

{# Fade-in upward #}
<article data-scroll-reveal="up">
  Card that reveals on scroll
</article>

{# Fade-in from left #}
<article data-scroll-reveal="left">
  Article from left
</article>

{# Con stagger para múltiples items #}
<div data-scroll-reveal="up" data-scroll-reveal="delay">
  {% for item in items %}
    <div class="item">{{ item.title }}</div>
    {# Cada uno entra con 100ms de delay #}
  {% endfor %}
</div>
```

### 3. Button Ripple Effect

```twig
{# Automático en todos los botones #}
<button class="btn-primary">Click me</button>
{# Al hacer click, expandirá una onda blanca #}
```

### 4. Focus States

```twig
{# Automático en navegación con teclado #}
<button>Tab para ver focus ring</button>
```

### 5. Side Component Entrance

```twig
{# Ya implementado en side-component.twig #}
{# Logo zoom-in + content slide-in con stagger #}
```

### 6. Header Shimmer

```twig
{# Automático en header, brillo dorado que se desplaza #}
```

### 7. Button Pulse on CTA

```twig
{# Para botones importantes (call-to-action) #}
<button class="btn-primary is-cta">
  Importante CTA
</button>
{# Pulsea infinitamente #}
```

---

## ⚡ PERFORMANCE

### Lazy Loading (Crítico)

```twig
{# ✅ SIEMPRE lazy load imágenes #}
<img src="{{ img.url }}" alt="{{ img.alt }}" loading="lazy" decoding="async">

{# ❌ Nunca sin lazy load #}
<img src="{{ img.url }}" alt="{{ img.alt }}">
```

### CSS Minification (Ya hecho)

```bash
npm run sass:build  # Compila a CSS minificado
```

### Critical CSS (Ya implementado)

El archivo `critical.scss` se incrusta inline en `<head>` para faster first render.

### JavaScript Deferring (Ya hecho)

Todos los scripts enqueued con `true` en 4º parámetro de `wp_enqueue_script()`.

---

## 🔒 SEGURIDAD

### XSS Prevention (Cross-Site Scripting)

```twig
{# ✅ SEGURO - Twig escapa por defecto #}
<h1>{{ user_input }}</h1>

{# ✅ SEGURO - Escapa atributos #}
<img alt="{{ (title|e) }}">

{# ⚠️ SOLO para TRUSTED content (ACF WYSIWYG) #}
<div>{{ acf_wysiwyg_content|raw }}</div>

{# ❌ NUNCA hagas esto #}
<div>{{ user_input|raw }}</div>
```

### Data Validation

```php
// En components-registry.php
'url' => [
  'label' => 'URL',
  'type' => 'url', // ACF valida URL format
  'required' => false,
],

'email' => [
  'label' => 'Email',
  'type' => 'email', // ACF valida email format
  'required' => false,
],
```

---

## 📚 RECURSOS RÁPIDOS

### Design System (Ya definido)
- **Colors**: Navy, Teal, Gold, Copper, Sand en `_variables.scss`
- **Typography**: Literata (heading) + Fustat (body)
- **Spacing**: 8px-based grid
- **Breakpoints**: 480px, 768px, 1024px, 1200px
- **Animations**: 150ms (fast), 250ms (base), 350ms (slow)

### Archivos Clave
- **Variables**: `assets/scss/abstracts/_variables.scss`
- **Mixins**: `assets/scss/abstracts/_mixins.scss`
- **Focus states**: `assets/scss/utilities/_focus-states.scss`
- **Animations**: `assets/scss/utilities/_animations.scss`
- **Scroll reveal JS**: `assets/js/scroll-reveal.js`

### Herramientas Recomendadas
- **Contrast checker**: https://webaim.org/resources/contrastchecker/
- **A11y auditor**: Firefox DevTools → Accessibility panel
- **Responsive testing**: Chrome DevTools → Device Emulation
- **Performance**: Chrome DevTools → Lighthouse
- **WCAG checker**: https://wave.webaim.org/

---

## 🎓 Ejemplo completo: CARD component

### 1. Registry

```php
'card' => [
  'slug' => 'card',
  'location' => 'page',
  'name' => 'Card',
  'description' => 'Tarjeta con imagen, título y descripción.',
  'file' => 'card.twig',
  'fields' => [
    'image' => ['label' => 'Image', 'type' => 'image', 'required' => false],
    'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
    'description' => ['label' => 'Description', 'type' => 'textarea', 'required' => false],
    'link' => ['label' => 'Link URL', 'type' => 'url', 'required' => false],
  ],
],
```

### 2. Twig (card.twig)

```twig
<article class="card" data-scroll-reveal="up">
  {% set img = image ?? null %}

  {% if img %}
    <div class="card__image">
      <img
        src="{{ img.url ?? img }}"
        alt="{{ (img.alt ?? 'Card image')|e }}"
        loading="lazy"
        decoding="async"
      >
    </div>
  {% endif %}

  <div class="card__body">
    {% if title %}
      <h3 class="card__title">{{ title }}</h3>
    {% endif %}

    {% if description %}
      <p class="card__description">{{ description }}</p>
    {% endif %}

    {% if link %}
      <a href="{{ link }}" class="card__link">
        Read more
        <span aria-hidden="true">→</span>
      </a>
    {% endif %}
  </div>
</article>
```

### 3. SCSS (_card.scss)

```scss
@use '../abstracts/variables' as *;
@use '../abstracts/mixins' as *;

.card {
  background: $color-white;
  border-radius: $border-radius-lg;
  overflow: hidden;
  box-shadow: $shadow-md;
  transition: all $transition-base;
  display: flex;
  flex-direction: column;

  &:hover {
    box-shadow: $shadow-lg;
    transform: translateY(-4px);
  }

  &:focus-within {
    outline: 2px solid $color-teal;
    outline-offset: 2px;
  }
}

.card__image {
  width: 100%;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  background: $color-off-white;

  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform $transition-base;
  }

  .card:hover & img {
    transform: scale(1.05);
  }
}

.card__body {
  padding: $spacing-lg;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.card__title {
  font-family: $font-heading;
  font-size: $font-size-lg;
  font-weight: $font-weight-light;
  color: $color-navy;
  margin-bottom: $spacing-md;
}

.card__description {
  color: $color-text-secondary;
  font-size: $font-size-sm;
  line-height: $line-height-normal;
  margin-bottom: $spacing-lg;
  flex: 1;
}

.card__link {
  color: $color-teal;
  text-decoration: none;
  font-weight: $font-weight-medium;
  display: inline-flex;
  align-items: center;
  gap: $spacing-sm;
  transition: gap $transition-fast;

  &:hover {
    gap: $spacing-md;
  }

  &:focus-visible {
    outline: 2px solid $color-teal;
    outline-offset: 2px;
    border-radius: $border-radius-sm;
  }
}

// Responsive
@include breakpoint-up('sm') {
  .card__body {
    padding: $spacing-xl;
  }
}

// Respeta preferencia usuario
@media (prefers-reduced-motion: reduce) {
  .card,
  .card__image img,
  .card__link {
    transition: none;
    transform: none;
  }
}
```

### 4. Import en main.scss

```scss
@use 'components/card';
```

### 5. Compilar

```bash
npm run sass:build
```

**Resultado**: Una tarjeta accesible, responsiva, con animaciones, y pixel-perfect ✨

