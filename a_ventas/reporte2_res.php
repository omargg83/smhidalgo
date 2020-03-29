<?php
  require_once("db_.php");
  $pd=$db->productos_vendidos();

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br><h5>Ventas</h5>";
	echo "<hr>";
?>

  <div class="content table-responsive table-full-width">
  		<table id='x_venta' class='dataTable compact hover row-border' style='font-size:10pt;'>
  		<thead>
  		<tr>
  		<th>-</th>
  		<th>Venta</th>
  		<th>Fecha</th>
  		<th>Cliente</th>
  		<th>Tienda</th>
  		<th>Total</th>
  		<th>Gran total</th>
  		<th>Estado</th>
  		<th>Nombre</th>
  		<th>Observaciones</th>
  		<th>Observaciones 2</th>
  		</tr>
  		</thead>
  		<tbody>
  		<?php
  			foreach($pd as $key){
  		?>
  					<tr id="<?php echo $key->idventa; ?>" class="edit-t">
  						<td>
  							<div class="btn-group">
  								<button class='btn btn-outline-primary btn-sm'  id='edit_persona' title='Editar' data-lugar='a_ventas/editar'><i class="fas fa-pencil-alt"></i></button>
  							</div>
  						</td>
  						<td><?php echo $key->idventa; ?></td>
  						<td><?php echo $key->fecha; ?></td>
  						<td><?php echo $key->razon_social_prove; ?></td>
  						<td><?php echo $key->nombre; ?></td>
  						<td align="right"><?php echo number_format($key->total,2); ?></td>
  						<td align="right"><?php echo number_format($key->gtotal,2); ?></td>
  						<td><?php echo $key->estado; ?></td>
  						<td><?php echo $key->nombre; ?></td>
  						<td><?php echo $key->observaciones; ?></td>
  						<td><?php echo $key->cliente; ?></td>

  					</tr>
  		<?php
  			}
  		?>
  		</tbody>
  	</table>
  </div>


  <script>
  	$(document).ready( function () {
  		lista("x_venta");
  	});
  </script>
