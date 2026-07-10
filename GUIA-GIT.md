# Guía de Git y GitHub desde cero

Esta guía explica, en orden, los comandos de Git que se usan en este proyecto desde la terminal. Está pensada para alguien que nunca usó Git ni GitHub.

## 1. Conceptos básicos

- **Git**: un programa que instalas en tu computadora. Guarda un historial de todos los cambios que hacés en tus archivos, como una máquina del tiempo.
- **GitHub**: una página web que guarda una copia de ese historial "en la nube", para que varias personas puedan trabajar sobre el mismo proyecto.
- **Repositorio (repo)**: la carpeta del proyecto que Git está vigilando. Este proyecto (`Oratorio_Liturgia`) es un repositorio.
- **Commit**: una "foto" del estado de los archivos en un momento dado, con un mensaje que explica qué cambió. Los commits forman el historial.
- **Rama (branch)**: una línea de trabajo independiente. La rama principal casi siempre se llama `main`. Podés crear ramas nuevas para probar cosas sin tocar `main`.
- **Remoto (remote / origin)**: la copia del repositorio que vive en GitHub. `origin` es el nombre que Git le da por defecto a "el repositorio en GitHub".
- **Working directory / staging area / repositorio**: un cambio pasa por tres lugares:
  1. **Working directory**: donde editás los archivos normalmente.
  2. **Staging area**: una lista de "lo que va a entrar en el próximo commit" (se arma con `git add`).
  3. **Historial (commit)**: una vez que hacés `git commit`, el cambio queda guardado para siempre en el historial local.

## 2. El flujo de trabajo diario (en orden)

Este es el orden típico de comandos que vas a usar cada vez que trabajes en el proyecto:

```
git status
git pull
   ... editás archivos ...
git status
git add <archivos>
git commit -m "mensaje explicando el cambio"
git push
```

### Paso a paso

**1. `git status`**
Muestra qué archivos cambiaste, cuáles son nuevos, y si tu rama está adelantada o atrasada respecto a GitHub. Es el comando que más vas a usar — no modifica nada, solo informa.

**2. `git pull`**
Trae los cambios que otras personas subieron a GitHub y los mezcla con tu copia local. **Siempre corré esto antes de empezar a trabajar**, para no perder cambios de otros ni generar conflictos innecesarios.

**3. Editar archivos**
Acá hacés el trabajo real: programar, corregir, agregar archivos, etc. Esto pasa en tu "working directory".

**4. `git status` (de nuevo)**
Para ver qué archivos quedaron modificados, agregados o eliminados antes de guardarlos.

**5. `git add <archivo>`**
Marca un archivo para que entre en el próximo commit (lo mueve a la "staging area"). Ejemplos:

```
git add servidor/conexionBD.php        # un archivo puntual
git add servidor/                      # todos los cambios de una carpeta
git add -A                             # todos los cambios del repo (usar con cuidado)
```

**6. `git commit -m "mensaje"`**
Guarda en el historial local todo lo que agregaste con `git add`. El mensaje debe explicar **por qué** se hizo el cambio, no solo qué se cambió. Ejemplo:

```
git commit -m "Corregir conexión a la base de datos en Hostinger"
```

**7. `git push`**
Sube tus commits locales a GitHub, para que queden guardados en la nube y otras personas los puedan ver/descargar.

> Con `git pull` bajás cambios. Con `git push` subís cambios. Es fácil confundirlos al principio.

## 3. Comandos para revisar el historial y los cambios

- `git log` → lista los commits (los más nuevos primero). Agregá `--oneline` para verlo en una sola línea por commit: `git log --oneline`.
- `git diff` → muestra línea por línea qué cambió en los archivos que **todavía no** hiciste `git add`.
- `git diff --staged` → lo mismo, pero para lo que ya está en la staging area (lo que entraría en el próximo commit).

## 4. Deshacer cosas (con cuidado)

- `git restore <archivo>` → descarta los cambios sin guardar de un archivo y lo deja como estaba en el último commit. **Esto borra tu trabajo no guardado**, usalo solo si estás seguro.
- `git restore --staged <archivo>` → saca un archivo de la staging area (le hace lo contrario a `git add`), pero no borra los cambios, solo lo "desmarca".

## 5. Trabajar con ramas (branches)

Las ramas sirven para probar cambios sin afectar `main` hasta estar seguro de que funcionan.

- `git branch` → lista las ramas que existen en tu copia local.
- `git branch nombre-rama` → crea una rama nueva (pero no te movés a ella todavía).
- `git checkout nombre-rama` → te movés a esa rama.
- `git checkout -b nombre-rama` → crea la rama y te movés a ella en un solo paso (el más usado).
- `git checkout main` → volver a la rama principal.

Cuando terminás de trabajar en una rama y querés llevar esos cambios a `main`, normalmente se hace a través de un **Pull Request** en la página de GitHub (no desde la terminal), para que alguien pueda revisar el cambio antes de aceptarlo.

## 6. Clonar un repositorio por primera vez

Si todavía no tenés el proyecto en tu computadora:

```
git clone https://github.com/Ale58150/Oratorio_Liturgia.git
```

Esto crea una carpeta nueva con todo el historial del proyecto, ya conectada a GitHub como `origin`.

## 7. ¿Qué son los conflictos?

Un **conflicto** pasa cuando dos personas modificaron la misma línea de un mismo archivo de formas distintas, y Git no puede decidir cuál versión usar. Git marca el archivo con símbolos como:

```
<<<<<<< HEAD
tu versión del cambio
=======
la versión que vino de GitHub
>>>>>>> origin/main
```

Para resolverlo: abrís el archivo, decidís qué parte dejar (o combinás ambas), borrás las líneas `<<<<<<<`, `=======` y `>>>>>>>`, guardás el archivo, y después hacés `git add` + `git commit` para cerrar el conflicto.

## 8. Resumen rápido (acordate de esto)

| Comando | Qué hace |
|---|---|
| `git status` | Ver qué cambió (no modifica nada) |
| `git pull` | Bajar los cambios de GitHub |
| `git add <archivo>` | Preparar un cambio para guardarlo |
| `git commit -m "mensaje"` | Guardar los cambios preparados en el historial local |
| `git push` | Subir tus commits a GitHub |
| `git log --oneline` | Ver el historial de commits |
| `git diff` | Ver el detalle de lo que cambió |
| `git checkout -b rama` | Crear y moverse a una rama nueva |

**Orden mental simple:** `pull` → trabajar → `add` → `commit` → `push`.
