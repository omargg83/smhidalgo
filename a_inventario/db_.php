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
		$sql="select * from et_marca where idmarca='$id'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}
	public function modelo($id){
		self::set_names();
		$sql="select * from et_modelo where idmodelo='$id'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}
	public function tiendas_lista(){
		self::set_names();
		if($_SESSION['nivel']==1){
			$sql="SELECT * FROM et_tienda";
		}
		else{
			$sql="SELECT * FROM et_tienda where id='".$_SESSION['idtienda']."'";
		}
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function tiendas_global($key=""){
		self::set_names();
		if(strlen($key)==0){
			$sql="SELECT * FROM et_tienda where id!='".$_SESSION['idtienda']."'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		else{
			$sql="SELECT * FROM et_tienda where id='$key'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch();
		}
	}
	public function inventario($id){
		self::set_names();
		$sql="select * from et_invent
		left outer join et_marca on et_marca.idmarca=et_invent.idmarca
		left outer join et_modelo on et_modelo.idmodelo=et_invent.idmodelo
		where id_invent='$id'
		order by id_invent asc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}
	public function inventario_detalle($id){
		self::set_names();
		$sql="select * from et_bodega where id_invent='$id' and idtienda='".$_SESSION['idtienda']."' order by id asc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function bodega_edit($id){
		self::set_names();
		$sql="select * from et_bodega where id='$id'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}
	public function inventario_lista($idtienda){
		self::set_names();
		$sql="select inven.id_invent, inven.codigo, inven.unico, inven.nombre, inven.pvgeneral, inven.rapido,(select COALESCE(sum(cantidad),0) as total from et_bodega where et_bodega.id_invent=inven.id_invent and et_bodega.idtienda='$idtienda') as conteo, inven.preciocompra, inven.pvpromo, inven.pvdistr, et_marca.marca, et_modelo.modelo from et_invent inven
		left outer join et_marca on et_marca.idmarca=inven.idmarca
		left outer join et_modelo on et_modelo.idmodelo=inven.idmodelo
		where activo=1 order by unico desc, nombre";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
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
		foreach ($this->dbh->query($sql) as $res){
			$this->traspaso[]=$res;
		}
		return $this->traspaso;
		$this->dbh=null;
	}

	public function traspaso($id){
		self::set_names();
		$sql="select * from et_traspaso where id='$id'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}
	public function traspaso_lista(){
		self::set_names();
		$sql="select et_traspaso.id, et_traspaso.nombre, de.nombre as nde, para.nombre as npara, et_traspaso.idde, et_traspaso.fecha, et_traspaso.estado  from et_traspaso
		left outer join et_tienda de on de.id=et_traspaso.idde
		left outer join et_tienda para on para.id=et_traspaso.idpara where idde='".$_SESSION['idtienda']."' order by fecha desc";
		$this->traspaso=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->traspaso[]=$res;
		}
		return $this->traspaso;
		$this->dbh=null;
	}
	public function traspaso_llegada(){
		self::set_names();
		$sql="select et_traspaso.id, et_traspaso.nombre, de.nombre as nde, para.nombre as npara, et_traspaso.idde, et_traspaso.fecha, et_traspaso.estado  from et_traspaso
		left outer join et_tienda de on de.id=et_traspaso.idde
		left outer join et_tienda para on para.id=et_traspaso.idpara where idpara='".$_SESSION['idtienda']."' and estado='Enviada' order by fecha desc";
		$this->traspaso=array();
		foreach ($this->dbh->query($sql) as $res){
			$this->traspaso[]=$res;
		}
		return $this->traspaso;
		$this->dbh=null;
	}
	public function traspaso_pedido($id){
		self::set_names();
		$sql="select et_bodega.id, et_invent.codigo, et_bodega.clave, et_bodega.total, et_bodega.color, et_invent.nombre, et_invent.unidad, et_bodega.cantidad, et_bodega.precio, et_bodega.pendiente, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.id_invent, et_bodega.observaciones, et_bodega.recibido, et_bodega.frecibido from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where idtraspaso='$id' order by et_bodega.id desc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
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
		if (isset($_REQUEST['idpara'])){
			$arreglo+=array('idpara'=>$_REQUEST['idpara']);
		}
		if($id==0){
			$arreglo+=array('idde'=>$_SESSION['idtienda']);
			$x.=$this->insert('et_traspaso', $arreglo);
		}
		else{
			$x.=$this->update('et_traspaso',array('id'=>$id), $arreglo);
		}
		return $x;
	}
	public function busca_producto(){
		try{
			$x="";
			if (isset($_REQUEST['texto'])){$texto=$_REQUEST['texto'];}
			parent::set_names();

			$sql="SELECT et_bodega.* from et_bodega where idtienda='".$_SESSION['idtienda']."' and cantidad>0 and (descripcion like :texto or clave like :texto or rapido like :texto or codigo like :texto) ";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();
			$x.="<div class='row' style='height:300px;overflow:auto;'>";
			if(count($res)>0){
				$x.="<table class='table table-sm'>";
				$x.= "<tr>";
				$x.= "<th>-</th>";
				$x.= "<th>Descripción</th>";
				$x.= "<th>Color</th>";
				$x.="</tr>";
				foreach ($res as $key) {
						$x.= "<tr id=".$key['id']." class='edit-t'>";

						$x.= "<td>";
						$x.= "<div class='btn-group'>";
						$x.= "<button type='button' onclick='traspasosel(".$key['id'].")' class='btn btn-outline-secondary btn-sm' title='Agregar'><i class='fas fa-plus'></i></button>";
						$x.= "</div>";
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["descripcion"];
						$x.= "<br><span style='font-size:12px'>";
						$x.= "<B>IMEI:</B>".$key["clave"]." / ";
						$x.= "<B>BARRAS:</B>".$key["codigo"]." / ";
						$x.= "<B>RAPIDO:</B>".$key["rapido"];
						$x.= "</span>";
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["color"];
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
	public function agregatraspaso(){
		parent::set_names();
		$x="";

		$idtraspaso=$_REQUEST['idtraspaso'];
		$idbodega=$_REQUEST['idbodega'];

		$sql="select * from et_bodega where id=:texto";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":texto",$idbodega);
		$sth->execute();
		$res=$sth->fetch();
		/*
		if($res['unico']==0){
			$arreglo =array();
			$arreglo+=array('idtraspaso'=>$idtraspaso);
			$arreglo+=array('cantidad'=>$cantidad*-1);
			$arreglo+=array('pendiente'=>0);
			$arreglo+=array('total'=>$cantidad);
			$arreglo+=array('descripcion'=>$res['descripcion']);
			$arreglo+=array('unico'=>$res['unico']);
			$arreglo+=array('id_invent'=>$res['id_invent']);
			$arreglo+=array('idtienda'=>$res['idtienda']);
			$arreglo+=array('color'=>$res['color']);
			$x.=$this->insert('et_bodega', $arreglo);
		}*/

		$arreglo =array();
		$arreglo+=array('idtraspaso'=>$idtraspaso);
		$arreglo+=array('idtienda'=>null);
		$x.=$this->update('et_bodega',array('id'=>$idbodega), $arreglo);

		return $x;
	}
	public function borrar_traspaso(){
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
	public function recibir(){
		$x="";

		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['idtraspaso'])){$idtraspaso=$_POST['idtraspaso'];}

		$arreglo =array();
		$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
		$arreglo+=array('recibido'=>1);
		$arreglo+=array('frecibido'=>date("Y-m-d H:i:s"));
		$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
		$x=$this->update('et_bodega',array('id'=>$id), $arreglo);
		return $x;
	}

	public function guardar_bodega(){
		$x="";
		self::set_names();
		$arreglo =array();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['idprod'])){$idprod=$_REQUEST['idprod'];}

		if (isset($_REQUEST['descripcion'])){
			$arreglo+=array('descripcion'=>$_REQUEST['descripcion']);
		}
		if (isset($_REQUEST['unidad'])){
			$arreglo+=array('unidad'=>$_REQUEST['unidad']);
		}
		if (isset($_REQUEST['color'])){
			$arreglo+=array('color'=>$_REQUEST['color']);
		}
		if (isset($_REQUEST['material'])){
			$arreglo+=array('material'=>$_REQUEST['material']);
		}
		if (isset($_REQUEST['clave'])){
			$arreglo+=array('clave'=>$_REQUEST['clave']);
		}
		if (isset($_REQUEST['pventa'])){
			$arreglo+=array('pventa'=>$_REQUEST['pventa']);
		}
		if (isset($_REQUEST['cantidad'])){
			$arreglo+=array('cantidad'=>$_REQUEST['cantidad']);
		}
		if (isset($_REQUEST['precio'])){
			$arreglo+=array('precio'=>$_REQUEST['precio']);
		}
		if (isset($_REQUEST['codigo'])){
			$arreglo+=array('codigo'=>$_REQUEST['codigo']);
		}
		if (isset($_REQUEST['clave']) and strlen($_REQUEST['clave'])>0){
			$clave=trim($_REQUEST['clave']);

			if($id==0){
				$sql="SELECT * FROM et_bodega where clave='$clave'";
				$stmt= $this->dbh->query($sql);
				if($stmt->rowCount()>0){
					return "Verificar producto ya existe IMEI";
				}
			}
			$arreglo+=array('clave'=>$_REQUEST['clave']);
		}
		else{
			$arreglo+=array('clave'=>null);
		}
		if($id==0){
			$arreglo+=array('id_invent'=>$_REQUEST['idprod']);
			$arreglo+=array('idtienda'=>1);
			$x.=$this->insert('et_bodega', $arreglo);
		}
		else{
			$x.=$this->update('et_bodega',array('id'=>$id), $arreglo);
		}
		//return $x;
		return $idprod;
	}
	public function enviarproducto(){
		$x="";
		self::set_names();
		$arreglo =array();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo+=array('estado'=>"Enviada");
		$x.=$this->update('et_traspaso',array('id'=>$id), $arreglo);
		return $x;
	}
}

$db = new Inventario();
if(strlen($function)>0){
	echo $db->$function();
}
