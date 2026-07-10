# Historial: cómo se desplegó la base de datos en Railway y se intentó desplegar el sitio en Vercel

Este documento explica, paso a paso y desde cero, todo lo que se hizo para intentar poner este proyecto "en internet" usando **Railway** (para la base de datos) y **Vercel** (para el sitio PHP). Al final se decidió no usar Vercel para el sitio (se explican los motivos) y se migró a Hostinger — eso está documentado aparte en `DEPLOY-HOSTINGER.md`.

Está escrito para alguien que nunca usó GitHub, Vercel ni Railway.

---

## 0. Conceptos básicos (glosario rápido)

- **Repositorio (repo)**: la carpeta de tu proyecto, pero versionada con Git — guarda un historial de todos los cambios. Este proyecto vive en GitHub en `github.com/Ale58150/Oratorio_Liturgia`.
- **Commit**: un "punto de guardado" del código, con un mensaje que dice qué cambió.
- **Push**: subir tus commits desde tu computadora al repositorio en GitHub (que vive en internet).
- **Base de datos (BD) accesible por internet**: tu MySQL local (XAMPP/Laragon) solo existe en tu computadora. Para que un sitio desplegado en internet la use, la base de datos también tiene que estar en un servidor accesible por internet, no en "localhost".
- **Variable de entorno**: un valor de configuración (como una contraseña) que no se escribe directo en el código, sino que se guarda por fuera y el programa lo lee en el momento de ejecutarse. Sirve para no subir contraseñas al repositorio.
- **Token de API**: una clave secreta que te da un servicio (como Vercel) para poder controlarlo automáticamente (por ejemplo, desde una terminal) sin tener que loguearte manualmente cada vez.
- **Serverless / runtime**: Vercel no tiene un servidor tradicional prendido 24/7 esperando pedidos. Cada vez que alguien visita el sitio, Vercel "prende" tu código por unos segundos, responde, y lo vuelve a apagar. PHP no es un lenguaje pensado originalmente para funcionar así, por eso hizo falta una herramienta especial (`vercel-php`) para que funcionara.

---

## 1. Desplegar la base de datos en Railway

**Railway** es un servicio que aloja bases de datos (y otras cosas) en la nube, accesibles desde internet.

### 1.1. Crear la base de datos

