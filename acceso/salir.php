<?php
	session_start();
	
	//Des-establecemos todas las sesiones
	unset($_SESSION);

	//Destruimos las sesiones
	session_destroy();

	//Redireccionamos a el index
	header("Location: ../");
	die();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cerrando sesión...</title>
</head>
<body>
</body>
</html>