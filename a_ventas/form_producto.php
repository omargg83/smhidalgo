<?php
	require_once("db_.php");
	$id2=$_REQUEST['id2'];
?>
<div class="modal-header">
  <h5 class="modal-title">Buscar producto</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body" style='max-height:580px;overflow: auto;'>
	<div clas='row'>
			<div class="input-group mb-3">
			<input type="text" class="form-control" name="prod_venta" id='prod_venta' placeholder='buscar producto' aria-label="buscar producto" aria-describedby="basic-addon2" onkeyup='Javascript: if (event.keyCode==13) buscar_producto(<?php echo $id2;  ?>)'>
			<div class="input-group-append">
				<button class="btn btn-outline-secondary btn-sm" type="button" onclick='buscar_producto(<?php echo $id2;  ?>)'><i class='fas fa-search'></i>Buscar</button>
			</div>
		</div>
	</div>
	<div clas='row' id='resultadosx'>

	</div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cerrar</button>
</div>
