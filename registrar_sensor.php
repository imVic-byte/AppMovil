<?php
header('Content-Type: application/json');
$cont = mysqli_connect('localhost', 'chris', 'Admin123', 'app_movil');

if (!$cont) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
    exit();
}

$codigo_sensor = mysqli_real_escape_string($cont, $_GET['codigo_sensor']);
$id_departamento = mysqli_real_escape_string($cont, $_GET['id_departamento']);
$id_usuario = mysqli_real_escape_string($cont, $_GET['id_usuario']);
$tipo = mysqli_real_escape_string($cont, $_GET['tipo']);
$estado = 'ACTIVO';
$fecha_alta = date('Y-m-d H:i:s');

$sql_check = "SELECT id_sensor FROM SENSORES WHERE codigo_sensor = '$codigo_sensor'";
$result_check = mysqli_query($cont, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'El código de este sensor ya se encuentra registrado.']);
} else {
    $sql_insert = "INSERT INTO SENSORES (codigo_sensor, id_departamento, id_usuario, tipo, estado, fecha_alta) 
                   VALUES ('$codigo_sensor', '$id_departamento', '$id_usuario', '$tipo', '$estado', '$fecha_alta')";

    if (mysqli_query($cont, $sql_insert)) {
        echo json_encode(['status' => 'success', 'message' => 'Sensor registrado correctamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar el sensor: ' . mysqli_error($cont)]);
    }
}

mysqli_close($cont);
?>