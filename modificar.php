<?php
$cont = mysqli_connect('localhost', 'chris', 'Admin123', 'app_movil');

$id = $_GET['id'];
$nombre = $_GET['nombre'];
$apellido = $_GET['apellido'];
$email = $_GET['email'];
$telefono = $_GET['telefono'];

$sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', email='$email', telefono='$telefono' WHERE id='$id'";

if (mysqli_query($cont, $sql)) {
    echo "Modificación exitosa";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($cont);
}

mysqli_close($cont);
?>
