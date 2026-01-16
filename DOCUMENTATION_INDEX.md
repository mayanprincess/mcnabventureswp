# McNab Ventures - Documentación de Design System

**Índice completo de documentación para desarrollo e integración con Figma MCP**

---

## 📚 Documentos Principales

### 1. **CLAUDE.md** - Quick Reference (COMIENZA AQUÍ)
**Mejor para:** Desarrollo diario, referencia rápida
**Tamaño:** ~800 líneas
**Contenido:**
- Colores y tipografía a un vistazo
- Espaciado y responsive breakpoints
- Componentes principales
- Sistema de nomenclatura CSS
- Mixins frecuentes
- Comandos y recursos

**Cuándo usarlo:** Consultas rápidas durante desarrollo

---

### 2. **DESIGN_SYSTEM_RULES.md** - Documentación Exhaustiva
**Mejor para:** Comprensión profunda, referencia completa
**Tamaño:** ~1500 líneas
**Contenido:**
- Estructura completa del proyecto
- Definición detallada de tokens
- Librería de componentes
- Frameworks & tecnologías
- Sistema de estilos SCSS
- Sistema de iconos & assets
- Patrones de desarrollo
- Convenciones de nomenclatura
- Guía de integración Figma

**Cuándo usarlo:** Cuando necesitas entender profundamente algún aspecto

---

### 3. **IMPLEMENTATION_EXAMPLES.md** - Guías Paso a Paso
**Mejor para:** Aprender con ejemplos prácticos
**Tamaño:** ~900 líneas
**Contenido:**
- Crear nuevos componentes (Twig + SCSS)
- Variantes con BEM
- Responsive design móvil-first
- Utilidades de color
- Animaciones CSS
- Accesibilidad completa
- Grid systems
- ACF field registration
- Bloques Gutenberg
- Patrones Twig
- Debugging

**Cuándo usarlo:** Cuando necesitas implementar algo específico

---

### 4. **FIGMA_DESIGN_SYSTEM_MAP.md** - Sincronización Figma ↔ Código
**Mejor para:** Mapeo de diseños a código
**Tamaño:** ~700 líneas
**Contenido:**
- Mapeo de tokens Figma
- Sistema de colores (hex values)
- Escalas de tipografía
- Sistema de espaciado
- Especificaciones de efectos
- Registry de componentes
- Code Connect proposals
- Responsive specifications
- Workflow de sincronización

**Cuándo usarlo:** Cuando importas diseños de Figma

---

### 5. **.cursor/rules/design_system.mdc** - Cursor IDE Rules
**Mejor para:** Integración con Cursor IDE
**Tamaño:** ~400 líneas
**Contenido:**
- Stack resumido
- Colores y tipografía
- Variables SCSS
- Componentes
- Patrones frecuentes

**Cuándo usarlo:** Automáticamente cargado en Cursor

---

## 🗺️ Flujo de Trabajo Recomendado

### Para Nuevo Desarrollador
1. Lee **CLAUDE.md** (5-10 minutos)
2. Revisa **DESIGN_SYSTEM_RULES.md** secciones 1-5 (15-20 minutos)
3. Consulta **IMPLEMENTATION_EXAMPLES.md** cuando necesites implementar

### Para Implementar un Componente Figma
1. Abre **FIGMA_DESIGN_SYSTEM_MAP.md**
2. Busca si existe el componente
3. Usa **IMPLEMENTATION_EXAMPLES.md** para código
4. Consulta **DESIGN_SYSTEM_RULES.md** para detalles

### Para Depuración
1. **CLAUDE.md** - Checklist rápido
2. **DESIGN_SYSTEM_RULES.md** - Sección "Buenas Prácticas"
3. **IMPLEMENTATION_EXAMPLES.md** - Sección "Debugging"

---

## 🎯 Búsqueda Rápida

### Busco...

**Información sobre colores:**
- Valores hex → `CLAUDE.md` § "Colores"
- Variables SCSS → `DESIGN_SYSTEM_RULES.md` § "2.1 Variables SCSS"
- Uso en diseño → `FIGMA_DESIGN_SYSTEM_MAP.md` § "Color Usage Guidelines"

**Información sobre tipografía:**
- Familias → `CLAUDE.md` § "Tipografía"
- Escala → `DESIGN_SYSTEM_RULES.md` § "2.2 Definición de Tokens"
- Implementación → `IMPLEMENTATION_EXAMPLES.md` § "Typography Patterns"

**Información sobre spacing:**
- Escala → `CLAUDE.md` § "Espaciado"
- Variables → `DESIGN_SYSTEM_RULES.md` § "2.1 Variables SCSS"
- Uso en componentes → `IMPLEMENTATION_EXAMPLES.md` § "Container System"

