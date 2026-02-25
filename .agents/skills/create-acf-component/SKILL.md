---
name: create-acf-component
description: Creates new WordPress ACF components for the McNab Ventures theme. Use this skill when the user asks to add a new section, block, or page component to the WordPress backend. Covers backend registry, Twig template, SCSS, and SCSS compilation.
---

# Create ACF Component — McNab Ventures

This skill creates end-to-end WordPress components for the McNab Ventures theme.
The stack is: **WordPress + ACF Pro + Timber (Twig v2) + SCSS (no Tailwind, no Gutenberg classes)**.

---

## Architecture Flow

```
components-registry.php  →  acf-fields.php (auto)  →  Twig template  →  Frontend
       ↑ YOU EDIT THIS                ↑ DO NOT TOUCH        ↑ YOU CREATE THIS
```

Only two files need to be created/edited per new component:
1. `mcnabventures/inc/components-registry.php` — backend field definition
2. `mcnabventures/views/components/<slug>.twig` — frontend template

Optionally (for custom styles):
3. `mcnabventures/assets/scss/components/_<slug>.scss` — component styles
4. `mcnabventures/assets/scss/main.scss` — add `@use` import

---

## Step 1 — Register the Component

Edit `mcnabventures/inc/components-registry.php`.
Add a new entry inside `mcnab_get_registered_components()` return array:

```php
'my-component' => [
  'slug'        => 'my-component',          // kebab-case, unique
  'location'    => 'page',                  // 'page' | 'post' | ['page','post']
  'name'        => 'My Component',          // Human label in WP admin
  'description' => 'Short description.',    // Shown in admin panel
  'file'        => 'my-component.twig',     // Must match slug + .twig
  'fields'      => [
    // → fields here (see reference below)
  ],
],
```

**Slug rules:**
- kebab-case only (`my-component`, not `my_component`)
- must be unique across all registered components
- `file` value must equal `slug` + `.twig`

---

## Field Type Reference

### text
```php
'title' => [
  'label'       => 'Title',
  'type'        => 'text',
  'default'     => 'Default value',   // optional
  'required'    => false,
  'placeholder' => 'Hint text',       // optional
],
```

### textarea
```php
'description' => [
  'label'    => 'Description',
  'type'     => 'textarea',
  'required' => false,
],
```
Auto-configured: `rows: 4`.

### wysiwyg
```php
'content' => [
  'label'    => 'Content',
  'type'     => 'wysiwyg',
  'required' => false,
],
```
Auto-configured: full toolbar, media upload enabled.
In Twig: always render with `{{ content|raw }}`.

### email
```php
'email' => [
  'label'       => 'Email',
  'type'        => 'email',
  'required'    => true,
  'placeholder' => 'hello@example.com',
],
```

### url
```php
'link' => [
  'label'       => 'URL',
  'type'        => 'url',
  'default'     => '#',
  'required'    => false,
  'placeholder' => 'https://example.com',
],
```

### number
```php
'quantity' => [
  'label'    => 'Quantity',
  'type'     => 'number',
  'default'  => 1,
  'required' => false,
],
```

### image
```php
'background_image' => [
  'label'    => 'Background Image',
  'type'     => 'image',
  'required' => false,
],
```
Returns array: `{ ID, url, alt, title, width, height, … }`.
In Twig: `{{ image.url ?? image }}` and `{{ (image.alt ?? '')|e }}`.

### gallery
```php
'photos' => [
  'label'    => 'Photo Gallery',
  'type'     => 'gallery',
  'required' => false,
],
```
Returns array of image arrays.

### file
```php
'video_src' => [
  'label'      => 'Video (MP4)',
  'type'       => 'file',
  'mime_types' => 'mp4',    // 'mp4' | 'svg' | 'pdf' | etc.
  'required'   => false,
],
```
Returns array: `{ ID, url, filename, … }`.
In Twig: `{{ video_src.url ?? video_src }}`.

### date
```php
'publish_date' => [
  'label'    => 'Date',
  'type'     => 'date',
  'required' => false,
],
```

### true_false (boolean toggle)
```php
'active' => [
  'label'    => 'Active',
  'type'     => 'true_false',
  'default'  => 1,           // 1 = on, 0 = off
  'required' => false,
],
```
In Twig: `{% if active %}…{% endif %}`.

