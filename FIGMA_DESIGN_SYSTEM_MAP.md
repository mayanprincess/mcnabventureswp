# McNab Ventures - Figma Design System Map

Guía de mapeo entre Figma designs y la implementación en código.

---

## 🎯 Objetivo de Este Documento

Este documento ayuda a:
1. **Sincronizar** tokens de Figma con variables SCSS
2. **Mapear** componentes Figma a plantillas Twig
3. **Documentar** estados y variantes
4. **Facilitar** Code Connect en el MCP

---

## 📐 Tokens de Diseño

### Color System

| Nombre Figma | Color Hex | SCSS Variable | WordPress | Uso |
|---|---|---|---|---|
| Navy | #0E5573 | `$color-navy` | `navy` | Primary actions, headers |
| Teal | #2FBFB3 | `$color-teal` | `teal` | Secondary actions, hover |
| Gold | #C9A441 | `$color-gold` | `gold` | Accents, premium feel |
| Copper | #C49A6D | `$color-copper` | - | Highlights, decorative |
| Sand | #C9C5B8 | `$color-sand` | `sand` | Neutral, borders |
| Gray Dark | #3A3A3A | `$color-gray-dark` | - | Primary text |
| Gray | #6B6B6B | `$color-gray` | - | Secondary text |
| Light Gray | #9C9EA1 | `$color-gray-light` | - | Tertiary text, muted |
| Off-White | #F5F5F3 | `$color-off-white` | - | Secondary background |
| White | #FFFFFF | `$color-white` | `white` | Primary background |
| Black | #000000 | `$color-black` | - | Text on light backgrounds |

### Gradient System

| Nombre Figma | SCSS Variable | CSS |
|---|---|---|
| Gold Shimmer | `$gradient-gold` | `linear-gradient(135deg, #D4B44A 0%, #C9A441 25%, #E6C866 50%, #C9A441 75%, #B8933A 100%)` |
| Gold Vertical | `$gradient-gold-vertical` | `linear-gradient(180deg, #E6C866 0%, #C9A441 50%, #B8933A 100%)` |
| Navy → Teal Diagonal | `$gradient-navy-teal` | `linear-gradient(135deg, #0E5573 0%, #2FBFB3 100%)` |
| Navy → Teal Vertical | `$gradient-navy-teal-vertical` | `linear-gradient(180deg, #0E5573 0%, #2FBFB3 100%)` |
| Copper → Gold Diagonal | `$gradient-copper-gold` | `linear-gradient(135deg, #C49A6D 0%, #C9A441 100%)` |
| Copper → Gold Vertical | `$gradient-copper-gold-vertical` | `linear-gradient(180deg, #C49A6D 0%, #C9A441 100%)` |
| Sand → White | `$gradient-sand-white` | `linear-gradient(180deg, #C9C5B8 0%, #FFFFFF 100%)` |
| Warm Palette | - | `linear-gradient(90deg, #C9C5B8 0%, #C49A6D 50%, #C9A441 100%)` |

**Ubicación en código:** `assets/scss/abstracts/_variables.scss:46-68`

### Typography Scale

| Figma Size | SCSS Variable | Base em | Pixels (18px) | Usage |
|---|---|---|---|---|
| XSmall | `$font-size-xs` | 0.667rem | 12px | Labels, captions |
| Small | `$font-size-sm` | 0.833rem | 15px | Body small |
| Base | `$font-size-base` | 1rem | 18px | Body text (default) |
| Large | `$font-size-lg` | 1.222rem | 22px | Subheading |
| XLarge | `$font-size-xl` | 1.444rem | 26px | Heading 6 |
| 2XL | `$font-size-2xl` | 1.722rem | 31px | Heading 5 |
| 3XL | `$font-size-3xl` | 2.056rem | 37px | Heading 4 |
| 4XL | `$font-size-4xl` | 2.5rem | 45px | Heading 3 |
| 5XL | `$font-size-5xl` | 3rem | 54px | Hero title |

**Type Scale Ratio:** 1.25 (Perfect Fifth)

**Ubicación en código:** `assets/scss/abstracts/_variables.scss:85-94`

### Typefaces

| Figma Name | CSS Stack | Weight | Usage |
|---|---|---|---|
| Literata | `'Literata', Georgia, 'Times New Roman', serif` | 300 (Light) | All headings (h1-h6) |
| Fustat | `'Fustat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif` | 400-800 | Body text, UI |

**Font Weights in Fustat:**
- Regular: 400
- Medium: 500
- Bold: 700
- Extra Bold: 800 (for "snap text" - all caps)

