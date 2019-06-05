<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}
	
class Usuario extends Sagyc{
	
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

	public function usuario($id){
		self::set_names();
		$sql="select * from et_usuario where idusuario='$id'";
		 foreach ($this->dbh->query($sql) as $res){
            $this->inventario=$res;
        }
        return $this->inventario;
        $this->dbh=null;
	}
	public function usuario_lista(){
        self::set_names();
		$sql="select et_usuario.idusuario, et_usuario.idtienda, et_usuario.nombre, et_usuario.user, et_usuario.pass, et_usuario.nivel, et_tienda.nombre as tienda  from et_usuario left outer join et_tienda on et_tienda.id=et_usuario.idtienda";
        foreach ($this->dbh->query($sql) as $res){
            $this->comprax[]=$res;
        }
        return $this->comprax;
        $this->dbh=null;
    }

    public function tiendas_lista(){
		self::set_names();
		
		$sql="SELECT * FROM et_tienda";
		foreach ($this->dbh->query($sql) as $res){
            $this->tiendas[]=$res;
        }
        return $this->tiendas;
        $this->dbh=null;
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
}

if(strlen($function)>0){
	$db = new Usuario();
	echo $db->$function();
}