### select (dropdown)
```php
'variant' => [
  'label'   => 'Variant',
  'type'    => 'select',
  'choices' => [
    'default' => 'Default',
    'dark'    => 'Dark',
    'light'   => 'Light',
  ],
  'default'  => 'default',
  'required' => false,
],
```
`choices` keys = stored value; values = admin label.

### group (non-repeatable sub-fields)
```php
'primary_button' => [
  'label'      => 'Primary Button',
  'type'       => 'group',
  'sub_fields' => [
    'label' => [
      'label'    => 'Label',
      'type'     => 'text',
      'required' => false,
    ],
    'href' => [
      'label'    => 'URL',
      'type'     => 'url',
      'required' => false,
    ],
  ],
],
```
In Twig: `{{ primary_button.label }}` / `{{ primary_button.href }}`.

### repeater
```php
'items' => [
  'label'      => 'Items',
  'type'       => 'repeater',
  'required'   => false,
  'default'    => [],
  'sub_fields' => [
    'title' => [
      'label'    => 'Title',
      'type'     => 'text',
      'required' => false,
    ],
    'content' => [
      'label'    => 'Content',
      'type'     => 'wysiwyg',
      'required' => false,
    ],
  ],
],
```
Auto-configured: layout `block`, button label `Add Item`, no min/max.

---

## Conditional Logic

Show a field only when another field has a specific value.
The control field MUST appear before the conditional field in the array.

```php
'show_button' => [
  'label'   => 'Show Button',
  'type'    => 'select',
  'choices' => ['no' => 'No', 'yes' => 'Yes'],
  'default' => 'no',
],
'button_text' => [
  'label' => 'Button Text',
  'type'  => 'text',
  'conditional_logic' => [
    [
      [
        'field'    => 'show_button',   // key name in this component
        'operator' => '==',            // == | != | > | < | >= | <=
        'value'    => 'yes',
      ],
    ],
  ],
],
```

Multiple OR groups → outer array.
Multiple AND conditions → inner array.

Works inside repeater `sub_fields` too (references sibling field names).

---

## Step 2 — Create the Twig Template

File: `mcnabventures/views/components/<slug>.twig`

```twig
{# <ComponentName> — brief description #}
<section class="my-component" aria-label="{{ title ?? '' }}">

  {% if title %}
    <h2 class="my-component__title">{{ title }}</h2>
  {% endif %}

  {% if content %}
    <div class="my-component__content">{{ content|raw }}</div>
  {% endif %}

  {# Repeater pattern #}
  {% set rows = items ?? [] %}
  {% if rows|length %}
    <ul class="my-component__list" role="list">
      {% for row in rows %}
        {% set img = row.image ?? null %}
        <li class="my-component__item" data-scroll-reveal="up">
          {% if img %}
            <img
              src="{{ img.url ?? img }}"
              alt="{{ (img.alt ?? '')|e }}"
              loading="lazy"
              decoding="async"
            >
          {% endif %}
          {% if row.title %}
            <h3 class="my-component__item-title">{{ row.title }}</h3>
          {% endif %}
          {% if row.content %}
            <div class="my-component__item-content">{{ row.content|raw }}</div>
          {% endif %}
        </li>
      {% endfor %}
    </ul>
  {% endif %}

  {% if button_text and button_url %}
    <a class="btn btn-primary my-component__cta" href="{{ button_url }}">
      {{ button_text }}
      <span aria-hidden="true">→</span>
    </a>
  {% endif %}

</section>
```

**Twig rules:**
- `{{ field }}` → auto-escaped (safe for text)
- `{{ field|raw }}` → unescaped (only for trusted ACF WYSIWYG content)
- `{{ (field ?? '')|e }}` → explicit escape for attributes
- `{% set x = field ?? fallback %}` → null-coalescing default
- Image: `{{ img.url ?? img }}` handles both array and string returns
- Never use `|raw` on user-typed text fields

---

## Step 3 — Create SCSS (only if custom styles needed)

File: `mcnabventures/assets/scss/components/_<slug>.scss`

