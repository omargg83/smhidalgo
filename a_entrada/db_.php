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
  public function entrada($id){
    self::set_names();
    $sql="select * from et_entrada where identrada='$id'";
     foreach ($this->dbh->query($sql) as $res){
            $this->inventario=$res;
        }
        return $this->inventario;
        $this->dbh=null;
  }
  public function entrada_lista(){
    self::set_names();
    $sql="select et_entrada.identrada, et_entrada.numero, et_prove.razon_social_prove, et_compra.numero as cnumero, et_entrada.estado, et_entrada.total from et_entrada
      left outer join et_prove on et_prove.id_prove=et_entrada.id_prove
      left outer join et_compra on et_compra.idcompra=et_entrada.idcompra
      order by identrada desc";
        foreach ($this->dbh->query($sql) as $res){
            $this->ventas[]=$res;
        }
        return $this->ventas;
        $this->dbh=null;
  }
  public function entrada_pedido($id){
        self::set_names();
        $sql="select et_bodega.id, et_invent.codigo, et_invent.nombre, et_invent.unidad, abs(et_bodega.cantidad) as cantidad, et_bodega.total, et_bodega.clave, et_bodega.precio, et_bodega.gtotal, et_bodega.pendiente, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.gtotal, et_bodega.id_invent, et_bodega.observaciones, et_bodega.color, et_bodega.tipo from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where identrada='$id' order by et_bodega.id desc";

        foreach ($this->dbh->query($sql) as $res){
            $this->ventasp[]=$res;
        }
        return $this->ventasp;
        $this->dbh=null;
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
$db = new Entrada();

if(strlen($function)>0){

	echo $db->$function();
}
