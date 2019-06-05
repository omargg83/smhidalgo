<?php 
	require_once("../form/control_db.php");
	$bdd = new Venta();
	$pd = $bdd->ventas_lista($_SESSION['idtienda']);
?>

<div class="content table-responsive table-full-width">
	<table class="table table-hover table-striped" id="myTable">
		<thead>
		<tr>
		<th>Numero</th>
		<th>Fecha</th>
		<th>Cliente</th>
		<th>Factura</th>
		<th>Forma de pago</th>
		<th>Tienda</th>
		<th>Total</th>
		<th>Gran total</th>
		<th>Estado</th>
		<th><input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" onkeyup="myFunction()" id="myInput">
		</tr>
		</thead>
		<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
		?>
					<tr id="<?php echo $pd[$i]['idventa']; ?>" class="edit-t">
						<td  ><?php echo $pd[$i]["idventa"]; ?></td>
						<td><?php echo $pd[$i]["fecha"]; ?></td>
						<td><?php echo $pd[$i]["razon_social_prove"]; ?></td>
						<td><?php echo $pd[$i]["factura"]; ?></td>
						<td><?php echo $pd[$i]["descuento"]; ?></td>
						<td><?php echo $pd[$i]["nombre"]; ?></td>
						<td align="right"><?php echo number_format($pd[$i]["total"],2); ?></td>
						<td align="right"><?php echo number_format($pd[$i]["gtotal"],2); ?></td>
						<td><?php echo $pd[$i]["estado"]; ?></td>
						<td>
							<div class="btn-group">
								<button class="btn btn-info btn-fill pull-left btn-sm" id="edit_ventas"><i class="fa fa-edit"></i>Editar</button>
								<button class="btn btn-info btn-fill pull-left btn-sm" id="deta_ventas"><i class="fas fa-box-open"></i>Articulos</button>
							</div>
						</td>
					</tr>
		<?php
			}
		?>
		</tbody>
	</table>
</div>
