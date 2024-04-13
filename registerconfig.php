<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

// Determina qué base de datos estás usando
$DB_TYPE = 'MYSQL'; 

// Intenta conectarte utilizando la información anterior.
switch ($DB_TYPE) {
    case 'MYSQL':
        $con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if ($con->connect_error) {
            // Si hay un error en la conexión, detén el script y muestra el error.
            die('Error al conectar con MySQL: ' . $con->connect_error);
        }
        break;
    default:
        die('Tipo de base de datos no válido');
}

// Ahora comprobamos si los datos fueron enviados, la función isset() comprobará si los datos existen.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    // No se han podido obtener los datos que deberían haberse enviado.
    exit('Por favor, completa el registro!');
}
// Asegúrese de que los valores de registro enviados no están vacíos.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    // Uno o mas valores estan vacios.
    exit('Por favor, completa el registro');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Email no valido!');
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Usuario no valido!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('La contraseña debera tener entre 5 y 20 caracteres!');
}
// Tenemos que comprobar si la cuenta con ese nombre de usuario existe.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    // Almacena el resultado para que podamos comprobar si la cuenta existe en la base de datos.
    if ($stmt->num_rows > 0) {
        // El usuario existe
        echo 'El usuario existe, por favor elige otro!';
    } else {
        // Si el usuario no existe crea una cuenta
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
            // No queremos exponer las contraseñas en nuestra base de datos, así que hash de la contraseña y el uso password_verify cuando un usuario se conecta.
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $uniqid = uniqid();
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
            $stmt->execute();
            // Comentario del envio mail (no funciona)
            // $from    = 'noreply@yourdomain.com';
            // $subject = 'Account Activation Required';
            // $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
            // $activate_link = 'http://yourdomain.com/phplogin/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
            // $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
            // mail($_POST['email'], $subject, $message, $headers);
            // Echoing the message to check
            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all three fields.
            echo 'Could not prepare statement!';
        }
    }
    $stmt->close();
}
$con->close();
?>
