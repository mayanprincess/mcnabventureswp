# McNab Ventures Design System Rules
## Guía Completa para Integración con Figma MCP

**Última actualización:** Enero 2026
**Proyecto:** McNab Ventures WordPress Theme
**Framework:** WordPress + Timber (Twig) + SCSS

---

## 📋 Tabla de Contenidos

1. [Estructura del Proyecto](#estructura-del-proyecto)
2. [Tokens de Diseño](#tokens-de-diseño)
3. [Librería de Componentes](#librería-de-componentes)
4. [Frameworks & Librerías](#frameworks--librerías)
5. [Sistema de Estilos](#sistema-de-estilos)
6. [Sistema de Iconos & Assets](#sistema-de-iconos--assets)
7. [Patrones de Desarrollo](#patrones-de-desarrollo)
8. [Convenciones de Nomenclatura](#convenciones-de-nomenclatura)

---

## 1. Estructura del Proyecto

### Organización General

```
mcnabventures/                      # Raíz del tema WordPress
├── assets/                         # Recursos compilados y fuentes
│   ├── css/                       # CSS compilado (generado)
│   ├── images/                    # Imágenes estáticas
│   ├── js/                        # JavaScript
│   └── scss/                      # Fuentes SCSS
├── inc/                           # PHP incluyentes
│   ├── acf-fields.php             # Campos ACF personalizados
│   ├── components-registry.php     # Registro de componentes
│   ├── gutenberg-blocks.php        # Bloques Gutenberg personalizados
│   └── timber-setup.php            # Configuración de Timber
├── views/                         # Plantillas Twig
│   ├── components/                # Componentes reutilizables
│   └── ...                        # Otras plantillas
├── templates/                     # Plantillas principales
├── template-parts/                # Partes de plantillas
├── functions.php                  # Configuración principal del tema
├── theme.json                     # Configuración theme.json WordPress
├── package.json                   # Dependencias Node.js
└── composer.json                  # Dependencias PHP
```

### Tecnología Stack

- **CMS**: WordPress (Block Editor / Gutenberg)
- **Backend**: PHP 7.4+
- **Template Engine**: Timber (Twig)
- **Estilos**: SCSS (compilado a CSS)
- **Build System**: SCSS compiler (npm sass)
- **Componentes**: Custom Gutenberg blocks + ACF

---

## 2. Tokens de Diseño

### 2.1 Definición de Tokens

Los tokens de diseño se definen en múltiples ubicaciones para máxima flexibilidad:

#### A. Variables SCSS (Fuente Principal)
**Ubicación:** `assets/scss/abstracts/_variables.scss`

```scss
// Colores Primarios
$color-navy: #0E5573;      // Color primario
$color-teal: #2FBFB3;      // Color secundario
$color-sand: #C9C5B8;      // Color neutral cálido
$color-copper: #C49A6D;    // Color acentuado
$color-gold: #C9A441;      // Color dorado (premium)

// Neutrales
$color-white: #FFFFFF;
$color-black: #000000;
$color-gray-dark: #3A3A3A;
$color-gray: #6B6B6B;
$color-gray-light: #9C9EA1;
$color-off-white: #F5F5F3;

// Semánticos
$color-primary: $color-navy;
$color-secondary: $color-teal;
$color-accent: $color-gold;

// Tipografía
$font-heading: 'Literata', Georgia, 'Times New Roman', serif;
$font-body: 'Fustat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

$font-size-xs: 0.667rem;   // 12px
$font-size-sm: 0.833rem;   // 15px
$font-size-base: 1rem;     // 18px
$font-size-lg: 1.222rem;   // 22px
$font-size-xl: 1.444rem;   // 26px
$font-size-2xl: 1.722rem;  // 31px
$font-size-3xl: 2.056rem;  // 37px
$font-size-4xl: 2.5rem;    // 45px
$font-size-5xl: 3rem;      // 54px

// Espaciado
$spacing-xs: 0.25rem;      // 4px
$spacing-sm: 0.5rem;       // 8px
$spacing-md: 1rem;         // 16px
$spacing-lg: 1.5rem;       // 24px
$spacing-xl: 2rem;         // 32px
$spacing-2xl: 3rem;        // 48px
$spacing-3xl: 4rem;        // 64px
$spacing-4xl: 6rem;        // 96px

// Border Radius
$border-radius-sm: 4px;
$border-radius-md: 8px;
$border-radius-lg: 16px;
$border-radius-xl: 24px;
$border-radius-full: 9999px;

// Sombras
$shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
$shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
$shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
$shadow-gold: 0 4px 14px rgba(201, 164, 65, 0.3);

// Transiciones
$transition-fast: 150ms ease;
$transition-base: 250ms ease;
$transition-slow: 350ms ease;
```

#### B. CSS Custom Properties (Acceso desde JavaScript)
**Ubicación:** `assets/scss/main.scss`

```scss
:root {
  /* Colores */
  --color-navy: #0E5573;
  --color-teal: #2FBFB3;
  --color-gold: #C9A441;
  --color-sand: #C9C5B8;

  /* Tipografía */
  --font-heading: 'Literata', serif;
  --font-body: 'Fustat', sans-serif;
  --font-size-base: 1rem;
  --font-size-lg: 1.222rem;
  --font-size-xl: 1.444rem;

  /* Responsive adjustments en media queries */
}

@media (max-width: 768px) {
  :root {
    --font-size-5xl: 2.25rem;
    --font-size-4xl: 2rem;
  }
}
```

#### C. WordPress Theme.json
**Ubicación:** `theme.json` (Configuración de WordPress)

```json
{
  "settings": {
    "color": {
      "palette": [
        { "slug": "navy", "color": "#0E5573", "name": "Navy Blue" },
        { "slug": "teal", "color": "#2FBFB3", "name": "Teal" },
        { "slug": "gold", "color": "#C9A441", "name": "Gold" },
        { "slug": "sand", "color": "#C9C5B8", "name": "Sand" }
      ],
      "gradients": [
        {
          "slug": "gold-shimmer",
          "gradient": "linear-gradient(135deg, #D4B44A 0%, #C9A441 100%)",
          "name": "Gold Shimmer"
        },
        {
          "slug": "navy-teal",
          "gradient": "linear-gradient(135deg, #0E5573 0%, #2FBFB3 100%)",
          "name": "Navy → Teal"
        }
      ]
    },
    "typography": {
      "fontFamilies": [
        {
          "fontFamily": "'Literata', Georgia, serif",
          "slug": "literata",
          "name": "Literata"
        },
        {
          "fontFamily": "'Fustat', -apple-system, BlinkMacSystemFont, sans-serif",
          "slug": "fustat",
          "name": "Fustat"
        }
      ],
      "fontSizes": [
        { "slug": "base", "size": "1rem", "name": "Base (18px)" },
        { "slug": "lg", "size": "1.222rem", "name": "Large (22px)" },
        { "slug": "3xl", "size": "2.056rem", "name": "3X Large (37px)" },
        { "slug": "5xl", "size": "3rem", "name": "5X Large (54px)" }
      ]
    }
  }
}
```

### 2.2 Gradientes Personalizados

```scss
$gradient-gold: linear-gradient(
  135deg,
  #D4B44A 0%,
  #C9A441 25%,
  #E6C866 50%,
  #C9A441 75%,
  #B8933A 100%
);

$gradient-gold-vertical: linear-gradient(180deg, #E6C866 0%, #C9A441 50%, #B8933A 100%);

$gradient-navy-teal: linear-gradient(135deg, $color-navy 0%, $color-teal 100%);

$gradient-copper-gold: linear-gradient(135deg, $color-copper 0%, $color-gold 100%);

$gradient-sand-white: linear-gradient(180deg, $color-sand 0%, $color-white 100%);
```

### 2.3 Breakpoints & Media Queries

```scss
$breakpoint-sm: 480px;     // Teléfonos pequeños
$breakpoint-md: 768px;     // Tablets
$breakpoint-lg: 1024px;    // Laptops
$breakpoint-xl: 1200px;    // Desktops

// Uso del mixin (mobile-first)
@include breakpoint-up('md') {
  /* Estilos para tablets y arriba */
}
```

---

## 3. Librería de Componentes

### 3.1 Componentes Existentes

#### A. Hero Component
**Ubicación:** `views/components/hero.twig`
**Estilos:** `assets/scss/components/_hero.scss`

```twig
{# Hero Component - Twig Template #}
<section class="groups-hero hero" {% if background_image %}style="background-image: url('{{ background_image.url }}');"{% endif %}>
  <div class="hero__overlay" aria-hidden="true"></div>

  <div class="hero__inner">
    {% if title %}
      <h1 class="hero__title">{{ title }}</h1>
    {% endif %}

    {% if button_text and button_url %}
      <div class="hero__actions">
        <a class="hero__button" href="{{ button_url }}">
          <span class="hero__button-text">{{ button_text }}</span>
          <span class="hero__button-arrow" aria-hidden="true">→</span>
        </a>
      </div>
    {% endif %}
  </div>

  <button class="hero__scroll-indicator" type="button" aria-label="Scroll down"></button>
</section>
```

**Variables Esperadas:**
- `title` (string): Título principal
- `background_image` (image): Imagen de fondo
- `button_text` (string): Texto del botón
- `button_url` (string): URL del botón

#### B. Highlights Component
**Ubicación:** `views/components/highlights.twig`
**Estilos:** `assets/scss/components/_highlights.scss`

#### C. Accordion Component
**Ubicación:** `views/components/accordion.twig`
**Estilos:** `assets/scss/components/_accordion.scss`

#### D. Side Component
**Ubicación:** `views/components/side-component.twig`
**Estilos:** `assets/scss/components/_side-component.scss`

### 3.2 Estructura de Componentes

Cada componente sigue esta estructura:

```
component-name/
├── component-name.twig       # Plantilla Twig
└── _component-name.scss      # Estilos SCSS
```

**Patrón de Nomenclatura CSS:**
- Bloque: `.component-name`
- Elemento: `.component-name__element`
- Modificador: `.component-name--modifier`

**Ejemplo:**
```scss
.hero {
  /* Bloque */
}

.hero__title {
  /* Elemento */
}

.hero__button {
  /* Elemento */
}

.hero--dark {
  /* Modificador */
}
```

### 3.3 Componentes de WordPress

**Bloques Gutenberg Personalizados:**
- Ubicación: `inc/gutenberg-blocks.php`
- Registro: `inc/components-registry.php`

**Campos ACF Personalizados:**
- Ubicación: `inc/acf-fields.php`
- Grupos de campos para cada componente

---

## 4. Frameworks & Librerías

### 4.1 Stack Técnico

| Componente | Tecnología | Versión | Ubicación |
|-----------|-----------|---------|-----------|
| **Template Engine** | Timber (Twig) | v2.x | vendor/roots/timber |
| **CSS Preprocessor** | SASS | ^1.69.0 | node_modules/sass |
| **WordPress** | Core | Latest | wp-content |
| **ACF** | Advanced Custom Fields Pro | Latest | plugins/ |

### 4.2 Dependencias NPM

```json
{
  "name": "mcnabventures-theme",
  "version": "0.1.0",
  "scripts": {
    "sass": "sass --watch assets/scss:assets/css --style compressed",
    "sass:build": "sass assets/scss:assets/css --style compressed",
    "dev": "npm run sass"
  },
  "devDependencies": {
    "sass": "^1.69.0"
  }
}
```

### 4.3 Dependencias PHP

```json
{
  "require": {
    "roots/timber": "2.x"
  }
}
```

### 4.4 Scripts & Build

**Compilar SCSS:**
```bash
npm run sass:build      # Compilación única
npm run sass            # Watch mode para desarrollo
```

**Resultado:** `assets/scss/` → `assets/css/main.css`

---

## 5. Sistema de Estilos

### 5.1 Arquitectura SCSS (SMACSS + BEM)

```
assets/scss/
├── abstracts/
│   ├── _variables.scss      # Todas las variables
│   └── _mixins.scss         # Todos los mixins
├── base/
│   ├── _reset.scss          # Reset/normalize
│   └── _typography.scss     # Estilos base de tipografía
├── layout/
│   └── _container.scss      # Contenedores principales
├── components/              # Componentes reutilizables
│   ├── _buttons.scss
│   ├── _header.scss
│   ├── _footer.scss
│   ├── _hero.scss
│   ├── _highlights.scss
│   ├── _accordion.scss
│   ├── _side-component.scss
│   ├── _deep-dives.scss
│   ├── _notice-box.scss
│   └── _subscribe.scss
├── utilities/
│   ├── _animations.scss     # Animaciones CSS
│   ├── _backgrounds.scss    # Clases de fondo
│   ├── _text.scss           # Clases de texto
│   └── _focus-states.scss   # Estados de foco
├── main.scss                # Archivo principal (imports)
└── critical.scss            # Estilos críticos para head
```

### 5.2 Metodología CSS

**BEM (Block Element Modifier):**

```scss
// Bloque
.button { }

// Elemento
.button__icon { }
.button__text { }

// Modificador
.button--primary { }
.button--large { }
.button--primary.is-active { }
```

### 5.3 Mixins Principales

```scss
// Responsive Design (mobile-first)
@include breakpoint-up('md') { /* tablets+ */ }
@include breakpoint-up('lg') { /* desktop+ */ }

// Flexbox helpers
@include flex-center;        // center items
@include flex-between;       // space-between

// Component utilities
@include button-base;        // Reset button
@include card;              // Card styles
@include button-ripple;     // Ripple effect

// Typography
@include snap-text;         // Fustat ExtraBold uppercase
@include heading-light;     // Literata Light
@include heading-medium;    // Literata Medium
@include subheading;        // Fustat Medium
@include gold-text;         // Gradient text effect

// Layout
@include full-width;        // Break out of container
@include truncate;          // Text truncation
```

### 5.4 Animaciones & Transiciones

**Ubicación:** `assets/scss/utilities/_animations.scss`

```scss
@keyframes revealFadeUp {
  from {
    opacity: 0;
    transform: translateY(32px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes revealFadeLeft {
  from {
    opacity: 0;
    transform: translateX(-32px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes ripple {
  0% {
    transform: scale(0);
    opacity: 0.6;
  }
  100% {
    transform: scale(4);
    opacity: 0;
  }
}

@keyframes pulse {
  0%, 100% {
    box-shadow: 0 0 0 0 rgba(201, 164, 65, 0.7);
  }
  50% {
    box-shadow: 0 0 0 10px rgba(201, 164, 65, 0);
  }
}
```

### 5.5 Estados Responsivos

**Prefijos de Utilidad:**
- `.mobile-*` - Móvil
- `.tablet-*` - Tablet (768px+)
- `.desktop-*` - Desktop (1024px+)

**Estados Especiales:**
- `:hover` - Interacción
- `:focus` - Accesibilidad (con estilos de foco visible)
- `:active` - Presionado
- `.is-active` - Clase de estado
- `.prefers-reduced-motion` - Respeta preferencias de usuario

---

## 6. Sistema de Iconos & Assets

### 6.1 Gestión de Imágenes

**Ubicación:** `assets/images/`

```
assets/images/
├── footermainlogo.png       # Logo principal footer
├── footerlogo.png           # Logo alternativo footer
└── waves.png                # Elemento decorativo ondas
```

### 6.2 Formato de Imágenes

- **Logos:** PNG con transparencia
- **Fotos:** JPG/WebP (según contexto)
- **Gráficos:** SVG cuando sea posible
- **Optimización:** Comprimidas para web

### 6.3 Referencias en Código

**En Twig:**
```twig
{# Desde views (ruta relativa) #}
<img src="{{ get_stylesheet_directory_uri() }}/assets/images/logo.png" alt="Logo">

{# Usando helper de Timber #}
<img src="{{ theme.link }}/assets/images/logo.png" alt="Logo">
```

**En SCSS:**
```scss
.logo {
  background-image: url('../../images/logo.png');
  background-size: contain;
  background-repeat: no-repeat;
}
```

### 6.4 Iconografía

Actualmente se usan:
- **Flechas:** Caracteres Unicode (→)
- **Scroll Indicators:** Elementos decorativos CSS

**Patrón para Iconos Futuros:**
```html
<svg class="icon icon--arrow" aria-hidden="true">
  <use href="#icon-arrow"></use>
</svg>
```

---

## 7. Patrones de Desarrollo

### 7.1 Patrón Twig con Componentes

```php
// En functions.php o archivo de contexto
$context = [
    'title' => 'Welcome',
    'background_image' => [
        'url' => '/path/to/image.jpg'
    ],
    'button_text' => 'Get Started',
    'button_url' => '/start'
];

Timber::render('components/hero.twig', $context);
```

### 7.2 Patrón ACF + Componentes

```php
// Campo ACF flexible con componentes
$layout = get_field('content_blocks');

foreach ($layout as $block) {
    $context = [
        'data' => $block,
        'type' => $block['acf_fc_layout']
    ];

    Timber::render('components/' . $context['type'] . '.twig', $context);
}
```

### 7.3 Patrón Bloques Gutenberg

```php
// inc/gutenberg-blocks.php
register_block_type('mcnab/hero', [
    'render_callback' => function($attributes, $content) {
        $context = [
            'title' => $attributes['title'] ?? '',
            'background_image' => $attributes['backgroundImage'] ?? null
        ];

        return Timber::compile('components/hero.twig', $context);
    }
]);
```

### 7.4 Accesibilidad

- **Atributos ARIA:** `aria-label`, `aria-hidden`, `role`
- **Colores:** Relación de contraste ≥ 4.5:1
- **Foco Visible:** Siempre visible en teclado
- **Movimiento Reducido:** Respetar `prefers-reduced-motion`

```scss
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

## 8. Convenciones de Nomenclatura

### 8.1 Variables SCSS

```scss
// Colores
$color-{name}: {value}              // $color-navy
$color-{function}-{intensity}: {value}  // $color-text-primary

// Tipografía
$font-{family}-{weight}: {value}    // $font-heading, $font-weight-bold
$font-size-{scale}: {value}         // $font-size-lg
$line-height-{type}: {value}        // $line-height-tight

// Espaciado
$spacing-{scale}: {value}           // $spacing-xl
$container-{size}: {value}          // $container-lg

// Efectos
$shadow-{intensity}: {value}        // $shadow-lg
$border-radius-{size}: {value}      // $border-radius-md
$transition-{speed}: {value}        // $transition-base
$breakpoint-{size}: {value}         // $breakpoint-md
```

### 8.2 Clases CSS

```css
/* Componentes */
.{component-name}
.{component-name}__element
.{component-name}--modifier

/* Utilidades */
.u-{utility}                    /* .u-flex-center */
.is-{state}                     /* .is-active */
.has-{state}                    /* .has-error */

/* Responsive */
.{breakpoint}:{class}           /* .md:flex */
```

### 8.3 Archivos & Carpetas

```
component-name.twig             // Minúscula con guión
_component-name.scss            // Guión bajo al inicio
ComponentName.php               // PascalCase
component_name_field            // ACF: guión bajo
```

### 8.4 Clases Semánticas

| Patrón | Uso | Ejemplo |
|--------|-----|---------|
| `.hero` | Sección principal | `.hero`, `.hero__title` |
| `.btn-*` | Botones | `.btn-primary`, `.btn-secondary` |
| `.wp-block-*` | Bloques WordPress | `.wp-block-button__link` |
| `.is-*` | Estados JavaScript | `.is-active`, `.is-visible` |
| `.has-*` | Condiciones | `.has-background`, `.has-border` |

---

## 9. Guía de Integración con Figma

### 9.1 Mapeo de Estilos Figma → Código

**Colores en Figma:**
- Usar nombres iguales a variables SCSS
- Crear documentación de color con valores hex

**Componentes en Figma:**
- Nombrar igual a archivos TWIG
- Incluir especificaciones de estado (hover, active, etc.)
- Documentar variables de componente

**Tipografía:**
- Literata para headings (h1-h6)
- Fustat para body/UI

### 9.2 Code Connect

Cuando se implemente Code Connect (futuro):

```
Figma Component → Code Component
Hero Design → views/components/hero.twig
Button Primary → Mixin: button-ripple + btn-primary
```

### 9.3 Tokens en Figma

Sincronizar con:
- Color palette en `theme.json`
- Font sizes en `theme.json`
- Spacing scale en variables SCSS
- Shadow values

---

## 10. Buenas Prácticas

### 10.1 Desarrollo de Componentes

1. **Crear archivo Twig** en `views/components/`
2. **Crear archivo SCSS** en `assets/scss/components/`
3. **Importar SCSS** en `main.scss`
4. **Registrar en ACF** si es necesario
5. **Documentar variables** esperadas

### 10.2 Modificación de Estilos

- Cambiar valores en `_variables.scss`
- Usar mixins para reutilización
- No usar `!important` salvo casos especiales
- Mantener consistencia BEM

### 10.3 Performance

- Compilar SCSS comprimido
- Usar CSS custom properties para valores dinámicos
- Lazy load imágenes con `loading="lazy"`
- Minificar CSS para producción

### 10.4 Testing

- Probar en breakpoints: 480px, 768px, 1024px, 1200px
- Validar contraste de colores
- Verificar accesibilidad con screen readers
- Probar con `prefers-reduced-motion` habilitado

---

## 11. Recursos Útiles

### Archivos Clave

- **Variables:** `assets/scss/abstracts/_variables.scss`
- **Mixins:** `assets/scss/abstracts/_mixins.scss`
- **Main:** `assets/scss/main.scss`
- **Theme Config:** `theme.json`
- **Functions:** `functions.php`

### Comandos Frecuentes

```bash
# Compilar SCSS (desarrollo)
npm run sass

# Compilar SCSS (producción)
npm run sass:build

# Verificar WordPress
wp theme list
wp option get home
```

### Enlaces de Referencia

- [WordPress Theme JSON](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json-schema/)
- [Timber Documentation](https://timber.github.io/timber/)
- [SMACSS Methodology](http://smacss.com/)
- [BEM Naming](http://getbem.com/)
- [WCAG Accessibility](https://www.w3.org/WAI/WCAG21/quickref/)

---

## 12. Hoja de Referencia Rápida

### Colores Primarios
```
Navy:    #0E5573
Teal:    #2FBFB3
Gold:    #C9A441
Sand:    #C9C5B8
Copper:  #C49A6D
```

### Tipografía
```
Headings: Literata (serif)
Body:     Fustat (sans-serif)
Base:     18px (1rem)
Scale:    1.25 (perfecto)
```

### Espaciado
```
Base: 16px (1rem)
Escala: xs=4px, sm=8px, md=16px, lg=24px, xl=32px, 2xl=48px
```

### Breakpoints
```
Mobile: 480px
Tablet: 768px
Desktop: 1024px
Wide: 1200px
```

### Transiciones
```
Fast: 150ms
Base: 250ms
Slow: 350ms
```

---

**Versión:** 1.0
**Última actualización:** Enero 2026
**Mantenedor:** McNab Ventures Team
**Licencia:** Privado
