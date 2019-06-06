<?php
	require_once("control_db.php");
	$bdd = new Venta();
	$id=$_REQUEST['id'];
	$i=0;

	$categoria = $bdd->categoria_lista();
	$marca = $bdd->marca_lista();
	$modelo = $bdd->modelo_lista();
	if($id>0){
		$pd = $bdd->inventario($id);
		$id=$pd['id_invent'];
		$codigo=$pd['codigo'];
		$nombre=$pd['nombre'];
		$unidad=$pd['unidad'];
		$stockmin=$pd['stockmin'];
		$stockmax=$pd['stockmax'];
		$preciocompra=$pd['preciocompra'];
		$pvgeneral=$pd['pvgeneral'];
		$pvdistr=$pd['pvdistr'];
		$pvpromo=$pd['pvpromo'];
		$productoactivo=$pd['productoactivo'];
		$descripcion=$pd['descripcion'];
		$fechaalta=$pd['fechaalta'];
		$fechamod=$pd['fechamod'];
		$categoria=$pd['categoria'];
		$seguimiento=$pd['seguimiento'];
		$unico=$pd['unico'];
		$idmarca=$pd['idmarca'];
		$idmodelo=$pd['idmodelo'];
		$activo=$pd['activo'];
	}
	else{
		$id =0;
		$codigo=$bdd->numero("et_invent","id_invent");
		$codigo="9".str_pad($codigo, 6, "0", STR_PAD_LEFT);
		$categoria="";
		$nombre="";
		$unidad="";
		$stockmin="1";
		$stockmax="1";
		$preciocompra="1";
		$pvgeneral="1";
		$pvdistr="1";
		$pvpromo="1";
		$productoactivo="";
		$descripcion="";
		$tienda="";
		$numpiezas="";
		$fechaalta="";
		$fechamod="";
		$seguimiento=0;
		$unico=0;
		$idmarca=0;
		$idmodelo=0;
		$activo=1;
	}