```scss
// ==========================================================================
// MY COMPONENT
// ==========================================================================

@use '../abstracts/variables' as *;
@use '../abstracts/mixins' as *;

.my-component {
  padding: $spacing-3xl 0;

  @include breakpoint-up('md') {
    padding: $spacing-4xl 0;
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
  font-family: $font-body;
  font-size: $font-size-base;
  line-height: $line-height-normal;
  color: $color-text-primary;
}

.my-component__list {
  display: grid;
  grid-template-columns: 1fr;
  gap: $spacing-lg;
  list-style: none;
  padding: 0;
  margin: $spacing-xl 0 0;

  @include breakpoint-up('md') {
    grid-template-columns: repeat(2, 1fr);
  }

  @include breakpoint-up('lg') {
    grid-template-columns: repeat(3, 1fr);
    gap: $spacing-xl;
  }
}

.my-component__item {
  background: $color-white;
  border-radius: $border-radius-lg;
  box-shadow: $shadow-md;
  overflow: hidden;
  transition: box-shadow $transition-base, transform $transition-base;

  &:hover {
    box-shadow: $shadow-lg;
    transform: translateY(-4px);
  }

  img {
    width: 100%;
    aspect-ratio: 16 / 9;
    object-fit: cover;
  }
}

.my-component__item-title {
  font-family: $font-heading;
  font-weight: $font-weight-light;
  font-size: $font-size-lg;
  color: $color-navy;
  padding: $spacing-md $spacing-md 0;
}

.my-component__item-content {
  padding: $spacing-sm $spacing-md $spacing-md;
  font-size: $font-size-sm;
  color: $color-text-primary;
  line-height: $line-height-normal;
}

.my-component__cta {
  display: inline-flex;
  align-items: center;
  gap: $spacing-sm;
  margin-top: $spacing-2xl;
}

// Respect user motion preference
@media (prefers-reduced-motion: reduce) {
  .my-component__item {
    transition: none;
    transform: none;
  }
}
```

Then import in `mcnabventures/assets/scss/main.scss`:
```scss
@use 'components/my-component';
```

Compile:
```bash
npm run sass:build
```

---

## Design System Tokens (Use These — Never Hardcode Values)

### Colors
```scss
$color-navy:    #0E5573   // Primary, headings, backgrounds
$color-teal:    #2FBFB3   // Secondary, links, accents
$color-gold:    #C9A441   // Premium, CTA highlights
$color-copper:  #C49A6D   // Warm accent
$color-sand:    #C9C5B8   // Neutral warm
$color-white:   #FFFFFF
$color-off-white: #F5F5F3 // Section backgrounds
$color-text-primary: #3A3A3A
```

### Gradients
```scss
$gradient-gold:       linear-gradient(135deg, #D4B44A, #C9A441, #E6C866, #C9A441, #B8933A)
$gradient-navy-teal:  linear-gradient(135deg, #0E5573, #2FBFB3)
$gradient-copper-gold: linear-gradient(135deg, #C49A6D, #C9A441)
```

### Spacing
```scss
$spacing-xs: 0.25rem   //  4px
$spacing-sm: 0.5rem    //  8px
$spacing-md: 1rem      // 16px
$spacing-lg: 1.5rem    // 24px
$spacing-xl: 2rem      // 32px
$spacing-2xl: 3rem     // 48px
$spacing-3xl: 4rem     // 64px
$spacing-4xl: 6rem     // 96px
```

### Typography
```scss
$font-heading: 'Literata', Georgia, serif    // h1–h6
$font-body:    'Fustat', -apple-system, sans-serif  // body, UI

$font-size-xs:   0.667rem  // 12px
$font-size-sm:   0.833rem  // 15px
$font-size-base: 1rem      // 18px
$font-size-lg:   1.222rem  // 22px
$font-size-xl:   1.444rem  // 26px
$font-size-2xl:  1.722rem  // 31px
$font-size-3xl:  2.056rem  // 37px
$font-size-4xl:  2.5rem    // 45px
$font-size-5xl:  3rem      // 54px

$font-weight-light:     300
$font-weight-regular:   400
$font-weight-medium:    500
$font-weight-bold:      700
$font-weight-extrabold: 800

$line-height-tight:   1.2
$line-height-normal:  1.5
$line-height-relaxed: 1.625
```

