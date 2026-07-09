<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Personas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <!-- Tarjeta -->
        <div class="card shadow-lg rounded-4">
          <div class="card-body p-4">
            <h3 class="text-center text-primary mb-4">Registro de Personas</h3>

            <!-- Formulario -->
            <form action="../servidor/validar_personas.php" method="POST">
              <div class="row">
                <!-- ID Persona -->
               <!-- <div class="col-md-6 mb-3">
                  <label for="idPersona" class="form-label fw-medium text-secondary fs-6">ID Persona</label>
                  <input type="number" class="form-control" id="id_persona" name="txtid_persona" placeholder="Ingrese el ID de la persona" required>
                </div>  -->

                <!-- CI -->
                <div class="col-md-6 mb-3">
                  <label for="ci" class="form-label fw-medium text-secondary fs-6">Cédula de Identidad (CI)</label>
                  <input type="text" class="form-control" id="ci" name="txtci" placeholder="Ingrese su CI" required>
                </div>
              </div>

              <div class="row">
                <!-- Nombres -->
                <div class="col-md-6 mb-3">
                  <label for="nombres" class="form-label fw-medium text-secondary fs-6">Nombres</label>
                  <input type="text" class="form-control" id="nombres" name="txtnombres" placeholder="Ingrese sus nombres" required>
                </div>

                <!-- Apellidos -->
                <div class="col-md-6 mb-3">
                  <label for="apellidos" class="form-label fw-medium text-secondary fs-6">Apellidos</label>
                  <input type="text" class="form-control" id="apellidos" name="txtapellidos" placeholder="Ingrese sus apellidos" required>
                </div>
              </div>

              <div class="row">
                <!-- Género -->
                <div class="col-md-4 mb-3">
                  <label for="genero" class="form-label fw-medium text-secondary fs-6">Género</label>
                  <select id="genero" name="txtgenero" class="form-select" required>
                    <option value="" selected disabled>Seleccione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="O">Otro</option>
                  </select>
                </div>

                <!-- Teléfono -->
                <div class="col-md-4 mb-3">
                  <label for="telefono" class="form-label fw-medium text-secondary fs-6">Teléfono</label>
                  <input type="tel" class="form-control" id="telefono" name="txttelefono" placeholder="Ejemplo: 76543210">
                </div>

                <!-- Correo -->
                <div class="col-md-4 mb-3">
                  <label for="correo" class="form-label fw-medium text-secondary fs-6">Correo electrónico</label>
                  <input type="email" class="form-control" id="correo" name="txtcorreo" placeholder="ejemplo@correo.com" required>
                </div>
              </div>

              <div class="row">
                <!-- Dirección -->
                <div class="col-md-12 mb-3">
                  <label for="direccion" class="form-label fw-medium text-secondary fs-6">Dirección</label>
                  <input type="text" class="form-control" id="direccion" name="txtdireccion" placeholder="Ingrese su dirección">
                </div>
              </div>

              <div class="row">
                <!-- Contraseña -->
                <div class="col-md-6 mb-3">
                  <label for="password" class="form-label fw-medium text-secondary fs-6">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="txtpassword" placeholder="Ingrese su contraseña" required>
                </div>

                <!-- Tipo de Persona -->
                <div class="col-md-6 mb-3">
                  <label for="tipoPersona" class="form-label fw-medium text-secondary fs-6">Tipo de Persona</label>
                  <select id="tipo_persona" name="txttipo_persona" class="form-select" required>
                    <option value="" selected disabled>Seleccione</option>
                    <option value="estudiante">Estudiante</option>
                    <option value="docente">Docente</option>
                    <option value="administrativo">Administrativo</option>
                  </select>
                </div>
              </div>

               <div class="row"> 
                <!-- Fecha de Registro -->
             <div class="col-md-4 mb-3">
                  <label for="fechaRegistro" class="form-label fw-medium text-secondary fs-6">Fecha de Registro</label>
                  <input type="date" class="form-control" id="fecha_registro" name="txtfecha_registro" required>
                </div>   

                <!-- ID Universidad -->
             <div class="col-md-4 mb-3">
                  <label for="idUniversidad" class="form-label fw-medium text-secondary fs-6">ID Universidad</label>
                  <input type="number" class="form-control" id="id_universidad" name="txtid_universidad" placeholder="ID Univ." required>
                </div>  

                <!-- ID Usuario -->
                <div class="col-md-4 mb-3">
                  <label for="idUsuario" class="form-label fw-medium text-secondary fs-6">ID Usuario</label>
                  <input type="number" class="form-control" id="id_usuario" name="txtid_usuario" placeholder="ID Usuario" required>
                </div>
              </div>  

            <div class="row">
                <!-- Estado -->
              <div class="col-md-6 mb-3">
                  <label for="estado" class="form-label fw-medium text-secondary fs-6">Estado</label>
                  <select id="estado" name="txtestado" class="form-select" required>
                    <option value="" selected disabled>Seleccione</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                  </select>
                </div>   

                <!-- Foto de Perfil -->
                <div class="col-md-6 mb-3">
                  <label for="fotoPerfil" class="form-label fw-medium text-secondary fs-6">Foto de Perfil</label>
                  <input type="file" class="form-control" id="foto_perfil" name="txtfoto_perfil" accept="image/*">
                </div>
              </div>

              <!-- Botón -->
              <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>