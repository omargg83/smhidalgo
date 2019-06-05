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

	public function inventario($id){
		self::set_names();
		$sql="select * from et_invent where id_invent='$id'
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
		 foreach ($this->dbh->query($sql) as $res){
            $this->inventario[]=$res;
        }
        return $this->inventario;
        $this->dbh=null;
	}
	public function inventario_lista(){
		self::set_names();

			$sql="select * from et_invent	left outer join et_marca on et_marca.idmarca=et_invent.idmarca
				left outer join et_modelo on et_modelo.idmodelo=et_invent.idmodelo";
      foreach ($this->dbh->query($sql) as $res){
          $this->ventas[]=$res;
      }
      return $this->ventas;
      $this->dbh=null;
	}
	public function categoria_lista(){
		self::set_names();
		$sql="select * from et_categoria";
				foreach ($this->dbh->query($sql) as $res){
						$this->ventas[]=$res;
				}
				return $this->ventas;
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



	public function guardar_producto(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['codigo'])){
			$arreglo+=array('codigo'=>$_REQUEST['codigo']);
		}
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		}
		if (isset($_REQUEST['unidad'])){
			$arreglo+=array('unidad'=>$_REQUEST['unidad']);
		}
		if (isset($_REQUEST['stockmin'])){
			$arreglo+=array('stockmin'=>$_REQUEST['stockmin']);
		}
		if (isset($_REQUEST['stockmax'])){
			$arreglo+=array('stockmax'=>$_REQUEST['stockmax']);
		}
		if (isset($_REQUEST['preciocompra'])){
			$arreglo+=array('preciocompra'=>$_REQUEST['preciocompra']);
		}
		if (isset($_REQUEST['pvdistr'])){
			$arreglo+=array('pvdistr'=>$_REQUEST['pvdistr']);
		}
		if (isset($_REQUEST['pvgeneral'])){
			$arreglo+=array('pvgeneral'=>$_REQUEST['pvgeneral']);
		}
		if (isset($_REQUEST['pvpromo'])){
			$arreglo+=array('pvpromo'=>$_REQUEST['pvpromo']);
		}
		if (isset($_REQUEST['descripcion'])){
			$arreglo+=array('descripcion'=>$_REQUEST['descripcion']);
		}
		if (isset($_REQUEST['categoria'])){
			$arreglo+=array('categoria'=>$_REQUEST['categoria']);
		}
		if (isset($_REQUEST['seguimiento'])){
			$arreglo+=array('seguimiento'=>$_REQUEST['seguimiento']);
		}
		if (isset($_REQUEST['unico'])){
			$arreglo+=array('unico'=>$_REQUEST['unico']);
		}
		if (isset($_REQUEST['idmarca'])){
			$arreglo+=array('idmarca'=>$_REQUEST['idmarca']);
		}
		if (isset($_REQUEST['idmodelo'])){
			$arreglo+=array('idmodelo'=>$_REQUEST['idmodelo']);
		}
		if (isset($_REQUEST['activo'])){
			$arreglo+=array('activo'=>$_REQUEST['activo']);
		}

		if($id==0){
				$fecha=date("Y-m-d H:i:s");
				$arreglo+=array('fechamod'=>$fecha);
				$arreglo+=array('fechaalta'=>$fecha);
				$x.=$this->insert('et_invent', $arreglo);
		}
		else{
			$x.=$this->update('et_invent',array('id_invent'=>$id), $arreglo);
		}
		return $x;
	}
}

if(strlen($function)>0){
	$db = new Usuario();
	echo $db->$function();
}
