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
}

if(strlen($function)>0){
	$db = new Compra();
	echo $db->$function();
}


