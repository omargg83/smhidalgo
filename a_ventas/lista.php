<?php
	require_once("db_.php");
	$pd = $db->ventas_lista($_SESSION['idtienda']);

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

<div class="content table-responsive table-full-width">
	<table class="table table-hover table-striped" id="x_lista">
		<thead>
		<tr>
		<th>-</th>
		<th>Numero</th>
		<th>Fecha</th>
		<th>Cliente</th>
		<th>Factura</th>
		<th>Forma de pago</th>
		<th>Tienda</th>
		<th>Total</th>
		<th>Gran total</th>
		<th>Estado</th>
		</tr>
		</thead>
		<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
		?>
					<tr id="<?php echo $pd[$i]['idventa']; ?>" class="edit-t">
						<td>
							<div class="btn-group">
								<button class='btn btn-outline-secondary btn-sm'  id='edit_persona' title='Editar' data-lugar='a_ventas/editar'><i class="fas fa-pencil-alt"></i></button>
							</div>
						</td>
						<td  ><?php echo $pd[$i]["idventa"]; ?></td>
						<td><?php echo $pd[$i]["fecha"]; ?></td>
						<td><?php echo $pd[$i]["razon_social_prove"]; ?></td>
						<td><?php echo $pd[$i]["factura"]; ?></td>
						<td><?php echo $pd[$i]["descuento"]; ?></td>
						<td><?php echo $pd[$i]["nombre"]; ?></td>
						<td align="right"><?php echo number_format($pd[$i]["total"],2); ?></td>
						<td align="right"><?php echo number_format($pd[$i]["gtotal"],2); ?></td>
						<td><?php echo $pd[$i]["estado"]; ?></td>

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
