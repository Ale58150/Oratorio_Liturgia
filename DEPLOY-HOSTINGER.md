# Cómo desplegar este proyecto en Hostinger — guía paso a paso

Esta guía explica, desde cero, qué hay que hacer para poner este sitio (y su base de datos) a funcionar en Hostinger. Está pensada para alguien sin experiencia previa con hosting web.

A diferencia de Vercel, Hostinger es un **hosting tradicional**: tenés un servidor que está prendido todo el tiempo, con PHP y MySQL instalados de forma nativa. Esto significa que **no hace falta** ningún archivo de configuración especial (como el `vercel.json` que se usó para Vercel), ni variables de entorno, ni herramientas de línea de comandos — simplemente subís los archivos y listo.

---

## Paso 1 — Contratar un plan de hosting

1. Entrá a [hostinger.com](https://hostinger.com) y elegí un plan de **"Web Hosting"** (no hace falta VPS ni Cloud, cualquier plan compartido alcanza — el más básico ya incluye PHP y MySQL con phpMyAdmin).
2. Completá la compra y esperá a que Hostinger te dé acceso al **hPanel** (el panel de control donde se administra todo).
3. Si todavía no tenés un dominio (ej. `oratorioyliturgia.com`), Hostinger te va a ofrecer registrar uno durante la compra, o podés usar un subdominio temporal que te asignan gratis mientras tanto.

---

## Paso 2 — Crear la base de datos en Hostinger

1. Entrá al **hPanel** de tu hosting.
2. Buscá la sección **Bases de datos** → **Bases de datos MySQL** (en inglés: "Databases" → "MySQL Databases").
3. Creá una base de datos nueva. Hostinger te va a pedir un nombre — poné algo como `oratorio` (Hostinger le va a agregar automáticamente un prefijo, por ejemplo `u123456789_oratorio`).
4. Creá un usuario para esa base de datos y una contraseña (elegí una contraseña segura y anotala en un lugar seguro).
5. Anotá estos 4 datos, los vas a necesitar en el Paso 4:
   - **Nombre de la base de datos** (con el prefijo, ej. `u123456789_oratorio`)
   - **Usuario** (ej. `u123456789_admin`)
   - **Contraseña** (la que elegiste)
   - **Host**: en Hostinger casi siempre es `localhost` (porque la base de datos vive en el mismo servidor que tu sitio web)

---

## Paso 3 — Importar tu base de datos local a Hostinger

Necesitás pasar los datos de tu base de datos local (la de tu XAMPP/Laragon) a la de Hostinger.

### 3.1. Exportar tu base de datos local

Si todavía no tenés el archivo `.sql` exportado, desde una terminal en tu computadora (con tu MySQL local corriendo) corré:

```bash
mysqldump -u root -p oratorio > oratorio.sql
```

Te va a pedir la contraseña de tu MySQL local. Esto genera un archivo `oratorio.sql` con toda la estructura y los datos de tu base local.

### 3.2. Importar ese archivo en Hostinger usando phpMyAdmin

1. En el hPanel, en la sección de bases de datos, buscá el botón **phpMyAdmin** (al lado de la base de datos que creaste en el Paso 2) y hacé click.
2. Se abre phpMyAdmin (una herramienta visual para administrar MySQL). En el menú de la izquierda, seleccioná tu base de datos.
3. Andá a la pestaña **Importar** (en inglés: "Import").
4. Click en **Seleccionar archivo** (o "Choose file") y elegí el `oratorio.sql` que generaste en el paso anterior.
5. Click en **Continuar** / **Go**, al final de la página.
6. Cuando termine, en el menú de la izquierda vas a ver aparecer todas tus tablas (`personas`, `usuarios`, `actividades`, etc.) — eso confirma que se importó bien.

---

## Paso 4 — Editar el código con los datos reales de Hostinger

Hay que reemplazar los datos de conexión a la base de datos en **3 archivos**, poniendo los datos reales que anotaste en el Paso 2 en vez de los valores de ejemplo (`localhost`, `root`, `1234`, `oratorio`).

### 4.1. `servidor/conexionBD.php`

Buscá esta línea:
```php
$conexion = new mysqli("localhost", "root", "1234", "oratorio");
```

Y reemplazala por (con tus datos reales):
```php
$conexion = new mysqli("localhost", "u123456789_admin", "TU_CONTRASEÑA", "u123456789_oratorio");
```

### 4.2. `servidor/sacramentos_db.php`

Buscá estas líneas:
```php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "oratorio";
```

Y reemplazalas por:
```php
$servername = "localhost";
$username = "u123456789_admin";
$password = "TU_CONTRASEÑA";
$dbname = "u123456789_oratorio";
```

### 4.3. `servidor/Formulario_Inscripcion.php`

Buscá estas líneas:
```php
$host = "localhost";
$usuario = "root";
$password = "1234";
$bd = "oratorio";
```

Y reemplazalas por:
```php
$host = "localhost";
$usuario = "u123456789_admin";
$password = "TU_CONTRASEÑA";
$bd = "u123456789_oratorio";
```

> **Importante**: el `"localhost"` en los 3 archivos normalmente **no hay que cambiarlo**, porque en Hostinger la base de datos vive en el mismo servidor que tu sitio. Solo cambiá usuario, contraseña y nombre de la base de datos por los reales que te dio Hostinger en el Paso 2.

---

## Paso 5 — Subir los archivos del proyecto a Hostinger

Hay dos formas de hacerlo — elegí la que te resulte más cómoda.

### Opción A: File Manager (más simple, no requiere instalar nada)

1. En el hPanel, buscá **Administrador de archivos** (en inglés "File Manager").
2. Entrá a la carpeta `public_html` — esa es la carpeta que Hostinger sirve como la raíz de tu sitio web.
3. Subí **todo el contenido** de la carpeta del proyecto (`cliente/`, `css/`, `js/`, `portafolio/`, `servidor/`, `index.php`, etc.) dentro de `public_html`. Si tu ZIP contiene todo el proyecto dentro de una carpeta madre, primero subí el `.zip`, usá la opción **Extraer** (Extract) del File Manager, y después movés el contenido para que quede directo dentro de `public_html` (no dentro de una subcarpeta extra).

### Opción B: FTP (con un programa como FileZilla)

1. En el hPanel, buscá los datos de acceso **FTP** (host, usuario, contraseña, puerto — normalmente el puerto es 21).
2. Descargá e instalá [FileZilla](https://filezilla-project.org/) (es gratis).
3. Conectate con esos datos y arrastrá los archivos del proyecto desde tu computadora hacia la carpeta `public_html` del servidor.

---

## Paso 6 — Probar que funciona

1. Entrá a tu dominio (o al subdominio temporal que te dio Hostinger) desde el navegador: `https://tudominio.com`. Debería redirigirte automáticamente a la página de inicio (gracias al `index.php` que redirige a `cliente/PaginaInicio.php`).
2. Probá el login en `https://tudominio.com/cliente/login.php`.
3. Si algo no conecta a la base de datos, revisá:
   - Que el usuario/contraseña/nombre de base de datos en los 3 archivos PHP coincidan exactamente con los que te dio Hostinger (Paso 2).
   - Que hayas subido **todos** los archivos, incluyendo la carpeta `servidor/` completa.

---

## Diferencias clave respecto a lo que se intentó con Vercel

- **No hace falta** ningún archivo `vercel.json`, ni runtimes especiales, ni GitHub Actions: PHP corre nativamente en el servidor de Hostinger.
- **No hace falta** variables de entorno: las credenciales van escritas directo en el código PHP (Paso 4), porque el servidor es tuyo y persistente — no es una función que se prende y apaga como en Vercel.
- La base de datos puede vivir en **el mismo servidor** que el sitio (host `localhost`), sin necesidad de un proveedor externo como Railway.
- No hay firewall automático agresivo bloqueando tus propias pruebas, como pasó en Vercel.