1. Se creó una cuenta en [railway.app](https://railway.app).
2. Se creó un proyecto nuevo y se agregó un servicio de tipo **MySQL** (Railway lo levanta automáticamente, ya instalado y corriendo).
3. Railway generó automáticamente las credenciales de conexión. Las importantes eran:
   - `MYSQL_PUBLIC_URL`: la dirección para conectarse **desde fuera de Railway** (desde tu computadora, o desde Vercel). Tiene esta forma:
     ```
     mysql://root:CONTRASEÑA@hayabusa.proxy.rlwy.net:59667/railway
     ```
   - `MYSQLHOST` interno (`mysql.railway.internal`): esta dirección **solo funciona entre servicios dentro de Railway**, no sirve para conectarse desde afuera (este fue un error que se cometió al principio — hay que usar siempre la versión "pública").

De esa URL pública se sacan 5 datos sueltos que se usan en los pasos siguientes:

| Dato | Valor de ejemplo |
|---|---|
| Host | `hayabusa.proxy.rlwy.net` |
| Puerto | `59667` (¡ojo! no es el 3306 de siempre) |
| Usuario | `root` |
| Contraseña | (la generada por Railway) |
| Nombre de la base | `railway` |

### 1.2. Exportar la base de datos local

Desde la computadora donde está la base de datos local (con XAMPP/Laragon corriendo), se abrió una terminal y se corrió:

```bash
mysqldump -u root -p oratorio > oratorio.sql
```

- `mysqldump` es un programa que viene instalado junto con MySQL. Sirve para "volcar" toda la estructura (tablas) y los datos de una base de datos a un archivo de texto plano (`.sql`).
- `-u root` = usuario de tu MySQL local.
- `-p` = le va a pedir la contraseña de tu MySQL local (en este caso, era vacía o `1234` según el entorno).
- `oratorio` = nombre de la base de datos local.
- `> oratorio.sql` = guarda toda esa información en un archivo llamado `oratorio.sql`, en la carpeta donde estabas parado en la terminal.

### 1.3. Importar la base de datos a Railway

Con el archivo `oratorio.sql` ya generado, se subió su contenido a la base de datos de Railway:

```bash
mysql -h hayabusa.proxy.rlwy.net -P 59667 -u root -p railway < oratorio.sql
```

- `-h` = host (la dirección del servidor de Railway).
- `-P` (mayúscula) = puerto.
- `-u root -p` = usuario y le pide la contraseña de Railway.
- `railway` = nombre de la base de datos destino en Railway.
- `< oratorio.sql` = en vez de escribir comandos a mano, le decimos que lea y ejecute todo lo que está adentro del archivo `oratorio.sql`.

**Problema que apareció:** la primera vez tiró `ERROR 1045 Access denied`, porque al escribir la contraseña a mano (con el prompt `Enter password:` que no muestra lo que tipeás) se cometió un error de tipeo. La solución fue pasar la contraseña pegada directamente en el comando, sin espacio después de `-p`:

```bash
mysql -h hayabusa.proxy.rlwy.net -P 59667 -u root -pLA_CONTRASEÑA_ACA railway < oratorio.sql
```

### 1.4. Verificar que la importación funcionó

```bash
mysql -h hayabusa.proxy.rlwy.net -P 59667 -u root -pLA_CONTRASEÑA_ACA railway -e "SHOW TABLES;"
```

El flag `-e` le dice a `mysql` "ejecutá este único comando SQL y salí", en vez de abrir una sesión interactiva. Esto mostró la lista de tablas (`personas`, `usuarios`, `actividades`, etc.), confirmando que la estructura y los datos se copiaron bien. También se pudo verificar visualmente entrando a Railway → el servicio de MySQL → pestaña **Data**.

---

## 2. Intento de desplegar el sitio PHP en Vercel

**Vercel** es una plataforma pensada principalmente para sitios en JavaScript/Next.js. No soporta PHP de forma nativa — hizo falta usar un "runtime" (motor de ejecución) hecho por la comunidad llamado `vercel-php` para poder correr archivos `.php` ahí.

### 2.1. Adaptar el código (resumen — detalle completo en `CAMBIOS-CODIGO.md`)

Se creó un archivo `vercel.json` en la raíz del proyecto para decirle a Vercel cómo tratar los archivos `.php`, y se modificaron los archivos que se conectan a la base de datos para que lean host/usuario/contraseña desde **variables de entorno** en vez de tenerlos escritos fijos en el código (esto después se revirtió, ver `DEPLOY-HOSTINGER.md`).

### 2.2. Crear el proyecto en Vercel (vía dashboard web)

1. Se creó una cuenta en [vercel.com](https://vercel.com), conectada a la cuenta de GitHub `Ale58150`.
2. **Add New** → **Project** → se importó el repositorio `Oratorio_Liturgia` desde GitHub (Vercel pidió autorización para leer los repos de esa cuenta).
3. En la pantalla de configuración se dejó **Framework Preset: Other** (porque no es un framework de JavaScript) y **Root Directory: `./`**.
4. Antes de desplegar, se cargaron las variables de entorno con la conexión a Railway usando el botón **"Import .env"**, seleccionando un archivo `.env` local que contenía:
   ```
   DB_HOST=hayabusa.proxy.rlwy.net
   DB_PORT=59667
   DB_USER=root
   DB_PASS=...
   DB_NAME=railway
   ```
5. Click en **Deploy**.

### 2.3. Errores encontrados y cómo se diagnosticaron

Este fue el tramo más largo. Cada error se fue resolviendo en orden:

**Error 1 — "The pattern `**/*.php` defined in 'functions' doesn't match any Serverless Functions inside the 'api' directory"**

Vercel, en su configuración "moderna" (`functions` dentro de `vercel.json`), sólo reconoce funciones si están dentro de una carpeta llamada `/api`. Como los archivos `.php` de este proyecto están repartidos en `cliente/` y `servidor/`, no calzaban con esa regla.

*Solución*: se cambió `vercel.json` al formato "legacy" (`builds` + `routes`), que sí permite que las funciones estén en cualquier carpeta.

**Error 2 — "Deployment Blocked: the commit author did not have contributing access to the project on Vercel"**

Cada vez que se hacía `git push`, Vercel intentaba desplegar automáticamente (integración nativa de Git), pero bloqueaba el despliegue. El motivo: el commit estaba firmado con el nombre/email de Git configurado en la computadora (`Marian Zamorano`), que Vercel no reconocía como un colaborador autorizado de la cuenta dueña del proyecto (`ale58150`). El plan gratuito ("Hobby") de Vercel no permite agregar colaboradores a un proyecto.

*Intento 1 (no alcanzó)*: hacer público el repositorio en GitHub. Ayudó a que el código fuera visible, pero el bloqueo por "autor del commit" siguió ocurriendo igual (o sea, no era un tema de repo público/privado sino de identidad).

*Solución real*: se armó un **flujo de CI/CD** (integración continua) usando **GitHub Actions**, un sistema que corre comandos automáticamente cada vez que se hace `push` al repositorio. Se creó el archivo `.github/workflows/deploy.yml`, que en cada push a la rama `main`:
1. Descarga el código.
2. Instala la herramienta de línea de comandos de Vercel (`vercel` CLI).
3. Despliega el proyecto usando un **token de API** de Vercel (en vez de depender de "quién hizo el commit").

Para que ese workflow funcionara, hubo que guardar 3 "secrets" (valores secretos) en GitHub → **Settings** → **Secrets and variables** → **Actions**:
- `VERCEL_TOKEN`: el token generado en vercel.com → Settings → Tokens.
- `VERCEL_ORG_ID` y `VERCEL_PROJECT_ID`: identificadores del proyecto, obtenidos corriendo, una sola vez, de forma local:
  ```bash
  vercel link --token=TU_TOKEN --yes
  ```
  Este comando conecta la carpeta local con el proyecto de Vercel y genera un archivo `.vercel/repo.json` con este contenido:
  ```json
  {
    "projects": [
      {
        "id": "prj_xxxxxxxxxxxxxxxxxxxx",
        "orgId": "team_xxxxxxxxxxxxxxxxxxxx"
      }
    ]
  }
  ```
  `id` es el `VERCEL_PROJECT_ID` y `orgId` es el `VERCEL_ORG_ID`.

Desde ese momento, cada `git push` a `main` disparaba el GitHub Action, que desplegaba usando el token — sin importar quién hizo el commit.

**Error 3 — "403: Forbidden" al abrir el sitio ya desplegado**

Aun con el deploy exitoso (GitHub Action en verde), al abrir la URL del sitio (`oratorio-liturgia.vercel.app`) aparecía una página de error genérica de Vercel: `403: Forbidden`.

Se investigaron, en orden, tres posibles causas:
1. **Deployment Protection** (una opción de Vercel que exige estar logueado para ver el sitio) — se revisó en Settings → Deployment Protection y estaba **desactivada**, así que no era esto.
2. **Falta de una ruta "catch-all"** en `vercel.json`: se había definido una sola ruta explícita (la de "/"), y en el formato legacy de Vercel, si no agregás una regla que reenvíe "todo lo demás" tal cual, esas rutas no se sirven. Se agregó:
   ```json
   { "src": "/(.*)", "dest": "/$1" }
   ```
   Esto no resolvió el problema (el error 403 persistía en **todas** las rutas, incluso la raíz "/", lo cual no encajaba con un problema de rutas — un archivo no encontrado da error 404, no 403).
3. **Causa real: el Firewall automático de Vercel bloqueó la propia IP del usuario.** En el dashboard, sección **Firewall → Overview**, se vio una regla llamada "DDoS Mitigation" que había bloqueado (`Denied`) la IP pública desde la que se estaban haciendo las pruebas, porque el sistema interpretó las múltiples recargas rápidas de la página (probando una y otra vez) como un patrón sospechoso de ataque.

### 2.4. Decisión final

Entre la complejidad de adaptar PHP a un entorno serverless, el bloqueo por identidad de Git, y el firewall bloqueando las propias pruebas, se decidió **abandonar Vercel** para este proyecto y usar **Hostinger** en su lugar — un hosting tradicional donde PHP y MySQL corren de forma nativa, sin necesidad de runtimes especiales, variables de entorno, ni CI/CD. Ver `DEPLOY-HOSTINGER.md` para esos pasos.
