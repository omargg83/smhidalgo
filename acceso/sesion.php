<?php
	session_start();
	
	class objx {
		public $activo = 0;
	}
	$myObj = new objx;
	
	
	if($_SESSION['estado'] == 'Autenticado' and strlen($_SESSION['idusuario'])>0 and strlen($_SESSION['idtienda'])>0) {
		$myObj->activo = 1;
		$myJSON = json_encode($myObj);
		echo $myJSON;
	} 
	else {
		$myObj->activo = 0;
		echo $myJSON;
	}	
?>