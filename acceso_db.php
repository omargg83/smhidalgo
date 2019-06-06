<?php
	require_once("control_db.php");
	if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

	if(strlen($function)>0){
		echo $function();
	}

	function fondo(){
		$x="";
		$salud = new Sagyc();
		if (isset($_REQUEST['imagen'])){$imagen=$_REQUEST['imagen'];}
		$arreglo=array('idfondo'=>$imagen);
		$x=$salud->update('et_usuario',array('idusuario'=>$_SESSION['idpersona']), $arreglo);
	}
	function leerfondo(){
		return $_SESSION['idfondo'];
	}
	function acceso(){
		$bdd = new Sagyc();
		//Obtenemos los datos del formulario de acceso
		$userPOST = htmlspecialchars($_REQUEST["userAcceso"]);
		$passPOST = $_REQUEST["passAcceso"];

		$CLAVE = $bdd->acceso2($userPOST, $passPOST);
		if(is_array($CLAVE)){
			if($userPOST == $CLAVE['user'] and strtoupper($passPOST)==strtoupper($CLAVE['pass'])){
				$_SESSION['autoriza']=1;
				$_SESSION['nombre']=$CLAVE['nombre'];

				$_SESSION['idfondo']=$CLAVE['idfondo'];
				$_SESSION['nick']=$CLAVE['user'];
				$_SESSION['idpersona']=$CLAVE['idusuario'];
				$_SESSION['foto']=$CLAVE['file_foto'];
				$_SESSION['idtienda']=$CLAVE['idtienda'];


				$fecha=date("Y-m-d");
				list($anyo,$mes,$dia) = explode("-",$fecha);
				$_SESSION['n_sistema']="J&D";

				$_SESSION['cfondo']="white";
				$_SESSION['hasta']=2019;
				$_SESSION['foco']=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
				$_SESSION['cfondo']="white";

				return "1";
			}
		}
		else {
			return "Usuario o Contraseña incorrecta";
		}
	}
	function guardar_file(){
		$cal = new Sagyc();
		$arreglo =array();
		$x="";
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['ruta'])){$ruta=$_REQUEST['ruta'];}
		if (isset($_REQUEST['tipo'])){$tipo=$_REQUEST['tipo'];}
		if (isset($_REQUEST['ext'])){$ext=$_REQUEST['ext'];}
		if (isset($_REQUEST['tabla'])){$tabla=$_REQUEST['tabla'];}
		if (isset($_REQUEST['campo'])){$campo=$_REQUEST['campo'];}
		if (isset($_REQUEST['direccion'])){$direccion=$_REQUEST['direccion'];}
		if (isset($_REQUEST['keyt'])){$keyt=$_REQUEST['keyt'];}
		if($tipo==1){	//////////////update
			$arreglo+=array($campo=>$direccion);
			$x=$cal->update($tabla,array($keyt=>$id), $arreglo);
			rename("historial/$direccion", "$ruta/$direccion");
		}
		else{
			$arreglo+=array($campo=>$direccion);
			$arreglo+=array($keyt=>$id);
			$x=$cal->insert($tabla, $arreglo);
			rename("historial/$direccion", "$ruta/$direccion");
		}
		return $x;
	}
	function eliminar_file(){
		$cal = new Sagyc();
		$arreglo =array();
		$x="";
		if (isset($_REQUEST['ruta'])){$ruta=$_REQUEST['ruta'];}
		if (isset($_REQUEST['key'])){$key=$_REQUEST['key'];}
		if (isset($_REQUEST['keyt'])){$keyt=$_REQUEST['keyt'];}
		if (isset($_REQUEST['tabla'])){$tabla=$_REQUEST['tabla'];}
		if (isset($_REQUEST['campo'])){$campo=$_REQUEST['campo'];}
		if (isset($_REQUEST['tipo'])){$tipo=$_REQUEST['tipo'];}
		if (isset($_REQUEST['borrafile'])){$borrafile=$_REQUEST['borrafile'];}

		if($borrafile==1){
			if ( file_exists($_REQUEST['ruta']) ) {
				unlink($_REQUEST['ruta']);
			}
			else{
			}
		}
		if($tipo==1){ ////////////////actualizar tabla
			$arreglo+=array($campo=>"");
			$x.=$cal->update($tabla,array($keyt=>$key), $arreglo);
		}
		if($tipo==2){
			$x.=$cal->borrar($tabla,$keyt,$key);
		}
		return "$x";
	}
	function anioc(){
		$x="";
		$salud = new Sagyc();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$_SESSION['anio']=$id;
		return "Se establecio: $id como año de trabajo";
	}
	function subir_file(){
		$contarx=0;
		$arr=array();

		foreach ($_FILES as $key){
			$extension = pathinfo($key['name'], PATHINFO_EXTENSION);
			$n = $key['name'];
			$s = $key['size'];
			$string = trim($n);
			$string = str_replace( $extension,"", $string);
			$string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string );
			$string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string );
			$string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string );
			$string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string );
			$string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string );
			$string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string );
			$string = str_replace( array(' '), array('_'), $string);
			$string = str_replace(array("\\","¨","º","-","~","#","@","|","!","\"","·","$","%","&","/","(",")","?","'","¡","¿","[","^","`","]","+","}","{","¨","´",">","<",";",",",":","."),'', $string );
			$string.=".".$extension;

			$n_nombre=date("YmdHis")."_".$contarx."_".rand(1,1983).".".$extension;
			$destino="historial/".$n_nombre;

			if(move_uploaded_file($key['tmp_name'],$destino)){
				chmod($destino,0666);
				$arr[$contarx] = array("archivo" => $n_nombre);
			}
			else{

			}
			$contarx++;
		}
		$myJSON = json_encode($arr);
		return $myJSON;
	}
	function recuperar(){
		$cal = new Sagyc();
		$x="";
		require 'librerias15/PHPMailer-5.2-stable/PHPMailerAutoload.php';

		$telefono="";
		if (isset($_REQUEST['telefono'])){$texto=$_REQUEST['telefono'];}
		$sql="select * from personal where correo='$texto'";
		$res=$cal->general($sql);
		if(count($res)>0){

			if(strlen($res[0]['correo'])>0){
				$x.=$res[0]['correo'];
				$mail = new PHPMailer;
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = "smtp.gmail.com";						  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = "sistema.subsaludpublicahgo@gmail.com";       // SMTP username
				$mail->Password = "TEUFEL123";                       // SMTP password
				$mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 465;                                    // TCP port to connect to
				$mail->CharSet = 'UTF-8';

				$mail->From = "sistema.subsaludpublicahgo@gmail.com";
				$mail->FromName = "Sistema Administrativo de Salud Pública";
				$mail->Subject = "Recuperar contraseña";
				$mail->AltBody = "Contraseña";
				$mail->addAddress($res[0]['correo']);     // Add a recipient
				$mail->addCC('omargg83@gmail.com');

				// $mail->addAddress('ellen@example.com');               // Name is optional
				// $mail->addReplyTo('info@example.com', 'Information');
				// $mail->addCC('cc@example.com');
				// $mail->addBCC('bcc@example.com');

				//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML

				$numero="pass_".rand(1,6666666);
				$arreglo=array("llave"=>$numero);
				$cal->update('personal',array('idpersona'=>$res[0]['idpersona']), $arreglo);

				$texto="Recuperar contraseña <b>Contraseña! $x</b>";
				$texto.="<br><a href='http://spublicahgo.ddns.net/acceso/index.php?llave=$numero'>De click para recuperar la contraseña</a>";
				$mail->Body    = $texto;
				$mail->AltBody = "Recuperar contraseña";

				if(!$mail->send()) {
				    $x.= 'Message could not be sent.';
				    $x.= 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
				   	$x= 'Se envío enlace a su correo';
				}
				return $x;
			}
			else{
				return "no tiene correo registrado en la plantilla";
			}

		}
		else{
			return 0;
		}
	}
	function password_cambia(){
		$cal = new Sagyc();
		if (isset($_REQUEST['usuario'])){$usuario=$_REQUEST['usuario'];}
		if (isset($_REQUEST['pass1'])){$pass1=trim($_REQUEST['pass1']);}
		if (isset($_REQUEST['pass2'])){$pass2=trim($_REQUEST['pass2']);}

		if($pass1==$pass2){
			$arreglo=array('pass'=>$pass1);
			$x=$cal->update('personal',array('llave'=>$usuario), $arreglo);
			return 1;
		}
		else{
			return "no coincide";
		}
	}
	function fondo_carga(){
		$x="";

		$directory="fondo/";
		$dirint = dir($directory);
		$x.= "<ul class='nav navbar-nav navbar-right'>";
			$x.= "<li class='nav-item dropdown'>";
				$x.= "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-desktop'></i>Fondos</a>";
				$x.= "<div class='dropdown-menu' aria-labelledby='navbarDropdown' style='width: 200px;max-height: 400px !important;overflow: scroll;overflow-x: scroll;overflow-x: hidden;'>";
					while (($archivo = $dirint->read()) !== false){
						if ($archivo != "." && $archivo != ".." && $archivo != "" && substr($archivo,-4)==".jpg"){
							$x.= "<a class='dropdown-item' href='#' id='fondocambia' title='Click para aplicar el fondo'><img src='$directory".$archivo."' alt='Fondo' class='rounded' style='width:140px;height:80px'></a>";
						}
					}
				$x.= "</div>";
			$x.= "</li>";
		$x.= "</ul>";
		$dirint->close();

		return $x;
	}
?>
