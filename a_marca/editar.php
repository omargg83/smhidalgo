<?php 
	require_once("db_marca.php");
	$bdd = new Marca();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	
	$i=0;
	if($id>0){
		$pd = $bdd->marca($id);
		$id=$pd['idmarca'];
		$marca=$pd['marca'];
			
	}
	else{
		$id=0;
		$marca="";
	}
?>

<div class="container">
	<div class='card'>
		<div class='card-body'>
			<form action="" id="form_marca" data-lugar="a_marca/db_marca" data-funcion="guardar_marca">
				<div class="header">
					<h4 class="title">Editar Marca</h4>
					<hr>
				</div>
				<div class="header" style="text-align: center;">
					<h4 class="title"><b>Marca</b></h4>
					<br>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2" for="">Marca:</label>
					<div class="col-sm-10">
						<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
						<input type="text" class="form-control" name="marca" id="marca" value="<?php echo $marca;?>" placeholder="Marca">
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="btn-group">
						<button class="btn btn-outline-secondary btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
						<button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_marca/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</form>	
		</div>
	</div>
</div>