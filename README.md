# WPThene (McNab Ventures)

Este repo contiene:
- WordPress en Docker para **desarrollo local**
- Theme `mcnabventures/` usando **ACF Pro (Flexible Content) + Timber + Twig**
- Guía principal para crear componentes (para entrenar la IA)

## 🤖 IA Component Creation Guide (MOST IMPORTANT)

Lee primero: `IA_COMPONENT_CREATION_GUIDE.md`

## 🧑‍💻 DEV (Local)

### 1) Levantar WordPress

En el root del repo:

```bash
docker compose up -d
```

Luego abre:
- `http://localhost:8080` (WordPress)
- `http://localhost:8081` (phpMyAdmin)

### 2) Instalar dependencias del theme

Entra al directorio del theme e instala Composer y Node:

```bash
cd mcnabventures
composer install
npm install
```

Esto instala:
- **Timber** (templating engine con Twig)
- **Node dependencies** (Sass compiler, etc.)

### 3) Compilar estilos (Sass watch)

En otra terminal dentro de `mcnabventures/`:

```bash
npm run sass
```

Esto deja un watch corriendo que compila:
- `assets/scss/` → `assets/css/`

## 🧩 Crear un componente (mini resumen)

La guía completa está en `IA_COMPONENT_CREATION_GUIDE.md`. Resumen rápido:

1. Registra el componente en `mcnabventures/inc/components-registry.php`
2. Crea el template Twig en `mcnabventures/views/components/<slug>.twig`
3. Crea estilos en `mcnabventures/assets/scss/components/_<slug>.scss` y lo importas en `mcnabventures/assets/scss/main.scss`
4. Si necesita interacción, agrega JS en `mcnabventures/assets/js/main.js` usando `data-*`
5. Compila CSS: `npm run sass:build` (o deja `npm run sass` corriendo)

