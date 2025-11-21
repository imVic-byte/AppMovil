<?php
header('Content-Type: application/json');
$cont = mysqli_connect('localhost', 'chris', 'Admin123', 'AppMovil');

if (!$cont) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
    exit();
}

$codigo_sensor = mysqli_real_escape_string($cont, $_GET['codigo_sensor']);
$id_departamento = mysqli_real_escape_string($cont, $_GET['id_departamento']);
$id_usuario = mysqli_real_escape_string($cont, $_GET['id_usuario']);
$mac_sensor = mysqli_real_escape_string($cont, $_GET['MAC']);
$tipo = mysqli_real_escape_string($cont, $_GET['tipo']);
$estado = 'ACTIVO';
$fecha_alta = date('Y-m-d H:i:s');
$fecha_baja = '';

$sql_check = "SELECT id FROM sensores WHERE id = '$codigo_sensor'";
$result_check = mysqli_query($cont, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'El código de este sensor ya se encuentra registrado.']);
} else {
    $sql_insert = "INSERT INTO sensores (id, id_departamento, id_usuario, MAC_UID, tipo, activo, fecha_alta, fecha_baja) 
                   VALUES ('$codigo_sensor', '$id_departamento', '$id_usuario', '$mac_sensor',' $tipo', '$estado', '$fecha_alta',''$fecha_baja)";

    if (mysqli_query($cont, $sql_insert)) {
        echo json_encode(['status' => 'success', 'message' => 'Sensor registrado correctamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar el sensor: ' . mysqli_error($cont)]);
    }
}

mysqli_close($cont);
?>