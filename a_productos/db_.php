<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Productos extends Sagyc{

	public function __construct(){
		parent::__construct();

		$this->doc="a_imagenextra/";
	}
	public function productos_lista(){
		try{
			parent::set_names();
			if (isset($_REQUEST['buscar']) and strlen(trim($_REQUEST['buscar']))>0){
				$texto=trim(htmlspecialchars($_REQUEST['buscar']));
				$sql="SELECT * from productos where codigo like '%$texto%' or nombre like '%$texto%' or marca like '%$texto%' or modelo like '%$texto%' or imei like '%$texto%' limit 100";
			}
			else{
				$sql="SELECT * from productos where activo=1 limit 100";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function producto_editar($id){
		try{
			parent::set_names();
			$sql="select sum(cantidad) as total from bodega where idproducto=$id";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$total=$sth->fetch(PDO::FETCH_OBJ);
			$existencia=$total->total;
			$arreglo =array();
			$arreglo = array('cantidad'=>$existencia);
			$this->update('productos',array('id'=>$id), $arreglo);


			$sql="select * from productos where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(':id', "$id");
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guardar_producto(){
		try{
			parent::set_names();
			$id=$_REQUEST['id'];
			$arreglo =array();
			$tipo=$_REQUEST['tipo'];
			$arreglo += array('tipo'=>$tipo);

			if (isset($_REQUEST['codigo'])){
				$arreglo += array('codigo'=>$_REQUEST['codigo']);
			}
			if (isset($_REQUEST['nombre'])){
				$arreglo += array('nombre'=>$_REQUEST['nombre']);
			}
			if (isset($_REQUEST['unidad'])){
				$arreglo += array('unidad'=>$_REQUEST['unidad']);
			}
			if (isset($_REQUEST['precio'])){
				$arreglo += array('precio'=>$_REQUEST['precio']);
			}
			if (isset($_REQUEST['marca'])){
				$arreglo += array('marca'=>$_REQUEST['marca']);
			}
			if (isset($_REQUEST['marca'])){
				$arreglo += array('marca'=>$_REQUEST['marca']);
			}
			if (isset($_REQUEST['modelo'])){
				$arreglo += array('modelo'=>$_REQUEST['modelo']);
			}
			if (isset($_REQUEST['descripcion'])){
				$arreglo += array('descripcion'=>$_REQUEST['descripcion']);
			}

			if (isset($_REQUEST['activo'])){
				$arreglo += array('activo'=>$_REQUEST['activo']);
			}
			if (isset($_REQUEST['rapido'])){
				$arreglo += array('rapido'=>$_REQUEST['rapido']);
			}
			if (isset($_REQUEST['color'])){
				$arreglo += array('color'=>$_REQUEST['color']);
			}
			if (isset($_REQUEST['material'])){
				$arreglo += array('material'=>$_REQUEST['material']);
			}
			if (isset($_REQUEST['imei'])){
				$arreglo += array('imei'=>$_REQUEST['imei']);
			}

			$x="";
			if($id==0){
				if($tipo==0){
						$arreglo += array('cantidad'=>0);
				}
				else{
					$arreglo += array('cantidad'=>1);
				}
				$arreglo+=array('fechaalta'=>date("Y-m-d H:i:s"));
				$x=$this->insert('productos', $arreglo);
			}
			else{
				$arreglo+=array('fechamod'=>date("Y-m-d H:i:s"));
				$x=$this->update('productos',array('id'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function genera_barras(){
		try{
			parent::set_names();
			$id=$_REQUEST['id'];


			$codigo="9".str_pad($id, 6, "0", STR_PAD_LEFT);


			$arreglo =array();

			$arreglo = array('codigo'=>$codigo);
			$arreglo+=array('fechamod'=>date("Y-m-d H:i:s"));
			$x=$this->update('productos',array('id'=>$id), $arreglo);

			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}

	}
	public function existencia_agrega(){
		try{
			parent::set_names();
			$id=$_REQUEST['id'];
			$idproducto=$_REQUEST['idproducto'];
			$arreglo =array();
			$arreglo = array('idproducto'=>$idproducto);
			if (isset($_REQUEST['cantidad'])){
				$arreglo += array('cantidad'=>$_REQUEST['cantidad']);
			}
			if (isset($_REQUEST['nota'])){
				$arreglo += array('nota'=>$_REQUEST['nota']);
			}
			if (isset($_REQUEST['fecha'])){
				$fx=explode("-",$_REQUEST['fecha']);
				$arreglo+=array('fecha'=>$fx['2']."-".$fx['1']."-".$fx['0']);
			}
			$x="";
			if($id==0){
				$arreglo+=array('fechaalta'=>date("Y-m-d H:i:s"));
				$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
				$x=$this->insert('bodega', $arreglo);
			}
			else{
				$arreglo+=array('fechamod'=>date("Y-m-d H:i:s"));
				$x=$this->update('bodega',array('id'=>$id), $arreglo);
			}
			$ped=json_decode($x);
			if($ped->error==0){
				$arreglo =array();
				$arreglo+=array('id'=>$idproducto);
				$arreglo+=array('error'=>0);
				$arreglo+=array('terror'=>0);
				$arreglo+=array('param1'=>"");
				$arreglo+=array('param2'=>"");
				$arreglo+=array('param3'=>"");
				return json_encode($arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function productos_inventario($id){
		try{
			parent::set_names();
			$sql="select * from bodega where idproducto=:id order by fecha desc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(':id', "$id");
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function borrar_ingreso(){
		if (isset($_POST['id'])){$id=$_POST['id'];}
		return $this->borrar('bodega',"id",$id);
	}
}
$db = new Productos();
if(strlen($function)>0){
	echo $db->$function();
}
?>
