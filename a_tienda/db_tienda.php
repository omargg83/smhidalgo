<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}
	
class Tienda extends Sagyc{
	
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

	public function tiendas_lista(){
		self::set_names();
		
		$sql="SELECT * FROM et_tienda";
		foreach ($this->dbh->query($sql) as $res){
            $this->tiendas[]=$res;
        }
        return $this->tiendas;
        $this->dbh=null;
	}

	public function tienda($id){
		self::set_names();
		$sql="SELECT * FROM et_tienda where id='$id'";
		 foreach ($this->dbh->query($sql) as $res){
            $this->tienda=$res;
        }
        return $this->tienda;
        $this->dbh=null;
	}

	public function guardar_tienda(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		}
		if (isset($_REQUEST['ubicacion'])){
			$arreglo+=array('ubicacion'=>$_REQUEST['ubicacion']);
		}
		if($id==0){
			$x.=$this->insert('et_tienda', $arreglo);
		}
		else{
			$x.=$this->update('et_tienda',array('id'=>$id), $arreglo);
		}
		return $x;
	}
}

if(strlen($function)>0){
	$db = new Tienda();
	echo $db->$function();
}


