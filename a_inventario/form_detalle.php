<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];
	$pd = $db->inventario($id);
	$nombre=$pd['nombre'];
	$marca=$pd['marca'];
	$modelo=$pd['modelo'];
	$codigo=$pd['codigo'];
	$rapido=$pd['rapido'];
	$pventa=$pd['pvgeneral'];
	$precio=$pd['preciocompra'];
  $unidad=$pd['unidad'];
?>

	<div class='card'>
		<div class='card-header'>Inventario <?php echo $id; ?></div>
		<div class='card-body'>
			<div class='row'>
				<div class='col-2'>
					<label>Numero:</label>
					<input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de compra" readonly>
				</div>
				<div class='col-3'>
					<label >Nombre:</label>
					<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre" readonly>
				</div>
				<div class='col-3'>
					<label >Marca:</label>
					<input type="text" class="form-control" name="marca" id="marca" value="<?php echo $marca; ?>" placeholder="Marca" readonly>
				</div>
				<div class='col-3'>
					<label >Modelo:</label>
					<input type="text" class="form-control" name="modelo" id="modelo" value="<?php echo $modelo; ?>" placeholder="Modelo" readonly>
				</div>

				<div class='col-3'>
					<label >Código:</label>
					<input type="text" class="form-control" name="codigo" id="codigo" value="<?php echo $codigo; ?>" placeholder="Código" readonly>
				</div>

				<div class='col-3'>
					<label >$ Compra:</label>
					<input type="text" class="form-control" name="rapido" id="rapido" value="<?php echo $precio; ?>" placeholder="Rápido" readonly>
				</div>

				<div class='col-3'>
					<label >$ venta:</label>
					<input type="text" class="form-control" name="rapido" id="rapido" value="<?php echo $pventa; ?>" placeholder="Rápido" readonly>
				</div>

			</div>
		</div>
		<div class='card-footer'>
			<?php
				echo "<div class='btn-group'>";
				echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo'  data-id='0' data-id2='$id' data-lugar='a_inventario/editar_producto' title='Editar'><i class='fas fa-plus'></i> Nuevo</button>";
				echo "<button class='btn btn-outline-secondary btn-sm' id='imprime_comision' title='Imprimir' data-lugar='a_inventario/imprimir' data-tipo='1' type='button'><i class='fas fa-barcode'></i>C. Barras</button>";
				echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='lista_principal'  data-lugar='a_inventario/lista' title='Editar'><i class='fas fa-undo-alt'></i> Regresar</button>";
				echo "</div>";
			?>
		</div>
	</div>
	<br>
	<div class='card'>
		<div class='card-body' id='pedido'>
		<?php
			$pd = $db->inventario_detalle($id);
			$gtotal=0;
			echo "<table class='table table-sm' id='x_lista'>";
			echo "<thead>";
			echo "<tr>
			<th>-</th>
			<th>Clave</th>
			<th>Nombre</th>
			<th>Color</th>
			<th># Entrada</th>
			<th># Venta</th>
			<th>Entrada</th>
			<th>Salida</th>
			<th>Precio Compra</th>
			<th>Precio Venta</th>
			</tr>";
			echo "</thead>";

			for($i=0;$i<count($pd);$i++){
				echo "<tr id='".$pd[$i]['id']."' class='edit-t' >";

				echo "<td>";
				if($pd[$i]['cantidad']>0){
					echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo'  data-id='".$pd[$i]['id']."' data-id2='$id' data-lugar='a_inventario/editar_producto' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
				}

				echo "</td>";
				echo "<td>".$pd[$i]['clave']."</td>";
				echo "<td>".$pd[$i]['descripcion']."</td>";
				echo "<td>".$pd[$i]['color']."</td>";
				echo "<td>".$pd[$i]['identrada']."</td>";
				echo "<td>".$pd[$i]['idventa']."</td>";
				echo "<td><center>";
				if($pd[$i]['cantidad']>0)
				echo $pd[$i]['cantidad'];

				$gtotal+=$pd[$i]['cantidad'];
				echo "</center></td>";
				echo "<td>".$pd[$i]['total']."</td>";
				echo "<td align='right'>".moneda($pd[$i]['precio'])."</td>";
				echo "<td align='right'>".moneda($pd[$i]['pventa'])."</td>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td>Total:</td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";

			echo "<td><b><center>";
			echo $gtotal;
			echo "</center></b></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "</tr>";
			echo "</table>";
		?>
		</div>
	</div>


	<script>
		$(document).ready( function () {
			lista("x_lista");
		});
	</script>
