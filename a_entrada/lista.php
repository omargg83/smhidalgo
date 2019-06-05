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
		<th>Numero</th>
		<th>Proveedor</th>
		<th># Compra</th>
		<th>Estado</th>
		<th>Total</th>
		<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
		?>
			<tr id="<?php echo $pd[$i]['identrada']; ?>" class="edit-t">
				<td><?php echo $pd[$i]["identrada"]; ?></td>
				<td><?php echo $pd[$i]["razon_social_prove"]; ?></td>
				<td><?php echo $pd[$i]["numero"]; ?></td>
				<td><?php echo $pd[$i]["estado"]; ?></td>
				<td align="right"><?php echo number_format($pd[$i]["total"],2); ?></td>
				<td>
					<div class="btn-group">
						<button class="btn btn-info btn-fill pull-left btn-sm" id="edit_entrada"><i class="fa fa-edit"></i>Editar</button>
						<button class="btn btn-info btn-fill pull-left btn-sm" id="deta_entrada"><i class="fas fa-box-open"></i>Articulos</button>
					</div>
				</td>
			</tr>
		<?php
			}
		?>

		</tbody>
	</table>
</div>
<script>
	$(document).ready( function () {
		lista("x_lista");
	});
</script>
