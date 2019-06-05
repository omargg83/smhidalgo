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
	public function numero($table,$id){
		self::set_names();
		$sql = "SELECT MAX($id) + 1 FROM $table";
		$statement = $this->dbh->prepare($sql);
		$statement->execute();
		$item_id = $statement->fetchColumn();
		return $item_id;
	}
	public function insert($DbTableName, $values = array()){
		try{
			self::set_names();
			$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			foreach ($values as $field => $v)
            $ins[] = ':' . $field;

			$ins = implode(',', $ins);
			$fields = implode(',', array_keys($values));
			$sql="INSERT INTO $DbTableName ($fields) VALUES ($ins)";
			$sth = $this->dbh->prepare($sql);
			foreach ($values as $f => $v){
				$sth->bindValue(':' . $f, $v);
			}
			$sth->execute();
			return $this->lastId = $this->dbh->lastInsertId();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function update($DbTableName, $id, $values = array()){
		try{
			self::set_names();
			$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$campo=key($id);
			$valor=$id[$campo];
			foreach ($values as $field => $v){
				$ins[] = $field.'= :' . $field;
			}

			$ins = implode(',', $ins);
			$fields = implode(',', array_keys($values));
			$sql="update $DbTableName set $ins where $campo=$valor";
			$sth = $this->dbh->prepare($sql);


			foreach ($values as $f => $v){
				$sth->bindValue(':' . $f, $v);
			}
			$sth->execute();
			return $valor;
		}
		catch(PDOException $e){
			return "------->$sql <------------- Database access FAILED!".$e->getMessage();
		}
	}
	public function borrar($DbTableName, $id){
		try{
			self::set_names();
			$sql="delete from $DbTableName where id=$id";
			$this->dbh->query($sql);
			return 1;
		}
		catch(PDOException $e){
			return "------->$sql <------------- Database access FAILED!".$e->getMessage();
		}
	}

	public function acceso($userPOST, $passPOST){
		self::set_names();
		$sql="select * from et_usuario where user='$userPOST' and pass='$passPOST'";
		foreach ($this->dbh->query($sql) as $res){
            $this->accesox=$res;
        }
        return $this->accesox;
        $this->dbh=null;
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

	public function venta($id){
		self::set_names();
		$sql="select * from et_venta where idventa='$id'";
		foreach ($this->dbh->query($sql) as $res){
            $this->ventas=$res;
        }
        return $this->ventas;
        $this->dbh=null;
	}
	public function ventas_lista($idtienda){
        self::set_names();

		$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, et_cliente.razon_social_prove, et_tienda.nombre, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado, et_descuento.nombre as descuento from et_venta
		left outer join et_cliente on et_cliente.idcliente=et_venta.idcliente
		left outer join et_descuento on et_descuento.iddescuento=et_venta.iddescuento
		left outer join et_tienda on et_tienda.id=et_venta.idtienda where et_venta.idtienda='$idtienda' order by et_venta.fecha desc";


        foreach ($this->dbh->query($sql) as $res){
            $this->ventas[]=$res;
        }
        return $this->ventas;
        $this->dbh=null;
    }
	public function ventas_pedido($id){
        self::set_names();
        $sql="select et_bodega.id, et_bodega.clave, et_invent.codigo, et_invent.nombre, abs(et_bodega.cantidad) as cantidad, et_bodega.precio, et_bodega.pventa, et_bodega.pendiente, et_bodega.total, et_bodega.gtotal, et_bodega.gtotalv, COALESCE(et_bodega.idpaquete,0) as paquete, et_bodega.idtienda, et_bodega.id_invent, et_bodega.unico, et_bodega.observaciones from et_bodega left outer join et_invent on et_invent.id_invent=et_bodega.id_invent where idventa='$id' order by et_bodega.id desc";

        foreach ($this->dbh->query($sql) as $res){
            $this->ventasp[]=$res;
        }
        return $this->ventasp;
        $this->dbh=null;
    }










	public function descuento_lista(){
		self::set_names();
		$sql="SELECT * FROM et_descuento";
		foreach ($this->dbh->query($sql) as $res){
            $this->descuento[]=$res;
        }
        return $this->descuento;
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
