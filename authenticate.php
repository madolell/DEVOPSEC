<?php
session_start();

// Cambia esta información de conexión según tu configuración.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

// Determina qué base de datos estás usando
$DB_TYPE = 'MYSQL'; 

// Intenta conectarte utilizando la información anterior.
switch ($DB_TYPE) {
    case 'MYSQL':
        $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if ($conn->connect_error) {
            // Si hay un error en la conexión, detén el script y muestra el error.
            die('Error al conectar con MySQL: ' . $conn->connect_error);
        }
        break;
    default:
        die('Tipo de base de datos no válido');
}

// Variable para almacenar mensajes de error
$error_message = '';

// Verifica si se enviaron los datos del formulario de inicio de sesión.
if (isset($_POST['username'], $_POST['password'])) {
    // Prepara nuestra consulta SQL, preparar la declaración SQL evitará la inyección SQL.
    $stmt = $conn->prepare('SELECT id, password, is_admin FROM accounts WHERE username = ?');
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $is_admin);
        $stmt->fetch();
        // La cuenta existe, ahora verificamos la contraseña.
        if (password_verify($_POST['password'], $password)) {
            // Verificación exitosa. El usuario ha iniciado sesión.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['is_admin'] = $is_admin;

            // Redirigir al usuario a la página correspondiente
            if ($is_admin == 1) {
                // Si el usuario es administrador, redirigir a la página de administración
                header('Location: admin.php');
            } else {
                // Si el usuario no es administrador, redirigir a la página de inicio
                header('Location: home.php');
            }
            exit();
        } else {
            // Contraseña incorrecta
            $error_message = '¡Contraseña incorrecta!';
        }
    } else {
        // Nombre de usuario incorrecto
        $error_message = '¡Nombre de usuario incorrecto!';
    }

    $stmt->close();
}
?>
