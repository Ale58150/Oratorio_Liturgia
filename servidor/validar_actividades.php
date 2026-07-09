<?php
include("conexionBD.php");

// ======================
//   REGISTRAR ACTIVIDAD
// ======================
if (isset($_POST['action']) && $_POST['action'] == 'registrar') {

    $nombre_actividad    = $_POST['txtnombre_actividad'];
    $tipo_actividad      = $_POST['txttipo_actividad'];
    $fecha_inicio        = $_POST['txtfecha_inicio'];
    $fecha_fin           = $_POST['txtfecha_fin'];
    $dias_semana         = $_POST['txtdias_semana'];
    $hora_inicio         = $_POST['txthora_inicio'];
    $hora_fin            = $_POST['txthora_fin'];
    $duracion            = $_POST['txtduracion'];
    $requisitos          = $_POST['txtrequisitos'];
    $costo               = $_POST['txtcosto'];
    $cupo_maximo         = $_POST['txtcupo_maximo'];
    $cupo_disponible     = $_POST['txtcupo_disponible'];
    $descripcion         = $_POST['txtdescripcion'];
    $id_evento           = $_POST['txtid_evento'];
    $estado              = $_POST['txtestado'];
    $fecha_creacion      = $_POST['txtfecha_creacion'];
    $fecha_actualizacion = $_POST['txtfecha_actualizacion'];

    $consulta = "INSERT INTO actividades(
        nombre_actividad, tipo_actividad, fecha_inicio, fecha_fin, dias_semana,
        hora_inicio, hora_fin, duracion, requisitos, costo, cupo_maximo,
        cupo_disponible, descripcion, id_evento, estado, fecha_creacion, fecha_actualizacion
    ) VALUES (
        '$nombre_actividad', '$tipo_actividad', '$fecha_inicio', '$fecha_fin', '$dias_semana',
        '$hora_inicio', '$hora_fin', '$duracion', '$requisitos', '$costo', '$cupo_maximo',
        '$cupo_disponible', '$descripcion', '$id_evento', '$estado', '$fecha_creacion', '$fecha_actualizacion'
    )";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
            alert('¡Registro exitoso!');
            window.location='../cliente/listarActividades.php';
        </script>";
    } else {
        echo "Error al insertar: " . mysqli_error($conexion);
    }
}


// ======================
//      ELIMINAR
// ======================
if (isset($_GET['eliminar'])) {

    $id = intval($_GET['eliminar']); // seguridad

    $sql = "DELETE FROM actividades WHERE id_actividad = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../cliente/listarActividades.php");
        exit;
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
}


// ======================
//        EDITAR
// ======================
if (isset($_POST['action']) && $_POST['action'] == 'editar') {

    $id                = $_POST['txtid'];
    $nombre            = $_POST['txtnombre_actividad'];
    $tipo              = $_POST['txttipo_actividad'];
    $fecha_inicio      = $_POST['txtfecha_inicio'];
    $fecha_fin         = $_POST['txtfecha_fin'];
    $dias              = $_POST['txtdias_semana'];
    $hora_inicio       = $_POST['txthora_inicio'];
    $hora_fin          = $_POST['txthora_fin'];
    $duracion          = $_POST['txtduracion'];
    $requisitos        = $_POST['txtrequisitos'];
    $costo             = $_POST['txtcosto'];
    $cupo_maximo       = $_POST['txtcupo_maximo'];
    $cupo_disponible   = $_POST['txtcupo_disponible'];
    $descripcion       = $_POST['txtdescripcion'];
    $id_evento         = $_POST['txtid_evento'];
    $estado            = $_POST['txtestado'];

    $sql = "UPDATE actividades SET
                nombre_actividad='$nombre',
                tipo_actividad='$tipo',
                fecha_inicio='$fecha_inicio',
                fecha_fin='$fecha_fin',
                dias_semana='$dias',
                hora_inicio='$hora_inicio',
                hora_fin='$hora_fin',
                duracion='$duracion',
                requisitos='$requisitos',
                costo='$costo',
                cupo_maximo='$cupo_maximo',
                cupo_disponible='$cupo_disponible',
                descripcion='$descripcion',
                id_evento='$id_evento',
                estado='$estado'
            WHERE id_actividad=$id";

    if ($conexion->query($sql)) {
        header("Location: ../cliente/listarActividades.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}
?>
