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
  $unico=$pd['unico'];
?>

	<div class='card'>
		<div class='card-header'>Inventario <?php echo $id; ?></div>
		<div class='card-body'>
			<div class='row'>
				<div class='col-2'>
					<label>Numero:</label>
					<input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de compra" readonly>
				</div>
				<div class='col-2'>
					<label >Código:</label>
					<input type="text" class="form-control" name="codigo" id="codigo" value="<?php echo $codigo; ?>" placeholder="Código" readonly>
				</div>

				<div class='col-2'>
					<label >Nombre:</label>
					<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre" readonly>
				</div>
				<div class='col-2'>
					<label >$ Compra:</label>
					<input type="text" class="form-control" name="rapido" id="rapido" value="<?php echo $precio; ?>" placeholder="Rápido" readonly>
				</div>

				<div class='col-2'>
					<label >$ venta:</label>
					<input type="text" class="form-control" name="rapido" id="rapido" value="<?php echo $pventa; ?>" placeholder="Rápido" readonly>
				</div>

			</div>
		</div>
		<div class='card-footer'>
			<?php
				echo "<div class='btn-group'>";
				if ($unico==0 or $unico==1){
					echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo'  data-id='0' data-id2='$id' data-lugar='a_inventario/editar_producto' title='Editar'><i class='fas fa-plus'></i> Nuevo</button>";
				}
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
			<th>Clave/IMEI</th>
			<th>Nombre</th>
			<th>Color</th>
			<th># No. de Venta</th>
			<th>Entrada</th>
			<th>Salida</th>
			<th>Precio Compra</th>
			<th>Precio Venta</th>
			</tr>";
			echo "</thead>";

			foreach($pd as $key){
				echo "<tr id='".$key['id']."' class='edit-t' >";

				echo "<td>";
				if($key['cantidad']>0){
					echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo'  data-id='".$key['id']."' data-id2='$id' data-lugar='a_inventario/editar_producto' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
				}

				echo "</td>";
				echo "<td>".$key['clave']."</td>";
				echo "<td>".$key['descripcion']."</td>";
				echo "<td>".$key['color']."</td>";
				$fventa="";
				if($key['idventa']>0){
					$sql="select * from et_venta where idventa='".$key['idventa']."'";
					$venta=$db->general($sql);
					$fventa=fecha($venta[0]['fecha']);
				}
				echo "<td>#".$key['idventa']." - $fventa</td>";

				echo "<td><center>";
				if($key['cantidad']>0)
				echo $key['cantidad'];
				$gtotal+=$key['cantidad'];
				echo "</center></td>";
				echo "<td>".$key['total']."</td>";
				echo "<td align='right'>".moneda($key['precio'])."</td>";
				echo "<td align='right'>".moneda($key['pventa'])."</td>";
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
