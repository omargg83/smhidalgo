<?php
	if (!isset($_SESSION)) { session_start(); }
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	date_default_timezone_set("America/Mexico_City");

	class Sagyc{
		public $nivel_personal;
		public $nivel_captura;
		public $limite=300;

		public function __construct(){
			date_default_timezone_set("America/Mexico_City");
			$this->Salud = array();
			$this->dbh = new PDO('mysql:host=smhidalgo.com;dbname=sagycrmr_smhidalgo', "sagyccom_esponda", "esponda123$");
			//$this->dbh = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['bdd']."", $_SESSION['mysqluser'], $_SESSION['mysqlpass']);

		}
		public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
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
		public function update($DbTableName, $id = array(), $values = array(), $key=""){
			try{
				self::set_names();
				$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				if($key==""){
					$dataid=$id;
				}
				foreach ($id as $field => $v){
					$condicion[] = $field.'= :' . $field;
				}
				$condicion = implode(' and ', $condicion);
				$cond = implode(',', array_keys($id));

				foreach ($values as $field => $v){
					$ins[] = $field.'= :' . $field;
				}

				$ins = implode(',', $ins);
				$fields = implode(',', array_keys($values));

				$sql="update $DbTableName set $ins where $condicion";
				$sth = $this->dbh->prepare($sql);
				foreach ($values as $f => $v){
					$sth->bindValue(':' . $f, $v);
				}
				foreach ($id as $f => $v){
					$sth->bindValue(':' . $f, $v);
				}
				$sth->execute();

				$sql="select * from $DbTableName where $condicion";
				$updax = $this->dbh->prepare($sql);
				foreach ($id as $f => $v){
					$updax->bindValue(':' . $f, $v);
				}
				$updax->execute();
				$res=$updax->fetch();

				if($key==""){
					$campo=key($dataid);
					return $dataid[$campo];
				}
				else{
					return $res[$key];
				}
			}
			catch(PDOException $e){
				return "------->$sql <------------- Database access FAILED!".$e->getMessage();
			}
		}
		public function borrar($DbTableName, $key,$id){
			try{
				self::set_names();
				$sql="delete from $DbTableName where $key=$id";
				$this->dbh->query($sql);
				return 1;
			}
			catch(PDOException $e){
				return "------->$sql <------------- Database access FAILED!".$e->getMessage();
			}
		}

		public function acceso2($mail, $pass){
			try{
				self::set_names();
				$sql="SELECT * FROM et_usuario where user=:correo and pass=:pass and activo=1";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":correo",$mail);
				$sth->bindValue(":pass",$pass);
				$sth->execute();
				$res=$sth->fetch();
				return $res;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function recuperar($llave){
			try{
				self::set_names();
				$sql="SELECT * FROM personal where llave=:llave and autoriza=1";

				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":llave",$llave);
				$sth->execute();
				$res=$sth->fetch();
				return $res;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}


		public function permiso($idpersona){
			try{
				self::set_names();
				$sql="select * from personal_permiso where idpersona='$idpersona'";
				foreach ($this->dbh->query($sql) as $res){
					$this->accesox[]=$res;
				}
				return $this->accesox;
				$this->dbh=null;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}

		public function general($sql){
			try{
				self::set_names();
				$this->geral=array();
				 foreach ($this->dbh->query($sql) as $res){
					$this->geral[]=$res;
				}
				return $this->geral;
				$this->dbh=null;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}

		public function numero($table,$id){
			self::set_names();
			$sql = "SELECT MAX($id) + 1 FROM $table";
			$statement = $this->dbh->prepare($sql);
			$statement->execute();
			$item_id = $statement->fetchColumn();
			return $item_id;
		}



		public function mes($mes,$key=""){
			if ($mes==1){ $mes="Enero";}
			if ($mes==2){ $mes="Febrero";}
			if ($mes==3){ $mes="Marzo";}
			if ($mes==4){ $mes="Abril";}
			if ($mes==5){ $mes="Mayo";}
			if ($mes==6){ $mes="Junio";}
			if ($mes==7){ $mes="Julio";}
			if ($mes==8){ $mes="Agosto";}
			if ($mes==9){ $mes="Septiembre";}
			if ($mes==10){ $mes="Octubre";}
			if ($mes==11){ $mes="Noviembre";}
			if ($mes==12){ $mes="Diciembre";}
			if($key==1){
				$mes=substr($mes,0,3);
			}
			return $mes;
		}

		public function color($id){
			try{
				self::set_names();
				$this->areax="";
				$sql="select * from colores where idcolor='$id'";
				foreach ($this->dbh->query($sql) as $res){
					$this->areax=$res;
				}
				return $this->areax;
				$this->dbh=null;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function colores(){
			try{
				self::set_names();
				$sql="select * from colores";
				$this->areax=array();
				foreach ($this->dbh->query($sql) as $res){
					$this->areax[]=$res;
				}
				return $this->areax;
				$this->dbh=null;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function letranum($numero){

				if($numero>0){
				$var=($numero)*100;
				$tmp=strlen($var);
				$tmp2=substr($var,$tmp-2,2);
				$entero=substr($var,0,$tmp-2);

				$num=$entero;
				$fem = true;
				$dec = true;
				$matuni[2]  = "dos";
				$matuni[3]  = "tres";
				$matuni[4]  = "cuatro";
				$matuni[5]  = "cinco";
				$matuni[6]  = "seis";
				$matuni[7]  = "siete";
				$matuni[8]  = "ocho";
				$matuni[9]  = "nueve";
				$matuni[10] = "diez";
				$matuni[11] = "once";
				$matuni[12] = "doce";
				$matuni[13] = "trece";
				$matuni[14] = "catorce";
				$matuni[15] = "quince";
				$matuni[16] = "dieciseis";
				$matuni[17] = "diecisiete";
				$matuni[18] = "dieciocho";
				$matuni[19] = "diecinueve";
				$matuni[20] = "veinte";
				$matunisub[2] = "dos";
				$matunisub[3] = "tres";
				$matunisub[4] = "cuatro";
				$matunisub[5] = "quin";
				$matunisub[6] = "seis";
				$matunisub[7] = "sete";
				$matunisub[8] = "ocho";
				$matunisub[9] = "nove";

				$matdec[2] = "veint";
				$matdec[3] = "treinta";
				$matdec[4] = "cuarenta";
				$matdec[5] = "cincuenta";
				$matdec[6] = "sesenta";
				$matdec[7] = "setenta";
				$matdec[8] = "ochenta";
				$matdec[9] = "noventa";
				$matsub[3]  = 'mill';
				$matsub[5]  = 'bill';
				$matsub[7]  = 'mill';
				$matsub[9]  = 'trill';
				$matsub[11] = 'mill';
				$matsub[13] = 'bill';
				$matsub[15] = 'mill';
				$matmil[4]  = 'millones';
				$matmil[6]  = 'billones';
				$matmil[7]  = 'de billones';
				$matmil[8]  = 'millones de billones';
				$matmil[10] = 'trillones';
				$matmil[11] = 'de trillones';
				$matmil[12] = 'millones de trillones';
				$matmil[13] = 'de trillones';
				$matmil[14] = 'billones de trillones';
				$matmil[15] = 'de billones de trillones';
				$matmil[16] = 'millones de billones de trillones';

				$num = trim((string)@$num);
				if ($num[0] == '-') {
					$neg = 'menos ';
					$num = substr($num, 1);
				}else
					$neg = '';
				while ($num[0] == '0') $num = substr($num, 1);
				if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
				$zeros = true;
				$punt = false;
				$ent = '';
				$fra = '';
				for ($c = 0; $c < strlen($num); $c++) {
					$n = $num[$c];
					if (! (strpos(".,'''", $n) === false)) {
						if ($punt) break;
						else{
							$punt = true;
						continue;
						}
					}elseif (! (strpos('0123456789', $n) === false)) {
						if ($punt) {
							if ($n != '0') $zeros = false;
							$fra .= $n;
						}else
						$ent .= $n;
					}else
					break;
				}
				$ent = '     ' . $ent;
				if ($dec and $fra and ! $zeros) {
					$fin = ' coma';
					for ($n = 0; $n < strlen($fra); $n++) {
						if (($s = $fra[$n]) == '0')
							$fin .= ' cero';
						elseif ($s == '1')
							$fin .= $fem ? ' un' : ' un';
						else
							$fin .= ' ' . $matuni[$s];
					}
				}else
					$fin = '';
					if ((int)$ent === 0) return 'Cero ' . $fin;
					$tex = '';
					$sub = 0;
					$mils = 0;
					$neutro = false;
					while ( ($num = substr($ent, -3)) != '   ') {
						$ent = substr($ent, 0, -3);
						if (++$sub < 3 and $fem) {
							$matuni[1] = 'un';
							$subcent = 'os';
						}else{
							$matuni[1] = $neutro ? 'un' : 'uno';
							$subcent = 'os';
						}
					$t = '';
					$n2 = substr($num, 1);

					if ($n2 == '00') {
					}elseif ($n2 < 21)
						$t = ' ' . $matuni[(int)$n2];
					elseif ($n2 < 30) {
						$n3 = $num[2];
						if ($n3 != 0) $t = 'i' . $matuni[$n3];
						$n2 = $num[1];
						$t = ' ' . $matdec[$n2] . $t;
					}else{
						$n3 = $num[2];
						if ($n3 != 0) $t = ' y ' . $matuni[$n3];
						$n2 = $num[1];
						$t = ' ' . $matdec[$n2] . $t;
					}
					$n = $num[0];
					if ($n == 1) {
						$t = ' ciento' . $t;
					}elseif ($n == 5){
						$t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
					}elseif ($n != 0){
						$t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
					}
					if ($sub == 1) {
					}elseif (! isset($matsub[$sub])) {
						if ($num == 1) {
							$t = ' mil';
						}elseif ($num > 1){
							$t .= ' mil';
						}
					}elseif ($num == 1) {
						$t .= ' ' . $matsub[$sub] . '?n';
					}elseif ($num > 1){
						$t .= ' ' . $matsub[$sub] . 'ones';
					}
					if ($num == '000') $mils ++;
					elseif ($mils != 0) {
						if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
						$mils = 0;
					}
					$neutro = true;
					$tex = $t . $tex;
				}
				$tex = $neg . substr($tex, 1) . $fin;
				$letra= ucfirst($tex)." pesos ".$tmp2;
				$letra =$letra."/100 M.N";
				return $letra;
			}
			else {
				return "";
			}
		}

		public function despachos(){
			try{
				self::set_names();
				$sql="SELECT * FROM despachos";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
				$res=$sth->fetchAll();
				return $res;
			}
			catch(PDOException $e){
				return "Database access FAILED! ".$e->getMessage();
			}
		}

		public function empresas(){
			try{
				self::set_names();
				$sql="SELECT * FROM empresas";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
				$res=$sth->fetchAll();
				return $res;
			}
			catch(PDOException $e){
				return "Database access FAILED! ".$e->getMessage();
			}
		}
		public function tipos(){
			try{
				self::set_names();
				$sql="SELECT * FROM producto_tipo";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
				$res=$sth->fetchAll();
				return $res;
			}
			catch(PDOException $e){
				return "Database access FAILED! ".$e->getMessage();
			}
		}
	}

	function moneda($valor){
		return "$ ".number_format( $valor, 2, "." , "," );
	}
	function fecha($fecha,$key=""){
		$fecha = new DateTime($fecha);
		if($key==1){
			$mes=$fecha->format('m');
			if ($mes==1){ $mes="Enero";}
			if ($mes==2){ $mes="Febrero";}
			if ($mes==3){ $mes="Marzo";}
			if ($mes==4){ $mes="Abril";}
			if ($mes==5){ $mes="Mayo";}
			if ($mes==6){ $mes="Junio";}
			if ($mes==7){ $mes="Julio";}
			if ($mes==8){ $mes="Agosto";}
			if ($mes==9){ $mes="Septiembre";}
			if ($mes==10){ $mes="Octubre";}
			if ($mes==11){ $mes="Noviembre";}
			if ($mes==12){ $mes="Diciembre";}

			return $fecha->format('d')." de $mes de ".$fecha->format('Y');
		}
		if($key==2){
			return $fecha->format('d-m-Y H:i:s');
		}
		else{
			return $fecha->format('d-m-Y');
		}
	}
?>