### Effects
```scss
$border-radius-sm: 4px
$border-radius-md: 8px
$border-radius-lg: 16px
$border-radius-xl: 24px
$border-radius-full: 9999px

$shadow-sm:   0 1px 2px rgba(0,0,0,0.05)
$shadow-md:   0 4px 6px rgba(0,0,0,0.07)
$shadow-lg:   0 10px 15px rgba(0,0,0,0.1)
$shadow-gold: 0 4px 14px rgba(201,164,65,0.3)

$transition-fast: 150ms ease
$transition-base: 250ms ease
$transition-slow: 350ms ease
```

### Breakpoints (mobile-first)
```scss
@include breakpoint-up('sm')  // 480px+
@include breakpoint-up('md')  // 768px+
@include breakpoint-up('lg')  // 1024px+
@include breakpoint-up('xl')  // 1200px+
```

### Key Mixins
```scss
@include heading-light;      // Literata 300
@include heading-medium;     // Literata 500
@include subheading;         // Fustat Medium uppercase
@include snap-text;          // Fustat ExtraBold uppercase
@include gold-text;          // Gradient gold text
@include button-base;        // Reset button
@include button-ripple;      // Click ripple effect
@include card;               // Card base styles
@include flex-center;        // display:flex; center all
@include flex-between;       // display:flex; space-between
@include full-width;         // Break container
@include truncate;           // Text ellipsis
```

---

## Available Button Classes (Use in Twig)

```twig
<a class="btn btn-primary" href="…">Navy + ripple + CTA pulse</a>
<a class="btn btn-secondary" href="…">Teal + ripple</a>
<a class="btn btn-gold" href="…">Gold gradient</a>
<a class="btn btn-copper" href="…">Copper</a>
<a class="btn btn-outline" href="…">Navy outline</a>
<a class="btn btn-outline-gold" href="…">Gold outline</a>
```

---

## Scroll Reveal Animations

Add `data-scroll-reveal` to any element to trigger entrance animation on scroll:

```twig
<article data-scroll-reveal="up">   {# fade in upward #}
<article data-scroll-reveal="left"> {# fade in from left #}
```

---

## Existing Components (Do Not Duplicate Slugs)

| Slug | Name |
|------|------|
| `active-toggle` | Boolean toggle |
| `side-component` | Two-column logo + content |
| `hero` | Full-width hero |
| `accordion` | Expandable accordion |
| `highlights` | Horizontal slider cards |
| `multimedia` | Photo + video gallery |
| `primary-hero` | Hero with MP4 video background |
| `secondary-hero` | Hero with background image |
| `mission-statement` | Single large text block |
| `video-player` | Standalone video |
| `group-snapshot` | Snapshot slides + logos |
| `our-partners` | Partner logo grid |
| `featured-experiences` | Mixed media tile grid |
| `stay-in-the-loop` | News/article teaser cards |
| `diversified` | Image section with title |
| `join-our-team` | Recruiting CTA section |
| `who-we-are` | Badge + split title + logo |
| `our-journey` | Accordion timeline |
| `get-highlights` | Highlight cards with links |
| `our-industries` | Industry card grid |
| `contact-card` | Contact details + social links |
| `useful-links` | Icon link list |
| `driven-by-progress` | Stats + image |
| `experiences-gallery` | Gallery slides with split text |
| `sustainability-in-action` | Card grid with BG image |
| `the-experiences` | Experience layouts (single/dual) |

---

## Complete Real-World Example

### Registry (components-registry.php)

