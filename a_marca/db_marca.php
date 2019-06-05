<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}
	
class Marca extends Sagyc{
	
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

	public function marca($id){
		self::set_names();
		$this->marca="";
		$sql="select * from et_marca where idmarca='$id'";
		foreach ($this->dbh->query($sql) as $res){
            $this->marca=$res;
        }
        return $this->marca;
        $this->dbh=null;
	}
	public function marca_lista(){
		self::set_names();
		$this->marca=array();
		$sql="SELECT * FROM et_marca";
		 foreach ($this->dbh->query($sql) as $res){
            $this->marca[]=$res;
        }
        return $this->marca;
        $this->dbh=null;
	}
	public function guardar_marca(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['marca'])){
			$arreglo+=array('marca'=>$_REQUEST['marca']);
		}
		if($id==0){
			$x.=$this->insert('et_marca', $arreglo);
		}
		else{
			$x.=$this->update('et_marca',array('idmarca'=>$id), $arreglo);
		}
		return $x;
	}
}

if(strlen($function)>0){
	$db = new Marca();
	echo $db->$function();
}

