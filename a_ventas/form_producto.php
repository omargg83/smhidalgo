<?php
	require_once("db_.php");
	$id2=$_REQUEST['id2'];
	echo "<input type='hidden' name='idpedido' id='idpedido' placeholder='buscar producto' value='$id2' class='form-control'>";
?>
<div class="card">
	<div class="card-header">Buscar producto</div>
	<div class="card-body" >
		<div clas='row'>
				<div class="input-group mb-3">
			  <input type="text" class="form-control" name="prod_venta" id='prod_venta' placeholder='buscar producto' aria-label="buscar producto" aria-describedby="basic-addon2">
			  <div class="input-group-append">
			    <button class="btn btn-outline-secondary btn-sm" type="button" id='buscar_prodventa'><i class='fas fa-search'></i>Buscar</button>
			  </div>
			</div>
		</div>

		<div clas='row' id='resultadosx'>

		</div>
	</div>

	<div class="card-footer">
		<div class='btn-group'>
			<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cerrar</button>
		</div>
	</div>
</div>
