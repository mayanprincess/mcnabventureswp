# Cómo Usar los Componentes

## Opciones para Usar Componentes

### 1. **Usar Shortcodes en el Editor** (Más Fácil)

En cualquier página/post de WordPress, simplemente escribe el shortcode:

```
[side_component badge="WHO WE ARE" title_part1="Experience..." title_highlight="Mayan Princess..." description="As a proud member..." logo="/path/to/logo.png"]
```

O con campos vacíos (usará ACF si están configurados):

```
[side_component]
```

**Componentes disponibles como shortcodes:**
- `[side_component]`
- `[hero_component]`
- `[accordion_component]`

---

### 2. **Usar en Templates PHP**

Edita un template (ej: `page.php`, `single.php`) y agrega:

```php
<?php
// Con argumentos directos
if (function_exists('mcnab_render_twig_component')) {
  mcnab_render_twig_component('side-component', [
    'badge' => 'WHO WE ARE',
    'title_part1' => 'Experience crystal-clear waters...',
    'title_highlight' => 'Mayan Princess Beach & Dive Resort.',
    'description' => 'As a proud member...',
    'logo' => get_template_directory_uri() . '/assets/images/logo.png',
  ]);
}
?>
```

---

### 3. **Usar con ACF (Advanced Custom Fields)**

Si tienes campos ACF con los mismos nombres, simplemente llama el componente sin argumentos:

```php
<?php
// Lee automáticamente los campos ACF
if (function_exists('mcnab_render_twig_component')) {
  mcnab_render_twig_component('side-component');
}
?>
```

**Campos ACF necesarios:**
- `badge`
- `title_part1`
- `title_highlight`
- `description`
- `logo` (image field)

---

### 4. **Ver Documentación**

Ve a **WordPress Admin → Appearance → Components** para ver:
- Todos los componentes disponibles
- Código de ejemplo
- Campos requeridos
- Shortcodes disponibles

---

## Ejemplo Completo: Crear una Página con Componentes

### Opción A: Usando Shortcodes (Recomendado para no-programadores)

1. Crea una nueva página en WordPress
2. En el editor, escribe:

```
[hero_component title="Welcome" subtitle="To our resort" button_text="Explore" button_url="#" background_image="/path/to/image.jpg"]

[side_component badge="WHO WE ARE" title_part1="Experience..." title_highlight="Mayan Princess..." description="As a proud member..." logo="/path/to/logo.png"]

[accordion_component title="Our Journey"]
```

3. Publica la página

### Opción B: Usando Template PHP (Para programadores)

1. Crea un archivo `templates/page-homepage.php`
2. Agrega el código de ejemplo (ver archivo creado)
3. En WordPress, crea una página y selecciona el template "Page with Components"

---

## Dónde Aparecen los Componentes

**NO aparecen automáticamente** - Debes llamarlos explícitamente:

✅ **Sí aparecen:**
- Cuando usas shortcodes en el editor
- Cuando los llamas desde templates PHP
- Cuando los llamas desde otros componentes Twig

❌ **NO aparecen:**
- Automáticamente en ninguna página
- En el panel de bloques (a menos que uses los bloques de Gutenberg que creamos)
- Por sí solos

---

## Resumen Rápido

**Para usar componentes fácilmente:**
1. Usa shortcodes: `[side_component]`
2. O ve a **Appearance → Components** para ver ejemplos de código
3. O llámalos desde templates PHP con `mcnab_render_twig_component()`

**Para ver qué componentes hay:**
- Ve a **WordPress Admin → Appearance → Components**
