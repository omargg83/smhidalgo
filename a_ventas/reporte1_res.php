<?php
  require_once("db_.php");
  $pd=$db->emitidas();
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br><h5>Ventas abiertas</h5>";
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
  		</tr>
  		</thead>
  		<tbody>
  		<?php
  			for($i=0;$i<count($pd);$i++){
  		?>
  					<tr id="<?php echo $pd[$i]['idventa']; ?>" class="edit-t">
  						<td>
  							<div class="btn-group">
  								<button class='btn btn-outline-primary btn-sm'  id='edit_persona' title='Editar' data-lugar='a_ventas/editar'><i class="fas fa-pencil-alt"></i></button>
  							</div>
  						</td>
  						<td  ><?php echo $pd[$i]["idventa"]; ?></td>
  						<td><?php echo $pd[$i]["fecha"]; ?></td>
  						<td><?php echo $pd[$i]["razon_social_prove"]; ?></td>
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
  		lista("x_venta");
  	});
  </script>
