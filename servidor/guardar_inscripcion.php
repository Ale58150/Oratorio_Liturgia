<?php

include("Formulario_inscripcion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibir datos
    $nombre = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $actividad = $_POST['actividad'];
    $mensaje = $_POST['mensaje'];

    // Checkbox
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;

    // Consulta preparada (SEGURA)
    $sql = "INSERT INTO formulario_reservalugar
    (nombre_completo, email, telefono, actividad, mensaje, newsletter)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "sssssi",
        $nombre,
        $email,
        $telefono,
        $actividad,
        $mensaje,
        $newsletter
    );

    if ($stmt->execute()) {

        echo "
        <script>
            alert('Inscripción enviada correctamente');
            window.location='../cliente/PaginaInicio.php';
        </script>
        ";

    } else {

        echo "Error al guardar";

    }

    $stmt->close();
    $conexion->close();
}

?>