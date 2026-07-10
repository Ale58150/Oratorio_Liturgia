<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "oratorio";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario de manera segura
$sacramento = $_POST['sacramento'];
$nombre_solicitante = $_POST['nombre_solicitante'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$lugar_nacimiento = $_POST['lugar_nacimiento'];
$nombre_padre = $_POST['nombre_padre'];
$nombre_madre = $_POST['nombre_madre'];
$nombre_padrino = $_POST['nombre_padrino'];
$nombre_madrina = $_POST['nombre_madrina'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

// Preparar y ejecutar la consulta SQL para insertar los datos
$sql = "INSERT INTO formulario_sacramentos (sacramento, nombre_solicitante, fecha_nacimiento, lugar_nacimiento, nombre_padre, nombre_madre, nombre_padrino, nombre_madrina, telefono, email)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $sacramento, $nombre_solicitante, $fecha_nacimiento, $lugar_nacimiento, $nombre_padre, $nombre_madre, $nombre_padrino, $nombre_madrina, $telefono, $email);

if ($stmt->execute()) {
    echo "¡Inscripción exitosa! Te contactaremos pronto.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>