<?php
header('Content-Type: application/json');
$cont = mysqli_connect('localhost', 'chris', 'Admin123', 'app_movil');

if (!isset($_GET['id_departamento'])) {
    echo json_encode(['status' => 'error', 'message' => 'Se requiere un id_departamento.']);
    exit();
}

$id_departamento = mysqli_real_escape_string($cont, $_GET['id_departamento']);

$sql = "SELECT id_usuario, nombre, apellido, email, telefono, rol, estado 
        FROM usuarios 
        WHERE id_departamento = '$id_departamento'";

$result = mysqli_query($cont, $sql);
$arr = array();
while ($datos = mysqli_fetch_assoc($result)) {
    $arr[] = $datos;
}

echo json_encode($arr);

mysqli_close($cont);
?>