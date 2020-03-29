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
	public function busca_producto(){
		try{
			$texto=$_REQUEST['texto'];
			$idventa=$_REQUEST['idventa'];

			$sql="SELECT * from productos where idtienda=:tienda and cantidad>0 and
			(nombre like :texto or
				descripcion like :texto or
				codigo like :texto  or
				imei like :texto or
				rapido like :texto or
				marca like :texto or
				modelo like :texto
			) order by tipo limit 20";

			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->bindValue(":tienda",$_SESSION['idtienda']);
			$sth->execute();
			$res=$sth->fetchAll();

			echo "<div class='row'>";
			echo "<table class='table table-sm' style='font-size:14px'>";
			echo  "<tr>";
			echo  "<th>-</th>";
			echo  "<th>Código</th>";
			echo  "<th>Nombre</th>";
			echo  "<th>Marca</th>";
			echo  "<th>Modelo</th>";
			echo  "<th>Existencias</th>";
			echo  "<th>Precio</th>";
			echo "</tr>";
			if(count($res)>0){
				foreach ($res as $key) {
					echo  "<tr id=".$key['id']." class='edit-t'>";
					echo  "<td>";
					echo  "<div class='btn-group'>";
					if($key['tipo']==0 or $key['tipo']==2 or ($key['tipo']==3 and $key['cantidad']>0) or ($key['tipo']==4 and strlen($key['idventa'])==0)){
							echo  "<button type='button' onclick='sel_prod(".$key['id'].",$idventa)' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='far fa-hand-pointer'></i></button>";
					}
					echo $key['tipo'];
					echo  "</div>";
					echo  "</td>";

					echo  "<td>";
						echo  "<span style='font-size:12px'>";
						echo  "<B>IMEI: </B>".$key["imei"]."  ";
						echo  "<br><B>BARRAS: </B>".$key["codigo"]."  ";
						echo  "<br><B>RAPIDO: </B>".$key["rapido"];
						echo  "</span>";
					echo  "</td>";

					echo  "<td>";
					echo  $key["nombre"];
					echo  "</td>";

					echo  "<td>";
					echo  $key["marca"];
					echo  "</td>";

					echo  "<td>";
					echo  $key["modelo"];
					echo  "</td>";

					echo  "<td class='text-center'>";
					echo  $key["cantidad"];
					echo  "</td>";

					echo  "<td align='right'>";
						echo 	moneda($key["precio"]);
					echo  "</td>";

					echo  "</tr>";
				}
			}
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function selecciona_producto(){
		try{
			parent::set_names();
			$idproducto=$_REQUEST['idproducto'];
			$idventa=$_REQUEST['idventa'];

			$sql="SELECT * from productos where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$idproducto);
			$sth->execute();
			$res=$sth->fetch(PDO::FETCH_OBJ);

			echo "<form id='form_producto' action='' data-lugar='a_ventas/db_' data-destino='a_ventas/editar' data-funcion='agregaventa'>";
			echo "<input type='hidden' name='idventa' id='idventa' value='$idventa' readonly>";
			echo "<input type='hidden' name='idproducto' id='idproducto' value='$idproducto' readonly>";
			echo "<input type='hidden' name='tipo' id='tipo' value='".$res->tipo."' readonly>";
			echo "<div class='row'>";
				/*
				echo "<div class='col-12'>";
					echo "<label>Tipo:</label>";
						if($res->tipo=="0") echo $res->tipo."Registro (solo registra ventas, no es necesario registrar entrada, tiempo aire)";
						if($res->tipo=="1") echo $res->tipo."Pago de linea";
						if($res->tipo=="2") echo $res->tipo."Reparación";
						if($res->tipo=="3") echo $res->tipo."Volúmen (Se controla el inventario por volúmen, fundas, accesorios)";
						if($res->tipo=="4") echo $res->tipo."Unico (se controla inventario por pieza única, Fichas Amigo, Equipos)";
					echo "</select>";
				echo "</div>";
				*/
				echo "<div class='col-12'>";
					echo "<label>Nombre:</label>".$res->tipo;
					echo "<input type='text' class='form-control form-control-sm' name='nombre' id='nombre' value='".$res->nombre."' readonly>";
				echo "</div>";

				if($res->tipo==1 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>Barras</label>";
						echo "<input type='text' class='form-control form-control-sm' name='codigo' id='codigo' value='".$res->codigo."' readonly>";
					echo "</div>";
				}
				if($res->tipo==1 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>Marca</label>";
						echo "<input type='text' class='form-control form-control-sm' name='marca' id='marca' value='".$res->marca."' readonly>";
					echo "</div>";
				}

				if($res->tipo==1 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>Modelo</label>";
						echo "<input type='text' class='form-control form-control-sm' name='modelo' id='modelo' value='".$res->nombre."' readonly>";
					echo "</div>";
				}

				if($res->tipo==1 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>IMEI</label>";
						echo "<input type='text' class='form-control form-control-sm' name='imei' id='imei' value='".$res->imei."' readonly>";
					echo "</div>";
				}

				if($res->tipo==0 or $res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>Cantidad</label>";
						echo "<input type='text' class='form-control form-control-sm' name='cantidad' id='cantidad' value='1'";
							if($res->tipo==0 or $res->tipo==2 or $res->tipo==4){
								echo " readonly";
							}
						echo ">";
					echo "</div>";
				}
				if($res->tipo==0 or $res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>Precio</label>";
						echo "<input type='text' class='form-control form-control-sm' name='precio' id='precio' value='".$res->precio."' ";
							if($res->tipo==0){
								echo "";
							}
						echo ">";
					echo "</div>";
				}
				if($res->tipo==0 or $res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-12'>";
						echo "<label>Observaciones</label>";
						echo "<input type='text' class='form-control form-control-sm' name='observaciones' id='observaciones' value='' placeholder='Observaciones'>";
					echo "</div>";
				}
				if($res->tipo==2){
					echo "<div class='col-12'>";
						echo "<label>Cliente:</label>";
						echo "<input type='text' class='form-control form-control-sm' name='cliente' id='cliente' value='' placeholder='Cliente'>";
					echo "</div>";
				}

			echo "</div>";
			echo "<hr>";
			echo "<div class='row'>";
				echo "<div class='col-12'>";
					echo "<div class='btn-group'>";
						echo "<button type='submit' class='btn btn-outline-info btn-sm'><i class='fas fa-cart-plus'></i>Agregar</button>";
						echo "<button type='button' class='btn btn-outline-primary btn-sm' data-dismiss='modal'><i class='fas fa-sign-out-alt'></i>Cerrar</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "</form>";

		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function agregaventa(){
		parent::set_names();
		$x="";
		$idventa=$_REQUEST['idventa'];
		$idproducto=$_REQUEST['idproducto'];
		$cliente="";
		$observaciones="";
		$cantidad="0";
		$precio="0";
		$tipo="0";

		if (isset($_REQUEST['observaciones'])){
			$observaciones=$_REQUEST['observaciones'];
		}
		if (isset($_REQUEST['cantidad'])){
			$cantidad=$_REQUEST['cantidad'];
		}
		if (isset($_REQUEST['precio'])){
			$precio=$_REQUEST['precio'];
		}
		if (isset($_REQUEST['cliente'])){
			$cliente=$_REQUEST['cliente'];
		}
		$tipo=$_REQUEST['tipo'];



		try{
			parent::set_names();
			if($idventa==0){
				$arreglo=array();
				$arreglo+=array('idcliente'=>1);
				$arreglo+=array('estado'=>"Activa");
				$date=date("Y-m-d H:i:s");
				$arreglo+=array('fecha'=>$date);
				$arreglo+=array('idusuario'=>$_SESSION['idpersona']);
				$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
				$x=$this->insert('et_venta', $arreglo);
				$ped=json_decode($x);
				if($ped->error==0){
					$idventa=$ped->id;
				}
				else{
						return $x;
				}
			}

			$sql="SELECT * from productos where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$idproducto);
			$sth->execute();
			$res=$sth->fetch(PDO::FETCH_OBJ);

			///////////////////////////////////////////////////actualiza producto tipo idn_to_unicode

			$sql="update productos set idventa=:idventa where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idventa",$idventa);
			$sth->bindValue(":id",$idproducto);
			$sth->execute();


			////////////////////////////////////////////////////////
			$arreglo=array();
			$arreglo+=array('idventa'=>$idventa);
			$arreglo+=array('idproducto'=>$idproducto);
			$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
			$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
			$arreglo+=array('tipo'=>$tipo);
			$arreglo+=array('nombre'=>$res->nombre);
			$arreglo+=array('observaciones'=>$observaciones);
			$arreglo+=array('cliente'=>$cliente);
			if($tipo==3){
				$arreglo+=array('cantidad'=>$cantidad*-1);
			}
			$arreglo+=array('v_cantidad'=>$cantidad);
			$arreglo+=array('v_precio'=>$precio);
			$total=$precio*$cantidad;
			$arreglo+=array('v_total'=>$total);
			if($tipo==4){
				$arreglo+=array('v_marca'=>$res->marca);
				$arreglo+=array('v_modelo'=>$res->modelo);
				$arreglo+=array('v_imei'=>$res->imei);
			}
			//$arreglo+=array('v_total'=>$total);
			$x=$this->insert('bodega', $arreglo);
			$ped=json_decode($x);

			if($ped->error==0){
				{
					$sql="select sum(v_total) as gtotal from bodega where idventa=:texto";
					$sth = $this->dbh->prepare($sql);
					$sth->bindValue(":texto",$idventa);
					$sth->execute();
					$res=$sth->fetch();
					$gtotal=$res['gtotal'];

					$subtotal=$gtotal/1.16;
					$iva=$gtotal-$subtotal;

					$values = array('subtotal'=>$subtotal, 'iva'=>$iva, 'total'=>$gtotal, 'gtotal'=>$gtotal );
					$this->update('et_venta',array('idventa'=>$idventa), $values);
				}

				$arreglo =array();
				$arreglo+=array('id'=>$idventa);
				$arreglo+=array('error'=>0);
				$arreglo+=array('terror'=>0);
				$arreglo+=array('param1'=>"");
				$arreglo+=array('param2'=>"");
				$arreglo+=array('param3'=>"");
				return json_encode($arreglo);
			}
			else{
					return $x;
			}
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function borrar_venta(){
		self::set_names();
		$id=$_REQUEST['id'];

		$sql="SELECT * from bodega where id=:id";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":id",$id);
		$sth->execute();
		$res=$sth->fetch(PDO::FETCH_OBJ);

		if($res->tipo==4){
			$sql="update productos set idventa=NULL where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$res->idproducto);
			$sth->execute();
		}
		return $this->borrar('bodega',"id",$id);
	}
	public function ventas_pedido($id){
		self::set_names();
		$sql="select * from bodega where idventa='$id' order by id desc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}

	public function ventas_lista(){
		self::set_names();
		$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, et_cliente.razon_social_prove, et_tienda.nombre, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado, et_descuento.nombre as descuento from et_venta
		left outer join et_cliente on et_cliente.idcliente=et_venta.idcliente
		left outer join et_descuento on et_descuento.iddescuento=et_venta.iddescuento
		left outer join et_tienda on et_tienda.id=et_venta.idtienda where et_venta.idtienda='".$_SESSION['idtienda']."' and et_venta.estado='Activa' order by et_venta.fecha desc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function buscar($texto){
		self::set_names();
		$texto=trim($texto);
		if(strlen($texto)>0){
			$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, et_cliente.razon_social_prove, et_tienda.nombre, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado, et_descuento.nombre as descuento from et_venta
			left outer join et_cliente on et_cliente.idcliente=et_venta.idcliente
			left outer join et_descuento on et_descuento.iddescuento=et_venta.iddescuento
			left outer join et_tienda on et_tienda.id=et_venta.idtienda where et_venta.idtienda='".$_SESSION['idtienda']."' and (et_venta.idventa like '%$texto%' or et_cliente.razon_social_prove like '%$texto%' or et_venta.estado like '%$texto%' or et_venta.total like '%$texto%') order by et_venta.fecha desc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
	}
	public function clientes_lista(){
		self::set_names();
		$sql="SELECT * FROM et_cliente";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function tiendas_lista(){
		self::set_names();
		$sql="SELECT * FROM et_tienda where id='".$_SESSION['idtienda']."'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function descuento_lista(){
		self::set_names();
		$sql="SELECT * FROM et_descuento";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
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
		if (isset($_REQUEST['llave'])){
			$llave=$_REQUEST['llave'];
			$arreglo+=array('llave'=>$llave);
		}

		if($id==0){
			$date=date("Y-m-d H:i:s");
			$arreglo+=array('fecha'=>$date);
			$arreglo+=array('idusuario'=>$_SESSION['idpersona']);
			$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
			$this->insert('et_venta', $arreglo);

			$sql="select * from et_venta where llave='$llave' and idusuario='".$_SESSION['idpersona']."'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$res=$sth->fetch();
			return $res['idventa'];
		}
		else{
			$x.=$this->update('et_venta',array('idventa'=>$id), $arreglo);
			{
				$sql="select sum(gtotalv) as gtotal from et_bodega where idventa=:texto";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":texto",$id);
				$sth->execute();
				$res=$sth->fetch();
				$gtotal=$res['gtotal'];

				$subtotal=$gtotal/1.16;
				$iva=$gtotal-$subtotal;

				$values = array('subtotal'=>$subtotal, 'iva'=>$iva, 'total'=>$gtotal, 'gtotal'=>$gtotal );
				$this->update('et_venta',array('idventa'=>$id), $values);
			}
		}
		return $x;
	}

	public function imprimir(){
		self::set_names();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo =array();
		$arreglo+=array('imprimir'=>1);
		return $this->update('et_venta',array('idventa'=>$id), $arreglo);
	}
	public function finalizar_venta(){
		self::set_names();

		$total_g=$_REQUEST['total_g'];
		$efectivo_g=$_REQUEST['efectivo_g'];
		$cambio_g=$_REQUEST['cambio_g'];

		if($total_g>0){
			if($total_g<=$efectivo_g){
				if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
				$arreglo =array();
				$arreglo+=array('estado'=>"Pagada");
				return $this->update('et_venta',array('idventa'=>$id), $arreglo);
			}
			else{
				return "favor de verificar";
			}
		}
		else{
			return "Debe de agregar un producto";
		}
	}

	public function emitidas(){
		try{
			parent::set_names();
			$desde=$_REQUEST['desde'];
			$hasta=$_REQUEST['hasta'];

			$desde = date("Y-m-d", strtotime($desde))." 00:00:00";
			$hasta = date("Y-m-d", strtotime($hasta))." 23:59:59";

			$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, et_cliente.razon_social_prove, et_tienda.nombre, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado from et_venta
			left outer join et_cliente on et_cliente.idcliente=et_venta.idcliente
			left outer join et_tienda on et_tienda.id=et_venta.idtienda where (et_venta.fecha BETWEEN :fecha1 AND :fecha2)";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":fecha1",$desde);
			$sth->bindValue(":fecha2",$hasta);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function productos_vendidos(){
		try{
			parent::set_names();
			$desde=$_REQUEST['desde'];
			$hasta=$_REQUEST['hasta'];

			$desde = date("Y-m-d", strtotime($desde))." 00:00:00";
			$hasta = date("Y-m-d", strtotime($hasta))." 23:59:59";

			$sql="SELECT
					et_venta.idventa,
					et_venta.idtienda,
					et_venta.iddescuento,
					et_venta.factura,
					et_cliente.razon_social_prove,
					et_tienda.nombre,
					et_venta.total,
					et_venta.fecha,
					et_venta.gtotal,
					et_venta.estado,
					bodega.nombre,
					bodega.observaciones,
				bodega.cliente
				FROM
					bodega
				LEFT OUTER JOIN et_venta ON et_venta.idventa = bodega.idventa
				left outer join productos on productos.id=bodega.idproducto
				LEFT OUTER JOIN et_cliente ON et_cliente.idcliente = et_venta.idcliente
				LEFT OUTER JOIN et_tienda ON et_tienda.id = et_venta.idtienda
				where bodega.idventa and (et_venta.fecha BETWEEN :fecha1 AND :fecha2) order by idventa desc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":fecha1",$desde);
			$sth->bindValue(":fecha2",$hasta);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
}

$db = new Venta();
if(strlen($function)>0){
	echo $db->$function();
}
