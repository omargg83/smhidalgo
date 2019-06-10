<?php
	require_once("db_.php");
	$id2=$_REQUEST['id2'];
	echo "<input type='hidden' name='idpedido' id='idpedido' placeholder='buscar producto' value='$id2' class='form-control'>";
?>

<div class="card">
	<div class="card-header">Buscar producto
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>

	</div>
	<div class="card-body">
		<div clas='row'>
				<div class="input-group mb-3">
			  <input type="text" class="form-control" name="prod_entra" id='prod_entra' placeholder='buscar producto' aria-label="buscar producto" aria-describedby="basic-addon2">
			  <div class="input-group-append">
			    <button class="btn btn-outline-secondary btn-sm" type="button" id='buscar_prodentra'><i class='fas fa-search'></i>Buscar</button>
			  </div>
			</div>
		</div>

		<div clas='row' id='resultadosx'>

		</div>
	</div>
</div>
