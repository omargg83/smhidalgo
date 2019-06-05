<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}
	
class Cliente extends Sagyc{
	
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

	public function clientes_lista(){
		self::set_names();
		$sql="SELECT * FROM et_cliente";
		 foreach ($this->dbh->query($sql) as $res){
            $this->clientes[]=$res;
        }
        return $this->clientes;
        $this->dbh=null;
	}

	public function cliente($id){
		self::set_names();
		$this->clientes="";
		$sql="select * from et_cliente where idcliente='$id'";
		 foreach ($this->dbh->query($sql) as $res){
            $this->clientes=$res;
        }
        return $this->clientes;
        $this->dbh=null;
	}

	public function guardar_cliente(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['razon'])){
			$arreglo+=array('razon_social_prove'=>$_REQUEST['razon']);
		}
		if (isset($_REQUEST['rfc'])){
			$arreglo+=array('rfc_prove'=>$_REQUEST['rfc']);
		}
		if (isset($_REQUEST['contacto'])){
			$arreglo+=array('contacto_prove'=>$_REQUEST['contacto']);
		}
		if (isset($_REQUEST['direccion'])){
			$arreglo+=array('direccion_prove'=>$_REQUEST['direccion']);
		}
		if (isset($_REQUEST['colonia'])){
			$arreglo+=array('colonia_prove'=>$_REQUEST['colonia']);
		}
		if (isset($_REQUEST['no_ext'])){
			$arreglo+=array('no_ext_prove'=>$_REQUEST['no_ext']);
		}
		if (isset($_REQUEST['no_int'])){
			$arreglo+=array('no_int_prove'=>$_REQUEST['no_int']);
		}
		if (isset($_REQUEST['cp'])){
			$arreglo+=array('cp_prove'=>$_REQUEST['cp']);
		}
		if (isset($_REQUEST['localidad'])){
			$arreglo+=array('localidad_prove'=>$_REQUEST['localidad']);
		}
		if (isset($_REQUEST['municipio'])){
			$arreglo+=array('municipio_prove'=>$_REQUEST['municipio']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('estado_prove'=>$_REQUEST['estado']);
		}
		if (isset($_REQUEST['tel'])){
			$arreglo+=array('tel_prove'=>$_REQUEST['tel']);
		}
		if (isset($_REQUEST['cel1'])){
			$arreglo+=array('cel1_prove'=>$_REQUEST['cel1']);
		}
		if (isset($_REQUEST['cel2'])){
			$arreglo+=array('cel2_prove'=>$_REQUEST['cel2']);
		}
		if (isset($_REQUEST['web'])){
			$arreglo+=array('web_prove'=>$_REQUEST['web']);
		}
		if (isset($_REQUEST['giro'])){
			$arreglo+=array('giro_prove'=>$_REQUEST['giro']);
		}
		if (isset($_REQUEST['email'])){
			$arreglo+=array('email_prove'=>$_REQUEST['email']);
		}
		if (isset($_REQUEST['banco'])){
			$arreglo+=array('banco_prove'=>$_REQUEST['banco']);
		}
		if (isset($_REQUEST['cuenta'])){
			$arreglo+=array('cuenta_prove'=>$_REQUEST['cuenta']);
		}
		if (isset($_REQUEST['sucursal'])){
			$arreglo+=array('sucursal_prove'=>$_REQUEST['sucursal']);
		}
		if (isset($_REQUEST['clabe'])){
			$arreglo+=array('clabe_prove'=>$_REQUEST['clabe']);
		}
		if (isset($_REQUEST['credito'])){
			$arreglo+=array('credito_prove'=>$_REQUEST['credito']);
		}
		if (isset($_REQUEST['plazo'])){
			$arreglo+=array('plazo_prove'=>$_REQUEST['plazo']);
		}
		if($id==0){
			
			$date=date("Y-m-d H:i:s");
			$arreglo+=array('fecha_alta_prove'=>$_REQUEST['plazo']);
			$arreglo+=array('fecha_mod_prove'=>$_REQUEST['plazo']);
			$x.=$this->insert('et_cliente', $arreglo);
		}
		else{
			$x.=$this->update('et_cliente',array('idcliente'=>$id), $arreglo);
		}
		return $x;
	}
}

if(strlen($function)>0){
	$db = new Cliente();
	echo $db->$function();
}