**Ubicación en código:** `assets/scss/abstracts/_variables.scss:74-83`

### Spacing Scale

| Name | SCSS Variable | Base Pixels | Usage |
|---|---|---|---|
| XSmall | `$spacing-xs` | 4px | Micro spacing |
| Small | `$spacing-sm` | 8px | Tight spacing |
| Medium | `$spacing-md` | 16px | Default spacing |
| Large | `$spacing-lg` | 24px | Generous spacing |
| XLarge | `$spacing-xl` | 32px | Section padding |
| 2XL | `$spacing-2xl` | 48px | Large sections |
| 3XL | `$spacing-3xl` | 64px | Hero padding |
| 4XL | `$spacing-4xl` | 96px | Max vertical spacing |

**Ubicación en código:** `assets/scss/abstracts/_variables.scss:107-114`

### Effects

#### Border Radius
```
sm: 4px      - Subtle roundness
md: 8px      - Default (buttons)
lg: 16px     - Cards
xl: 24px     - Large elements
full: 9999px - Circles
```

#### Shadow Elevation
```
sm:   0 1px 2px rgba(0,0,0,0.05)       - Subtle
md:   0 4px 6px rgba(0,0,0,0.07)       - Hover state
lg:   0 10px 15px rgba(0,0,0,0.1)      - Elevated
xl:   0 20px 25px rgba(0,0,0,0.12)     - Maximum
gold: 0 4px 14px rgba(201,164,65,0.3)  - Gold accent
```

#### Transitions
```
fast: 150ms ease   - Quick interactions
base: 250ms ease   - Standard transitions
slow: 350ms ease   - Entrance animations
```

**Ubicación en código:** `assets/scss/abstracts/_variables.scss:128-143`

### Breakpoints

| Name | Size | SCSS Variable | Device |
|---|---|---|---|
| Small | 480px | `$breakpoint-sm` | Small phones |
| Medium | 768px | `$breakpoint-md` | Tablets |
| Large | 1024px | `$breakpoint-lg` | Laptops |
| XLarge | 1200px | `$breakpoint-xl` | Desktops |

**Ubicación en código:** `assets/scss/abstracts/_variables.scss:148-152`

---

## 🧩 Componentes

### Component Registry

```
Component Name (Figma)
├── File: component-name.twig
├── Styles: _component-name.scss
├── Fields: component_name (ACF)
├── Block: mcnab/component-name (Gutenberg)
├── States: default, hover, active, disabled
└── Responsive: mobile, tablet, desktop
```

### Hero Component

**Figma:** Hero Section
**Twig:** `views/components/hero.twig`
**SCSS:** `assets/scss/components/_hero.scss`
**ACF:** Hero Fields
**Block:** `mcnab/hero`

**Variables Expected:**
```twig
title           (string)       - Main heading
background_image (image/string) - Background image URL
button_text     (string)       - CTA button label
button_url      (string)       - CTA button link
```

**CSS Classes:**
```
.hero                   - Main wrapper
.hero__overlay         - Dark overlay
.hero__inner           - Content container
.hero__title           - Main title
.hero__actions         - Button container
.hero__button          - CTA button
.hero__scroll-indicator - Scroll indicator button
```

**States:**
- Default: Full height with background
- Mobile: Reduced height, single column
- Dark: Navy background with light text
- With Video: Background video support

### Highlights Component

**Figma:** Highlights/Features Grid
**Twig:** `views/components/highlights.twig`
**SCSS:** `assets/scss/components/_highlights.scss`

**Expected Structure:**
```
Items array with:
- title (string)
- description (string)
- icon/image (optional)
- link (optional)
```

**CSS Classes:**
```
.highlights              - Main container
.highlights__grid       - Grid wrapper
.highlights__item       - Individual item
.highlights__arrow      - Directional arrow
```

**Responsive Behavior:**
- Mobile: 1 column
- Tablet: 2 columns
- Desktop: 3-4 columns

### Accordion Component

**Figma:** Expandable Content / FAQ
**Twig:** `views/components/accordion.twig`
**SCSS:** `assets/scss/components/_accordion.scss`

**Structure:**
```
Items array with:
- title (string)
- content (string)
- expanded (boolean, default false)
```

**CSS Classes:**
```
.accordion              - Container
.accordion__item       - Individual accordion
.accordion__header     - Clickable header
.accordion__icon       - Expand/collapse icon
.accordion__content    - Hidden/shown content
.is-active            - Expanded state
```

