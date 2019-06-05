<?php 
	require_once("control_db.php");
	$bdd = new Venta();
	$pd = $bdd->entrada_lista();
?>

<div class="content table-responsive table-full-width">
	<table class="table table-hover table-striped" id="myTable">
		<thead>
		<tr>
		<th>Numero</th>
		<th>Proveedor</th>
		<th># Compra</th>
		<th>Estado</th>
		<th>Total</th>
		<th><input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" onkeyup="myFunction()" id="myInput">
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
