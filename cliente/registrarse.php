<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <link rel="stylesheet" href="../assets/librerias/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
        }

        .registro-box {
            width: 450px;
        }
    </style>

</head>

<body>

    <div class="vh-100 d-flex justify-content-center align-items-center">

        <div class="registro-box bg-white p-5 rounded-5 shadow border border-primary">

            <div class="text-center mb-3">
                <img src="../portafolio/img/logo.jpg" width=100">
            </div>

            <h2 class="text-center text-primary mb-4">
                Crear Cuenta
            </h2>

            <form action="../servidor/registrar_usuario.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Nombres:</label>

                    <input type="text"
                        class="form-control border border-primary"
                        name="txtnombre"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apellidos:</label>

                    <input type="text"
                        class="form-control border border-primary"
                        name="txtapellidos"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Carnet de Identidad:</label>

                    <input type="text"
                        class="form-control border border-primary"
                        name="txtci"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo:</label>

                    <input type="email"
                        class="form-control border border-primary"
                        name="txtcorreo"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña:</label>

                    <input type="password"
                        class="form-control border border-primary"
                        name="txtpassword"
                        required>
                </div>

                <div class="d-grid">

                    <button class="btn btn-primary" type="submit">
                        Registrarse
                    </button>

                </div>

            </form>

            <div class="mt-3 text-center">

                <a href="login.php">
                    Ya tengo cuenta
                </a>

            </div>

        </div>

    </div>

    <script src="../assets/librerias/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>