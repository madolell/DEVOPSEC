<?php
// Verificar si se ha proporcionado un ID de usuario
if(isset($_GET['id'])) {
    // Conexión a la base de datos
    include_once('../config.php');

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el ID del usuario seleccionado
    $id = $_GET['id'];

    // Consulta SQL preparada para obtener los datos del usuario seleccionado
    $sql = "SELECT id, username, email, password, activation_code FROM accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: blue 0px 0px 0px 2px inset, rgb(255, 255, 255) 10px -10px 0px -3px, rgb(31, 193, 27) 10px -10px, rgb(255, 255, 255) 20px -20px 0px -3px, rgb(255, 217, 19) 20px -20px, rgb(255, 255, 255) 30px -30px 0px -3px, rgb(255, 156, 85) 30px -30px, rgb(255, 255, 255) 40px -40px 0px -3px, rgb(255, 85, 85) 40px -40px;
        
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .user-details {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            color: #333;

        }

        .user-details label {
            font-weight: bold;
        }

        .user-details p {
            margin: 15px 0;
        }

        .error-message {
            color: #ff0000;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detalles del Usuario</h2>
        <?php
        if(isset($user)) {
            // Datos del usuario
            echo '<div class="user-details">';
            echo '<label>ID:</label><p>' . htmlspecialchars($user["id"]) . '</p>';
            echo '<label>Nombre de usuario:</label><p>' . htmlspecialchars($user["username"]) . '</p>';
            echo '<label>Correo electrónico:</label><p>' . htmlspecialchars($user["email"]) . '</p>';
            echo '<label>Contraseña:</label><p>' . htmlspecialchars($user["password"]) . '</p>';
            echo '<label>Codigo de activación:</label><p>' . htmlspecialchars($user["activation_code"]) . '</p>';
            echo '</div>';
        } else {
            echo '<p class="error-message">No se encontró el usuario con el ID proporcionado.</p>';
        }
        ?>
    </div>
</body>
</html>
