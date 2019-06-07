<?php
	require_once("db_.php");
	$idtienda=$_REQUEST['id'];
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";

	$pd = $db->inventario_lista($idtienda);
?>
	<table class="table table-hover table-striped" id="x_lista">
	<thead>
	<th></th>
	<th>Tipo</th>
	<th>Código</th>
	<th>Nombre</th>
	<th>Marca</th>
	<th>Modelo</th>

	<th>Existencia</th>
	<th>$ Compra</th>
	<th>$ Venta</th>
	<th>$ Promo</th>
	<th>$ Distribuidor</th>

	</thead>
	<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
		?>
			<tr id="<?php echo $pd[$i]['id_invent']; ?>" class="edit-t">
				<td class="edit">
					<div class="btn-group">
					<button class="btn btn-outline-secondary btn-sm" id='edit_inventario' data-lugar='a_inventario/form_detalle' data-valor='idtienda'><i class="fas fa-arrow-circle-right"></i></button>
				</div></td>
				<td><?php
					if ($pd[$i]["unico"]==0){ echo "Almacén";}
					if ($pd[$i]["unico"]==1){ echo "Unico";}
					if ($pd[$i]["unico"]==2){ echo "Registro";}
					if ($pd[$i]["unico"]==3){ echo "Pago de linea";}
					if ($pd[$i]["unico"]==4){ echo "Reparación";}
				?></td>
				<td ><?php echo $pd[$i]["codigo"]; ?></td>
				<td><?php echo $pd[$i]["nombre"]; ?></td>
				<td><?php echo $pd[$i]["marca"]; ?></td>
				<td><?php echo $pd[$i]["modelo"]; ?></td>

				<td><?php echo $pd[$i]["conteo"]; ?></td>
				<td><?php echo $pd[$i]["preciocompra"]; ?></td>
				<td><?php echo $pd[$i]["pvgeneral"]; ?></td>
				<td><?php echo $pd[$i]["pvpromo"]; ?></td>
				<td><?php echo $pd[$i]["pvdistr"]; ?></td>

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