**Información sobre responsivo:**
- Breakpoints → `CLAUDE.md` § "Responsive"
- Mixins → `DESIGN_SYSTEM_RULES.md` § "5.3 Mixins Principales"
- Ejemplos → `IMPLEMENTATION_EXAMPLES.md` § "Responsive Design Pattern"

**Crear nuevo componente:**
- Paso a paso → `IMPLEMENTATION_EXAMPLES.md` § "1. Crear un Nuevo Componente"
- Reglas CSS → `DESIGN_SYSTEM_RULES.md` § "3.2 Estructura de Componentes"
- Checklist → `FIGMA_DESIGN_SYSTEM_MAP.md` § "Implementation Checklist"

**Integración Figma:**
- Mapeos → `FIGMA_DESIGN_SYSTEM_MAP.md` § "Componentes"
- Code Connect → `FIGMA_DESIGN_SYSTEM_MAP.md` § "Code Connect Mappings"
- Workflow → `FIGMA_DESIGN_SYSTEM_MAP.md` § "Sync Workflow"

**Accesibilidad:**
- Checklist → `CLAUDE.md` § "Accesibilidad"
- Ejemplos → `IMPLEMENTATION_EXAMPLES.md` § "Accesibilidad"
- Guía completa → `DESIGN_SYSTEM_RULES.md` § "7.4 Accesibilidad"

**Animaciones:**
- Tipos → `CLAUDE.md` § "Animaciones"
- Keyframes → `DESIGN_SYSTEM_RULES.md` § "5.4 Animaciones & Transiciones"
- Ejemplos → `IMPLEMENTATION_EXAMPLES.md` § "Animación & Transición"

---

## 📖 Secciones Importantes por Documento

### CLAUDE.md
```
Colores                    (línea ~20-60)
Tipografía                (línea ~65-100)
Espaciado                 (línea ~105-125)
Responsive                (línea ~130-150)
Componentes Principales   (línea ~165-210)
Estructura del Proyecto   (línea ~215-260)
Nomenclatura CSS          (línea ~265-310)
Mixins Frecuentes         (línea ~315-360)
```

### DESIGN_SYSTEM_RULES.md
```
Estructura del Proyecto   (sección 1)
Tokens de Diseño          (sección 2)
Librería de Componentes   (sección 3)
Frameworks & Librerías    (sección 4)
Sistema de Estilos        (sección 5)
Sistema de Iconos         (sección 6)
Patrones de Desarrollo    (sección 7)
Convenciones              (sección 8)
```

### IMPLEMENTATION_EXAMPLES.md
```
Crear Componente          (sección 1)
Variantes BEM             (sección 2)
Responsive Design         (sección 3)
Color Utilities           (sección 4)
Animaciones               (sección 5)
Accesibilidad            (sección 6)
Grid Systems             (sección 7)
Color Adjustments        (sección 8)
ACF Registration         (sección 9)
Gutenberg Blocks         (sección 10)
Patrones Twig            (sección 11)
Debugging                (sección 12)
```

### FIGMA_DESIGN_SYSTEM_MAP.md
```
Color System              (tabla completa)
Typography Scale         (tabla con uso)
Spacing Scale           (tabla con pixeles)
Effects                 (sombras, radio, transiciones)
Component Registry      (mapeo Figma→Código)
Design Patterns         (directrices visuales)
Code Connect Mappings   (propuestas)
Responsive Specs        (breakpoints)
Implementation Checklist (pasos)
Sync Workflow          (proceso)
```

---

## 🔍 Cómo Usar Estos Documentos

### Lectura Secuencial (Recomendada para nuevos)
1. `CLAUDE.md` - Visión general (30 min)
2. `DESIGN_SYSTEM_RULES.md` - Profundidad (45 min)
3. `IMPLEMENTATION_EXAMPLES.md` - Práctica (60 min)
4. `FIGMA_DESIGN_SYSTEM_MAP.md` - Integración (30 min)

### Referencia por Tarea

**Estoy desarrollando un componente nuevo:**
```
1. Abre FIGMA_DESIGN_SYSTEM_MAP.md
2. Busca el componente en "Component Registry"
3. Si no existe, abre IMPLEMENTATION_EXAMPLES.md § 1
4. Sigue el paso a paso
5. Consulta DESIGN_SYSTEM_RULES.md para detalles específicos
```

**Estoy migrando diseños de Figma:**
```
1. Abre FIGMA_DESIGN_SYSTEM_MAP.md
2. Consulta secciones de tokens (Color System, Typography Scale)
3. Mapea los tokens a variables SCSS
4. Abre IMPLEMENTATION_EXAMPLES.md
5. Crea/actualiza componentes
```

