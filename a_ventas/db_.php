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

		$this->ventas=array();
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

			$sql="SELECT * FROM et_bodega where idtienda='".$_SESSION['idtienda']."' and cantidad>0 and (descripcion like :texto or clave like :texto) ";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();

			$x.="<div class='row'>";
			if(count($res)>0){
				$x.="<table class='table table-sm'>";

				$x.= "<tr>";
				$x.= "<th>-</th>";
				$x.= "<th>Existencias</th>";
				$x.= "<th>Código</th>";
				$x.= "<th>Descripción</th>";
				$x.= "<th>Unidad</th>";

				$x.= "<th>Precio</th>";

				$x.="</tr>";
				foreach ($res as $key) {
					$x.= "<tr id=".$key['id']." class='edit-t'>";

					$x.= "<td>";
					$x.= "<div class='btn-group'>";
					$x.= "<button type='button' onclick='ventraprod(".$key['id'].")' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='fas fa-check'></i>+1</button>";
					$x.= "</div>";
					$x.= "</td>";

					$x.= "<td><center>";
					$x.= $key["cantidad"];
					$x.= "</center></td>";

					$x.= "<td>";
					$x.= $key["clave"];
					$x.= "</td>";

					$x.= "<td>";
					$x.= $key["descripcion"];
					$x.= "</td>";

					$x.= "<td>";
					$x.= $key["unidad"];
					$x.= "</td>";


					$x.= "<td align='right'>";
					$x.= moneda($key["pventa"]);
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
		$key=$this->bodega($id);

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
	function agregaventa(){
		parent::set_names();
		$x="";
		$idventa=$_REQUEST['idventa'];
		$idbodega=$_REQUEST['idbodega'];

/*

		if($unico=="0") echo "Almacén (Se controla el inventario por volúmen)</option>";--------------->POR VOLUMEN
		if($unico=="1") echo "Unico (se controla inventario por pieza única)</option>";--------------->PIEZA UNICA
		if($unico=="2") echo "Registro (solo registra ventas, no es necesario registrar entrada)</option>"; --------->NO SE REGISTRA EN BODEGA
		if($unico=="3") echo "Pago de linea</option>"; --------->NO SE REGISTRA EN BODEGA
		if($unico=="4") echo "Reparación</option>";  --------->NO SE REGISTRA EN BODEGA


*/
		$sql="select * from et_bodega where id=:texto";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":texto",$idbodega);
		$sth->execute();
		$res=$sth->fetch();
		if($res['unico']==0){
		}
		if($res['unico']==1){
			$arreglo =array();
			$arreglo+=array('idventa'=>$idventa);
			$arreglo+=array('cantidad'=>0);
			$arreglo+=array('pendiente'=>0);
			$arreglo+=array('total'=>1);
			$x.=$this->update('et_bodega',array('id'=>$idbodega), $arreglo);
		}
		return $x;
	}
	function borrar_venta(){
		self::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		$arreglo+=array('idventa'=>null);
		$arreglo+=array('cantidad'=>1);
		$arreglo+=array('pendiente'=>0);
		$arreglo+=array('total'=>0);
		return $this->update('et_bodega',array('id'=>$id), $arreglo);
	}
}

$db = new Venta();
if(strlen($function)>0){
	echo $db->$function();
}
