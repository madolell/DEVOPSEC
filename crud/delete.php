<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phplogin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado un ID para eliminar
if(isset($_GET['id'])) {
    // Validar el ID proporcionado para evitar inyección de SQL
    $id = intval($_GET['id']);

    if ($id <= 0) {
        die("ID no válido.");
    }

    // Consulta preparada para eliminar el usuario con el ID proporcionado
    $stmt = $conn->prepare("DELETE FROM accounts WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: ../admin.php');
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No se ha proporcionado un ID para eliminar.";
}

// Cerrar la conexión
$conn->close();
?>