**Estoy arreglando un bug de estilos:**
```
1. Abre CLAUDE.md para referencia rápida
2. Localiza la sección relevante (colores, espaciado, etc.)
3. Verifica variables en DESIGN_SYSTEM_RULES.md
4. Busca ejemplos en IMPLEMENTATION_EXAMPLES.md
5. Revisa CLAUDE.md § "Mejores Prácticas"
```

**Estoy optimizando para accesibilidad:**
```
1. Abre IMPLEMENTATION_EXAMPLES.md § 6 "Accesibilidad"
2. Consulta CLAUDE.md § "Accesibilidad"
3. Revisa DESIGN_SYSTEM_RULES.md § "7.4 Accesibilidad"
4. Usa checklist de FIGMA_DESIGN_SYSTEM_MAP.md
```

---

## 🛠️ Herramientas & Recursos

### En Código
- **Variables:** `assets/scss/abstracts/_variables.scss`
- **Mixins:** `assets/scss/abstracts/_mixins.scss`
- **Main:** `assets/scss/main.scss`
- **Theme Config:** `theme.json`
- **Functions:** `functions.php`

### Comandos Útiles
```bash
# Compilar SCSS
npm run sass:build

# Watch mode
npm run sass

# Verificar estructura
find mcnabventures -type f -name "*.scss" | sort
```

### Enlaces Externos
- [WordPress Theme JSON Docs](https://developer.wordpress.org/block-editor/)
- [Timber/Twig Docs](https://timber.github.io/timber/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [BEM Methodology](http://getbem.com/)

---

## 📝 Notas Importantes

### Convenciones Críticas
- **No usar Tailwind** - Proyecto usa SCSS puro
- **Mobile-first** - Empezar móvil, mejorar con breakpoints
- **BEM only** - Nomenclatura consistente en CSS
- **Variables siempre** - No hardcodear valores
- **Accesibilidad desde inicio** - No es opcional

### Stack Específico
- WordPress (Block Editor / Gutenberg)
- Timber (Twig templating)
- SCSS (no Tailwind)
- ACF Pro (campos personalizados)
- Custom Gutenberg blocks

### Validaciones
- Contraste de color ≥ 4.5:1
- Foco visible siempre
- Toque responsive ≥ 44x44px
- Mobile en 375px, 768px, 1024px, 1200px

---

## 🚀 Próximos Pasos

### Para Usar con Figma MCP
1. ✅ Todos los documentos están creados
2. ✅ Mapeos de Code Connect documentados
3. ✅ Tokens totalmente especificados
4. ⏭️ Implementar Code Connect en Figma
5. ⏭️ Sincronizar tokens automáticamente

### Para Mantenimiento
- Actualizar documentación cuando cambien tokens
- Mantener sincronización Figma ↔ Código
- Revisar ejemplos cuando se agreguen componentes
- Validar design system continuamente

---

## 📞 Soporte

### Si necesitas...

**Entender dónde está algo:**
→ Usa `Ctrl+F` en el documento
→ Consulta las secciones de este index

**Crear algo nuevo:**
→ `IMPLEMENTATION_EXAMPLES.md`

**Debuggear algo:**
→ `CLAUDE.md` + `DESIGN_SYSTEM_RULES.md`

**Integrar con Figma:**
→ `FIGMA_DESIGN_SYSTEM_MAP.md`

**Recordar valores (colores, espaciado):**
→ `CLAUDE.md` § "Hoja de Referencia Rápida"

---

## 📊 Estadísticas de Documentación

| Documento | Líneas | Secciones | Ejemplos | Código |
|-----------|--------|-----------|----------|--------|
| CLAUDE.md | ~800 | 12 | + | ✓ |
| DESIGN_SYSTEM_RULES.md | ~1500 | 12 | ++ | ✓✓ |
| IMPLEMENTATION_EXAMPLES.md | ~900 | 12 | +++ | ✓✓✓ |
| FIGMA_DESIGN_SYSTEM_MAP.md | ~700 | 10 | + | ✓ |
| **.cursor/design_system.mdc** | ~400 | 15 | | ✓ |
| **TOTAL** | **~4300** | **61** | | **Completo** |

---

## 📅 Versión & Mantenimiento

**Versión:** 1.0
**Fecha:** Enero 2026
**Proyecto:** McNab Ventures WordPress Theme v0.1.0
**Stack:** WordPress + Timber + SCSS + ACF Pro
**Última Actualización:** Enero 16, 2026

---

**Created with ❤️ for McNab Ventures Design System**
**Ready for Figma MCP Integration**
