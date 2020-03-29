<?php
	require_once("db_tienda.php");
	$bdd = new Tienda();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}

	if($id>0){
		$pd = $bdd->tienda($id);
		$id=$pd['id'];
		$nombre=$pd['nombre'];
		$ubicacion=$pd['ubicacion'];
		$activo=$pd['activo'];

	}
	else{
		$id=0;
		$nombre="";
		$ubicacion=0;
		$activo=1;
	}
?>

<div class="container">
	<div class='card'>
		<div class='card-body'>
			<form action="" id="form_personal" data-lugar="a_tienda/db_tienda" data-funcion="guardar_tienda">
				<div class="header">
				<h4 class="title">Editar Sucursal</h4>
				<hr>
				</div>

				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Numero:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control form-control-sm" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero" readonly>
				   </div>
				 </div>

				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Nombre:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre" required>
				   </div>
				 </div>

				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Ubicación:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control form-control-sm" name="ubicacion" id="ubicacion" value="<?php echo $ubicacion ;?>" placeholder="Ubicación" required>
				   </div>
				 </div>

				 <div class="form-group row">
					<label class="control-label col-sm-2" for="">Activo:</label>
					<div class="col-sm-10">
						<select class='form-control form-control-sm' name='activo' id='activo' >
						<?php
							echo "<option value='1'"; if ($activo==1){ echo " selected"; } echo ">Activo</option>";
							echo "<option value='0'"; if ($activo==0){ echo " selected"; }echo ">Inactivo</option>";
						?>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-12">
						<div class="btn-group">
						<button class="btn btn-outline-secondary btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
						<button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_tienda/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
