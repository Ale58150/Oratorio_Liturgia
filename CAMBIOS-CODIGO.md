# Historial de cambios de código realizados en este proyecto

Este documento explica, archivo por archivo, todos los cambios de código que se hicieron durante el proceso de intentar desplegar el proyecto (primero en Vercel + Railway, y los que quedaron finales para Hostinger). Está pensado para que cualquiera pueda entender **qué se cambió y por qué**, sin tener que revisar el historial de Git.

---

## Resumen del estado final

Después de decidir usar Hostinger en vez de Vercel, se **revirtieron** los cambios que sólo tenían sentido para Vercel (variables de entorno, configuración de rutas, CI/CD), dejando el código otra vez simple: con las credenciales de la base de datos escritas directamente en el código, como estaba al principio. Ese es el estado en el que queda el proyecto ahora. Los cambios que sí quedan de forma permanente son mínimos y se explican al final.

---

## 1. Archivos de conexión a la base de datos

Hay 3 archivos que se conectan directamente a MySQL con `mysqli`:

- `servidor/conexionBD.php`
- `servidor/sacramentos_db.php`
- `servidor/Formulario_Inscripcion.php`

### Cambio hecho (para Vercel)

Originalmente, los 3 archivos tenían la dirección del servidor, usuario, contraseña y nombre de la base **escritos directamente en el código** (por ejemplo `"localhost", "root", "1234", "oratorio"`). Como Vercel no tiene una base de datos en "localhost" (cada despliegue es efímero y corre en otro servidor), había que poder cambiar esos datos sin tocar el código cada vez. Se modificaron para leer esos valores desde **variables de entorno**, con el valor original como respaldo si la variable no existe:

```php
$servername = getenv('DB_HOST') ?: 'localhost';
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASS') ?: '1234';
$dbname     = getenv('DB_NAME') ?: 'oratorio';
$dbport     = getenv('DB_PORT') ?: 3306;

$conexion = new mysqli($servername, $username, $password, $dbname, $dbport);
```

`getenv('DB_HOST') ?: 'localhost'` significa: "leé la variable de entorno `DB_HOST`; si no existe o está vacía, usá `'localhost'`". Esto permitía que el código local (en tu XAMPP/Laragon) siguiera funcionando exactamente igual que antes (sin esas variables configuradas, usa los valores de respaldo), mientras que en Vercel sí se configuraban esas variables con los datos de Railway.

También se agregó el parámetro de **puerto** (`$dbport`), porque Railway usa un puerto distinto al 3306 estándar de MySQL (en este caso, `59667`).

### Estado actual (revertido para Hostinger)

Se volvió a la versión simple original, con los datos escritos directamente:

```php
$conexion = new mysqli("localhost", "root", "1234", "oratorio");
```

Esto es lo correcto para un hosting tradicional como Hostinger, donde no hace falta variables de entorno — simplemente hay que reemplazar `"localhost", "root", "1234", "oratorio"` por los datos reales que te da Hostinger. Ver `DEPLOY-HOSTINGER.md` para el detalle de qué reemplazar y dónde.

---

## 2. `vercel.json` (creado y luego eliminado)

Archivo de configuración que le decía a Vercel cómo desplegar el proyecto. Pasó por dos versiones:

**Versión 1** (formato moderno, no funcionó):
```json
{
  "functions": {
    "**/*.php": { "runtime": "vercel-php@0.7.4" }
  },
  "rewrites": [
    { "source": "/", "destination": "/cliente/PaginaInicio.php" }
  ]
}
```

**Versión 2** (formato legacy, la que sí funcionó para el build):
```json
{
  "builds": [
    { "src": "**/*.php", "use": "vercel-php@0.7.4" },
    { "src": "css/**", "use": "@vercel/static" },
    { "src": "js/**", "use": "@vercel/static" },
    { "src": "portafolio/**", "use": "@vercel/static" }
  ],
  "routes": [
    { "src": "^/$", "dest": "/cliente/PaginaInicio.php" },
    { "src": "/(.*)", "dest": "/$1" }
  ]
}
```

**Estado actual**: este archivo **fue eliminado** del proyecto, porque Hostinger no usa `vercel.json` para nada — es específico de Vercel.

---

## 3. `.github/workflows/deploy.yml` (creado y luego eliminado)

Archivo de configuración de **GitHub Actions**, que automatizaba el despliegue a Vercel cada vez que se hacía `push` a la rama `main`, usando un token de API en vez de depender de la identidad del autor del commit (ver `DEPLOY-VERCEL-RAILWAY.md`, sección "Error 2", para el contexto completo de por qué hizo falta esto).

**Estado actual**: este archivo (y la carpeta `.github/`) **fueron eliminados**, porque ya no se despliega a Vercel.

---

## 4. `index.php` en la raíz del proyecto (se mantiene)

Antes de este cambio, el proyecto no tenía ningún archivo en la raíz — la página de inicio real está en `cliente/PaginaInicio.php`. Se agregó este archivo:

```php
<?php
header("Location: cliente/PaginaInicio.php");
exit;
```

Esto hace que, al entrar a la URL raíz del sitio (por ejemplo `tudominio.com/`), el navegador sea redirigido automáticamente a la página de inicio real. **Este archivo se mantiene** porque es útil independientemente del hosting (Vercel, Hostinger, o cualquier otro): cualquier servidor Apache/LiteSpeed busca automáticamente un `index.php` en la carpeta raíz.

---

## 5. `.gitignore` (se mantiene)

Este proyecto no tenía ningún archivo `.gitignore` antes. Se creó uno para evitar subir accidentalmente al repositorio archivos que contienen contraseñas u otra información sensible:

```
.env
.env.local
.vercel
```

- `.env` / `.env.local`: archivos que en algún momento contuvieron las credenciales de la base de datos de Railway. Nunca llegaron a subirse al repositorio gracias a este archivo (se verificó revisando todo el historial de Git).
- `.vercel`: carpeta que genera automáticamente la herramienta de línea de comandos de Vercel al conectar el proyecto local con uno en la nube.

**Este archivo se mantiene** aunque ya no se use Vercel, porque es buena práctica general no subir archivos `.env` con contraseñas al repositorio, sin importar qué hosting se use.

---

## 6. Archivo `.env` (temporal, nunca se subió al repositorio)

Se creó un archivo `.env` local (ignorado por Git) con las credenciales de conexión a la base de datos de Railway, solo para poder cargarlas rápido en el formulario de Vercel usando el botón "Import .env". No forma parte del código del proyecto ni se sube a ningún lado.
