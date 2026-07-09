<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios_Sistema</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <!-- Tarjeta -->
        <div class="card shadow-lg rounded-4">
            <div class="card-body p-4">
            <h3 class="text-center text-primary mb-4">Registro de Usuario del Sistema</h3>

            <!-- Formulario -->
            <form action="../servidor/validar_usuarios_sistema.php" method="POST">
                <div class="row">
                <!-- ID Usuario -->
             <!--   <div class="col-md-6 mb-3">
                    <label for="id_usuario" class="form-label fw-medium text-secondary fs-6">ID Usuario</label>
                    <input type="number" class="form-control" id="id_usuario" name="txtid_usuario" placeholder="Ingrese ID del usuario" required>
                </div>  -->

                <!-- Rol -->
                <div class="col-md-6 mb-3">
                    <label for="rol" class="form-label fw-medium text-secondary fs-6">Rol</label>
                    <select id="rol" name="txtrol" class="form-select" required>
                    <option value="" selected disabled>Seleccione</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Coordinador/a">Coordinador/a</option>
                    <option value="Sacerdote">Sacerdote</option>
                    <option value="Docente">Docente</option>
                    <option value="Estudiante">Estudiante</option>
                    <option value="Voluntario">Voluntario</option>
                    <option value="Externo">Externo</option>
                    </select>
                </div>
                </div>

                <div class="row">
                <!-- Permisos -->
                <div class="col-md-6 mb-3">
                    <label for="permisos" class="form-label fw-medium text-secondary fs-6">Permisos</label>
                    <input type="text" class="form-control" id="permisos" name="txtpermisos" placeholder="Ingrese permisos del usuario">
                </div>

                <!-- Estado -->
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label fw-medium text-secondary fs-6">Estado</label>
                    <select id="estado" name="txtestado" class="form-select" required>
                    <option value="" selected disabled>Seleccione</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                    <option value="Inactivo">Suspendido</option>
                    </select>
                </div>
                </div>
                
               <!-- <div class="row">
                <!-- Fecha Creación 
                <div class="col-md-6 mb-3">
                    <label for="fecha_creacion" class="form-label fw-medium text-secondary fs-6">Fecha Creación</label>
                    <input type="date" class="form-control" id="fecha_creacion" name="txtfecha_creacion" required>
                </div> 

                <!-- Fecha Actualización 
                <div class="col-md-6 mb-3">
                    <label for="fecha_actualizacion" class="form-label fw-medium text-secondary fs-6">Fecha Actualización</label>
                    <input type="date" class="form-control" id="fecha_actualizacion" name="txtfecha_actualizacion">
                </div>
                </div>

                <!-- Botón -->
                <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary btn-lg">Registrar Usuario</button>
                </div>
            </form>

        </div>
        </div>
    </div>
    </div>
</div>
</body>

</html>