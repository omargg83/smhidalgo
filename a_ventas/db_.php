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

	public function ventas_pedido($id){
		self::set_names();
		$sql="select et_bodega.id, et_bodega.clave, et_invent.codigo, et_invent.nombre, et_bodega.cantidad, et_bodega.precio, et_bodega.pventa, et_bodega.total, et_bodega.gtotal, et_bodega.gtotalv, et_bodega.idtienda, et_bodega.id_invent, et_bodega.observaciones, et_bodega.rapido from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where idventa='$id' order by et_bodega.id desc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
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
	public function busca_producto(){
		try{
			$x="";
			if (isset($_REQUEST['texto'])){$texto=$_REQUEST['texto'];}
			if (isset($_REQUEST['idtienda'])){$idtienda=$_REQUEST['idtienda'];}
			parent::set_names();

			$sql="SELECT et_bodega.* from et_bodega where idtienda='".$_SESSION['idtienda']."' and (descripcion like :texto or clave like :texto  or codigo like :texto or rapido like :texto ) limit 10";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();

			$x.="<div class='row'>";
			$x.="<table class='table table-sm'>";
			$x.= "<tr>";
			$x.= "<th>-</th>";
			$x.= "<th>Descripción</th>";
			$x.= "<th>Precio</th>";
			$x.= "<th>Observaciones</th>";
			$x.="</tr>";
			if(count($res)>0){
				foreach ($res as $key) {
					if($key["cantidad"]>0){
						$x.= "<tr id=".$key['id']." class='edit-t'>";
						$x.= "<td>";
						$x.= "<div class='btn-group'>";
						$x.= "<button type='button' onclick='ventraprod(".$key['id'].",1)' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='fas fa-plus'></i></button>";
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

						$x.= "<td align='right'>";
						$preciov=number_format($key["pventa"],2);
						$x.= "<input type='text' class='form-control' name='precio_".$key['id']."' id='precio_".$key['id']."' value='$preciov' placeholder='Precio'>";
						$x.= "</td>";

						$x.= "<td>";
						$x.= "<input type='text' class='form-control' name='observa_".$key['id']."' id='observa_".$key['id']."' value='' placeholder='Observaciones'>";
						$x.= "</td>";
						$x.= "</tr>";
					}
				}
			}

			$sql="SELECT * from et_invent where unico>1 and (nombre like :texto or codigo like :texto or rapido like :texto) limit 10";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto","%$texto%");
			$sth->execute();
			$res=$sth->fetchAll();

			foreach ($res as $key) {
				$x.= "<tr id=".$key['id_invent']." class='edit-t'>";
				$x.= "<td>";
				$x.= "<div class='btn-group'>";
				$x.= "<button type='button' onclick='ventraprod(".$key['id_invent'].",2)' class='btn btn-outline-secondary btn-sm' title='Seleccionar articulo'><i class='fas fa-plus'></i></button>";
				$x.= "</div>";
				$x.= "</td>";


				$x.= "<td>";
				$x.= $key["nombre"];

				$x.= "<br><span style='font-size:10px'>";
				$x.= "<B>BARRAS:</B>".$key["codigo"]." / ";
				$x.= "<B>RAPIDO:</B>".$key["rapido"];
				$x.= "</span>";
				$x.= "</td>";


				$x.= "<td align='right'>";
				$preciov=$key['pvgeneral'];
				$x.= "<input type='text' class='form-control' name='precio_".$key['id_invent']."' id='precio_".$key['id_invent']."' value='$preciov' placeholder='Precio'>";
				$x.= "</td>";

				$x.= "<td>";
				$x.= "<input type='text' class='form-control' name='observa_".$key['id_invent']."' id='observa_".$key['id_invent']."' value='' placeholder='Observaciones'>";
				$x.= "</td>";



				$x.= "</tr>";
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
		$idcliente=$_REQUEST['idcliente'];
		$idbodega=$_REQUEST['idbodega'];
		$id_invent=$_REQUEST['id_invent'];

		$precio=$_REQUEST['precio'];
		$observa=$_REQUEST['observa'];
		$tipo=$_REQUEST['tipo'];

		if($idventa==0){
			$arreglo=array();
			$arreglo+=array('idcliente'=>$idcliente);
			$arreglo+=array('estado'=>"Activa");
			$date=date("Y-m-d H:i:s");
			$arreglo+=array('fecha'=>$date);
			$arreglo+=array('idusuario'=>$_SESSION['idpersona']);
			$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
			$x=$this->insert('et_venta', $arreglo);
			$idventa=$x;
		}
		$nombre="";
		$clave="";
		$codigo="";
		$rapido="";
		$total=0;
		$pventa=0;

		if($tipo==1){
			$sql="select * from et_bodega where id=:texto";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto",$idbodega);
			$sth->execute();
			$res=$sth->fetch();
			$nombre=$res['descripcion'];
			$codigo=$res['codigo'];
			$rapido=$res['rapido'];
			$clave=$res['clave'];
			$pventa=$res['pventa'];

			$total=1;
			$arreglo =array();
			$arreglo+=array('idventa'=>$idventa);
			$arreglo+=array('cantidad'=>0);
			$arreglo+=array('pendiente'=>0);
			$arreglo+=array('total'=>1);
			$arreglo+=array('gtotalv'=>$res['pventa']);
			$x.=$this->update('et_bodega',array('id'=>$idbodega), $arreglo);
			$id=$idbodega;
		}
		if($tipo==2){
			$sql="select * from et_invent where id_invent=:texto";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto",$id_invent);
			$sth->execute();
			$res=$sth->fetch();
			$arreglo =array();
			$nombre=$res['nombre'];
			$codigo=$res['codigo'];
			$rapido=$res['rapido'];
			$pventa=$precio;
			$clave="";
			$total=1;

			$arreglo+=array('observaciones'=>$observa);
			$arreglo+=array('idventa'=>$idventa);
			$arreglo+=array('id_invent'=>$id_invent);
			$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
			$arreglo+=array('descripcion'=>$res['nombre']);
			$arreglo+=array('total'=>1);
			$arreglo+=array('gtotalv'=>1*$precio);
			$arreglo+=array('precio'=>$precio);
			$arreglo+=array('pventa'=>$precio);
			$arreglo+=array('cantidad'=>0);
			$arreglo+=array('pendiente'=>0);
			$arreglo+=array('tipo'=>0);
			$id=$this->insert('et_bodega', $arreglo);
		}

		{
			$sql="select sum(gtotalv) as gtotal from et_bodega where idventa=:texto";
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
		///////
		$estado="";
		$observaciones="";

		$data="<div class='row' id='div_$id'>";
			$data.= "<div class='col-1'>";
				$data.= "<button class='btn btn-outline-secondary btn-sm' id='eliminar_pedido' onclick='borra_venta($id)'><i class='far fa-trash-alt'></i></i></button>";
			$data.= "</div>";
			$data.= "<div class='col-3'>";
				$data.= $nombre;
				if(strlen($observa)>0){
					$data.= "<br><span style='font-size:10px;font-weight: bold;'>".$observa."</span>";
				}
			$data.= "</div>";

			$data.= "<div class='col-2'>";
				$data.= "<span style='font-size:12px'>";
				$data.= "<B>IMEI:</B>".$clave." / ";
				$data.= "<B>BARRAS:</B>".$codigo." / ";
				$data.= "<B>RAPIDO:</B>".$rapido;
			$data.= "</div>";

			$data.= "<div class='col-2 text-center'>";
				$data.= number_format($total);
			$data.= "</div>";

			$data.= "<div class='col-2 text-right'>";
				$data.= number_format($pventa,2);
			$data.= "</div>";

			$data.= "<div class='col-2 text-right'>";
				$data.= number_format($pventa,2);
			$data.= "</div>";
		$data.= "</div>";

		$row = array('idventa' =>$idventa,'subtotal' =>round($subtotal,2), 'iva'=>round($iva,2), 'total'=>round($gtotal,2), 'datax'=>$data);
		return json_encode($row);
	}

	public function borrar_venta(){
		self::set_names();
		$arreglo =array();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$res="";
		$sql="select * from et_bodega where id=:texto";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":texto",$id);
		$sth->execute();
		$res=$sth->fetch();

		$idventa=$res['idventa'];

		if ($res['tipo']==0){
			if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
			$res=$this->borrar('et_bodega',"id",$id);
		}
		else{
			$arreglo+=array('idventa'=>null);
			$arreglo+=array('cantidad'=>1);
			$arreglo+=array('pendiente'=>0);
			$arreglo+=array('total'=>0);
			$arreglo+=array('gtotalv'=>null);
			$res=$this->update('et_bodega',array('id'=>$id), $arreglo);
		}

		{
			$sql="select sum(gtotalv) as gtotal from et_bodega where idventa=:texto";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":texto",$idventa);
			$sth->execute();
			$resx=$sth->fetch();
			$gtotal=$resx['gtotal'];

			$subtotal=$gtotal/1.16;
			$iva=$gtotal-$subtotal;

			$values = array('subtotal'=>$subtotal, 'iva'=>$iva, 'total'=>$gtotal, 'gtotal'=>$gtotal );
			$this->update('et_venta',array('idventa'=>$idventa), $values);
		}
		$row = array('id' =>$id,'subtotal' =>round($subtotal,2), 'iva'=>round($iva,2), 'total'=>round($gtotal,2));
		return json_encode($row);
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
