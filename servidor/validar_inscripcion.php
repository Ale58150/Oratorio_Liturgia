<?php
include("conexionBD.php");
$id_actividad=$_POST['txtid_actividad'];
$id_persona=$_POST['txtid_persona'];
$id_pago=$_POST['txtid_pago'];
$cumple_requisitos=$_POST['txtcumple_requisitos'];
$estado=$_POST['txtestado'];
$fecha_inscripcion=$_POST['txtfecha_inscripcion'];
$fecha_actualizacion=$_POST['txtfecha_actualizacion'];
$observaciones=$_POST['txtobservaciones'];
$asistencia=$_POST['txtasistencia'];
$calificacion=$_POST['txtcalificacion'];
$consulta="INSERT INTO inscripcion (id_actividad,id_persona,id_pago,cumple_requisitos,estado,fecha_inscripcion,fecha_actualizacion,observaciones,asistencia, calificacion) VALUES ('$id_actividad','$id_persona','$id_pago','$cumple_requisitos','$estado','$fecha_inscripcion','$fecha_actualizacion','$observaciones','$asistencia', '$calificacion')";
$resultado=mysqli_query($conexion,$consulta);
if ($resultado) {
    echo "<script>
            alert('¡Registro exitoso!');
            window.location='../cliente/PaginaInicio.php';
        </script>";
} else {
    echo "Error al insertar: " . mysqli_error($conexion);
}
?>