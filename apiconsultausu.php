<?php
header('Content-Type: application/json');
$cont = mysqli_connect('localhost', 'chris', 'Admin123', 'AppMovil');

$email = mysqli_real_escape_string($cont, $_GET['email']);
$password_plano = mysqli_real_escape_string($cont, $_GET['password_hash']);

$sql = "SELECT id, nombre, apellido, privilegios, id_departamento, estado, password_hash
        FROM usuarios 
        WHERE email = '$email'";

$result = mysqli_query($cont, $sql);

if (mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
    $hash_guardado = $usuario['password_hash']; 
    if (password_verify($password_plano, $hash_guardado)) {
        
        if ($usuario['estado'] == 'ACTIVO') {
            
            unset($usuario['password_hash']); 
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Login correcto.',
                'usuario' => $usuario
            ]);
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Tu cuenta se encuentra ' . $usuario['estado'] . '.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Email o contraseña incorrectos.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Email o contraseña incorrectos.'
    ]);
}

mysqli_close($cont);
?>