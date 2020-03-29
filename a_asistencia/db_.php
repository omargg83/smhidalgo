<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Usuario extends Sagyc{

	public $nivel_personal;
	public $nivel_captura;

	public function __construct(){
		parent::__construct();
		$this->doc="a_clientes/papeles/";

		if(isset($_SESSION['idpersona']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
		}
	}
	public function lista_acceso(){
    self::set_names();
		$sql="select *  from et_usuarioreg left outer join et_usuario on et_usuario.idusuario=et_usuarioreg.idpersonal order by fecha desc limit 1000";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
  }

}

$db = new Usuario();
if(strlen($function)>0){
	echo $db->$function();
}
