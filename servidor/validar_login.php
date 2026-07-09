<?php
include("conexionBD.php");
session_start();

$email = $_POST['txtemail'];
$password = $_POST['txtpassword'];

$stmt = $conexion->prepare("SELECT * FROM personas WHERE correo = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$resultado = $stmt->get_result();

if ($usuario = $resultado->fetch_assoc()) {

    if (password_verify($password, $usuario['password'])) {

        $_SESSION['usuario'] = $usuario['correo'];
        $_SESSION['nombre'] = $usuario['nombres'];

        header("Location: ../cliente/PaginaInicio.php");
        exit();

    } else {
        echo "<script>alert('Contraseña incorrecta'); window.location='../cliente/login.php';</script>";
    }

} else {
    echo "<script>alert('Usuario no existe'); window.location='../cliente/login.php';</script>";
}
?>