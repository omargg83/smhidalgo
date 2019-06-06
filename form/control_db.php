<?php
session_start();

class Venta{
    private $ventas;
    private $ventasp;
	private $clientes;
	private $marca;
	private $modelo;
	private $inventario;
	private $tiendas;
	private $descuento;
    private $dbh;
    private $geral;
    private $traspaso;
    private $accesox;
    private $comprax;
    private $tienda;
    private $bodega;

    public function __construct(){
		date_default_timezone_set("America/Chicago");
        $this->ventas = array();
        // $this->dbh = new PDO('mysql:host=localhost;dbname=smhidalgo', "root", "root");
		$this->dbh = new PDO('mysql:host=smhidalgo.com;dbname=sagycrmr_smhidalgo', "sagyccom_esponda", "esponda123$");
    }

    private function set_names(){
        return $this->dbh->query("SET NAMES 'utf8'");
    }

	public function empresa(){
		$sql="select * from et_empresas";
		foreach ($this->dbh->query($sql) as $res){
            $this->traspaso=$res;
        }
        return $this->traspaso;
        $this->dbh=null;
	}

	public function traspaso($id){
		self::set_names();
		$sql="select * from et_traspaso where id='$id'";
		foreach ($this->dbh->query($sql) as $res){
            $this->traspaso=$res;
        }
        return $this->traspaso;
        $this->dbh=null;
	}
	public function traspaso_lista(){
		self::set_names();
		$sql="select et_traspaso.id, et_traspaso.nombre, de.nombre as nde, para.nombre as npara, et_traspaso.idde, et_traspaso.fecha, et_traspaso.estado  from et_traspaso
		left outer join et_tienda de on de.id=et_traspaso.idde
		left outer join et_tienda para on para.id=et_traspaso.idpara where idde='".$_SESSION['idtienda']."' or idpara='".$_SESSION['idtienda']."' order by fecha desc";
        foreach ($this->dbh->query($sql) as $res){
            $this->traspaso[]=$res;
        }
        return $this->traspaso;
        $this->dbh=null;
	}
	public function traspaso_pedido($id){
        self::set_names();
        $sql="select et_bodega.id, et_invent.codigo, et_bodega.clave, et_bodega.total, et_invent.nombre, et_invent.unidad, et_invent.unico, abs(et_bodega.cantidad) as cantidad, et_bodega.precio, et_bodega.pendiente, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.id_invent, et_bodega.observaciones, et_bodega.recibido, et_bodega.frecibido from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where idtraspaso='$id' order by et_bodega.id desc";

        foreach ($this->dbh->query($sql) as $res){
            $this->ventasp[]=$res;
        }
        return $this->ventasp;
        $this->dbh=null;
    }

	public function general($sql){
		self::set_names();
		foreach ($this->dbh->query($sql) as $res){
            $this->general=$res;
        }
        return $this->general;
        $this->dbh=null;
	}
	public function general2($sql){
		self::set_names();
		 foreach ($this->dbh->query($sql) as $res){
            $this->geral[]=$res;
        }
        return $this->geral;
        $this->dbh=null;
	}



	public function bodega($id){
		self::set_names();
		$sql="select * from et_bodega where id='$id'";
		 foreach ($this->dbh->query($sql) as $res){
            $this->bodega=$res;
        }
        return $this->bodega;
        $this->dbh=null;
	}

	public function lineas_lista($desde,$hasta){
		self::set_names();
		list($dia,$mes,$anio)=explode("-",$desde);
		$desde=$anio."-".$mes."-".$dia." 00:00:00";

		list($dia,$mes,$anio)=explode("-",$hasta);
		$hasta=$anio."-".$mes."-".$dia." 23:59:59";


		$sql="select * from et_bodega where id_invent=1 and fecha between '$desde' AND '$hasta'";

        foreach ($this->dbh->query($sql) as $res){
            $this->ventas[]=$res;
        }
        return $this->ventas;
        $this->dbh=null;

	}
	public function reparaciones_lista($desde,$hasta){
		self::set_names();
		list($dia,$mes,$anio)=explode("-",$desde);
		$desde=$anio."-".$mes."-".$dia." 00:00:00";

		list($dia,$mes,$anio)=explode("-",$hasta);
		$hasta=$anio."-".$mes."-".$dia." 23:59:59";


		$sql="select * from et_bodega where id_invent=2 and fecha between '$desde' AND '$hasta'";

        foreach ($this->dbh->query($sql) as $res){
            $this->ventas[]=$res;
        }
        return $this->ventas;
        $this->dbh=null;

	}

	public function acceso_lista($id){

		self::set_names();
		$sql="select * from et_usuarioreg where idpersonal='$id'";
        foreach ($this->dbh->query($sql) as $res){
            $this->ventas[]=$res;
        }
        return $this->ventas;
        $this->dbh=null;
	}


}
?>
