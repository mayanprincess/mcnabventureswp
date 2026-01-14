# Component System - McNab Ventures Theme

Este tema usa **Timber + Twig** para componentes reutilizables.

## Instalación

Timber está instalado vía **Composer** (no como plugin).

```bash
composer install
```

## Uso de Componentes

### En Templates PHP

```php
// Con argumentos directos
mcnab_render_twig_component('side-component', [
  'badge' => 'WHO WE ARE',
  'title_part1' => 'Experience crystal-clear waters...',
  'title_highlight' => 'Mayan Princess Beach & Dive Resort.',
  'description' => 'As a proud member...',
  'logo' => get_template_directory_uri() . '/assets/images/logo.png',
]);

// O con ACF (campos automáticos)
mcnab_render_twig_component('side-component'); // Usa get_fields() automáticamente
```

### En Templates Twig

```twig
{% include 'components/side-component.twig' with {
  badge: 'WHO WE ARE',
  title_part1: 'Experience crystal-clear waters...',
  title_highlight: 'Mayan Princess Beach & Dive Resort.',
  description: 'As a proud member...',
  logo: theme.link ~ '/assets/images/logo.png'
} %}
```

### Como Shortcode

Puedes usar componentes como shortcodes en el editor:

```
[side_component badge="WHO WE ARE" title_part1="Experience..." title_highlight="Mayan Princess..." description="As a proud member..." logo="/path/to/logo.png"]
```

## ACF Integration

Los componentes detectan automáticamente campos ACF:

1. **Crea campos ACF** en el Customizer o con ACF Pro
2. **Usa el componente** sin pasar argumentos:
   ```php
   mcnab_render_twig_component('side-component'); // Lee ACF automáticamente
   ```

Los campos ACF se mapean automáticamente a los argumentos del componente.

## Componentes Disponibles

### 1. Side Component
**Archivo:** `views/components/side-component.twig`

**Campos:**
- `badge` - Texto del badge (ej: "WHO WE ARE")
- `title_part1` - Primera parte del título
- `title_highlight` - Texto destacado en teal
- `description` - Descripción
- `logo` - URL o ID de imagen (ACF image array se convierte automáticamente)

**Uso:**
```php
mcnab_render_twig_component('side-component');
```

### 2. Hero Component
**Archivo:** `views/components/hero.twig`

**Campos:**
- `title` - Título principal
- `subtitle` - Subtítulo
- `button_text` - Texto del botón
- `button_url` - URL del botón
- `background_image` - Imagen de fondo (ACF image array se convierte automáticamente)

**Uso:**
```php
mcnab_render_twig_component('hero');
```

### 3. Accordion Component
**Archivo:** `views/components/accordion.twig`

**Campos:**
- `title` - Título del acordeón
- `items` - Array de items con `title` y `content`

**Uso:**
```php
mcnab_render_twig_component('accordion');
```

## Ventajas de Timber + Twig

- ✅ HTML limpio y separado de PHP
- ✅ Sintaxis más clara: `{{ variable }}` vs `<?php echo $variable; ?>`
- ✅ Mejor para equipos (frontend puede trabajar en .twig)
- ✅ Escapado automático de seguridad
- ✅ Reutilización fácil con `{% include %}`
- ✅ Sin errores de PHP 8.2+ (versión Composer actualizada)

## Recursos

- [Timber Documentation](https://timber.github.io/docs/v2/)
- [Twig Documentation](https://twig.symfony.com/)
- [ACF Documentation](https://www.advancedcustomfields.com/resources/)
