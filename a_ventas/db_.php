<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Venta extends Sagyc{

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

	public function venta($id){
		self::set_names();
		$sql="select * from et_venta where idventa='$id'";
		$this->ventas="";
		foreach ($this->dbh->query($sql) as $res){
			$this->ventas=$res;
		}
		return $this->ventas;
		$this->dbh=null;
	}
	public function ventas_lista($idtienda){
		self::set_names();

		$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, et_cliente.razon_social_prove, et_tienda.nombre, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado, et_descuento.nombre as descuento from et_venta
		left outer join et_cliente on et_cliente.idcliente=et_venta.idcliente
		left outer join et_descuento on et_descuento.iddescuento=et_venta.iddescuento
		left outer join et_tienda on et_tienda.id=et_venta.idtienda where et_venta.idtienda='$idtienda' order by et_venta.fecha desc";


		foreach ($this->dbh->query($sql) as $res){
			$this->ventas[]=$res;
		}
		return $this->ventas;
		$this->dbh=null;
	}
	public function ventas_pedido($id){
		self::set_names();
		$sql="select et_bodega.id, et_bodega.clave, et_invent.codigo, et_invent.nombre, abs(et_bodega.cantidad) as cantidad, et_bodega.precio, et_bodega.pventa, et_bodega.pendiente, et_bodega.total, et_bodega.gtotal, et_bodega.gtotalv, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.id_invent, et_bodega.unico, et_bodega.observaciones from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where idventa='$id' order by et_bodega.id desc";
		$this->ventasp=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->ventasp[]=$res;
		}
		return $this->ventasp;
		$this->dbh=null;
	}

	public function clientes_lista(){
		self::set_names();
		$sql="SELECT * FROM et_cliente";
		$this->clientes=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->clientes[]=$res;
		}
		return $this->clientes;
		$this->dbh=null;
	}
	public function tiendas_lista(){
		self::set_names();
		$this->tiendas=array();
		$sql="SELECT * FROM et_tienda where id='".$_SESSION['idtienda']."'";
		foreach ($this->dbh->query($sql) as $res){
			$this->tiendas[]=$res;
		}
		return $this->tiendas;
		$this->dbh=null;
	}

	public function descuento_lista(){
		self::set_names();
		$sql="SELECT * FROM et_descuento";
		$this->descuento=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->descuento[]=$res;
		}
		return $this->descuento;
		$this->dbh=null;
	}
	function guardar_venta(){
		$x="";
		parent::set_names();
		$arreglo =array();
		$id=$_REQUEST['id'];
		if (isset($_REQUEST['idcliente'])){
			$arreglo+=array('idcliente'=>$_REQUEST['idcliente']);
		}
		if (isset($_REQUEST['idtienda'])){
			$arreglo+=array('idtienda'=>$_REQUEST['idtienda']);
		}
		if (isset($_REQUEST['iddescuento'])){
			$arreglo+=array('iddescuento'=>$_REQUEST['iddescuento']);
		}
		if (isset($_REQUEST['lugar'])){
			$arreglo+=array('lugar'=>$_REQUEST['lugar']);
		}
		if (isset($_REQUEST['entregarp'])){
			$arreglo+=array('entregarp'=>$_REQUEST['entregarp']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('estado'=>$_REQUEST['estado']);
		}
		if (isset($_REQUEST['factura'])){
			$arreglo+=array('factura'=>$_REQUEST['factura']);
		}
		if($id==0){
			$date=date("Y-m-d H:i:s");
			$arreglo+=array('fecha'=>$date);
			$x.=$this->insert('et_venta', $arreglo);
		}
		else{
			$x.=$this->update('et_venta',array('idventa'=>$id), $arreglo);
		}
		return $x;
	}
	function busca_producto(){
		try{
			$x="";
			if (isset($_REQUEST['texto'])){$texto=$_REQUEST['texto'];}
			if (isset($_REQUEST['idtienda'])){$idtienda=$_REQUEST['idtienda'];}
			parent::set_names();


			$sql="SELECT * FROM et_invent
				left outer join et_bodega on et_bodega.id_invent=et_invent.id_invent  where (et_invent.nombre like :texto OR et_invent.codigo like :nombre)";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->bindValue(":nombre","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();

			$x.="<div class='row'>";
			if(count($res)>0){
				$x.="<table class='table table-sm'>";

				$x.= "<tr>";
				$x.= "<th>Código</th>";
				$x.= "<th>Descripción</th>";
				$x.= "<th><span class='pull-right'>Cantidad</span></th>";
				$x.= "<th><span class='pull-right'>Precio</span></th>";
				$x.= "<th><span class='pull-right'>Material</span></th>";
				$x.= "<th><span class='pull-right'>Color</span></th>";
				$x.= "<th><span class='pull-right'>Clave/IMEI</span></th>";
				$x.= "<th><span class='pull-right'></span></th>";
				$x.="</tr>";
				foreach ($res as $key) {
					$x.= "<tr id=".$key['id_invent']." class='edit-t'>";

					$x.= "<td>";
					$x.= "<div class='btn-group'>";
					$x.= "<button type='button' id='entradasel' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='fas fa-plus'></i></button>";
					$x.= "</div>";
					$x.= "</td>";

					$x.= "<td>";
					$x.= $key["codigo"];
					$x.= "</td>";

					$x.= "<td>";
					$x.= $key["nombre"];
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
	function pre_sel(){
		$x="";
		$id=$_REQUEST['id'];
		$identrada=$_REQUEST['identrada'];
		$key=$this->inventario($id);

		$x.="<form action='' id='form_cliente' data-lugar='a_entrada/db_' data-funcion='agregar_producto' data-destino='a_entrada/editar'>";
			$x.="<input type='hidden' class='form-control input-sm' style='text-align:right' id='id' name='id' value='$id' readonly>";
			$x.="<input type='hidden' class='form-control input-sm' style='text-align:right' id='identrada' name='identrada' value='$identrada' readonly>";
			$x.="<div class='row'>";

				$x.="<div class='col-2'>";
					$x.="<label>Codigo</label>";
					$x.="<input type='text' class='form-control input-sm' id='codigo' name='codigo' value='".$key["codigo"]."' readonly>";
				$x.="</div>";

				$x.="<div class='col-4'>";
					$x.="<label>Descripción</label>";
					$x.="<input type='text' class='form-control input-sm' id='descripcion' name='descripcion' value='".$key["nombre"]."' readonly>";
				$x.="</div>";

				$unico="";
				if($key["unico"]==1){
					$unico="readonly";
				}
				$x.="<div class='col-4'>";
						$x.="<label>Color</label>";
						$x.="<input type='text' class='form-control input-sm' id='color' name='color' value='' placeholder='Color'>";
				$x.="</div>";

				$x.="<div class='col-2'>";
					$x.="<label>Material</label>";
					$x.= "<select class='form-control' name='material' id='material'>";
					$x.= "<option value=''></option>";
					$x.= "<option value='PREPAGO'>PREPAGO</option>";
					$x.= "<option value='TARIFARIO'>TARIFARIO</option>";
					$x.= "<option value='AMIGO CHIP'>AMIGO CHIP</option>";
					$x.= "<option value='LIBRES'>LIBRES</option>";
					$x.= "<option value='CONSIGNA'>CONSIGNA</option>";
					$x.= "</select>";
				$x.="</div>";

				$x.="<div class='col-4'>";
					$x.="<label>Cantidad</label>";
					$x.="<input type='text' class='form-control input-sm' style='text-align:right' id='cantidad' name='cantidad' value='1' $unico>";
				$x.="</div>";

				$x.="<div class='col-4'>";
					$x.="<label>Precio de compra</label>";
					$x.="<input type='text' class='form-control input-sm' style='text-align:right' id='precio'  name='precio' value='".$key['preciocompra']."'>";
				$x.="</div>";

				$x.="<div class='col-4'>";
					$x.="<label>Clave/IMEI</label>";
					$x.="<input type='text' class='form-control input-sm' id='clave'  value='' placeholder='Clave' >";
				$x.="</div>";

			$x.="</div>";
			$x.="<div class='row'>";
				$x.="<div class='col-12'>
					<div class='btn-group'>
						<button class='btn btn-outline-secondary btn-sm' title='Agregar producto a la compra' type='submit'><i class='fas fa-plus'></i>Agregar</button>
					</div>
				</div>";
			$x.="</div>";
		$x.="</form>";
		///////////////////////////////////////////////////////////////////////////
		return $x;
	}
}

$db = new Venta();
if(strlen($function)>0){
	echo $db->$function();
}
