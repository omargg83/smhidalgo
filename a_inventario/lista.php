<?php
	require_once("db_.php");
	$idtienda="";

	if (isset($_REQUEST['id']) and strlen($_REQUEST['id'])>0 and $_REQUEST['id']>0){
		$idtienda=$_REQUEST['id'];
	}
	else{
		$idtienda=$_SESSION['idtienda'];
	}
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	$pd = $db->inventario_lista($idtienda);

	$tienda=$db->tiendas_global($idtienda);
	echo "<br><h5>Sucursal:".$tienda['nombre']."</h5><hr>";
?>
	<table class="table table-hover table-striped" id="x_lista">
	<thead>
	<th></th>
	<th></th>
	<th>Tipo</th>
	<th>Código</th>
	<th>Rápido</th>
	<th>Nombre</th>
	<th>Marca</th>
	<th>Modelo</th>

	<th>Existencia</th>
	<th>$ Compra</th>
	<th>$ Venta</th>

	</thead>
	<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
		?>
			<tr id="<?php echo $pd[$i]['id_invent']; ?>" class="edit-t">
				<td><?php  echo $i+1; ?></td>
				<td class="edit">
					<div class="btn-group">
					<?php
						echo "<button class='btn btn-outline-secondary btn-sm' id='imprimir_comision' title='Imprimir código de barras' data-lugar='a_inventario/imprimir' data-tipo='1'><i class='fas fa-barcode'></i></button>";
						echo "<button class='btn btn-outline-secondary btn-sm' id='edit_persona' data-lugar='a_productos/editar' title='editar categoria'><i class='fas fa-pencil-alt'></i></button>";
						if ($pd[$i]["unico"]==0 or $pd[$i]["unico"]==1){
							echo "<button class='btn btn-outline-secondary btn-sm' id='edit_inventario' data-lugar='a_inventario/form_detalle' data-valor='idtienda' title='Ver productos'><i class='far fa-hand-pointer'></i></button>";
						}
					?>
				</div></td>

				<td><?php
					if ($pd[$i]["unico"]==0){ echo "Almacén";}
					if ($pd[$i]["unico"]==1){ echo "Unico";}
					if ($pd[$i]["unico"]==2){ echo "Registro";}
					if ($pd[$i]["unico"]==3){ echo "Pago de linea";}
					if ($pd[$i]["unico"]==4){ echo "Reparación";}
				?></td>

				<td ><?php echo $pd[$i]["codigo"]; ?></td>
				<td ><?php echo $pd[$i]["rapido"]; ?></td>
				<td><?php echo $pd[$i]["nombre"]; ?></td>
				<td><?php echo $pd[$i]["marca"]; ?></td>
				<td><?php echo $pd[$i]["modelo"]; ?></td>

				<td><?php echo $pd[$i]["conteo"]; ?></td>
				<td><?php echo $pd[$i]["preciocompra"]; ?></td>
				<td><?php echo $pd[$i]["pvgeneral"]; ?></td>

			</tr>
		<?php
			}
		?>
	</tbody>
	</table>
	<b>Se contróla el inventario de productos, asi como su registro y precio</b><br>

	</div>

<script>
	$(document).ready( function () {
		lista("x_lista");
	});
</script>
