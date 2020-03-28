<?php
	require_once("db_cliente.php");
	$bdd = new Cliente();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	
	if($id>0){
		$pd = $bdd->cliente($id);
		$id=$pd['idcliente'];
		$razon=$pd['razon_social_prove'];
		$rfc=$pd['rfc_prove'];
		$contacto=$pd['contacto_prove'];
		$direccion=$pd['direccion_prove'];
		$colonia=$pd['colonia_prove'];
		$no_ext=$pd['no_ext_prove'];
		$no_int=$pd['no_int_prove'];
		$cp=$pd['cp_prove'];
		$localidad=$pd['localidad_prove'];
		$municipio=$pd['municipio_prove'];
		$estado=$pd['estado_prove'];
		$tel=$pd['tel_prove'];
		$cel1=$pd['cel1_prove'];
		$cel2=$pd['cel2_prove'];
		$web=$pd['web_prove'];
		$giro=$pd['giro_prove'];
		$email=$pd['email_prove'];
		$banco=$pd['banco_prove'];
		$cuenta=$pd['cuenta_prove'];
		$sucursal=$pd['sucursal_prove'];
		$clabe=$pd['clabe_prove'];
		$credito=$pd['credito_prove'];
		$plazo=$pd['plazo_prove'];
	}
	else{
		$numero = $bdd->numero("et_cliente","idcliente");
		$pd = $bdd->cliente($id);
		$id=0;
		$razon="";
		$rfc="";
		$contacto="";
		$direccion="";
		$colonia="";
		$no_ext="";
		$no_int="";
		$cp="";
		$localidad="";
		$municipio="";
		$estado="";
		$tel="";
		$cel1="";
		$cel2="";
		$web="";
		$giro="";
		$email="";
		$banco="";
		$cuenta="";
		$sucursal="";
		$clabe="";
		$credito="";
		$plazo="";
	}
?>

