<?php
	require_once("../form/control_db.php");
	
	$tipo = $_POST["tipo"]; 
	if($tipo==1){
		$bdd = new Venta();
		//Obtenemos los datos del formulario de acceso
		$userPOST = $_POST["userAcceso"]; 
		$passPOST = $_POST["passAcceso"];

		//Filtro anti-XSS
		$userPOST = htmlspecialchars( $userPOST);
		$passPOST = htmlspecialchars( $passPOST);
		
		$datos = $bdd->acceso($userPOST, $passPOST);

		if($userPOST == $datos['user'] and $passPOST==$datos['pass']){
			$_SESSION['idusuario'] = $datos['idusuario'];
			$_SESSION['idtienda'] = $datos['idtienda'];
			$_SESSION['nivel'] = $datos['nivel'];
			$_SESSION['user'] = $datos['user'];
			$_SESSION['estado'] = 'Autenticado';
			$_SESSION['foco']=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
			
			echo "1";
		} 
		else {
			echo "Usuario o Contraseña incorecta";
		}
	}
	if($tipo==2){
		$telefono = $_POST["telefono"]; 
		
		require '../librerias/gmail/PHPMailerAutoload.php';
		
		$sql="select * from afiliados where Correo='$telefono' or Celular='$telefono'";
		$fecha=date("Y-m-d H:i:s");
		$consulta=mysqli_query($link,$sql);
		$num_rows=mysqli_num_rows($consulta);
		$rx=mysqli_fetch_array($consulta);
		if ($num_rows>0){
			if (filter_var($telefono, FILTER_VALIDATE_EMAIL) and $rx['Correo']==$telefono) {
				$mail = new PHPMailer();
				$mail->CharSet = 'UTF-8';
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "ssl";
				$mail->Host = "cs8.webhostbox.net";
				$mail->Port = 465;
				$mail->Username = "no_reply@snte.sagyc.com.mx";
				$mail->Password = "1234567890";
				
				$mail->From = "no_reply@snte.sagyc.com.mx";
				$mail->FromName = "SNTE";
				$mail->Subject = "SNTE";
				$mail->AltBody = "AVISO";
				
				$t="<br>Sistema de Credito y caja de ahorro<br>";
				$t.="la contraseña es: <b>".$rx['password']."</b>";
				
				$mail->MsgHTML($t);
				
				$mail->AddAddress("$telefono");			
				$mail->AddAttachment("logo_completo.jpg");
				
				$mail->IsHTML(true);
				if(!$mail->Send()) {
					echo $mail->ErrorInfo;
				} else {
					
				}
				$tipo="R:$telefono";
				$row = mysqli_query($link,"insert into abitacora (acceso, fecha, tipo,enviado) values ('".$rx['Filiacion']."','$fecha','$tipo','1') ");
			}
			else{
				$numero=trim($rx['celular']);
				$t=trim($rx['password']);
				$sql="insert into abitacora (acceso, fecha, tipo,numero, enviado, texto) values ('".$rx['Filiacion']."','$fecha','$tipo','$numero','0', '$t') ";
				if(mysqli_query($link,$sql)){
					
				}
			}
		}
		else{
			echo "No registrado";
		}
		
		
	}
?>
