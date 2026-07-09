<?php
require_once("../servidor/conexionBD.php");

$sql = "SELECT
            p.id_persona,
            p.ci,
            p.nombres,
            p.apellidos,
            p.genero,
            p.telefono,
            p.correo,
            p.tipo_persona,
            p.estado,
            u.sigla AS universidad,
            us.rol
        FROM personas p
        LEFT JOIN universidades u
            ON p.id_universidad = u.id_universidad
        LEFT JOIN usuarios_sistema us
            ON p.id_usuario = us.id_usuario
        ORDER BY p.id_persona ASC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Personas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body class="bg-light">

    <div class="container py-4">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">

                <h4>
                    <i class="fas fa-users"></i>
                    Personas Registradas
                </h4>
            </div>
            <!--Buscador-->
            <div class="row mb-3">

                <div class="col-md-6">
                    <input
                        type="text"
                        id="buscar"
                        class="form-control"
                        placeholder="Buscar por CI, nombre, tipo o rol...">
                </div>

                <div class="col-md-6 text-end">

                    <button
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalNuevaPersona">

                        <i class="fas fa-user-plus"></i>
                        Nueva Persona

                    </button>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-striped table-bordered align-middle text-center">

                        <thead class="table-dark text-center align-middle">
                            <tr>
                                <th width="60">ID</th>
                                <th width="90">CI</th>
                                <th>Nombre Completo</th>
                                <th>Tipo</th>
                                <th>Universidad</th>
                                <th>Rol</th>
                                <th width="100">Estado</th>
                                <th width="170">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>

                                <tr>

                                    <td><?= $fila['id_persona']; ?></td>

                                    <td><?= $fila['ci']; ?></td>

                                    <td class="text-start">
                                        <?= $fila['nombres'] . " " . $fila['apellidos']; ?>
                                    </td>

                                    <td><?= $fila['tipo_persona']; ?></td>

                                    <td>
                                        <?= empty($fila['universidad']) ? "No registrada" : $fila['universidad']; ?>
                                    </td>

                                    <td>
                                        <?= empty($fila['rol']) ? "Sin usuario" : $fila['rol']; ?>
                                    </td>

                                    <td>

                                        <?php

                                        if ($fila['estado'] == "Activo") {

                                        ?>

                                            <span class="badge bg-success">

                                                Activo

                                            </span>

                                        <?php

                                        } elseif ($fila['estado'] == "Suspendido") {

                                        ?>

                                            <span class="badge bg-warning text-dark">

                                                Suspendido

                                            </span>

                                        <?php

                                        } else {

                                        ?>

                                            <span class="badge bg-danger">

                                                Inactivo

                                            </span>

                                        <?php

                                        }

                                        ?>

                                    </td>

                                    <td class="text-center">

                                        <div class="btn-group">

                                            <button class="btn btn-warning btn-sm">

                                                <i class="fas fa-edit"></i>

                                            </button>

                                            <button class="btn btn-danger btn-sm">

                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>

const buscar = document.getElementById("buscar");

buscar.addEventListener("keyup", function(){

let texto = this.value.toLowerCase();

let filas = document.querySelectorAll("tbody tr");

filas.forEach(function(fila){

let contenido = fila.textContent.toLowerCase();

fila.style.display = contenido.includes(texto)
? ""
: "none";

});

});

</script>
</body>

</html>