```php
'team-members' => [
  'slug'        => 'team-members',
  'location'    => 'page',
  'name'        => 'Team Members',
  'description' => 'Grid of team member cards with photo, name, role, and bio.',
  'file'        => 'team-members.twig',
  'fields'      => [
    'badge' => [
      'label'    => 'Badge Text',
      'type'     => 'text',
      'default'  => 'OUR TEAM',
      'required' => false,
    ],
    'title' => [
      'label'    => 'Section Title',
      'type'     => 'text',
      'required' => false,
    ],
    'members' => [
      'label'      => 'Team Members',
      'type'       => 'repeater',
      'required'   => false,
      'default'    => [],
      'sub_fields' => [
        'photo' => [
          'label'    => 'Photo',
          'type'     => 'image',
          'required' => false,
        ],
        'name' => [
          'label'    => 'Name',
          'type'     => 'text',
          'required' => true,
        ],
        'role' => [
          'label'    => 'Role / Position',
          'type'     => 'text',
          'required' => false,
        ],
        'bio' => [
          'label'    => 'Bio',
          'type'     => 'textarea',
          'required' => false,
        ],
        'show_email' => [
          'label'   => 'Show Email',
          'type'    => 'select',
          'choices' => ['no' => 'No', 'yes' => 'Yes'],
          'default' => 'no',
        ],
        'email' => [
          'label'            => 'Email',
          'type'             => 'email',
          'required'         => false,
          'conditional_logic' => [
            [['field' => 'show_email', 'operator' => '==', 'value' => 'yes']],
          ],
        ],
      ],
    ],
  ],
],
```

### Twig (views/components/team-members.twig)

```twig
{# Team Members — Grid of team member cards #}
<section class="team-members">
  <div class="container">

    {% if badge %}
      <span class="team-members__badge">{{ badge }}</span>
    {% endif %}

    {% if title %}
      <h2 class="team-members__title">{{ title }}</h2>
    {% endif %}

    {% set members = members ?? [] %}
    {% if members|length %}
      <ul class="team-members__grid" role="list">
        {% for member in members %}
          {% set photo = member.photo ?? null %}
          <li class="team-members__card" data-scroll-reveal="up">
            {% if photo %}
              <div class="team-members__photo">
                <img
                  src="{{ photo.url ?? photo }}"
                  alt="{{ (photo.alt ?? member.name ?? '')|e }}"
                  loading="lazy"
                  decoding="async"
                >
              </div>
            {% endif %}

            <div class="team-members__info">
              {% if member.name %}
                <h3 class="team-members__name">{{ member.name }}</h3>
              {% endif %}
              {% if member.role %}
                <p class="team-members__role">{{ member.role }}</p>
              {% endif %}
              {% if member.bio %}
                <p class="team-members__bio">{{ member.bio }}</p>
              {% endif %}
              {% if member.show_email == 'yes' and member.email %}
                <a class="team-members__email" href="mailto:{{ member.email }}">
                  {{ member.email }}
                </a>
              {% endif %}
            </div>
          </li>
        {% endfor %}
      </ul>
    {% endif %}

  </div>
</section>
```

---

## Validation Checklist

Before saving, verify:

- [ ] `slug` is unique (not in the existing components list above)
- [ ] `slug` uses kebab-case (hyphens, not underscores)
- [ ] `file` matches `slug` + `.twig`
- [ ] Every field has `label` and `type`
- [ ] `select` fields have `choices` defined
- [ ] `repeater` and `group` fields have `sub_fields`
- [ ] `conditional_logic` references the exact key name of the control field
- [ ] Control field appears **before** its conditional field in the array
- [ ] Twig uses `{{ field|raw }}` only for WYSIWYG, not plain text
- [ ] Images use `{{ img.url ?? img }}` pattern
- [ ] SCSS imports added to `main.scss` if new stylesheet was created
- [ ] `npm run sass:build` run after SCSS changes

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Component not visible in editor | Verify ACF Pro active; check PHP syntax (missing comma?) |
| Fields don't appear | Each field needs `label` and `type`; check array syntax |
| Repeater broken | Add `sub_fields`; don't set `required: true` on the repeater itself |
| Conditional logic ignored | Control field name must be exact; control field must come first in array |
| Image not rendering | Use `{{ img.url ?? img }}` in Twig; field must be `type: image` |
| WYSIWYG shows raw HTML | Use `{{ content|raw }}` |
| Styles not updating | Run `npm run sass:build`; check `@use` import in `main.scss` |

---

## Verify Changes

```bash
# List all registered slugs
grep "'slug'" mcnabventures/inc/components-registry.php

# Check your new component exists
grep -A 5 "'my-component'" mcnabventures/inc/components-registry.php

# Compile SCSS
npm run sass:build
```

Then in **WP Admin → Edit Page → Page Components → Add Component** — your new component should appear.
