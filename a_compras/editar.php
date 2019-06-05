<?php
	require_once("db_.php");
	$bdd = new Compra();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}

	$i=0;
	$proveedores = $bdd->proveedores_lista();

	if($id==0){
		$id_prove=0;
		$condiciones="";
		$comentarios="";
		$estado="Activo";
	}
	else{
		$pd = $bdd->compra($id);
		$id_prove=$pd['id_prove'];
		$transporte=$pd['transporte'];
		$condiciones=$pd['condiciones'];
		$comentarios=$pd['comentarios'];
		$estado=$pd['estado'];
	}
?>

<div class="container">
	<form action="" id="form_cliente" data-lugar="a_compras/db_" data-funcion="guardar_compra" data-destino='a_compras/editar'>

	<div class='card'>
		<div class='card-header'>Compra #<?php echo $id; ?></div>
		<div class='card-body'>
			<div class='row'>
				<div class="col-2">
						<label for="id">Numero:</label>
					 	<input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de compra" readonly>
				</div>
				<div class="col-4">
				  <label for="id_prove">Proveedor:</label>
					<?php
						echo "<select class='form-control' name='id_prove' id='id_prove'>";
						echo '<option disabled>Seleccione el cliente</option>';
						for($i=0;$i<count($proveedores);$i++){
							echo '<option value="'.$proveedores[$i]['id_prove'].'"';
							if($proveedores[$i]['id_prove']==$id_prove){
								echo " selected";
							}
							echo '>'.$proveedores[$i]["razon_social_prove"].'</option>';
						}
						echo "</select>";
					?>
				</div>
				<div class="col-4">
					<label for="condiciones">Condiciones de pago a:</label>
						<input type="text" class="form-control" name="condiciones" id="condiciones" value="<?php echo $condiciones ;?>" placeholder="Condiciones de pago">
				</div>

				<div class="col-2">
				 <label for="estado">Estado:</label>
					<select class="form-control" name="estado" id="estado">
						<option value="Activa"<?php if($estado=="Activa") echo "selected"; ?> >Activa</option>
						<option value="Finalizada"<?php if($estado=="Finalizada") echo "selected"; ?> >Finalizada</option>
					</select>
				</div>

				<div class="col-12">
					<label for="comentarios">Comentarios:</label>
						<input type="text" class="form-control" name="comentarios" id="comentarios" value="<?php echo $comentarios ;?>" placeholder="Comentarios o instrucciones especiales">
				</div>
			</div>
		</div>
		<div class='card-footer'>
			<div class="row">
				<div class="col-sm-12">
					<div class="btn-group">
					<button class="btn btn-outline-secondary btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
					<button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_compras/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
					</div>
				</div>
			</div>
		</div>
			<?php

				if($id>0){
					echo "<div class='card-body' id='pedidos'>";
						include 'form_pedido.php';
					echo "</div>";
				}

			?>
	</div>
	</form>
</div>
