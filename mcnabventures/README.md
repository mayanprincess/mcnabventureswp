# Mcnab - WordPress Theme

A custom WordPress theme for the Genetics Learning Hub, built with modern development practices and the 23andMe brand design system.

## 🤖 IA Component Creation Guide (MOST IMPORTANT)

Lee primero: `IA_COMPONENT_CREATION_GUIDE.md`

## 🚀 Quick Start

### Prerequisites

- [Docker](https://www.docker.com/get-started) installed
- [Node.js](https://nodejs.org/) v18+ installed
- npm or yarn

### 1. Start WordPress with Docker

From the parent directory (`/wp`):

```bash
docker compose up -d
```

This starts:
- **WordPress** at [http://localhost:8080](http://localhost:8080)
- **phpMyAdmin** at [http://localhost:8081](http://localhost:8081)
- **MySQL** database

### 2. Complete WordPress Setup

1. Go to [http://localhost:8080](http://localhost:8080)
2. Complete the WordPress installation wizard
3. Go to **Appearance → Themes** and activate **"Medical 23andMe"**

### 3. Install Theme Dependencies

```bash
cd medical23andme
npm install
```

### 4. Start Development

```bash
npm run sass
```

This watches for changes in `assets/scss/` and compiles to `assets/css/main.css`.

---

## 🚢 Production (Dockerfile)

Tu `docker-compose.yml` actual es **solo para desarrollo local** (usa volumes para que puedas editar el theme/plugins y usar `sass --watch`).

Para producción, usamos **archivos separados** que NO afectan tu flujo local:

- `Dockerfile`: construye una imagen con el theme (CSS compilado) + `vendor/` de Composer + plugins.
- `docker-compose.prod.yml`: levanta WordPress usando la imagen construida (sin montar el theme como volume).
- `wp-config.prod.php`: config de WP para prod usando variables de entorno.
- `prod.env.example`: ejemplo de variables (salts, DB, etc).

### Opción A (recomendada): WordPress PHP-FPM + Nginx

El `docker-compose.prod.yml` usa:

- `wordpress` (PHP-FPM) en el puerto **9000** interno
- `nginx` como web server público en el puerto **80**

Nginx sirve estáticos y envía `.php` a FPM.

### Build + Run (prod)

1. Crea tu archivo de variables (no se commitea normalmente):

```bash
cp prod.env.example prod.env
```

2. Pega tus SALTS en `prod.env` (los generas desde `https://api.wordpress.org/secret-key/1.1/salt/`).

3. Si vas a incluir ACF PRO (u otros plugins privados), colócalos en `./plugins/` antes del build.

4. Construye y levanta:

```bash
docker compose -f docker-compose.prod.yml --env-file prod.env build
docker compose -f docker-compose.prod.yml --env-file prod.env up -d
```

### Nota de volumen

En producción se persiste `/var/www/html` en un volumen compartido entre `wordpress` y `nginx` (ver `docker-compose.prod.yml`).
Esto permite que Nginx sirva estáticos (theme assets, uploads, etc).

---

## 📁 Project Structure

```
medical23andme/
├── assets/
│   ├── css/
│   │   └── main.css          # Compiled CSS (don't edit directly)
│   ├── scss/                 # Source SCSS files
│   │   ├── main.scss         # Main entry point
│   │   ├── abstracts/        # Variables & mixins
│   │   ├── base/             # Reset & typography
│   │   ├── components/       # UI components
│   │   ├── layout/           # Layout styles
│   │   └── utilities/        # Helper classes
│   └── js/
│       └── main.js           # Theme JavaScript
├── template-parts/           # Reusable template parts
├── templates/                # Page templates
├── functions.php             # Theme functions
├── header.php                # Site header
├── footer.php                # Site footer
├── index.php                 # Main template
├── page.php                  # Page template
├── style.css                 # Theme metadata
├── theme.json                # Block editor settings
└── package.json              # NPM dependencies
```

---

## 🎨 Design System

### Brand Colors

| Color | Hex | CSS Variable |
|-------|-----|--------------|
| Periwinkle | `#3595D6` | `$color-periwinkle` |
| Teal | `#00B5B5` | `$color-teal` |
| Green | `#3BA510` | `$color-green` |
| Lime | `#92C746` | `$color-lime` |
| Orange | `#FFBA32` | `$color-orange` |
| Scarlet | `#FF6119` | `$color-scarlet` |
| Pink | `#D50F67` | `$color-pink` |
| Purple | `#9F0F7B` | `$color-purple` |
| Violet | `#6F3598` | `$color-violet` |
| Ultramarine | `#425DBF` | `$color-ultramarine` |
| Gray 7 | `#6B6B6B` | `$color-gray-7` |
| Gray 6 | `#9C9EA1` | `$color-gray-6` |

### Gradients

Available in Gutenberg and as CSS classes:

- `bg-gradient-periwinkle-teal`
- `bg-gradient-green-lime`
- `bg-gradient-pink-scarlet`
- `bg-gradient-purple-pink`
- `bg-gradient-violet-ultramarine`
- `bg-gradient-violet-periwinkle`
- `bg-gradient-rainbow`

---

## 🧩 Components

### Homepage Hero

Add class: `homepageHero`

```
Group (class: homepageHero)
├── Heading (H1)
├── Paragraph
└── YouTube Embed (optional)
```

### Deep-Dives Section

Add class: `Deep-Dives` to the section and `column-card` to each column.

```
Group (class: Deep-Dives)
├── Heading (H2)
├── Paragraph
└── Columns
    ├── Column (class: column-card)
    │   ├── Image (icon)
    │   ├── Heading (H3)
    │   ├── Paragraph
    │   └── Button
    └── ... more columns
```

### Notice Box

Add class: `notice-box`

```
Group (class: notice-box)
├── Heading (H5) - Title
└── Paragraph - Content
```

Variants:
- `notice-box` - Teal (info)
- `notice-box notice-warning` - Orange (warning)
- `notice-box notice-error` - Red (error)

### Subscribe Module

Add class: `subscribe-module`

```
Group (class: subscribe-module)
├── Image (icon)
├── Heading (H3)
├── Paragraph
└── Form or Search block
```

---

## 📜 NPM Scripts

| Command | Description |
|---------|-------------|
| `npm run sass` | Watch mode - auto-compiles SCSS on changes |
| `npm run sass:build` | One-time build for production |
| `npm run dev` | Alias for `npm run sass` |

---

## 🐳 Docker Commands

```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# View logs
docker compose logs -f wordpress

# Restart containers
docker compose restart

# Remove containers and volumes (clean start)
docker compose down -v
```

---

## 📝 WordPress Menus

Register locations in **Appearance → Menus**:

- **Header Menu** - Main navigation
- **Footer Menu** - Footer navigation

---

## 🔧 Development Tips

### Adding a New Component

1. Create `assets/scss/components/_my-component.scss`
2. Add `@use 'components/my-component';` to `main.scss`
3. Run `npm run sass` to compile

### Using Mixins

```scss
@use '../abstracts/variables' as *;
@use '../abstracts/mixins' as *;

.my-class {
  @include flex-center;
  @include card;
  
  @include respond-to('md') {
    // Mobile styles
  }
}
```

### Available Mixins

- `@include flex-center` - Flexbox center
- `@include flex-between` - Flexbox space-between
- `@include full-width` - Break out of container
- `@include card` - Card with hover effect
- `@include button-base` - Base button styles
- `@include respond-to('sm'|'md'|'lg'|'xl')` - Responsive breakpoints

---

## 📄 License

Private - 23andMe Research Institute

---

## 🤝 Support

For questions or issues, contact the development team.
