<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Inventario extends Sagyc{

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
	public function modelo($id){
		self::set_names();
		$sql="select * from et_modelo where idmodelo='$id'";
		foreach ($this->dbh->query($sql) as $res){
			$this->ventas=$res;
		}
		return $this->ventas;
		$this->dbh=null;
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
	public function inventario($id){
		self::set_names();
		$sql="select * from et_invent
		left outer join et_marca on et_marca.idmarca=et_invent.idmarca
		left outer join et_modelo on et_modelo.idmodelo=et_invent.idmodelo
		where id_invent='$id'
		order by id_invent asc";
		foreach ($this->dbh->query($sql) as $res){
			$this->inventario=$res;
		}
		return $this->inventario;
		$this->dbh=null;
	}
	public function inventario_detalle($id){
		self::set_names();
		$sql="select * from et_bodega where id_invent='$id'";
		$this->inventario=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->inventario[]=$res;
		}
		return $this->inventario;
		$this->dbh=null;
	}
	public function inventario_lista($idtienda){
		self::set_names();

		$sql="select inven.id_invent, inven.codigo, inven.unico, inven.nombre, inven.pvgeneral, (select COALESCE(sum(cantidad),0) as total from et_bodega where et_bodega.id_invent=inven.id_invent and et_bodega.idtienda='$idtienda') as conteo, inven.preciocompra, inven.pvpromo, inven.pvdistr, et_marca.marca, et_modelo.modelo from et_invent inven
		left outer join et_marca on et_marca.idmarca=inven.idmarca
		left outer join et_modelo on et_modelo.idmodelo=inven.idmodelo
		where activo=1 order by id_invent ,unico desc";

		foreach ($this->dbh->query($sql) as $res){
			$this->ventas[]=$res;
		}
		return $this->ventas;
		$this->dbh=null;
	}
	public function guardar_usuario(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		}
		if (isset($_REQUEST['idtienda'])){
			$arreglo+=array('idtienda'=>$_REQUEST['idtienda']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('activo'=>$_REQUEST['estado']);
		}
		if (isset($_REQUEST['user'])){
			$arreglo+=array('user'=>$_REQUEST['user']);
		}
		if (isset($_REQUEST['pass'])){
			$arreglo+=array('pass'=>$_REQUEST['pass']);
		}
		if (isset($_REQUEST['nivel'])){
			$arreglo+=array('nivel'=>$_REQUEST['nivel']);
		}

		if($id==0){

			$x.=$this->insert('et_usuario', $arreglo);
		}
		else{
			$x.=$this->update('et_usuario',array('idusuario'=>$id), $arreglo);
		}
		return $x;
	}
}

$db = new Inventario();
if(strlen($function)>0){
	echo $db->$function();
}
