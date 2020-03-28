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

			$sql="SELECT * from productos where idtienda=:tienda and
			(nombre like :texto or
				descripcion like :texto or
				codigo like :texto  or
				imei like :texto or
				rapido like :texto or
				marca like :texto or
				modelo like :texto
			) limit 10";

			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->bindValue(":tienda",$_SESSION['idtienda']);
			$sth->execute();
			$res=$sth->fetchAll();

			echo "<div class='row'>";
			echo "<table class='table table-sm' style='font-size:12px'>";
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
					echo  "<button type='button' onclick='sel_prod(".$key['id'].",$idventa)' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='far fa-hand-pointer'></i></button>";
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

				if($res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>Barras</label>";
						echo "<input type='text' class='form-control form-control-sm' name='codigo' id='codigo' value='".$res->codigo."' readonly>";
					echo "</div>";
				}
				if($res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>Marca</label>";
						echo "<input type='text' class='form-control form-control-sm' name='marca' id='marca' value='".$res->marca."' readonly>";
					echo "</div>";
				}

				if($res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>Modelo</label>";
						echo "<input type='text' class='form-control form-control-sm' name='modelo' id='modelo' value='".$res->nombre."' readonly>";
					echo "</div>";
				}

				if($res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
					echo "<div class='col-3'>";
						echo "<label>IMEI</label>";
						echo "<input type='text' class='form-control form-control-sm' name='imei' id='imei' value='".$res->imei."' readonly>";
					echo "</div>";
				}

				if($res->tipo==0 or $res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){

					echo "<div class='col-3'>";
						echo "<label>Cantidad</label>";
						echo "<input type='text' class='form-control form-control-sm' name='cantidad' id='cantidad' value='1'";
							if($res->tipo==0){
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
						echo "<input type='text' class='form-control form-control-sm' name='observaciones' id='observaciones' value=''>";
					echo "</div>";
				}
			echo "</div>";
			echo "<button type='submit' class='btn btn-outline-info btn-sm'><i class='fas fa-shopping-basket'></i>Agregar</button>";
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
		if (isset($_REQUEST['observaciones'])){
			$observaciones=$_REQUEST['observaciones'];
		}
		if (isset($_REQUEST['cantidad'])){
			$cantidad=$_REQUEST['cantidad'];
		}
		if (isset($_REQUEST['precio'])){
			$precio=$_REQUEST['precio'];
		}

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


			$arreglo=array();
			$arreglo+=array('idventa'=>$idventa);
			$arreglo+=array('idproducto'=>$idproducto);
			$arreglo+=array('nombre'=>$res->nombre);
			$arreglo+=array('observaciones'=>$observaciones);
			$arreglo+=array('cantidad'=>$cantidad*-1);
			$arreglo+=array('v_cantidad'=>$cantidad);
			$arreglo+=array('v_precio'=>$precio);
			$total=$precio*$cantidad;
			$arreglo+=array('v_total'=>$total);

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

		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
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
}

$db = new Venta();
if(strlen($function)>0){
	echo $db->$function();
}
