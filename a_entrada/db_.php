<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Entrada extends Sagyc{
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

	public function entrada($id){
		self::set_names();
		$this->inventario="";
		$sql="select * from et_entrada where identrada='$id'";
		foreach ($this->dbh->query($sql) as $res){
			$this->inventario=$res;
		}
		return $this->inventario;
		$this->dbh=null;
	}
	public function compras_lista(){
		self::set_names();
		$sql="select * from et_compra left outer join et_prove on et_prove.id_prove=et_compra.id_prove order by idcompra desc";
		foreach ($this->dbh->query($sql) as $res){
			$this->comprax[]=$res;
		}
		return $this->comprax;
		$this->dbh=null;
	}
	public function entrada_lista(){
		self::set_names();
		$sql="select et_entrada.identrada, et_entrada.numero, et_prove.razon_social_prove, et_compra.numero as cnumero, et_entrada.estado, et_entrada.total from et_entrada
		left outer join et_prove on et_prove.id_prove=et_entrada.id_prove
		left outer join et_compra on et_compra.idcompra=et_entrada.idcompra
		order by identrada desc";
		foreach ($this->dbh->query($sql) as $res){
			$this->ventas[]=$res;
		}
		return $this->ventas;
		$this->dbh=null;
	}
	public function entrada_pedido($id){
		self::set_names();
		$this->ventasp=array();
		$sql="select et_bodega.id, et_invent.codigo, et_invent.nombre, et_invent.unidad, abs(et_bodega.cantidad) as cantidad, et_bodega.total, et_bodega.clave,
		et_bodega.precio, et_bodega.gtotal, et_bodega.pendiente, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.gtotal, et_bodega.id_invent,
		et_bodega.observaciones, et_bodega.color, et_bodega.tipo from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where identrada='$id'
		order by et_bodega.id desc";
		foreach ($this->dbh->query($sql) as $res){
			$this->ventasp[]=$res;
		}
		return $this->ventasp;
		$this->dbh=null;
	}

	public function proveedores_lista(){
		self::set_names();
		$sql="SELECT * FROM et_prove";
		foreach ($this->dbh->query($sql) as $res){
			$this->clientes[]=$res;
		}
		return $this->clientes;
		$this->dbh=null;
	}


	function guardar_entrada(){
		$x="";
		parent::set_names();
		$arreglo =array();
		$id=$_REQUEST['id'];
		if (isset($_REQUEST['numero'])){
			$arreglo+=array('numero'=>$_REQUEST['numero']);
		}
		if (isset($_REQUEST['id_prove'])){
			$arreglo+=array('id_prove'=>$_REQUEST['id_prove']);
		}
		if (isset($_REQUEST['idcompra'])){
			$arreglo+=array('idcompra'=>$_REQUEST['idcompra']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('estado'=>$_REQUEST['estado']);
		}
		if (isset($_REQUEST['unico'])){
			$arreglo+=array('unico'=>$_REQUEST['unico']);
		}
		if($id==0){
			$x.=$this->insert('et_entrada', $arreglo);
		}
		else{
			$x.=$this->update('et_entrada',array('identrada'=>$id), $arreglo);
		}
		return $x;
	}
	public function borrar_producto(){
		self::set_names();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		return $this->borrar('et_bodega',"id",$id);
	}
	function busca_producto(){
		try{
			$x="";
			if (isset($_REQUEST['texto'])){$texto=$_REQUEST['texto'];}
			parent::set_names();

			$sql="SELECT * FROM et_invent where nombre like :texto OR codigo like :nombre";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->bindValue(":nombre","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();
			$x.="<div class='row'>";
			if(count($res)>0){
				$x.="<table class='table table-sm'>";
				$x.="<tr><th>Código</th><th>Nombre</th><th>Cantidad</th><th>+</th></tr>";
				foreach ($res as $key) {
					$x.= "<tr id=".$key['id_invent']." class='edit-t'>";
					$x.= "<td>";
					$x.= $key["codigo"];
					$x.= "</td>";

					$x.= "<td>";
					$x.= $key["nombre"];
					$x.= "</td>";

					$x.= "<td>";
					$x.= "<input id='cantidad_".$key['id_invent']."' name='cantidad_".$key['id_invent']."' value='1' class='form-control'>";
					$x.= "</td>";

					$x.= "<td>";
					$x.= "<div class='btn-group'>";
					$x.= "<button class='btn btn-outline-secondary btn-sm' id='producto_sel' title='Agregar producto a la compra'><i class='fas fa-plus'></i></button>";
					$x.= "</div>";
					$x.= "</td>";
					$x.= "</tr>";
				}
				$x.= "</table>";
			}
			else{
				$x="<div class='alert alert-primary' role='alert'>No se encontró: $texto</div>";
			}
			$x.="</div>";
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
		return $texto;
	}






	/////////////////////////////////////







	function agregar_producto(){
		$x="";
		parent::set_names();
		$arreglo =array();

		if (isset($_REQUEST['id_invent'])){
			$arreglo+=array('id_invent'=>$_REQUEST['id_invent']);
		}

		if (isset($_REQUEST['cantidad'])){
			$arreglo+=array('cantidad_oc'=>$_REQUEST['cantidad']);
		}

		if (isset($_REQUEST['idcompra'])){
			$arreglo+=array('idcompra'=>$_REQUEST['idcompra']);
		}

		$x.=$this->insert('et_comprapedido', $arreglo);

		return $x;
	}

}

$db = new Entrada();
if(strlen($function)>0){
	echo $db->$function();
}
