<?php
header('Content-Type: application/json');
$cont = mysqli_connect('localhost', 'chris', 'Admin123', 'app_movil');

if (!$cont) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
    exit();
}

$nombre = mysqli_real_escape_string($cont, $_GET['name']);
$apellido = mysqli_real_escape_string($cont, $_GET['lastname']);
$email = mysqli_real_escape_string($cont, $_GET['email']);
$telefono = mysqli_real_escape_string($cont, $_GET['phone']);
$clave = mysqli_real_escape_string($cont, $_GET['password']);

$sql_check = "SELECT email FROM usuarios WHERE email = '$email'";
$result_check = mysqli_query($cont, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya se encuentra registrado.']);
} else {
    $sql_insert = "INSERT INTO usuarios (nombre, apellido, email, telefono, password) VALUES ('$nombre', '$apellido', '$email', '$telefono', '$clave')";
    if (mysqli_query($cont, $sql_insert)) {
        echo json_encode(['status' => 'success', 'message' => 'Usuario registrado correctamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar el usuario: ' . mysqli_error($cont)]);
    }
}
mysqli_close($cont);
?>
