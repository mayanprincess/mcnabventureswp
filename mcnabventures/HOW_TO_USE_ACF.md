# Cómo Usar ACF con Componentes

## Configuración Automática

Los campos ACF se crean **automáticamente** basados en los componentes registrados. No necesitas configurar nada manualmente.

## Cómo Funciona

### 1. **Los Campos Aparecen Automáticamente**

Cuando editas una **Página** en WordPress, verás:

**En el panel derecho (Sidebar):**
- **"Page Component Settings"** - Selector para elegir qué componente usar
- Selecciona: "Side Component", "Hero Component", o "Accordion Component"

**En el editor principal:**
- Aparecerán los campos del componente seleccionado
- Por ejemplo, si seleccionas "Side Component", verás:
  - Badge Text
  - Title Part 1
  - Title Highlight
  - Description
  - Logo (selector de imagen)

### 2. **Uso Automático**

Una vez que seleccionas un componente y llenas los campos:

**Opción A: Auto-render (Automático)**
- El componente se muestra automáticamente arriba del contenido de la página
- No necesitas hacer nada más

**Opción B: Manual con Shortcode**
- Usa el shortcode: `[side_component]`
- Lee automáticamente los campos ACF que llenaste

**Opción C: Desde Template PHP**
```php
<?php mcnab_render_twig_component('side-component'); ?>
// Lee automáticamente los campos ACF
```

## Paso a Paso: Usar ACF en una Página

### Paso 1: Crear/Editar una Página

1. Ve a **Pages → Add New** (o edita una existente)
2. En el panel derecho, busca **"Page Component Settings"**
3. Selecciona el componente que quieres usar (ej: "Side Component")

### Paso 2: Llenar los Campos

Los campos aparecerán automáticamente en el editor:

**Para Side Component:**
- **Badge Text**: "WHO WE ARE"
- **Title Part 1**: "Experience crystal-clear waters..."
- **Title Highlight**: "Mayan Princess Beach & Dive Resort."
- **Description**: "As a proud member..."
- **Logo**: Haz clic para seleccionar una imagen

### Paso 3: Ver el Resultado

**Opción A: Automático**
- El componente se muestra automáticamente arriba del contenido
- Solo publica la página

**Opción B: Con Shortcode**
- En el contenido de la página, escribe: `[side_component]`
- El shortcode leerá los campos ACF automáticamente

## Asignar a Tipos de Página Específicos

Si quieres que los campos aparezcan solo en ciertos tipos de página, edita `inc/acf-fields.php`:

```php
'location' => [
  [
    [
      'param' => 'page_template',
      'operator' => '==',
      'value' => 'page-homepage.php', // Solo en homepage template
    ],
  ],
],
```

O para múltiples templates:

```php
'location' => [
  [
    [
      'param' => 'page_template',
      'operator' => '==',
      'value' => 'page-homepage.php',
    ],
  ],
  [
    [
      'param' => 'page_template',
      'operator' => '==',
      'value' => 'page-about.php',
    ],
  ],
],
```

## Campos Disponibles por Componente

### Side Component
- `badge` (text)
- `title_part1` (text)
- `title_highlight` (text)
- `description` (textarea)
- `logo` (image)

### Hero Component
- `title` (text)
- `subtitle` (text)
- `button_text` (text)
- `button_url` (url)
- `background_image` (image)

### Accordion Component
- `title` (text)
- `items` (repeater)
  - `title` (text)
  - `content` (wysiwyg)

## Ver Campos en el Editor

1. **Edita cualquier página**
2. **Panel derecho** → "Page Component Settings" → Selecciona componente
3. **Los campos aparecen automáticamente** en el editor principal
4. **Llena los campos**
5. **Publica** - El componente se muestra automáticamente

## Troubleshooting

**No veo los campos:**
- Asegúrate de tener ACF instalado y activo
- Verifica que `inc/acf-fields.php` esté cargado en `functions.php`
- Recarga la página de edición

**Los campos no se guardan:**
- Verifica permisos de usuario
- Revisa que ACF esté correctamente instalado

**El componente no aparece:**
- Verifica que hayas seleccionado un componente en "Page Component Settings"
- Revisa que los campos estén llenos
- Usa el shortcode `[side_component]` si el auto-render no funciona
