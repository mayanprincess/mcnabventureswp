# McNab Ventures - Design System Quick Reference

## 📚 Documentación Principal
- **Reglas Completas:** `DESIGN_SYSTEM_RULES.md`
- **Cursor Rules:** `.cursor/rules/design_system.mdc`

---

## 🎨 Colores

### Paleta Primaria
```
Navy Blue:    #0E5573  ($color-navy)      [Primario]
Teal:         #2FBFB3  ($color-teal)      [Secundario]
Gold:         #C9A441  ($color-gold)      [Acento]
Copper:       #C49A6D  ($color-copper)    [Highlight]
Sand:         #C9C5B8  ($color-sand)      [Neutral cálido]
```

### Escala de Grises
```
Black:        #000000
Dark Gray:    #3A3A3A  ($color-text-primary)
Gray:         #6B6B6B
Light Gray:   #9C9EA1
Off-White:    #F5F5F3
White:        #FFFFFF
```

### Gradientes
```
Gold Shimmer:   linear-gradient(135deg, #D4B44A, #C9A441, #E6C866, #C9A441, #B8933A)
Navy → Teal:    linear-gradient(135deg, #0E5573, #2FBFB3)
Copper → Gold:  linear-gradient(135deg, #C49A6D, #C9A441)
Sand → White:   linear-gradient(180deg, #C9C5B8, #FFFFFF)
```

**Ubicación:** `assets/scss/abstracts/_variables.scss`

---

## 🔤 Tipografía

### Fuentes
```
Headings: Literata     (Georgia, serif fallback)
Body:     Fustat       (-apple-system, BlinkMacSystemFont, sans-serif)
```

### Escala (Base 18px, Ratio 1.25)
```
xs:   0.667rem  (12px)
sm:   0.833rem  (15px)
base: 1rem      (18px)  ← Base
lg:   1.222rem  (22px)
xl:   1.444rem  (26px)
2xl:  1.722rem  (31px)
3xl:  2.056rem  (37px)
4xl:  2.5rem    (45px)
5xl:  3rem      (54px)
```

### Pesos
```
Light:      300 ($font-weight-light)
Regular:    400
Medium:     500
Bold:       700
Extra Bold: 800 ($font-weight-extrabold)
```

### Altura de Línea
```
Tight:    1.2   (headings)
Snug:     1.3
Normal:   1.5   (body)
Relaxed:  1.625
Loose:    2
```

---

## 📏 Espaciado

### Escala (Base 16px)
```
xs:   0.25rem  (4px)
sm:   0.5rem   (8px)
md:   1rem     (16px)  ← Base
lg:   1.5rem   (24px)
xl:   2rem     (32px)
2xl:  3rem     (48px)
3xl:  4rem     (64px)
4xl:  6rem     (96px)
```

### Contenedores
```
sm: 640px
md: 768px
lg: 980px  ← Content width
xl: 1200px ← Max width
```

---

## 📱 Responsive

### Breakpoints
```
sm:  480px   (móvil pequeño)
md:  768px   (tablet)
lg:  1024px  (desktop)
xl:  1200px  (desktop ancho)
```

### Uso en SCSS
```scss
// Mobile-first (RECOMENDADO)
@include breakpoint-up('md') { /* tablet+ */ }

// Desktop-first (alternativa)
@include respond-to('md') { /* < tablet */ }
```

---

## 🎛️ Efectos

### Sombras
```
sm:    0 1px 2px rgba(0,0,0,0.05)
md:    0 4px 6px rgba(0,0,0,0.07)
lg:    0 10px 15px rgba(0,0,0,0.1)
xl:    0 20px 25px rgba(0,0,0,0.12)
gold:  0 4px 14px rgba(201,164,65,0.3)
```

### Border Radius
```
sm:   4px
md:   8px
lg:   16px
xl:   24px
full: 9999px (completamente redondo)
```

### Transiciones
```
fast: 150ms ease
base: 250ms ease  ← Estándar
slow: 350ms ease
```

---

## 🔘 Componentes Principales

