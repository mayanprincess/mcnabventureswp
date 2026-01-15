# IA Component Creation Guide (McNab Ventures)

Este es el documento más importante del repo: explica **cómo crear componentes nuevos** en este theme usando **ACF Pro (Flexible Content) + Timber + Twig + SCSS + JS vanilla**.

## Filosofía del sistema

- **Sin Gutenberg markup**: los componentes Twig NO dependen de clases `wp-block-*`.
- **ACF Flexible Content** controla el orden y permite repetir componentes en una página.
- **Performance-first**: preferimos **CSS scroll-snap + JS mínimo** en vez de librerías pesadas.
- **Datos → Twig**: ACF entrega arrays (especialmente imágenes), y Twig renderiza HTML limpio.

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

