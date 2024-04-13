<?php
// Incluye el archivo authenticate.php
require_once 'authenticate.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
	
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<?php
   			// Muestra el mensaje de error si existe
    		if (!empty($error_message)) {
        		echo '<div class="error-box">' . $error_message . '</div>';
    		}
    		?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Usuario" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<div class="register-link">
    				<p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>.</p>
				</div>
				<input type="password" name="password" placeholder="Contraseña" id="password" required>
				<input type="submit" value="Iniciar Sesion">
			</form>
		</div>
	</body>
</html>