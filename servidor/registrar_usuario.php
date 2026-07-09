<?php

include("conexionBD.php");

// Recibir datos
$nombre = $_POST['txtnombre'];
$apellidos = $_POST['txtapellidos'];
$ci = $_POST['txtci'];
$correo = $_POST['txtcorreo'];
$password = $_POST['txtpassword'];

// Encriptar contraseña
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Verificar si el correo existe
$verificar = "SELECT * FROM personas WHERE correo='$correo'";

$resultado = mysqli_query($conexion, $verificar);

if(mysqli_num_rows($resultado) > 0){

    echo "
    <script>
        alert('El correo ya existe');
        window.location.href='../cliente/registrarse.php';
    </script>
    ";

    exit();

}

// Insertar usuario
$sql = "INSERT INTO personas(nombres, apellidos, ci, correo, password)
VALUES('$nombre','$apellidos','$ci','$correo','$passwordHash')";

if(mysqli_query($conexion, $sql)){

    echo "
    <script>
        alert('Usuario registrado correctamente');
        window.location.href='../cliente/login.php';
    </script>
    ";

}else{

    echo "Error: " . mysqli_error($conexion);

}

?>