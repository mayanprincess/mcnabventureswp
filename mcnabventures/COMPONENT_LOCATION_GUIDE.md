# Component Location Guide

## Cómo Funciona el Campo `location`

El campo `location` en el registry determina **dónde aparecen los campos ACF** en el editor de WordPress.

## Opciones de Location

### 1. **Tipo de Post Simple**
```php
'location' => 'page',  // Aparece en todas las páginas
'location' => 'post',  // Aparece en todos los posts
```

### 2. **Múltiples Tipos de Post**
```php
'location' => ['page', 'post'],  // Aparece en páginas Y posts
```

### 3. **Template Específico**
```php
'location' => 'page_template:page-homepage.php',  // Solo en homepage template
'location' => 'page_template:page-about.php',     // Solo en about template
```

### 4. **Custom Post Type**
```php
'location' => 'property',  // Si tienes un CPT llamado 'property'
'location' => 'experience', // Si tienes un CPT llamado 'experience'
```

### 5. **Múltiples Locations**
```php
'location' => [
  'page',
  'page_template:page-homepage.php',
  'property'  // Custom post type
],
```

## Ejemplos Prácticos

### Ejemplo 1: Hero solo en Homepage
```php
'hero' => [
  'slug' => 'hero',
  'location' => 'page_template:page-homepage.php',
  'name' => 'Hero Component',
  // ... campos
],
```

### Ejemplo 2: Side Component en Páginas y Posts
```php
'side-component' => [
  'slug' => 'side-component',
  'location' => ['page', 'post'],
  'name' => 'Side Component',
  // ... campos
],
```

### Ejemplo 3: Accordion solo en Páginas
```php
'accordion' => [
  'slug' => 'accordion',
  'location' => 'page',
  'name' => 'Accordion Component',
  // ... campos
],
```

## Cómo Funciona

1. **Editas el `location`** en `inc/components-registry.php`
2. **Los campos ACF aparecen automáticamente** en el editor cuando:
   - El tipo de post coincide con `location`
   - O el template de página coincide con `location`
3. **No necesitas seleccionar nada** - Los campos aparecen solos
4. **El componente se renderiza automáticamente** si el `location` coincide

## Auto-Render

Si el `location` del componente coincide con la página/post actual, el componente se muestra automáticamente arriba del contenido.

Si no quieres auto-render, simplemente usa el shortcode:
```
[side_component]
```

## Notas

- **Sin selector:** Ya no hay selector "Active Component" en el sidebar
- **Automático:** Los campos aparecen según el `location` definido
- **Múltiples componentes:** Puedes tener varios componentes con el mismo `location` - todos aparecerán
