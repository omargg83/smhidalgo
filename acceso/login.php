<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Acceso o registro</title>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SAGYC</title>
	<!--   Core JS Files   -->
	<link rel="icon" type="image/png" href="img/favicon.ico">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script src="librerias15/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="librerias15/jquery/jquery-ui.js"></script>
	
	<script src="librerias15/swal/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="librerias15/swal/dist/sweetalert2.min.css">

	<link rel="stylesheet" href="librerias15/css/bootstrap.min.css">
	<script src="librerias15/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="librerias15/modulos.css"/>
	
	<link rel="stylesheet" href="librerias15/fontawesome-free-5.8.1-web/css/all.css">	
	<script src="librerias15/jQuery-MD5-master/jquery.md5.js"></script>
	<script src="sagyc.js" type="text/javascript"></script>
	
</head>
	<?php
		$arreglo=array();
		$directory="fondo/";
		$dirint = dir($directory);
		$contar=0;
		while (($archivo = $dirint->read()) !== false){
			if ($archivo != "." && $archivo != ".." && $archivo != "" && substr($archivo,-4)==".jpg"){
				$arreglo[$contar]=$directory.$archivo;
				$contar++;
			}
		}
		$valor=$arreglo[rand(1,$contar-1)];
		$_SESSION['idfondo']=$valor;
		echo "<body style='background-image: url(\"$valor\")'>";
	?>
<div id='data'>
		<form id="acceso" action="">
		<br>
		<br>
		<br>
			<div class='container'>
				<div class='logincard' style='
				-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
				-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
				box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);'>
					
						<center><img src='img/logo.png' width='250px'></center>
						
						<p class='input_title'>Usuario o correo:</p>
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fas fa-user-circle"></i> </span>
							</div>
							<input class="form-control" placeholder="Introduzca usuario o correo" type="text"  id="userAcceso" name="userAcceso" required>
						</div>
						
						<p class='input_title'>Contraseña:</p>
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input class="form-control" placeholder="Contraseña" type="password"  id="passAcceso" name="passAcceso" required>
						</div>
						<button class="btn btn-outline-secondary btn-block" type="submit"><i class='fa fa-check'></i>Aceptar</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>