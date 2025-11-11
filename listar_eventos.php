<?php
header('Content-Type: application/json');
$cont = mysqli_connect('localhost', 'chris', 'Admin123', 'AppMovil');

if (!$cont) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
    exit();
}

if (!isset($_GET['id_departamento'])) {
    echo json_encode(['status' => 'error', 'message' => 'Se requiere un id_departamento.']);
    exit();
}

$id_departamento = mysqli_real_escape_string($cont, $_GET['id_departamento']);

$sql = "SELECT ev.id_evento, ev.id_sensor, ev.tipo_evento, ev.fecha_hora, ev.resultado, u.nombre, u.apellido
        FROM EVENTOS_ACCESO ev
        LEFT JOIN usuarios u ON ev.id_usuario = u.id_usuario
        WHERE u.id_departamento = '$id_departamento'
        ORDER BY ev.fecha_hora DESC";

$result = mysqli_query($cont, $sql);
$arr = array();
while ($datos = mysqli_fetch_assoc($result)) {
    $arr[] = $datos;
}

echo json_encode($arr);

mysqli_close($cont);
?>