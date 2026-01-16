# Ejemplo de Uso - Componente Multimedia

## Configuración en WordPress Admin

### Opción 1: Galería con Photos y Videos

#### Tab 1: "Photos" (Galería de Fotos)
```
Tab Name: Photos
Gallery Type: Photo Gallery (Upload/Select images)
Photo Gallery: [Selecciona imágenes del media library]
  - Imagen 1: TagAirlines-team.jpg
  - Imagen 2: Airport-group.jpg
  - Imagen 3: Passenger.jpg
  - Imagen 4: Lounge.jpg
  - Imagen 5: Check-in.jpg
  - Imagen 6: Flight-crew.jpg
  - Imagen 7: Cabin.jpg
  - Imagen 8: Service.jpg
```

#### Tab 2: "Videos" (Galería de Videos)
```
Tab Name: Videos
Gallery Type: Video Gallery (Add video URLs)
Videos (Repeater):
  - Video 1:
    - Video URL: https://yourdomain.com/videos/airport-tour.mp4
    - Video Title: Airport Tour
  - Video 2:
    - Video URL: https://yourdomain.com/videos/flight-experience.mp4
    - Video Title: Flight Experience
  - Video 3:
    - Video URL: https://yourdomain.com/videos/customer-testimonial.mp4
    - Video Title: Customer Testimonial
```

### Opción 2: Múltiples Galerías de Fotos

#### Tab 1: "Company"
```
Tab Name: Company
Gallery Type: Photo Gallery (Upload/Select images)
Photo Gallery: [Imágenes de la empresa]
```

#### Tab 2: "Destinations"
```
Tab Name: Destinations
Gallery Type: Photo Gallery (Upload/Select images)
Photo Gallery: [Imágenes de destinos]
```

#### Tab 3: "Behind the Scenes"
```
Tab Name: Behind the Scenes
Gallery Type: Photo Gallery (Upload/Select images)
Photo Gallery: [Imágenes del backstage]
```

---

## Flujo en WordPress Admin

### Paso 1: Crear el Componente
1. Accede a **Tema → Componentes → Multimedia**
2. Verás la interfaz del componente

### Paso 2: Configurar Título
```
Section Title: "Multimedia"
```

### Paso 3: Añadir Tabs
Haz clic en "+ Añadir fila" bajo "Multimedia Tabs"

Para cada tab:
1. Especifica el nombre (e.g., "Photos")
2. Selecciona Gallery Type:
   - **Photo Gallery** → Se mostrará campo `gallery` (selector de imágenes)
   - **Video Gallery** → Se mostrará repeater `videos` (URLs)

### Paso 4: Galería de Fotos (si seleccionaste Photo Gallery)
- Haz clic en "Select Gallery"
- Elige imágenes del media library
- Las imágenes aparecerán en orden

### Paso 5: Galería de Videos (si seleccionaste Video Gallery)
- Haz clic en "+ Añadir fila"
- Ingresa URL del video y (opcionalmente) título
- Repite para cada video

### Paso 6: Items por Página
```
Items Per Carousel Page: 4
```

### Paso 7: Guardar
Haz clic en "Guardar"

---

## Comportamiento en Frontend

### Desktop (≥1024px)
- **4 columnas × 3 filas** = 12 items por página
- Primer item (foto): 2×2 (grande)
- Botón play en esquina inferior derecha
- Paginación con dots y botones anterior/siguiente

### Tablet (768-1023px)
- **3 columnas × 3 filas** = 9 items por página
- Items 4-12 se ocultan
- Grid responsive

### Mobile (<768px)
- **1-2 columnas** (stacked)
- Altura automática
- Botones de navegación grandes (touch-friendly)

---

## Ejemplos de Cambio de Tab

### Click en "Videos" Tab
1. Galería de fotos desaparece (fade out)
2. Galería de videos aparece (fade in)
3. Paginación se recalcula para videos
4. Dots se regeneran
5. Botones anterior/siguiente se actualizan

### Las Imágenes/Videos se Ocultan
- Los videos con `data-item-type="video"` tienen botón play
- Las imágenes con `data-item-type="image"` muestran icono "+"

---

## Personalización Avanzada

### Cambiar Cantidad de Items por Página
En ACF: "Items Per Carousel Page: 6" → Cambia a 6 items por página

### Añadir Más Tabs
Simplemente añade más filas en el repeater "Multimedia Tabs"

### Cambiar Breakpoints
Editar en `_multimedia.scss`:
```scss
$breakpoint-md: 768px   // Tablet
$breakpoint-lg: 1024px  // Desktop
```

---

## Casos de Uso

### Caso 1: Portafolio Mixto
```
- Tab 1: "Photos" → Imágenes del proyectos
- Tab 2: "Time-lapse" → Videos del progreso
- Tab 3: "Behind the Scenes" → Imágenes del equipo
```

### Caso 2: Eventos
```
- Tab 1: "Moments" → Fotos del evento
- Tab 2: "Testimonials" → Videos de testimonios
```

### Caso 3: Productos
```
- Tab 1: "Gallery" → Imágenes del producto
- Tab 2: "Demos" → Videos de demostración
- Tab 3: "Reviews" → Fotos de clientes
```

---

## Troubleshooting

### Las imágenes no aparecen
✓ Verifica que las imágenes fueron agregadas al campo gallery
✓ Verifica que el media library tiene las imágenes

### Los videos no reproducen
✓ Verifica que las URLs son válidas
✓ Verifica que el servidor permite video embeds
✓ Prueba con formato .mp4 (más compatible)

### No se ven los tabs
✓ Verifica que hay más de 1 tab
✓ Si solo hay 1 tab, los tabs no se muestran

### Las paginaciones no funcionan
✓ Verifica que multimedia.js está cargado
✓ Comprueba console por errores JavaScript

---

## Notas Importantes

1. **Gallery Field (ACF)** - Soporte para multi-select de imágenes
2. **Videos repeater** - URL requerida, título opcional
3. **Responsive** - Funciona automáticamente en todos los tamaños
4. **Sin plugins externos** - Solo WordPress + ACF
5. **Accesibilidad** - ARIA labels + navegación por teclado

---

**Última actualización**: Enero 2026
**Versión**: 2.0 (Campos dinámicos)
