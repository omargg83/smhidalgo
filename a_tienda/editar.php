<?php 
	require_once("db_tienda.php");
	$bdd = new Tienda();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	
	if($id>0){	
		$pd = $bdd->tienda($id);
		$id=$pd['id'];
		$nombre=$pd['nombre'];
		$ubicacion=$pd['ubicacion'];
		
	}
	else{
		$id=0;
		$nombre="";
		$ubicacion=0;
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
					 <input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero" readonly>
				   </div>
				 </div>
				 
				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Nombre:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre" required>
				   </div>
				 </div>
				 
				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Ubicación:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control" name="ubicacion" id="ubicacion" value="<?php echo $ubicacion ;?>" placeholder="Ubicación" required>
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
