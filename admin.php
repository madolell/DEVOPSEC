<?php
include_once('config.php');
session_start();

// Consulta preparada para seleccionar datos de la tabla accounts
$sql = "SELECT id, username, email, activation_code FROM accounts";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $username, $email, $activation_code);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 100px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        a {
            text-decoration: none;
            color: #007bff;
            cursor: pointer;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
<body>
    <h2>Administración de Usuarios</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre de Usuario</th>
            <th>Correo Electrónico</th>
            <th>Codigo de activación</th>
            <th>Acciones</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
        // Iterar sobre los resultados de la consulta y mostrar los usuarios en una tabla
        while ($stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($id, ENT_QUOTES) . "</td>";
            echo "<td>" . htmlspecialchars($username, ENT_QUOTES) . "</td>";
            echo "<td>" . htmlspecialchars($email, ENT_QUOTES) . "</td>";
            echo "<td>" . htmlspecialchars($activation_code, ENT_QUOTES) . "</td>";
            echo "<td><a href='crud/create.php?id=" . htmlspecialchars($id, ENT_QUOTES) . "'>Crear</a></td>";
            echo "<td><a href='crud/edit.php?id=" . htmlspecialchars($id, ENT_QUOTES) . "'>Editar</a></td>";
            echo "<td><a href='crud/read.php?id=" . htmlspecialchars($id, ENT_QUOTES) . "'>Leer</a></td>";
            echo "<td><a href='crud/delete.php?id=" . htmlspecialchars($id, ENT_QUOTES) . "'>Eliminar</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
