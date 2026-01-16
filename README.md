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

### 2) Configurar WordPress (primera vez)

Si es la primera vez que levantas el proyecto, necesitas configurar WordPress:

1. **Completa la instalación de WordPress**
   - Abre `http://localhost:8080`
   - Completa el wizard de instalación (idioma, título del sitio, usuario admin, etc.)

2. **Subir e instalar ACF Pro**
   - Ve a `Plugins` → `Add New` → `Upload Plugin`
   - Sube el archivo `advanced-custom-fields-pro-main.zip` que está en el **root** del proyecto
   - Haz click en "Install Now" y luego en "Activate Plugin"

3. **Activar el theme McNab Ventures**
   - Ve a `Appearance` → `Themes`
   - Activa el theme **"McNab Ventures"**

### 3) Instalar dependencias del theme

Entra al directorio del theme e instala Composer y Node:

```bash
cd mcnabventures
composer install
npm install
```

Esto instala:
- **Timber** (templating engine con Twig)
- **Node dependencies** (Sass compiler, etc.)

### 4) Compilar estilos (Sass watch)

En otra terminal dentro de `mcnabventures/`:

```bash
npm run sass
```

Esto deja un watch corriendo que compila:
- `assets/scss/` → `assets/css/`

## 📋 Información útil

### Credenciales por defecto

**MySQL (phpMyAdmin):**
- Usuario: `root`
- Password: `root_pass`
- Database: `wordpress`

**WordPress Database:**
- Usuario: `wordpress`
- Password: `wordpress_pass`

### Puertos

- WordPress: `http://localhost:8080`
- phpMyAdmin: `http://localhost:8081`

*Puedes cambiar los puertos creando un archivo `.env` en el root:*
```env
WP_PORT=8080
PMA_PORT=8081
```

### Comandos útiles Docker

```bash
# Ver logs de WordPress
docker compose logs wordpress --tail=50 -f

# Reiniciar contenedores
docker compose restart

# Detener todo
docker compose down

# Detener y borrar volúmenes (⚠️ borra la DB)
docker compose down -v
```

## 📁 Estructura del proyecto

```
mcnabventureswp/
├── docker-compose.yml                      # Configuración Docker
├── custom-php.ini                          # Configuración PHP (upload limits, etc.)
├── advanced-custom-fields-pro-main.zip     # Plugin ACF Pro (subir en WP Admin)
├── plugins/                                # WordPress plugins adicionales
├── mcnabventures/                          # Theme principal
│   ├── inc/
│   │   ├── components-registry.php  # Registro de componentes
│   │   ├── acf-fields.php          # ACF Flexible Content config
│   │   ├── timber-setup.php        # Timber/Twig config
│   │   └── gutenberg-blocks.php    # Gutenberg integration
│   ├── views/
│   │   └── components/             # Templates Twig (.twig)
│   ├── assets/
│   │   ├── scss/                   # Estilos Sass
│   │   ├── css/                    # CSS compilado
│   │   └── js/                     # JavaScript
│   ├── functions.php               # Theme setup
│   ├── composer.json               # Timber dependency
│   └── package.json                # Node/Sass tools
└── IA_COMPONENT_CREATION_GUIDE.md  # Guía para crear componentes
```

## 🧩 Crear un componente (mini resumen)

La guía completa está en `IA_COMPONENT_CREATION_GUIDE.md`. Resumen rápido:

1. Registra el componente en `mcnabventures/inc/components-registry.php`
2. Crea el template Twig en `mcnabventures/views/components/<slug>.twig`
3. Crea estilos en `mcnabventures/assets/scss/components/_<slug>.scss` y lo importas en `mcnabventures/assets/scss/main.scss`
4. Si necesita interacción, agrega JS en `mcnabventures/assets/js/main.js` usando `data-*`
5. Compila CSS: `npm run sass:build` (o deja `npm run sass` corriendo)

