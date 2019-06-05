<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Modelo extends Sagyc{

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

	public function modelo($id){
		self::set_names();
		$sql="select * from et_modelo where idmodelo='$id'";
		foreach ($this->dbh->query($sql) as $res){
            $this->ventas=$res;
        }
        return $this->ventas;
        $this->dbh=null;
	}
	public function modelo_lista(){
		self::set_names();
		 $this->modelo=array();
		$sql="SELECT * FROM et_modelo";
		 foreach ($this->dbh->query($sql) as $res){
            $this->modelo[]=$res;
        }
        return $this->modelo;
        $this->dbh=null;
	}

	public function guardar_modelo(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['modelo'])){
			$arreglo+=array('modelo'=>$_REQUEST['modelo']);
		}

		if($id==0){
			$x.=$this->insert('et_modelo', $arreglo);
		}
		else{
			$x.=$this->update('et_modelo',array('idmodelo'=>$id), $arreglo);
		}
		return $x;
	}
}

if(strlen($function)>0){
	$db = new Modelo();
	echo $db->$function();
}
