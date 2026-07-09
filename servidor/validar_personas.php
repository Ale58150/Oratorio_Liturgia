<?php
include("conexionBD.php");
$ci=$_POST['txtci'];
$nombres=$_POST['txtnombres'];
$apellidos=$_POST['txtapellidos'];
$genero=$_POST['txtgenero'];
$direccion=$_POST['txtdireccion'];
$telefono=$_POST['txttelefono'];
$correo=$_POST['txtcorreo'];
$password=$_POST['txtpassword'];
$tipo_persona=$_POST['txttipo_persona'];
$fecha_registro=$_POST['txtfecha_registro'];
$id_universidad=$_POST['txtid_universidad'];
$id_usuario=$_POST['txtid_usuario'];
$estado=$_POST['txtestado'];
$foto_perfil=$_POST['txtfoto_perfil'];
$consulta =" INSERT INTO personas(ci,nombres,apellidos,genero,direccion,telefono,correo,password,tipo_persona,fecha_registro,id_universidad,id_usuario,estado,foto_perfil) VALUES ('$ci','$nombres','$apellidos','$genero','$direccion','$telefono','$correo','$password','$tipo_persona','$fecha_registro','$id_universidad','$id_usuario','$estado','$foto_perfil')";
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