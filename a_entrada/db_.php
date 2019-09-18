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
	public function entrada_lista(){
		self::set_names();
		$sql="select et_entrada.identrada, et_entrada.numero, et_prove.razon_social_prove,  et_entrada.estado, et_entrada.total from et_entrada
		left outer join et_prove on et_prove.id_prove=et_entrada.id_prove
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
		$sql="select  et_bodega.id, et_invent.codigo, et_invent.nombre, et_invent.unidad, sum(et_bodega.cantidad) as cantidad, et_bodega.total, et_bodega.clave,
		et_bodega.precio, et_bodega.gtotal, et_bodega.pendiente, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.gtotal, et_bodega.id_invent,
		et_bodega.observaciones, et_bodega.color, et_bodega.tipo, et_bodega.pventa, et_bodega.llave from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where identrada='$id'
		group by llave order by et_bodega.id asc ";

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
	public function guardar_entrada(){
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
		return $this->borrar('et_bodega',"llave",$id);
	}
	public function busca_producto(){
		try{
			$x="";
			if (isset($_REQUEST['texto'])){$texto=$_REQUEST['texto'];}
			parent::set_names();

			$sql="SELECT * FROM et_invent where activo=1 and (nombre like :texto OR codigo like :nombre) and (unico=0 or unico=1)";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->bindValue(":nombre","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();

			$x.="<div class='row'>";
			if(count($res)>0){
				$x.="<table class='table table-sm'>";

				$x.= "<tr>";
				$x.= "<th>-</th>";
				$x.= "<th>Código</th>";
				$x.= "<th>Descripción</th>";
				$x.= "<th>Unidad</th>";
				$x.= "<th>Tipo</th>";

				$x.="</tr>";
				foreach ($res as $key) {
					$x.= "<tr id=".$key['id_invent']." class='edit-t'>";

					$x.= "<td>";
					$x.= "<div class='btn-group'>";
					$x.= "<button type='button' id='entradasel' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='fas fa-check'></i></button>";
					$x.= "</div>";
					$x.= "</td>";

					$x.= "<td>";
					$x.= $key["codigo"];
					$x.= "</td>";

					$x.= "<td>";
					$x.= $key["nombre"];
					$x.= "</td>";

					$x.= "<td>";
					$x.= $key["unidad"];
					$x.= "</td>";

					$x.= "<td>";
						if($key["unico"]=="0") $x.= "Almacén (Se controla el inventario por volúmen)";
						if($key["unico"]=="1") $x.= "Unico (se controla inventario por pieza única)";
						if($key["unico"]=="2") $x.= "Registro (solo registra ventas, no es necesario registrar entrada)";
						if($key["unico"]=="3") $x.= "Pago de linea";
						if($key["unico"]=="4") $x.= "Reparación";
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
	public function pre_sel(){
		$x="";
		$id=$_REQUEST['id'];
		$identrada=$_REQUEST['identrada'];
		$key=$this->inventario($id);

		$x.="<form action='' id='form_cliente' data-lugar='a_entrada/db_' data-funcion='agregar_producto' data-destino='a_entrada/editar' data-cmodal='1'>";
			$x.="<input type='hidden' class='form-control input-sm' id='id' name='id' value='$id' readonly>";
			$x.="<input type='hidden' class='form-control input-sm' id='identrada' name='identrada' value='$identrada' readonly>";
			$x.="<input type='hidden' class='form-control input-sm' id='unico' name='unico' value='".$key["unico"]."' readonly>";
			$x.="<div class='row'>";

				$x.="<div class='col-2'>";
					$x.="<label>Código</label>";
					$x.="<input type='text' class='form-control input-sm' id='codigo' name='codigo' value='".$key["codigo"]."' readonly>";
				$x.="</div>";

				$x.="<div class='col-4'>";
					$x.="<label>Descripción</label>";
					$x.="<input type='text' class='form-control input-sm' id='descripcion' name='descripcion' value='".$key["nombre"]."' readonly>";
				$x.="</div>";

				$x.="<div class='col-2'>";
					$x.="<label>Unidad</label>";
					$x.="<input type='text' class='form-control input-sm' id='unidad'  name='unidad' value='".$key['unidad']."' readonly>";
				$x.="</div>";

				$x.="<div class='col-2'>";
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

				$unico="";
				if($key["unico"]==1){
					$unico="readonly";
				}

				$x.="<div class='col-2'>";
					$x.="<label>Cantidad</label>";
					$x.="<input type='text' class='form-control input-sm' style='text-align:right' id='cantidad' name='cantidad' value='1' $unico>";
				$x.="</div>";

				$x.="<div class='col-3'>";
					$x.="<label>Precio de compra</label>";
					$x.="<input type='text' class='form-control input-sm' style='text-align:right' id='precio'  name='precio' value='".$key['preciocompra']."'>";
				$x.="</div>";

				$x.="<div class='col-3'>";
					$x.="<label>Precio de venta</label>";
					$x.="<input type='text' class='form-control input-sm' style='text-align:right' id='pventa'  name='pventa' value='".$key['pvgeneral']."'>";
				$x.="</div>";

				$x.="<div class='col-4'>";
					$x.="<label>Clave/IMEI</label>";
					$x.="<input type='text' class='form-control input-sm' id='clave' name='clave' value='' placeholder='Clave' >";
				$x.="</div>";
			$x.="</div>";

			$x.="<div class='row'>";
				$x.="<div class='col-12'>
					<div class='btn-group'>
						<button class='btn btn-outline-secondary btn-sm' title='Agregar producto a la compra' type='submit'><i class='fas fa-plus'></i>Agregar</button>
						<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal' title='Cancelar'><i class='fas fa-sign-out-alt'></i>Cancelar</button>
					</div>
				</div>";
			$x.="</div>";
		$x.="</form>";
		///////////////////////////////////////////////////////////////////////////
		return $x;
	}
	public function agregar_producto(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_REQUEST['id'])){
			$arreglo+=array('id_invent'=>$_REQUEST['id']);
		}

		$cantidad=$_REQUEST['cantidad'];
		$arreglo+=array('cantidad'=>1);

		if (isset($_REQUEST['precio'])){
			$arreglo+=array('precio'=>$_REQUEST['precio']);
		}
		if (isset($_REQUEST['pventa'])){
			$arreglo+=array('pventa'=>$_REQUEST['pventa']);
		}
		if (isset($_REQUEST['identrada'])){
			$idx=$_REQUEST['identrada'];
			$arreglo+=array('identrada'=>$_REQUEST['identrada']);
		}
		if (isset($_REQUEST['clave'])){
			$arreglo+=array('clave'=>$_REQUEST['clave']);
		}
		if (isset($_REQUEST['codigo'])){
			$arreglo+=array('codigo'=>$_REQUEST['codigo']);
		}
		if (isset($_REQUEST['unidad'])){
			$arreglo+=array('unidad'=>$_REQUEST['unidad']);
		}
		if (isset($_REQUEST['color'])){
			$arreglo+=array('color'=>$_REQUEST['color']);
		}
		if (isset($_REQUEST['unico'])){
			$arreglo+=array('unico'=>$_REQUEST['unico']);
		}
		if (isset($_REQUEST['descripcion'])){
			$arreglo+=array('descripcion'=>$_REQUEST['descripcion']);
		}
		if (isset($_REQUEST['material'])){
			$arreglo+=array('material'=>$_REQUEST['material']);
		}
		$arreglo+=array('idtienda'=>1);
		$arreglo+=array('llave'=>date("YmdHis")."_".rand(0,10000));

		for($i=1;$i<=$cantidad;$i++){
			$x=$this->insert('et_bodega', $arreglo);
		}
		if(is_numeric($x)){
			return $idx;
		}
		else{
			return $x;
		}
	}
	public function cerrarentrada(){
		$x="";
		self::set_names();
		$arreglo =array();
		$id=$_REQUEST['id'];
		$arreglo =array();
		$arreglo+=array('estado'=>"Finalizada");
		$x=$this->update('et_entrada',array('identrada'=>$id), $arreglo);
		return $x;
	}
}

$db = new Entrada();
if(strlen($function)>0){
	echo $db->$function();
}
