<?php
include("conexionBD.php");
$id_persona=$_POST['txtid_persona'];
$concepto=$_POST['txtconcepto'];
$monto=$_POST['txtmonto'];
$fecha_pago=$_POST['txtfecha_pago'];
$metodo_pago=$_POST['txtmetodo_pago'];
$comprobante=$_POST['txtcomprobante'];
$estado=$_POST['txtestado'];
$observaciones=$_POST['txtobservaciones'];
$fecha_creacion=$_POST['txtfecha_creacion'];
$consulta ="INSERT INTO pagos (id_persona,concepto,monto,fecha_pago,metodo_pago,comprobante,estado,observaciones,fecha_creacion) VALUES ('$id_persona','$concepto','$monto','$fecha_pago','$metodo_pago','$comprobante','$estado','$observaciones','$fecha_creacion')";
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