?>
<div class="container">
	<div class='card'>
		<div class='card-body'>
			<form>
				<div class="header">
					<h4 class="title">Editar Catálogo de productos</h4>
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					<hr>
				</div>

				<div class="form-group row">
				 <label class="control-label col-sm-2" for="">Tipo de insumo:</label>
				  <div class="col-sm-10">
					<select class="form-control" name="unico" id="unico">
					  <option value="0"<?php if($unico=="0") echo "selected"; ?> > Almacén (Se controla el inventario por volúmen)</option>
					  <option value="1"<?php if($unico=="1") echo "selected"; ?> > Unico (se controla inventario por pieza única)</option>
					  <option value="2"<?php if($unico=="2") echo "selected"; ?> > Registro (solo registra ventas, no es necesario registrar entrada)</option>
					  <option value="3"<?php if($unico=="3") echo "selected"; ?> > Pago de linea</option>
					  <option value="4"<?php if($unico=="4") echo "selected"; ?> > Reparación</option>
					</select>
				  </div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2">Código de Producto:</label>
					<div class="col-sm-10">

						<input type="text" class="form-control" name="codigo" id="codigo" value="<?php echo $codigo ;?>" placeholder="Código de Producto">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2">Nombre de Producto:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre de Producto" required>
					</div>
				</div>

				<div class="form-group row">
				 <label class="control-label col-sm-2" for="">Descripción:</label>
				  <div class="col-sm-10">
					<input type="text" class="form-control" name="descripcion" id="descripcion" value="<?php echo $descripcion ;?>" placeholder="<?php echo $descripcion ;?>">
				  </div>
				</div>

				<hr>

				<div class='row'>
					<div class="form-group col-sm-6">
						<label class="control-label" for="">Marca:</label>
						<select class="form-control" id="idmarca" name="idmarca">
						  <option value="" disabled selected>Selecciona una marca</option>
							<?php
							for($i=0;$i<count($marca);$i++){
								echo '<option value="'.$marca[$i]['idmarca'].'"';
								if($marca[$i]['idmarca']==$idmarca){
									echo " selected";
								}
								echo '>'.$marca[$i]["marca"].'</option>';
							}
							?>
						</select>
					</div>

					<div class="form-group col-sm-6">
						<label class="control-label" for="">Modelo:</label>
						<select class="form-control" id="idmodelo" name="idmodelo">
						  <option value="" disabled selected>Selecciona modelo</option>
							<?php
							for($i=0;$i<count($modelo);$i++){
								echo '<option value="'.$modelo[$i]['idmodelo'].'"';
								if($modelo[$i]['idmodelo']==$idmodelo){
									echo " selected";
								}
								echo '>'.$modelo[$i]["modelo"].'</option>';
							}
							?>
						</select>
					</div>
				</div>


				<div class='row'>
					<div class="form-group col-sm-6">
					 <label class="control-label">Unidad de Medida:</label>
						<select class="form-control" name="unidad" id="unidad">
							<?php
								echo "<option value='pieza'"; if($unidad=="Pieza"){ echo "selected";} echo ">Pieza</option>";
							?>
						</select>
					</div>


					<div class="form-group col-sm-3">
						<label class="control-label " for="">Stock Minimo:</label>
						<input type="number" class="form-control" name="stockmin" id="stockmin" value="<?php echo $stockmin ;?>" placeholder="Stock Minimo" required>
					</div>

					<div class="form-group col-sm-3">
						<label class="control-label" for="">Stock Maximo:</label>
						<input type="number" class="form-control" name="stockmax" id="stockmax" value="<?php echo $stockmax ;?>" placeholder="Stock Maximo" required>
					</div>
				</div>

				<div class='row'>
					<div class="form-group col-sm-3">
						<label class="control-label" for="">Precio de Compra:</label>
						<input type="number" class="form-control" name="preciocompra" id="preciocompra" value="<?php echo $preciocompra ;?>" placeholder="Precio de Compra">
					</div>

					<div class="form-group col-sm-3">
						<label class="control-label" for="">Precio venta general:</label>
						<input type="number" class="form-control" name="pvgeneral" id="pvgeneral" value="<?php echo $pvgeneral ;?>" placeholder="Precio venta general">
					</div>

					<div class="form-group col-sm-3">
						<label class="control-label" for="">Precio venta distribuidor:</label>
						<input type="number" class="form-control" name="pvdistr" id="pvdistr" value="<?php echo $pvdistr ;?>" placeholder="$ <?php echo $pvdistr ;?>">
					</div>

					<div class="form-group col-sm-3">
						<label class="control-label" for="">Precio venta promoción:</label>
						<input type="number" class="form-control" name="pvpromo" id="pvpromo" value="<?php echo $pvpromo ;?>" placeholder="$ <?php echo $pvpromo ;?>">
					</div>
				</div>

				<div class='row'>
					<div class="form-group col-sm-3">
						<label class="control-label" for="">Activo:</label>
						<select class="form-control" name="activo" id="activo">
						  <option value="1"<?php if($activo=="1") echo "selected"; ?> >Si</option>
						  <option value="0"<?php if($activo=="0") echo "selected"; ?> >No</option>
						</select>
					</div>

					<div class="form-group col-sm-3">
						<label class="control-label" for="">Seguimiento:</label>
						<select class="form-control" name="seguimiento" id="seguimiento">
						  <option value="1"<?php if($seguimiento=="1") echo "selected"; ?> >Si</option>
						  <option value="0"<?php if($seguimiento=="0") echo "selected"; ?> >No</option>
						</select>
					</div>

				</div>

				<div class="form-group row">
					<div class="col-sm-12 btn-group">
						<button class="btn btn-info btn-fill pull-left" id='guardar_inventario'><i class="far fa-save"></i> Guardar</button>

					</div>
				</div>
			</form>
		</div>
	</div>
</form>
