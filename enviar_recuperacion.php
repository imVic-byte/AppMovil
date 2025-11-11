<?php
// Usar las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar el autoload.php de Composer
require 'vendor/autoload.php';

// --- CONFIGURACIÓN ---
// --- ¡DEBES MODIFICAR ESTOS VALORES! ---
$db_host = 'localhost';
$db_user = 'chris';
$db_pass = 'Admin123';
$db_name = 'app_movil';

$smtp_user = 'soportepenkavc@gmail.com'; // El correo que creaste para la app
$smtp_pass = 'iogt ecka hbix oqot'; // La contraseña de aplicación de 16 letras
$reset_page_url = 'http://18.211.13.143/reset_password.php'; // URL a tu otro archivo PHP
// --- FIN DE LA CONFIGURACIÓN ---

// Conexión a la base de datos
$conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conexion) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
    exit();
}

if (!isset($_GET['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'No se proporcionó un email.']);
    exit();
}

$email = mysqli_real_escape_string($conexion, $_GET['email']);

// 1. Verificar si el correo existe en la tabla de usuarios
$sql_check_user = "SELECT id FROM usuarios WHERE email = '$email'";
$result_check_user = mysqli_query($conexion, $sql_check_user);

if (mysqli_num_rows($result_check_user) > 0) {
    // 2. Generar un token seguro y la fecha de expiración
    $token = bin2hex(random_bytes(32));
    $expires = time() + 3600; // El token expira en 1 hora

    // 3. Insertar el token en la tabla 'password_resets'
    $sql_insert_token = "INSERT INTO password_resets (email, token, expires_at) VALUES ('$email', '$token', '$expires')";
    
    if (mysqli_query($conexion, $sql_insert_token)) {
        // 4. Enviar el correo electrónico
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP (Gmail)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtp_user;
            $mail->Password   = $smtp_pass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Destinatarios
            $mail->setFrom($smtp_user, 'Soporte PenkaApp');
            $mail->addAddress($email);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperacion de Contrasena - PenkaApp';
            $mail->Body    = "Hola,<br><br>Para restablecer tu contraseña, haz clic en el siguiente enlace:<br><a href='$reset_page_url?token=$token'>Restablecer Contraseña</a><br><br>El enlace expirará en 1 hora.";
            
            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Correo de recuperación enviado.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al generar el token.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'El correo no se encuentra registrado.']);
}

mysqli_close($conexion);
?>