### Button Components

**Figma:** Button Variants
**SCSS:** `assets/scss/components/_buttons.scss`

**Primary Buttons:**
```
.btn-primary        - Navy default
.btn-secondary      - Teal
.btn-gold          - Gold gradient
.btn-copper        - Copper
.btn-outline       - Navy outline
.btn-outline-gold  - Gold outline
```

**States:**
```
default   :default or no class
hover     :hover pseudo-class
active    :active pseudo-class
disabled  :disabled attribute
is-cta    .is-cta (adds pulse animation)
```

**Animations:**
- Ripple effect on click
- Hover lift (translateY -1px)
- Pulse animation for CTA buttons
- Respects prefers-reduced-motion

### Side Component

**Figma:** Side Panel / Sidebar Content
**Twig:** `views/components/side-component.twig`
**SCSS:** `assets/scss/components/_side-component.scss`

### Subscribe Component

**Figma:** Newsletter Signup
**Twig:** `components/subscribe.twig`
**SCSS:** `_subscribe.scss`

### Deep Dives Component

**Figma:** In-Depth Content Sections
**Twig:** `components/deep-dives.twig`
**SCSS:** `_deep-dives.scss`

### Notice Box Component

**Figma:** Alert / Callout
**Twig:** `components/notice-box.twig`
**SCSS:** `_notice-box.scss`

---

## 🎨 Design Patterns

### Color Usage Guidelines

```
Hero Backgrounds:
- Navy (#0E5573) - Premium, authority
- Teal (#2FBFB3) - Friendly, secondary
- Image overlays - Navy + 60% opacity

Button Colors:
- Primary CTA: Navy
- Secondary: Teal
- Premium: Gold gradient
- Accents: Copper

Text Colors:
- Headlines: Dark Gray (#3A3A3A)
- Body: Dark Gray (#3A3A3A)
- Secondary: Gray (#6B6B6B)
- Muted: Light Gray (#9C9EA1)
- Links: Navy (default), Teal (hover)

Background Colors:
- Primary: White
- Secondary: Off-White
- Dark sections: Navy
- Accented: Sand

Gradients:
- Gold Shimmer: Premium, eye-catching
- Navy→Teal: Corporate, modern
- Copper→Gold: Warm, inviting
```

### Typography Patterns

```
Page Hero: H1 (5XL, Literata Light)
↓
Section Headers: H2 (3XL-4XL, Literata Light)
↓
Card Headers: H3 (2XL, Literata Light)
↓
Subsection: H4 (XL-2XL, Literata Medium)
↓
Label/Meta: H5-H6 (sm-lg, Fustat Medium)

Body Text: Base (18px, Fustat Regular)
- Line height: 1.5
- Letter spacing: 0 (default)

Emphasis: Fustat Bold (700) or Gold text

CTAs: Fustat Medium (500), uppercase for buttons
```

### Layout Patterns

```
Container Padding:
- Mobile: 16px-20px (spacing-md to spacing-lg)
- Tablet: 24px-32px (spacing-lg to spacing-xl)
- Desktop: 32px-48px (spacing-xl to spacing-2xl)

Section Spacing:
- Between sections: 48px-96px (spacing-2xl to spacing-4xl)
- Mobile: 32px-48px
- Tablet: 48px-64px
- Desktop: 64px-96px

Grid Systems:
- Mobile: 1 column
- Tablet: 2 columns
- Desktop: 3 columns
- Max items per row: 4

Gap between items:
- Mobile: 16px
- Tablet: 24px
- Desktop: 32px
```

### Interactive Patterns

```
Hover States:
- Buttons: translateY(-2px) + shadow-md
- Cards: border-color change + shadow increase
- Links: color change Navy→Teal
- Icons: scale(1.1) or rotate

Focus States:
- Outline: 2px solid Navy
- Outline offset: 2px
- Never remove focus indicator

Active States:
- Buttons: translateY(0)
- Color: darker shade
- Shadow: none or minimal

Loading States:
- Button text hidden, spinner shown
- Cursor: not-allowed
- Opacity: reduced

Disabled States:
- Opacity: 0.5
- Cursor: not-allowed
- No hover effects
- No focus possible
```

---

## 🔗 Code Connect Mappings

### Propuesta de Code Connect

Cuando se implemente Code Connect, estos mapeos debería existir:

