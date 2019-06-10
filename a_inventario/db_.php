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
		if($_SESSION['nivel']==1){
			$sql="SELECT * FROM et_tienda";
		}
		else{
			$sql="SELECT * FROM et_tienda where id='".$_SESSION['idtienda']."'";
		}
		foreach ($this->dbh->query($sql) as $res){
			$this->tiendas[]=$res;
		}
		return $this->tiendas;
		$this->dbh=null;
	}
	public function tiendas_para(){
		self::set_names();
		$sql="SELECT * FROM et_tienda where id!='".$_SESSION['idtienda']."'";
		$this->tiendas=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->tiendas[]=$res;
		}
		return $this->tiendas;
		$this->dbh=null;
	}
	public function tiendas_global(){
		self::set_names();
		$sql="SELECT * FROM et_tienda";
		$this->tiendas=array();
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
		$sql="select * from et_bodega where id_invent='$id' order by id asc";
		$this->inventario=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->inventario[]=$res;
		}
		return $this->inventario;
		$this->dbh=null;
	}
	public function bodega_edit($id){
		self::set_names();
		$sql="select * from et_bodega where id='$id'";
		$this->inventario="";
		foreach ($this->dbh->query($sql) as $res){
			$this->inventario=$res;
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
		$this->ventas=array();
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
	public function transito_lista(){
		self::set_names();
		$sql="select et_traspaso.id, et_traspaso.nombre, de.nombre as nde, para.nombre as npara, et_traspaso.idde, et_traspaso.fecha, et_traspaso.estado  from et_traspaso
		left outer join et_tienda de on de.id=et_traspaso.idde
		left outer join et_tienda para on para.id=et_traspaso.idpara where idde='".$_SESSION['idtienda']."' or idpara='".$_SESSION['idtienda']."' order by fecha desc";
			$this->traspaso=array();
			echo $sql;
		foreach ($this->dbh->query($sql) as $res){
			$this->traspaso[]=$res;
		}
		return $this->traspaso;
		$this->dbh=null;
	}

	public function traspaso($id){
		self::set_names();
		$sql="select * from et_traspaso where id='$id'";
		foreach ($this->dbh->query($sql) as $res){
			$this->traspaso=$res;
		}
		return $this->traspaso;
		$this->dbh=null;
	}
	public function traspaso_lista(){
		self::set_names();
		$sql="select et_traspaso.id, et_traspaso.nombre, de.nombre as nde, para.nombre as npara, et_traspaso.idde, et_traspaso.fecha, et_traspaso.estado  from et_traspaso
		left outer join et_tienda de on de.id=et_traspaso.idde
		left outer join et_tienda para on para.id=et_traspaso.idpara where idde='".$_SESSION['idtienda']."' or idpara='".$_SESSION['idtienda']."' order by fecha desc";
		foreach ($this->dbh->query($sql) as $res){
			$this->traspaso[]=$res;
		}
		return $this->traspaso;
		$this->dbh=null;
	}
	public function traspaso_pedido($id){
		self::set_names();
		$sql="select et_bodega.id, et_invent.codigo, et_bodega.clave, et_bodega.total, et_bodega.color, et_invent.nombre, et_invent.unidad, et_invent.unico, abs(et_bodega.cantidad) as cantidad, et_bodega.precio, et_bodega.pendiente, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.id_invent, et_bodega.observaciones, et_bodega.recibido, et_bodega.frecibido from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where idtraspaso='$id' order by et_bodega.id desc";
		$this->ventasp=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->ventasp[]=$res;
		}
		return $this->ventasp;
		$this->dbh=null;
	}
	public function guardar_traspaso(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('estado'=>$_REQUEST['estado']);
		}
		if (isset($_REQUEST['idde'])){
			$arreglo+=array('idde'=>$_REQUEST['idde']);
		}
		if (isset($_REQUEST['idpara'])){
			$arreglo+=array('idpara'=>$_REQUEST['idpara']);
		}
		if($id==0){
			$x.=$this->insert('et_traspaso', $arreglo);
		}
		else{
			$x.=$this->update('et_traspaso',array('id'=>$id), $arreglo);
		}
		return $x;
	}
	function busca_producto(){
		try{
			$x="";
			if (isset($_REQUEST['texto'])){$texto=$_REQUEST['texto'];}
			parent::set_names();

			$sql="SELECT sum(cantidad) as totalx,et_bodega.* from et_bodega where idtienda='".$_SESSION['idtienda']."' and (descripcion like :texto or clave like :texto)  group by et_bodega.llave";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();

			$x.="<div class='row'>";
			if(count($res)>0){
				$x.="<table class='table table-sm'>";
				$x.= "<tr>";
				$x.= "<th>Código</th>";
				$x.= "<th>Descripción</th>";
				$x.= "<th>Unidad</th>";
				$x.= "<th>Color</th>";
				$x.= "<th>Existencia</th>";
				$x.= "<th>Cantidad</th>";
				$x.= "<th>-</th>";
				$x.="</tr>";
				foreach ($res as $key) {
					if($key["totalx"]>0){
						$x.= "<tr id=".$key['id']." class='edit-t'>";

						$x.= "<td>";
						$x.= $key["clave"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["descripcion"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["unidad"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["color"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= "<input type='text' class='form-control' name='existencia_".$key['id']."' id='existencia_".$key['id']."' value='".$key['totalx']."' placeholder='cantidad' readonly>";
						$x.= "</td>";

						$cantidad=1;
						$x.= "<td>";
						$readonly="";
						if($key["unico"]==1) {
							$readonly="readonly";
						}
						$x.= "<input type='text' class='form-control' name='cantidad_".$key['id']."' id='cantidad_".$key['id']."' value='$cantidad' placeholder='cantidad' $readonly>";
						$x.= "</td>";

						$x.= "<td>";
						$x.= "<div class='btn-group'>";
						$x.= "<button type='button' onclick='traspasosel(".$key['id'].")' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='fas fa-plus'></i></button>";
						$x.= "</div>";
						$x.= "</td>";

						$x.= "</tr>";
					}
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
	function agregatraspaso(){
		parent::set_names();
		$x="";

		$idtraspaso=$_REQUEST['idtraspaso'];
		$idbodega=$_REQUEST['idbodega'];
		$cantidad=$_REQUEST['cantidad'];

		$sql="select * from et_bodega where id=:texto";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":texto",$idbodega);
		$sth->execute();
		$res=$sth->fetch();
		if($res['unico']==0){
			$arreglo =array();
			$arreglo+=array('idtraspaso'=>$idtraspaso);
			$arreglo+=array('cantidad'=>$cantidad*-1);
			$arreglo+=array('pendiente'=>0);
			$arreglo+=array('total'=>$cantidad);
			$arreglo+=array('descripcion'=>$res['descripcion']);
			$arreglo+=array('unico'=>$res['unico']);
			$arreglo+=array('id_invent'=>$res['id_invent']);
			$arreglo+=array('llave'=>$res['llave']);
			$arreglo+=array('idtienda'=>$res['idtienda']);
			$arreglo+=array('color'=>$res['color']);
			$x.=$this->insert('et_bodega', $arreglo);
		}
		if($res['unico']==1){
			$arreglo =array();
			$arreglo+=array('idtraspaso'=>$idtraspaso);
			$arreglo+=array('idtienda'=>null);
			$x.=$this->update('et_bodega',array('id'=>$idbodega), $arreglo);
		}
		return $x;
	}
	function borrar_traspaso(){
		self::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		$sql="select * from et_bodega where id=:texto";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":texto",$id);
		$sth->execute();
		$res=$sth->fetch();
		if($res['unico']==0){
			return $this->borrar('et_bodega',"id",$id);
		}
		if($res['unico']==1){
			$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
			$arreglo+=array('idtraspaso'=>null);
			return $this->update('et_bodega',array('id'=>$id), $arreglo);
		}
	}
	function recibir(){
		$x="";
		if (isset($_POST['id'])){$id=$_POST['id'];}
		$arreglo =array();
		$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
		return $this->update('et_bodega',array('id'=>$id), $arreglo);
	}

	function guardar_bodega(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['idprod'])){$idprod=$_REQUEST['idprod'];}

		if (isset($_REQUEST['descripcion'])){
			$arreglo+=array('descripcion'=>$_REQUEST['descripcion']);
		}
		if (isset($_REQUEST['clave'])){
			$arreglo+=array('clave'=>$_REQUEST['clave']);
		}
		if (isset($_REQUEST['pventa'])){
			$arreglo+=array('pventa'=>$_REQUEST['pventa']);
		}
		$x.=$this->update('et_bodega',array('id'=>$id), $arreglo);
		return $idprod;
	}
}

$db = new Inventario();
if(strlen($function)>0){
	echo $db->$function();
}