### Botones
```
.btn-primary        Navy con ripple + pulse CTA
.btn-secondary      Teal con ripple
.btn-gold          Gradiente dorado
.btn-copper        Cobre
.btn-outline       Outline navy
.btn-outline-gold  Outline dorado
```

**Ejemplo:**
```twig
<a class="btn btn-primary" href="/action">Acción</a>
```

### Hero
```twig
<section class="hero" style="background-image: url(...)">
  <div class="hero__overlay"></div>
  <div class="hero__inner">
    <h1 class="hero__title">{{ title }}</h1>
    <div class="hero__actions">
      <a class="hero__button" href="{{ url }}">{{ text }}</a>
    </div>
  </div>
  <button class="hero__scroll-indicator"></button>
</section>
```

### Highlights
**Archivo:** `views/components/highlights.twig`

### Accordion
**Archivo:** `views/components/accordion.twig`

### Side Component
**Archivo:** `views/components/side-component.twig`

---

## 📁 Estructura del Proyecto

```
mcnabventures/
├── assets/
│   ├── css/              ← Compilado (generado)
│   ├── images/           ← Logos, assets estáticos
│   ├── js/
│   │   ├── main.js
│   │   ├── blocks.js
│   │   └── scroll-reveal.js
│   └── scss/
│       ├── abstracts/    ← Variables & Mixins ⭐
│       ├── base/         ← Reset & Typography
│       ├── layout/       ← Container
│       ├── components/   ← Component styles
│       ├── utilities/    ← Helpers & Animations
│       ├── main.scss     ← Import principal
│       └── critical.scss ← Above-the-fold
├── inc/
│   ├── acf-fields.php           ← Campos ACF
│   ├── components-registry.php  ← Registro
│   ├── gutenberg-blocks.php     ← Bloques WP
│   └── timber-setup.php         ← Configuración Timber
├── views/
│   ├── components/    ← Plantillas Twig
│   └── ...
├── templates/        ← Plantillas principales
├── functions.php     ← Setup del tema
├── theme.json        ← Config block editor
└── package.json      ← NPM scripts
```

---

## 🧩 Sistema de Nomenclatura CSS

### BEM (Block Element Modifier)
```scss
// Bloque (componente principal)
.button { }

// Elemento (parte del bloque)
.button__icon { }
.button__text { }

// Modificador (variación)
.button--primary { }
.button--large { }

// Estado
.button.is-active { }
.button.has-error { }
```

### Prefijos
```
.u-*       Utilidad        (.u-flex-center)
.is-*      Estado          (.is-active)
.has-*     Condición       (.has-background)
.wp-*      WordPress       (.wp-block-button)
```

---

## 🔧 Mixins Frecuentes

```scss
// Responsive (mobile-first)
@include breakpoint-up('md') { /* code */ }

// Flexbox
@include flex-center;      // center all items
@include flex-between;     // space-between

// Componentes
@include button-base;      // Reset button
@include button-ripple;    // Ripple effect
@include card;            // Card styles
@include full-width;      // Break out container

// Tipografía
@include snap-text;       // Fustat ExtraBold uppercase
@include heading-light;   // Literata 300
@include heading-medium;  // Literata 500
@include subheading;      // Fustat Medium
@include gold-text;       // Gradient text
@include truncate;        // Text ellipsis
```

---

## ⚙️ Comandos

### Compilar SCSS
```bash
# Watch mode (desarrollo)
npm run sass

# Single compile (producción)
npm run sass:build
```

**Resultado:** `assets/scss/` → `assets/css/main.css`

### WordPress
```bash
wp theme list           # Listar temas
wp option get home      # URL del sitio
wp plugin list          # Listar plugins (para ACF)
```

---

## 🎬 Animaciones

### Keyframes Disponibles
```
revealFadeUp      Fade + slide up (scroll reveal)
revealFadeLeft    Fade + slide left
ripple            Button ripple effect
pulse             Pulse glow (CTA buttons)
pulseSecondary    Pulse en teal
```

