# Componente Multimedia - Documentación

## 📋 Descripción
Componente galería multimedia con:
- **Tabs de filtrado** (Fotos/Videos)
- **Grid responsivo** (4 columnas desktop, 2 tablet, 1 móvil)
- **Carrusel con paginación** (dots + botones anterior/siguiente)
- **Botón play** para reproducir videos
- **Animaciones suaves** con transiciones CSS

## 📁 Archivos Generados

```
mcnabventures/
├── views/components/multimedia.twig          ← Plantilla Twig
├── assets/scss/components/_multimedia.scss   ← Estilos SCSS
├── assets/js/multimedia.js                   ← Lógica interactiva
└── inc/components-registry.php               ← Registrado en componentes
```

## 🎨 Uso

### En WordPress Admin
El componente está registrado y disponible en: **Tema → Componentes → Multimedia**

### Via Shortcode
```
[multimedia]
```

### Via PHP
```php
mcnab_render_twig_component('multimedia');
```

### Con Variables Twig
```twig
{% include 'components/multimedia.twig' with {
  title: 'Nuestros Momentos',
  tabs: [
    {
      name: 'Fotos',
      gallery_type: 'gallery',
      gallery: [
        { ID: 1, url: '/images/photo1.jpg', alt: 'Descripción 1' },
        { ID: 2, url: '/images/photo2.jpg', alt: 'Descripción 2' }
      ]
    },
    {
      name: 'Videos',
      gallery_type: 'videos',
      videos: [
        { video_url: '/videos/video1.mp4', video_title: 'Video 1' },
        { video_url: '/videos/video2.mp4', video_title: 'Video 2' }
      ]
    }
  ],
  itemsPerPage: 4
} %}
```

## 🎛️ Configuración en ACF

Los siguientes campos están disponibles en WordPress:

### 1. **Título de Sección** (text)
- Label: "Section Title"
- Default: "Multimedia"

### 2. **Multimedia Tabs** (repeater)
Cada tab puede ser una galería de fotos O una galería de videos.

Sub-campos:
- **name** (text): Nombre del tab (e.g., "Fotos", "Videos", "Behind the Scenes")
- **gallery_type** (select): Tipo de galería
  - `gallery` → Galería de fotos (campo gallery)
  - `videos` → Galería de videos (repeater con URLs)

**Si gallery_type = "gallery":**
- **gallery** (gallery): Selector de imágenes en WordPress
  - Upload o selecciona imágenes del media library
  - Soporta multi-select
  - Muestra vista previa

**Si gallery_type = "videos":**
- **videos** (repeater): Lista de videos
  - **video_url** (url): URL del video (requerido)
  - **video_title** (text): Título/descripción del video (opcional)

### 3. **Items por Página** (number)
- Label: "Items Per Carousel Page"
- Default: 4
- Aplica a todos los tabs

## 🎯 Características

### Desktop (≥1024px)
- Grid: 4 columnas × 3 filas
- Altura fija: 648px
- Primer item: 2×2 (grande)
- Espacio: 16px gap

### Tablet (768-1023px)
- Grid: 3 columnas
- Altura: 500px
- Items ocultos: 4-8
- Espacio: 8px gap

### Mobile (<768px)
- Grid: 1-2 columnas (stacked)
- Altura: auto
- Espaciado: 8px

## ⚙️ Funcionalidades JavaScript

### Tabs
- Cambiar entre Fotos y Videos
- Reset de paginación al cambiar tab
- Interfaz activa/inactiva

### Carrusel
- Navegación por dots
- Botones anterior/siguiente
- Deshabilitación automática en extremos
- Soporte para teclado (← →)

### Responsive
- Ajuste automático de items por página
- Reinicio de paginación en resize
- Grid responsivo CSS

### Accesibilidad
- ARIA labels en botones
- Focus visible en navegación
- Atributos ARIA-disabled
- Soporte para navegación por teclado

## 🎨 Diseño System Compliance

### Colores
- **Primario**: Navy (#0E5573) - Título, tabs activos
- **Acento**: Gold (#C9A441) - Dot activo
- **Fondo**: Sand (#C9C5B8) - Botones nav

### Tipografía
- **Título**: Literata Light, 45px (base), responsive
- **Tabs**: Fustat ExtraBold, 16px

### Espaciado
- Gap grid: 16px (desktop) / 8px (tablet/mobile)
- Padding play button: 16px
- Margin controls: 8px-16px

### Efectos
- Border-radius: 24px (items), 18px (play btn), 4px (dots)
- Transiciones: 250ms ease (base)
- Sombras: sm (hover buttons)

## 📱 Breakpoints Usados

```scss
// Mobile-first approach
$breakpoint-md: 768px   // Tablet
$breakpoint-lg: 1024px  // Desktop
$breakpoint-xl: 1200px  // Desktop ancho
```

## 🔧 Personalización

### Cambiar items por página (Desktop)
Editar en `_multimedia.scss`:
```scss
&__gallery {
  grid-template-columns: repeat(4, 1fr);  // ← cambiar aquí
  grid-template-rows: repeat(3, 1fr);
}
```

### Cambiar colores
Usar variables SCSS en `_variables.scss`:
```scss
$color-primary     // Titles
$color-accent      // Active dot
$color-sand        // Nav buttons
```

### Añadir más tabs
En ACF Repeater "Tab Filters" simplemente añadir más items.

## 🐛 Troubleshooting

### Los items no se muestran
1. Verificar que `data-multimedia` está en el contenedor
2. Verificar que `data-gallery` está en la galería
3. Verificar URLs de imágenes son válidas

### Paginación no funciona
1. Verificar que `multimedia.js` está cargado
2. Comprobar console por errores JavaScript
3. Verificar que itemsPerPage > 0

### Tabs no cambian contenido
1. Verificar que `data-tab` coincide con el tipo de item
2. Revisar filtrado en JavaScript

## 📝 Notas

- El componente es **totalmente responsive** sin necesidad de Tailwind
- Usa **CSS Grid nativo** para layout flexible
- **Sin dependencias externas** (solo vanilla JS)
- Soporta **prefers-reduced-motion** para accesibilidad
- Compatible con **WordPress ACF** para gestión de contenido

## 📞 Integración con Figma

Este componente fue generado del diseño Figma:
https://www.figma.com/design/njSel4MX5BvhsK2sfatkG0/McNab-Ventures-Website?node-id=334-1646

Mantiene fidelidad visual 1:1 con el diseño original.

---

**Última actualización**: Enero 2026
**Versión**: 1.0.0
**Estado**: Producción Ready ✓
