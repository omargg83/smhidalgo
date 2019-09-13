<?php
	require_once("db_.php");
	$pd = $db->entrada_lista();
  echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
  echo "<br>";
?>
<div class="content table-responsive table-full-width">
	<table class="table table-hover table-striped" id="x_lista">
		<thead>
		<tr>
		<th>-</th>
		<th>Numero</th>
		<th>Proveedor</th>
		<th># Compra</th>
		<th>Estado</th>
		<th>Total</th>
		</tr>
		</thead>
		<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
		?>
			<tr id="<?php echo $pd[$i]['identrada']; ?>" class="edit-t">
				<td>
					<div class="btn-group">
						<button class='btn btn-outline-secondary btn-sm' id='edit_persona' title='Editar' data-lugar='a_entrada/editar'><i class='fas fa-pencil-alt'></i></button>
					</div>
				</td>
				<td><?php echo $pd[$i]["identrada"]; ?></td>
				<td><?php echo $pd[$i]["razon_social_prove"]; ?></td>
				<td><?php echo $pd[$i]["numero"]; ?></td>
				<td><?php echo $pd[$i]["estado"]; ?></td>
				<td align="right"><?php echo number_format($pd[$i]["total"],2); ?></td>
			</tr>
		<?php
			}
		?>
		</tbody>
	</table>
	<b>Lista de entrada:</b><br>
	Para dar acceso a los articulos a vender,<br>
	1) Crear una nueva entrada.<br>
	2) Agregar producto (se suman directamente al stock de productos).<br>
	3) Finalizar entrada.<br>
</div>
<script>
	$(document).ready( function () {
		lista("x_lista");
	});
</script>
