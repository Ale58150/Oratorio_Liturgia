<?php
include("conexionBD.php");

// 1. Recibir correo
$correo = $_POST['correo'];

// 2. Buscar usuario
$stmt = $conexion->prepare("SELECT * FROM personas WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            font-family: Arial, Helvetica, sans-serif;
        }

        .card-box{
            width:100%;
            max-width:500px;
            background:#fff;
            border-radius:20px;
            padding:35px;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
            text-align:center;
        }

        .icono{
            font-size:60px;
            margin-bottom:20px;
        }

        .btn-link-custom{
            border-radius:12px;
            padding:12px;
            font-weight:bold;
        }

    </style>

</head>
<body>

<div class="card-box">

<?php

if ($usuario = $result->fetch_assoc()) {

    // 3. Crear token único
    $token = bin2hex(random_bytes(16));

    // 4. Fecha de expiración (1 hora)
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // 5. Guardar en BD
    $update = $conexion->prepare("UPDATE personas SET token=?, token_expira=? WHERE correo=?");
    $update->bind_param("sss", $token, $expira, $correo);
    $update->execute();

    // 6. Crear enlace
    $link = "http://localhost/oratorio%20y%20liturgia/cliente/reset.php?token=$token";

    // 7. Mostrar bonito
    echo "
        <i class='bi bi-check-circle-fill text-success icono'></i>

        <h2 class='mb-3 text-success'>
            Enlace generado
        </h2>

        <p class='text-secondary mb-4'>
            Haz clic en el botón para recuperar tu contraseña.
        </p>

        <a href='$link' class='btn btn-primary w-100 btn-link-custom'>
            <i class='bi bi-key-fill'></i>
            Recuperar contraseña
        </a>
    ";

} else {

    echo "
        <i class='bi bi-x-circle-fill text-danger icono'></i>

        <h2 class='mb-3 text-danger'>
            Correo no encontrado
        </h2>

        <p class='text-secondary'>
            El correo ingresado no existe en el sistema.
        </p>
    ";
}
?>

</div>

</body>
</html>