<div class="container">
	<div class='card'>
		<div class='card-body'>
			<form action="" id="form_cliente" data-lugar="a_cliente/db_cliente" data-funcion="guardar_cliente">
				<div class="header">
					<h4 class="title">Editar cliente</h4>
					<hr>
				</div>
				<div class="header" style="text-align: center;">
					<h4 class="title"><b>Datos Generales</b></h4>
					<br>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Razón social:</label>
					<div class="col-sm-10">
						<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
						<input type="text" class="form-control" name="razon" id="razon" value="<?php echo $razon;?>" placeholder="Razón social">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">R.F.C.</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="rfc" id="rfc" value="<?php echo $rfc;?>" placeholder="R.F.C.">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Nombre Contacto</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="contacto" id="contacto" value="<?php echo $contacto;?>" placeholder="Nombre Contacto">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Dirección</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $direccion;?>" placeholder="Dirección">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Colonia</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="colonia" id="colonia" value="<?php echo $colonia;?>" placeholder="Colonia">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for=""># Exterior</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="no_ext" id="no_ext" value="<?php echo $no_ext;?>" placeholder="# Exterior">
					</div>


					<label class="control-label col-sm-2" for=""># Interior</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="no_int" id="no_int" value="<?php echo $no_int;?>" placeholder="# Interior">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">C.P.</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="cp" id="cp" value="<?php echo $cp;?>" placeholder="C.P.">
					</div>

					<label class="control-label col-sm-2" for="">Localidad</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="localidad" id="localidad" value="<?php echo $localidad;?>" placeholder="Localidad">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Municipio</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="municipio" id="municipio" value="<?php echo $municipio;?>" placeholder="Municipio">
					</div>

					<label class="control-label col-sm-2" for="">Estado</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="estado" id="estado" value="<?php echo $estado;?>" placeholder="Estado">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Teléfono</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="tel" id="tel" value="<?php echo $tel;?>" placeholder="Teléfono">
					</div>

					<label class="control-label col-sm-2" for="">Celular 1</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="cel1" id="cel1" value="<?php echo $cel1;?>" placeholder="Celular 1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Celular 2</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="cel2" id="cel2" value="<?php echo $cel2;?>" placeholder="Celular 2">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Email</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="email" id="email" value="<?php echo $email;?>" placeholder="Email">
					</div>

					<label class="control-label col-sm-2" for="">Página Web</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="web" id="web" value="<?php echo $web;?>" placeholder="Página Web">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Giro</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="giro" id="giro" value="<?php echo $giro;?>" placeholder="Giro">
					</div>
				</div>



				<div class="header" style="text-align: center;">
					<h4 class="title"><b>Datos Bancarios</b></h4>
					<br>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Banco:</label>
					<div class="col-sm-4">
						<select class="form-control" name="banco" id="banco">
						<option value="BBVA BANCOMER" <?php if($banco=="BBVA BANCOMER") echo "selected"; ?> > BBVA BANCOMER</option>
						<option value="BANAMEX" <?php if($banco=="BANAMEX") echo "selected"; ?> > BANAMEX</option>
						<option value="SANTANDER" <?php if($banco=="SANTANDER") echo "selected"; ?> > SANTANDER</option>
						<option value="SCOTIABANK" <?php if($banco=="SCOTIABANK") echo "selected"; ?> > SCOTIABANK</option>
						<option value="BANCO DEL BAJIO" <?php if($banco=="BANCO DEL BAJIO") echo "selected"; ?> > BANCO DEL BAJIO</option>
						<option value="BANORTE" <?php if($banco=="BANORTE") echo "selected"; ?> > BANORTE</option>
						<option value="BANCO HSBC" <?php if($banco=="BANCO HSBC") echo "selected"; ?> > BANCO HSBC</option>
						<option value="BANCO INBURSA" <?php if($banco=="BANCO INBURSA") echo "selected"; ?> > BANCO INBURSA</option>
						<option value="BANCO AZTECA" <?php if($banco=="BANCO AZTECA") echo "selected"; ?> > BANCO AZTECA</option>
						<option value="BANCA MIFEL" <?php if($banco=="BANCA MIFEL") echo "selected"; ?> > BANCA MIFEL</option>
						<option value="BANCA AFIRME" <?php if($banco=="BANCA AFIRME") echo "selected"; ?> > BANCA AFIRME</option>
						<option value="BANSI" <?php if($banco=="BANSI") echo "selected"; ?> > BANSI</option>
						<option value="BANK OF AMERICA" <?php if($banco=="BANK OF AMERICA") echo "selected"; ?> > BANK OF AMERICA</option>
						<option value="BANREGIO" <?php if($banco=="BANREGIO") echo "selected"; ?> > BANREGIO</option>
						<option value="BANJERCITO" <?php if($banco=="BANJERCITO") echo "selected"; ?> > BANJERCITO</option>
						<option value="BANCO INTERACCIONES" <?php if($banco=="BANCO INTERACCIONES") echo "selected"; ?> > BANCO INTERACCIONES</option>
						<option value="AMERICAN EXPRESS" <?php if($banco=="AMERICAN EXPRESS") echo "selected"; ?> > AMERICAN EXPRESS</option>
						<option value="BANCO INVEX" <?php if($banco=="BANCO INVEX") echo "selected"; ?> > BANCO INVEX</option>
						<option value="BANCO VE POR MAS" <?php if($banco=="BANCO VE POR MAS") echo "selected"; ?> > BANCO VE POR MAS</option>
						<option value="ING BANCO" <?php if($banco=="ING BANCO") echo "selected"; ?> > ING BANCO</option>
						<option value="COMPARTAMOS" <?php if($banco=="COMPARTAMOS") echo "selected"; ?> > COMPARTAMOS</option>
						<option value="BANCO MULTIVA" <?php if($banco=="BANCO MULTIVA") echo "selected"; ?> > BANCO MULTIVA</option>
						<option value="BANCOPPEL" <?php if($banco=="BANCOPPEL") echo "selected"; ?> > BANCOPPEL</option>
						<option value="AHORRO FAMSA" <?php if($banco=="AHORRO FAMSA") echo "selected"; ?> > AHORRO FAMSA</option>
						<option value="AUTOFIN" <?php if($banco=="AUTOFIN") echo "selected"; ?> > AUTOFIN</option>
						<option value="MONEX" <?php if($banco=="MONEX") echo "selected"; ?> > MONEX</option>
						<option value="JP MORGAN" <?php if($banco=="JP MORGAN") echo "selected"; ?> > JP MORGAN</option>
						<option value="PRUDENTIAL BANK" <?php if($banco=="PRUDENTIAL BANK") echo "selected"; ?> > PRUDENTIAL BANK</option>
						<option value="BANCO VOLKSWAGEN" <?php if($banco=="BANCO VOLKSWAGEN") echo "selected"; ?> > BANCO VOLKSWAGEN</option>
						<option value="BANCO DE MEXICO" <?php if($banco=="BANCO DE MEXICO") echo "selected"; ?> > BANCO DE MEXICO</option>
						<option value="ABC CAPITAL" <?php if($banco=="ABC CAPITAL") echo "selected"; ?> > ABC CAPITAL</option>
						<option value="ACTINVER" <?php if($banco=="ACTINVER") echo "selected"; ?> > ACTINVER</option>
						<option value="BANCO BASE" <?php if($banco=="BANCO BASE") echo "selected"; ?> > BANCO BASE</option>
						<option value="BANCO CREDIT SUISSE" <?php if($banco=="BANCO CREDIT SUISSE") echo "selected"; ?> > BANCO CREDIT SUISSE</option>
						<option value="BANCO FINTERRA" <?php if($banco=="BANCO FINTERRA") echo "selected"; ?> > BANCO FINTERRA</option>
						<option value="BANCO FORJADORES" <?php if($banco=="BANCO FORJADORES") echo "selected"; ?> > BANCO FORJADORES</option>
						<option value="BANCO INMOBILIARIO MEXICANO" <?php if($banco=="BANCO INMOBILIARIO MEXICANO") echo "selected"; ?> > BANCO INMOBILIARIO MEXICANO</option>
						<option value="BANCO PAGATODO" <?php if($banco=="BANCO PAGATODO") echo "selected"; ?> > BANCO PAGATODO</option>
						<option value="BANCO PROGRESO CHIHUAHUA" <?php if($banco=="BANCO PROGRESO CHIHUAHUA") echo "selected"; ?> > BANCO PROGRESO CHIHUAHUA</option>
						<option value="BANCO SABADELL" <?php if($banco=="BANCO SABADELL") echo "selected"; ?> > BANCO SABADELL</option>
						<option value="BANCREA" <?php if($banco=="BANCREA") echo "selected"; ?> > BANCREA</option>
						<option value="BANK OF CHINA MEXICO" <?php if($banco=="BANK OF CHINA MEXICO") echo "selected"; ?> > BANK OF CHINA MEXICO</option>
						<option value="BANK OF TOKYO MITSUBISHI" <?php if($banco=="BANK OF TOKYO MITSUBISHI") echo "selected"; ?> > BANK OF TOKYO MITSUBISHI UFJ (MEXICO)</option>
						<option value="BANKAOOL" <?php if($banco=="BANKAOOL") echo "selected"; ?> > BANKAOOL</option>
						<option value="BARCLAYS BANK MEXICO" <?php if($banco=="BARCLAYS BANK MEXICO") echo "selected"; ?> > BARCLAYS BANK MEXICO</option>
						<option value="CIBANCO" <?php if($banco=="CIBANCO") echo "selected"; ?> > CIBANCO</option>
						<option value="CONSUBANCO" <?php if($banco=="CONSUBANCO") echo "selected"; ?> > CONSUBANCO</option>
						<option value="DEUTSCHE BANK MEXICO" <?php if($banco=="DEUTSCHE BANK MEXICO") echo "selected"; ?> > DEUTSCHE BANK MEXICO</option>
						<option value="FUNDACION DONDE BANCO" <?php if($banco=="FUNDACION DONDE BANCO") echo "selected"; ?> > FUNDACION DONDE BANCO</option>
						<option value="ICBC MEXICO" <?php if($banco=="ICBC MEXICO") echo "selected"; ?> > INDUSTRIAL AND COMMERCIAL BANK OF CHINA</option>
						<option value="INTERCAM BANCO" <?php if($banco=="INTERCAM BANCO") echo "selected"; ?> > INTERCAM BANCO</option>
						<option value="INVESTA BANCO" <?php if($banco=="INVESTA BANCO") echo "selected"; ?> > INVESTA BANK</option>
						<option value="MIZUHO BANCO" <?php if($banco=="MIZUHO BANCO") echo "selected"; ?> > MIZUHO BANK</option>
						<option value="SHINHAN BANCO" <?php if($banco=="SHINHAN BANCO") echo "selected"; ?> > SHINHAN BANK</option>
						<option value="UBS BANCO MEXICO" <?php if($banco=="UBS BANCO MEXICO") echo "selected"; ?> > UBS BANK MEXICO</option>
						<option value="IXE BANCO" <?php if($banco=="IXE BANCO") echo "selected"; ?> > IXE BANCO</option>
						</select>
					</div>

					<label class="control-label col-sm-2" for="">Cuenta:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="cuenta" id="cuenta" value="<?php echo $cuenta;?>" placeholder="Cuenta">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Sucursal</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="sucursal" id="sucursal" value="<?php echo $sucursal;?>" placeholder="Sucursal">
					</div>

					<label class="control-label col-sm-2" for="">Clabe</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="clabe" id="clabe" value="<?php echo $clabe;?>" placeholder="Clabe">
					</div>
				</div>


				<div class="header" style="text-align: center;">
					<h4 class="title"><b>Condiciones Comerciales</b></h4>
					<br>
				</div>


				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Crédito</label>
					<div class="col-sm-4">
						<select class="form-control" name="credito" id="credito">
						<option value="Si" <?php if($credito=="Si") echo "selected"; ?> > Si</option>
						<option value="No" <?php if($credito=="No") echo "selected"; ?> >No</option>
						</select>
					</div>

					<label class="control-label col-sm-2" for="">Plazo en días</label>
					<div class="col-sm-4">
						<input type="number" class="form-control" name="plazo" id="plazo" value="<?php echo $plazo;?>" placeholder="Plazo en días">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="btn-group">
						<button class="btn btn-outline-secondary btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
						<button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_cliente/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
