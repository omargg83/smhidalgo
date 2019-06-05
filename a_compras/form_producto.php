<?php
	require_once("db_.php");
	$bdd = new Compra();
	$id2=$_REQUEST['id2'];
	echo "<input type='hidden' name='idpedido' id='idpedido' placeholder='buscar producto' value='$id2' class='form-control'>";
?>

<div class="card">
	<div class="card-header">Buscar producto</div>
	<div class="card-body">
		<div clas='row'>
			<input type="text" name="prod_bus" id='prod_bus' placeholder='buscar producto' class='form-control'>
		</div>
	</div>
	<div class="card-footer">
		<div class='btn-group'>
			<button class='btn btn-outline-secondary btn-sm' type='button' id='buscar_producto'><i class='fas fa-search'></i>Buscar</button>
			<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cerrar</button>
		</div>
	</div>
	<div class='container' id='resultadosx'>
	</div>
</div>
