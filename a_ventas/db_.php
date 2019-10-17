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
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetch();
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
		$sql="select et_bodega.id, et_bodega.clave, et_invent.codigo, et_invent.nombre, abs(et_bodega.cantidad) as cantidad, et_bodega.precio, et_bodega.pventa, et_bodega.pendiente, et_bodega.total, et_bodega.gtotal, et_bodega.gtotalv, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.id_invent, et_bodega.observaciones from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where idventa='$id' order by et_bodega.id desc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
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
	public function guardar_venta(){
		$x="";
		parent::set_names();
		$arreglo =array();
		$id=$_REQUEST['id'];
		if (isset($_REQUEST['idcliente'])){
			$arreglo+=array('idcliente'=>$_REQUEST['idcliente']);
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
			$arreglo+=array('idusuario'=>$_SESSION['idpersona']);
			$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
			$x.=$this->insert('et_venta', $arreglo);
		}
		else{
			$x.=$this->update('et_venta',array('idventa'=>$id), $arreglo);
		}
		return $x;
	}
	public function busca_producto(){
		try{
			$x="";
			if (isset($_REQUEST['texto'])){$texto=$_REQUEST['texto'];}
			if (isset($_REQUEST['idtienda'])){$idtienda=$_REQUEST['idtienda'];}
			parent::set_names();

			$sql="SELECT et_bodega.* from et_bodega where idtienda='".$_SESSION['idtienda']."' and (descripcion like :texto or clave like :texto  or codigo like :texto or rapido like :texto )";

			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();

			$x.="<div class='row'>";

			$x.="<table class='table table-sm'>";
			$x.= "<tr>";
			$x.= "<th>Código</th>";
			$x.= "<th>Clave</th>";
			$x.= "<th>Rápido</th>";
			$x.= "<th>Descripción</th>";
			$x.= "<th>Precio</th>";
			$x.= "<th>Observaciones</th>";
			$x.= "<th>-</th>";
			$x.="</tr>";
			if(count($res)>0){
				foreach ($res as $key) {
					if($key["cantidad"]>0){
						$x.= "<tr id=".$key['id']." class='edit-t'>";

						$x.= "<td>";
						$x.= $key["codigo"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["clave"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["rapido"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["descripcion"];
						$x.= "</td>";

						$x.= "<td align='right'>";
						$preciov=number_format($key["pventa"],2);
						$x.= "<input type='text' class='form-control' name='precio_".$key['id']."' id='precio_".$key['id']."' value='$preciov' placeholder='cantidad' readonly>";
						$x.= "</td>";

						$x.= "<td>";
						$x.= "<input type='text' class='form-control' name='observa_".$key['id']."' id='observa_".$key['id']."' value='' placeholder='Observaciones'>";
						$x.= "</td>";

						$x.= "<td>";
						$x.= "<div class='btn-group'>";
						$x.= "<button type='button' onclick='ventraprod(".$key['id'].")' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='fas fa-plus'></i></button>";
						$x.= "</div>";
						$x.= "</td>";

						$x.= "</tr>";
					}
				}
			}


			$x.= "</table>";



			$x.="</div>";
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
		return $texto;
	}
	public function agregaventa(){
		parent::set_names();
		$x="";
		$idventa=$_REQUEST['idventa'];
		$idbodega=$_REQUEST['idbodega'];

		$precio=$_REQUEST['precio'];
		$observa=$_REQUEST['observa'];

		$sql="select * from et_bodega where id=:texto";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":texto",$idbodega);
		$sth->execute();
		$res=$sth->fetch();
		$arreglo =array();


		$arreglo+=array('idventa'=>$idventa);
		$arreglo+=array('cantidad'=>0);
		$arreglo+=array('pendiente'=>0);
		$arreglo+=array('total'=>1);
		$arreglo+=array('gtotalv'=>$res['pventa']);
		$x.=$this->update('et_bodega',array('id'=>$idbodega), $arreglo);

		return $x;
	}
	public function agregaespecial(){
		parent::set_names();
		$x="";
		$idventa=$_REQUEST['idventa'];
		$id_invent=$_REQUEST['id_invent'];
		$cantidad=$_REQUEST['cantidad'];
		$precio=$_REQUEST['precio'];
		$observa=$_REQUEST['observa'];

		$sql="select * from et_invent where id_invent=:texto";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":texto",$id_invent);
		$sth->execute();
		$res=$sth->fetch();
		$arreglo =array();

		if($res['unico']>1){
			$arreglo+=array('observaciones'=>$observa);
			$arreglo+=array('idventa'=>$idventa);
			$arreglo+=array('id_invent'=>$id_invent);
			$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
			$arreglo+=array('unico'=>$res['unico']);
			$arreglo+=array('descripcion'=>$res['nombre']);
			$arreglo+=array('total'=>$cantidad);
			$arreglo+=array('gtotalv'=>$cantidad*$precio);
			$arreglo+=array('precio'=>$precio);
			$arreglo+=array('pventa'=>$precio);
			$x.=$this->insert('et_bodega', $arreglo);
		}
		return $x;
	}
	public function borrar_venta(){
		self::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}

		$sql="select * from et_bodega where id=:texto";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":texto",$id);
		$sth->execute();
		$res=$sth->fetch();

		$arreglo+=array('idventa'=>null);
		$arreglo+=array('cantidad'=>1);
		$arreglo+=array('pendiente'=>0);
		$arreglo+=array('total'=>0);
		$arreglo+=array('gtotalv'=>null);
		return $this->update('et_bodega',array('id'=>$id), $arreglo);

	}
	public function imprimir(){
		self::set_names();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		$arreglo =array();
		$arreglo+=array('imprimir'=>1);
		return $this->update('et_venta',array('idventa'=>$id), $arreglo);
	}
	public function finalizar_venta(){
		self::set_names();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		$arreglo =array();
		$arreglo+=array('estado'=>"Pagada");
		return $this->update('et_venta',array('idventa'=>$id), $arreglo);
	}
}

$db = new Venta();
if(strlen($function)>0){
	echo $db->$function();
}