```
Figma Component ID → Code Component → Location

Hero Frame
├── Hero/Default → hero component → views/components/hero.twig
├── Hero/Dark → .hero--dark → assets/scss/components/_hero.scss
└── Hero/CTA → .hero.is-cta → (mixin)

Button Frame
├── Button/Primary → .btn-primary → assets/scss/components/_buttons.scss
├── Button/Secondary → .btn-secondary
├── Button/Large → .btn.btn-primary--large
├── Button/Disabled → .btn-primary:disabled
└── Button Ripple → @mixin button-ripple

Card Frame
├── Card/Default → @mixin card
├── Card/Hover → .card:hover
└── Card/Dark → .card--dark

Grid Systems
├── Grid/3-Column → .grid { grid-template-columns: repeat(3, 1fr) }
├── Grid/Responsive → .grid + @include breakpoint-up()
└── Gap Modifier → .grid--gap-{size}

Typography
├── Heading 1 → h1 { font-size: $font-size-5xl }
├── Body → p { font-size: $font-size-base }
└── Label → span.label { @include subheading }

Colors
├── Navy → $color-navy (#0E5573)
├── Teal → $color-teal (#2FBFB3)
├── Gold → $color-gold (#C9A441)
└── Gradients → $gradient-{name}
```

---

## 📱 Responsive Specifications

### Mobile-First Strategy

```
Step 1: Design for 375px (Mobile)
        - Single column
        - Stacked layout
        - Touch-friendly sizes

Step 2: Tablet Breakpoint (768px)
        - Two columns where appropriate
        - More generous spacing
        - Grid layouts begin

Step 3: Desktop Breakpoint (1024px)
        - Three+ columns
        - Full feature set
        - Optimized layout

Step 4: Large Desktop (1200px)
        - Max width container
        - Advanced layouts
        - Premium experience
```

### Responsive Checklist for Components

When designing in Figma:
- [ ] Mobile version (375px artboard)
- [ ] Tablet version (768px artboard)
- [ ] Desktop version (1024px artboard)
- [ ] Wide desktop version (1200px artboard)
- [ ] Touch targets ≥ 44x44px
- [ ] Text readable at mobile size
- [ ] Images scale appropriately
- [ ] Spacing consistent with scale
- [ ] States documented (hover, active, disabled)

---

## 🚀 Implementation Checklist

When implementing a Figma design:

### Before Coding
- [ ] Extract color values
- [ ] Identify typography (size, weight, family)
- [ ] Document spacing values
- [ ] List all component states
- [ ] Note responsive breakpoints
- [ ] Define animations/transitions
- [ ] Check accessibility requirements

### During Coding
- [ ] Create Twig template
- [ ] Create SCSS file
- [ ] Use existing variables
- [ ] Follow BEM naming
- [ ] Implement all states
- [ ] Test responsive breakpoints
- [ ] Verify color contrast
- [ ] Add ARIA labels
- [ ] Test keyboard navigation

### After Coding
- [ ] Compile SCSS
- [ ] Test in browser
- [ ] Cross-browser testing
- [ ] Mobile device testing
- [ ] Accessibility audit
- [ ] Performance check
- [ ] Documentation

---

## 📚 Quick Reference

### Variable Lookup by Use

**Need a spacing value?**
→ See `assets/scss/abstracts/_variables.scss:107-114`

**Need a color?**
→ See `assets/scss/abstracts/_variables.scss:9-40`

**Need a font size?**
→ See `assets/scss/abstracts/_variables.scss:85-94`

**Need a mixin?**
→ See `assets/scss/abstracts/_mixins.scss`

**Need a component?**
→ Search in `views/components/`

**Need Gutenberg block config?**
→ See `inc/gutenberg-blocks.php`

**Need ACF fields?**
→ See `inc/acf-fields.php`

---

## 🔄 Sync Workflow

### From Figma to Code (Recommended)

1. **Design in Figma**
   - Use design system components
   - Document specs in comments
   - Export assets

2. **Update Design Tokens** (if new)
   ```scss
   // In _variables.scss
   $new-color: #VALUE;
   $new-size: {value}rem;
   ```

3. **Update theme.json** (if Gutenberg needs it)
   ```json
   {
     "color": {
       "palette": [
         { "slug": "new", "color": "#VALUE" }
       ]
     }
   }
   ```

4. **Create/Update Component**
   - Twig template
   - SCSS styles
   - ACF fields
   - Gutenberg block

5. **Test & Document**
   - Responsive testing
   - Accessibility check
   - Update this document

---

**Version:** 1.0
**Last Updated:** Enero 2026
**Maintained By:** McNab Ventures Design System Team
