<?php 
	require_once("control_db.php");
	$bdd = new Venta();
		
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	$i=0;
	
	$pd = $bdd->bodega($id);
	
	
	$id=$pd['id'];
	$descripcion=$pd['descripcion'];
	$clave=$pd['clave'];
	$color=$pd['color'];
	$material=$pd['tipo'];
	$pventa=$pd['pventa'];
		

?>
<div class="container">
	<div class='card'>
		<div class='card-body'>
			<form>
				<div class="header">
					<h4 class="title">Editar Productos</h4>
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					<hr>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2">Clave/IMEI:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="clave" id="clave" value="<?php echo $clave ;?>" placeholder="Clave/IMEI">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2">Descripción:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="descripcion" id="descripcion" value="<?php echo $descripcion ;?>" placeholder="Descripción">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2">Color:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="color" id="color" value="<?php echo $color ;?>" placeholder="Descripción">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2">Tipo:</label>
					<div class="col-sm-10">
				<?php
					echo "<select class='form-control' name='material' id='material'>";
						echo "<option value=''"; if ($material=='') { echo "selected";} echo "></option>";
						echo "<option value='PREPAGO' "; if ($material=='PREPAGO') { echo "selected";} echo ">PREPAGO</option>";
						echo "<option value='TARIFARIO' "; if ($material=='TARIFARIO') { echo "selected";} echo ">TARIFARIO</option>";
						echo "<option value='AMIGO CHIP' "; if ($material=='AMIGO CHIP') { echo "selected";} echo ">AMIGO CHIP</option>";
						echo "<option value='LIBRES' "; if ($material=='LIBRES') { echo "selected";} echo ">LIBRES</option>";
						echo "<option value='CONSIGNA' "; if ($material=='CONSIGNA') { echo "selected";} echo ">CONSIGNA</option>";
					echo "</select>";
				?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2">Precio Venta:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="pventa" id="pventa" value="<?php echo $pventa ;?>" placeholder="Descripción">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12 btn-group">
						<button class="btn btn-info btn-fill pull-left" id='guardar_bodega'><i class="far fa-save"></i> Guardar</button>
						
					</div>
				</div>
			</form>
		</div>
	</div>
</form>