<?php
include("conexionBD.php");
$id_inscripcion=$_POST['txtid_inscripcion'];
$fecha=$_POST['txtfecha'];
$asistio=$_POST['txtasistio'];
$observaciones=$_POST['txtobservaciones'];
$registrado_por=$_POST['txtregistrado_por'];
$fecha_registro=$_POST['txtfecha_registro'];
$consulta= "INSERT INTO asistencias(id_inscripcion,fecha,asistio,observaciones,registrado_por,fecha_registro) VALUES ('$id_inscripcion','$fecha','$asistio','$observaciones','$registrado_por','$fecha_registro')";
$resultado=mysqli_query($conexion,$consulta);
if ($resultado) {
    echo "<script>
            alert('¡Registro exitoso!');
            window.location='../cliente/menu.php';
        </script>";
} else {
    echo "Error al insertar: " . mysqli_error($conexion);
}
?>