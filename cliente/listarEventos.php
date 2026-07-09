<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Eventos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <!-- FORMULARIO - LADO IZQUIERDO -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4">
                    <form action="../servidor/validar_eventos.php" method="POST">
                        <h3>Registro de Eventos</h3>
                        <input type='hidden' name='action' value='registrar'>
                        <div class="mb-3">
                            <label for="nombre_evento" class="form-label">Nombre Evento</label>
                            <input type="text" class="form-control" id="nombre_evento" name="txtnombre_evento" placeholder="Ingrese el nombre del evento" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="txtdescripcion" rows="3" placeholder="Ingrese descripción del evento"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select id="estado" name="txtestado" class="form-select" required>
                                <option value="" selected disabled>Seleccione</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_creacion" class="form-label">Fecha Creación</label>
                            <input type="date" class="form-control" id="fecha_creacion" name="txtfecha_creacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_actualizacion" class="form-label">Fecha Actualización</label>
                            <input type="date" class="form-control" id="fecha_actualizacion" name="txtfecha_actualizacion">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Registrar Evento</button>
                            <a href="./listarEventos.php" class="btn btn-secondary btn-lg">Listar Eventos</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TABLA - LADO DERECHO -->
        <div class="col-lg-8">
            <?php
            include("../servidor/conexionBD.php");
            $resultado = $conexion->query("SELECT * FROM eventos");
            ?>
            <table class="table table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Evento</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Actualización</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>
                            <td>{$fila['id_evento']}</td>
                            <td>{$fila['nombre_evento']}</td>
                            <td>{$fila['descripcion']}</td>
                            <td>{$fila['estado']}</td>
                            <td>{$fila['fecha_creacion']}</td>
                            <td>{$fila['fecha_actualizacion']}</td>
                            <td>
                                <a href='../servidor/validar_eventos.php?eliminar={$fila['id_evento']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Seguro que deseas eliminar?\")'>Eliminar</a>
                                <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar{$fila['id_evento']}'>Editar</button>
                            </td>
                        </tr>";

                        // Modal editar
                        echo "
                        <div class='modal fade' id='modalEditar{$fila['id_evento']}' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <form method='POST' action='../servidor/validar_eventos.php'>
                                        <input type='hidden' name='action' value='editar'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Editar Evento</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <input type='hidden' name='txtid' value='{$fila['id_evento']}'>
                                            <div class='mb-3'>
                                                <label>Nombre:</label>
                                                <input type='text' name='txtnombre' class='form-control' value='{$fila['nombre_evento']}'>
                                            </div>
                                            <div class='mb-3'>
                                                <label>Descripción:</label>
                                                <input type='text' name='txtdescripcion' class='form-control' value='{$fila['descripcion']}'>
                                            </div>
                                            <div class='mb-3'>
                                                <label>Estado:</label>
                                                <select name='txtestado' class='form-control'>
                                                    <option selected>{$fila['estado']}</option>
                                                    <option>Activo</option>
                                                    <option>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                                            <button type='submit' class='btn btn-primary'>Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
