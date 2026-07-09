<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Actividades</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="row">

        <!-- FORMULARIO IZQUIERDO -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4">

                    <form action="../servidor/validar_actividades.php" method="POST">
                        <h3 class="text-center mb-3">Registro de Actividades</h3>
                        <input type='hidden' name='action' value='registrar'>

                        <!-- SE ELIMINÓ EL ID ACTIVIDAD -->
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Nombre Actividad</label>
                                <input type="text" class="form-control" name="txtnombre_actividad" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tipo Actividad</label>
                                <input type="text" class="form-control" name="txttipo_actividad" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Fecha Inicio</label>
                                <input type="date" class="form-control" name="txtfecha_inicio" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Fecha Fin</label>
                                <input type="date" class="form-control" name="txtfecha_fin" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>Días Semana</label>
                                <input type="text" class="form-control" name="txtdias_semana">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Hora Inicio</label>
                                <input type="time" class="form-control" name="txthora_inicio" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Hora Fin</label>
                                <input type="time" class="form-control" name="txthora_fin" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Duración</label>
                                <input type="text" class="form-control" name="txtduracion">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Requisitos</label>
                                <input type="text" class="form-control" name="txtrequisitos">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Costo</label>
                                <input type="number" class="form-control" name="txtcosto" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Cupo Máximo</label>
                                <input type="number" class="form-control" name="txtcupo_maximo">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>Cupo Disponible</label>
                                <input type="number" class="form-control" name="txtcupo_disponible">
                            </div>
                            <div class="col-md-9 mb-3">
                                <label>Descripción</label>
                                <textarea class="form-control" name="txtdescripcion" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>ID Evento</label>
                                <input type="number" class="form-control" name="txtid_evento" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Estado</label>
                                <select class="form-select" name="txtestado" required>
                                    <option disabled selected>Seleccione</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Fecha Creación</label>
                                <input type="date" class="form-control" name="txtfecha_creacion" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Fecha Actualización</label>
                                <input type="date" class="form-control" name="txtfecha_actualizacion">
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary btn-lg mb-2">Registrar Actividad</button>
                            <a href="listarActividades.php" class="btn btn-secondary btn-lg">Listar Actividades</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <!-- TABLA DERECHA -->
        <div class="col-lg-8">

            <?php
            include("../servidor/conexionBD.php");
            $resultado = $conexion->query("SELECT * FROM actividades");
            ?>

            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()) { ?>
                        <tr class="text-center">
                            <td><?= $fila['id_actividad'] ?></td>
                            <td><?= $fila['nombre_actividad'] ?></td>
                            <td><?= $fila['tipo_actividad'] ?></td>
                            <td><?= $fila['fecha_inicio'] ?></td>
                            <td><?= $fila['fecha_fin'] ?></td>
                            <td>
                                <a href="../servidor/validar_actividades.php?eliminar=<?= $fila['id_actividad'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Eliminar actividad?')">
                                   Eliminar
                                </a>

                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editar<?= $fila['id_actividad'] ?>">
                                    Editar
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editar<?= $fila['id_actividad'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="../servidor/validar_actividades.php">
                                        <input type="hidden" name="action" value="editar">
                                        <input type="hidden" name="txtid" value="<?= $fila['id_actividad'] ?>">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Actividad</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Nombre</label>
                                                <input type="text" name="txtnombre" class="form-control"
                                                       value="<?= $fila['nombre_actividad'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label>Tipo</label>
                                                <input type="text" name="txttipo" class="form-control"
                                                       value="<?= $fila['tipo_actividad'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label>Descripción</label>
                                                <input type="text" name="txtdescripcion" class="form-control"
                                                       value="<?= $fila['descripcion'] ?>">
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cerrar
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                Actualizar
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
