<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Compra extends Sagyc{

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

	public function compra($id){
		self::set_names();
		$sql="select * from et_compra where idcompra='$id'";
		 foreach ($this->dbh->query($sql) as $res){
            $this->comprax=$res;
        }
        return $this->comprax;
        $this->dbh=null;
	}
	public function compras_lista(){
        self::set_names();
		$sql="select * from et_compra left outer join et_prove on et_prove.id_prove=et_compra.id_prove order by idcompra desc";
        foreach ($this->dbh->query($sql) as $res){
            $this->comprax[]=$res;
        }
        return $this->comprax;
        $this->dbh=null;
    }
	public function compras_pedido($id){
        self::set_names();
        $sql="select * from et_comprapedido left outer join et_invent on et_invent.id_invent=et_comprapedido.id_invent where idcompra='$id' order by id desc";

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

	public function guardar_compra(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['id_prove'])){
			$arreglo+=array('id_prove'=>$_REQUEST['id_prove']);
		}
		if (isset($_REQUEST['numero'])){
			$arreglo+=array('numero'=>$_REQUEST['numero']);
		}
		if (isset($_REQUEST['condiciones'])){
			$arreglo+=array('condiciones'=>$_REQUEST['condiciones']);
		}
		if (isset($_REQUEST['comentarios'])){
			$arreglo+=array('comentarios'=>$_REQUEST['comentarios']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('estado'=>$_REQUEST['estado']);
		}
		if($id==0){
			$x.=$this->insert('et_compra', $arreglo);
		}
		else{
			$x.=$this->update('et_compra',array('idcompra'=>$id), $arreglo);
		}
		return $x;
	}
		function busca_producto(){
			try{
				$x="";
				if (isset($_REQUEST['texto'])){$texto=$_REQUEST['texto'];}
				parent::set_names();

				$sql="SELECT * FROM et_invent where nombre like :texto OR codigo like :nombre";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":texto","%$texto%");
				$sth->bindValue(":nombre","%$texto%");
				$sth->execute();
				$res=$sth->fetchAll();
				$x.="<div class='row'>";
				if(count($res)>0){
					$x.="<table class='table table-sm'>";
					$x.="<tr><th>Código</th><th>Nombre</th><th>Cantidad</th><th>+</th></tr>";
					foreach ($res as $key) {
						$x.= "<tr id=".$key['id_invent']." class='edit-t'>";
						$x.= "<td>";
						$x.= $key["codigo"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= $key["nombre"];
						$x.= "</td>";

						$x.= "<td>";
						$x.= "<input id='cantidad_".$key['id_invent']."' name='cantidad_".$key['id_invent']."' value='1' class='form-control'>";
						$x.= "</td>";

						$x.= "<td>";
						$x.= "<div class='btn-group'>";
							$x.= "<button class='btn btn-outline-secondary btn-sm' id='producto_sel' title='Agregar producto a la compra'><i class='fas fa-plus'></i></button>";
						$x.= "</div>";
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
		function agregar_producto(){
			$x="";
			parent::set_names();
			$arreglo =array();

			if (isset($_REQUEST['id_invent'])){
				$arreglo+=array('id_invent'=>$_REQUEST['id_invent']);
			}

			if (isset($_REQUEST['cantidad'])){
				$arreglo+=array('cantidad_oc'=>$_REQUEST['cantidad']);
			}

			if (isset($_REQUEST['idcompra'])){
				$arreglo+=array('idcompra'=>$_REQUEST['idcompra']);
			}

			$x.=$this->insert('et_comprapedido', $arreglo);

			return $x;
		}
		public function borrar_producto(){
			self::set_names();
			if (isset($_POST['id'])){$id=$_POST['id'];}
			return $this->borrar('et_comprapedido',"id",$id);
		}
}

if(strlen($function)>0){
	$db = new Compra();
	echo $db->$function();
}
