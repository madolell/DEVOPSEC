<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $DATABASE_HOST = "localhost";
    $DATABASE_USER = "root";
    $DATABASE_PASS = "";
    $DATABASE_NAME = "phplogin";
    $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener los datos del formulario y verificar que no estén vacíos
    $username = !empty($_POST['username']) ? $_POST['username'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $activation_code = !empty($_POST['activation_code']) ? $_POST['activation_code'] : null;

    // Verificar que no hay campos vacíos
    if ($username && $email && $password && $activation_code) {

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Consulta preparada SQL para insertar un nuevo usuario
        $stmt = $conn->prepare("INSERT INTO accounts (username, email, password, activation_code) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password_hashed, $activation_code);

        if ($stmt->execute()) {
            header("Location: ../admin.php");
        } else {
            echo "Error al crear el usuario: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Por favor, rellena todos los campos del formulario.";
    }

    // Cerrar la conexión
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
</head>
    <style>
        body{
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: blue 0px 0px 0px 2px inset, rgb(255, 255, 255) 10px -10px 0px -3px, rgb(31, 193, 27) 10px -10px, rgb(255, 255, 255) 20px -20px 0px -3px, rgb(255, 217, 19) 20px -20px, rgb(255, 255, 255) 30px -30px 0px -3px, rgb(255, 156, 85) 30px -30px, rgb(255, 255, 255) 40px -40px 0px -3px, rgb(255, 85, 85) 40px -40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            color: #555;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
<body>
    <div class="container">
        <h2>Crear Usuario</h2>
        <form action="create.php" method="POST">
            <label for="username">Nombre de usuario:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="email">Correo electrónico:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="activation_code">Código de activación:</label><br>
            <input type="text" id="activation_code" name="activation_code" required><br><br>
            <input type="submit" value="Crear Usuario">
        </form>
    </div>
</body>
</html>
