<?php
	$id=$_REQUEST['id'];
	$id2=$_REQUEST['id2'];

	$cantidad="";
	$fecha=date("d-m-Y");
	$nota="";
?>
<form id='form_inventario' action='' data-lugar='a_productos/db_' data-destino='a_productos/editar' data-funcion='existencia_agrega'>
<div class='modal-header'>
	<h5 class='modal-title'>Agregar existencia</h5>
</div>
  <div class='modal-body' >
	<?php
		echo "<input type='hidden' id='id' NAME='id' value='$id'>";
		echo "<input type='hidden' id='idproducto' NAME='idproducto' value='$id2'>";
	?>
		<div class='row'>
			<div class="col-4">
			 <label>Cantidad</label>
			 <input type="text" class="form-control form-control-sm" id="cantidad" name='cantidad' placeholder="Cantidad" value="<?php echo $cantidad; ?>">
			</div>
			<div class="col-4">
			 <label>Fecha</label>
			 <input type="text" class="form-control form-control-sm fechaclass" id="fecha" name='fecha' placeholder="Fecha" value="<?php echo $fecha; ?>">
			</div>
			<div class="col-4">
			 <label>Nota de compra</label>
			 <input type="text" class="form-control form-control-sm" id="nota" name='nota' placeholder="nota" value="<?php echo $nota; ?>">
			</div>
		</div>
	</div>
	<div class='modal-footer' >


		<div class='btn-group'>
		<button type='submit' class='btn btn-outline-primary btn-sm'  id='acceso' title='Guardar'><i class='far fa-save'></i>Guardar</button>
		<button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal" title='Cancelar'><i class="fas fa-sign-out-alt"></i>Cancelar</button>
		</div>
  </div>
</form>

	<script>
		$(function() {
			fechas();
		});
	</script>
