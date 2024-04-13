<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
            color: #333;
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
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Usuario</h2>
        <?php
        include_once('../config.php');
        // Verificar si se ha proporcionado un ID de usuario
        if(isset($_GET['id'])) {
            $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
      
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Si se envió el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id = $_POST['id'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $activation_code = $_POST['activation_code'];

                $password_hashed = password_hash($password, PASSWORD_DEFAULT);


                // Consulta preparada SQL para actualizar los datos del usuario
                $stmt = $conn->prepare("UPDATE accounts SET username=?, email=?, password=?, activation_code=? WHERE id=?");
                $stmt->bind_param("ssssi", $username, $email, $password_hashed, $activation_code, $id);

                if ($stmt->execute()) {
                    echo '<div class="success-message">Datos actualizados correctamente.</div>';
                    echo '<script>setTimeout(function(){ window.location.href = "../admin.php"; }, 1000);</script>';
                } else {
                    echo '<div class="error-message">Error al actualizar los datos.</div>';
                }
                $stmt->close();
            }

            // Consulta preparada SQL para obtener los datos del usuario seleccionado
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM accounts WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                // Mostrar el formulario de edición con los datos del usuario
                $row = $result->fetch_assoc();
                ?>
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <label for="username">Nombre de usuario:</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required><br>
                        <label for="email">Correo electrónico:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br>
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" value="" required><br>
                        <label for="activation_code">Codigo de activación:</label>
                        <input type="text" id="activation_code" name="activation_code" value="<?php echo htmlspecialchars($row['activation_code']); ?>" required><br>
                        <input type="submit" value="Guardar Cambios">
                    </form>
                <?php
            } else {
                echo "No se encontró el usuario con el ID proporcionado.";
            }

            // Cerrar la conexión
            $stmt->close();
            $conn->close();
        } else {
            echo "No se ha proporcionado un ID de usuario.";
        }
        ?>
    </div>
</body>
</html>