### Uso
```scss
.element {
  animation: revealFadeUp 0.6s ease-out;
}
```

---

## ♿ Accesibilidad

### Checklist
- ✓ Contraste mínimo 4.5:1
- ✓ Foco visible siempre
- ✓ Atributos ARIA apropiados (`aria-label`, `aria-hidden`)
- ✓ Semántica HTML correcta
- ✓ Respetar `prefers-reduced-motion`
- ✓ Labels en inputs
- ✓ Alt text en imágenes

### En SCSS
```scss
// Respetar preferencias de movimiento
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    transition-duration: 0.01ms !important;
  }
}

// Focus visible
:focus-visible {
  outline: 2px solid $color-navy;
  outline-offset: 2px;
}
```

---

## 🔐 CSS Custom Properties (para JavaScript)

```css
--color-navy: #0E5573;
--color-teal: #2FBFB3;
--color-gold: #C9A441;
--font-heading: 'Literata', serif;
--font-body: 'Fustat', sans-serif;
--font-size-base: 1rem;
--font-size-lg: 1.222rem;
--font-size-3xl: 2.056rem;
--font-size-5xl: 3rem;
```

**Acceso en JS:**
```javascript
const color = getComputedStyle(document.documentElement)
  .getPropertyValue('--color-navy');
```

---

## 📖 WordPress theme.json

Define para el editor de bloques:
- Colores disponibles (palette)
- Gradientes
- Fuentes
- Tamaños de fuente
- Configuración de layout

**Ubicación:** `theme.json`

---

## 🎯 Checklist para Nuevos Componentes

1. ✓ Crear `component-name.twig` en `views/components/`
2. ✓ Crear `_component-name.scss` en `assets/scss/components/`
3. ✓ Importar en `main.scss`
4. ✓ Documentar variables esperadas (comentarios Twig)
5. ✓ Registrar en ACF si es necesario (`inc/acf-fields.php`)
6. ✓ Seguir BEM para clases CSS
7. ✓ Usar variables SCSS existentes
8. ✓ Hacer responsive con `breakpoint-up()`
9. ✓ Añadir atributos ARIA
10. ✓ Probar en móvil/tablet/desktop

---

## 🚀 Mejores Prácticas

### DO ✓
```scss
// Usar variables
color: $color-navy;

// Usar mixins
@include button-base;

// Mobile-first responsive
@include breakpoint-up('md') { }

// BEM methodology
.component__element { }

// CSS custom properties para valores dinámicos
color: var(--color-navy);
```

### DON'T ✗
```scss
// No hardcodear valores
color: #0E5573;

// No usar !important
background: $color-navy !important;

// No estilos inline en HTML
<div style="color: navy;">

// Inconsistencia BEM
.component_element { }
.component-element { }

// Desktop-first sin mobile
@include respond-to('md') { }
```

---

## 📞 Recursos

### Documentación Oficial
- [WordPress Theme JSON](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json-schema/)
- [Timber/Twig](https://timber.github.io/timber/)
- [SMACSS](http://smacss.com/)
- [BEM](http://getbem.com/)
- [WCAG 2.1](https://www.w3.org/WAI/WCAG21/quickref/)

### Archivos Clave
- **Variables:** `assets/scss/abstracts/_variables.scss`
- **Mixins:** `assets/scss/abstracts/_mixins.scss`
- **Main Import:** `assets/scss/main.scss`
- **WordPress Config:** `theme.json`
- **Componentes:** `views/components/`

---

## 📝 Notas Importantes

1. **No usar Tailwind** - Proyecto usa SCSS puro
2. **WordPress es la fuente de verdad** para layouts de bloque
3. **ACF Pro requerido** para campos personalizados
4. **Timber v2** - Usar sintaxis compatible
5. **Mobile-first** - Empezar mobile, mejorar con `@include breakpoint-up()`
6. **Colores en tema.json** - Sincronizar con variables SCSS

---

**Última actualización:** Enero 2026
**Proyecto:** McNab Ventures WordPress Theme
**Versión:** 0.1.0
