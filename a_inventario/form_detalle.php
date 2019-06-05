<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];
	$valor=$_REQUEST['valor'];
	$pd = $db->inventario($id);
	$nombre=$pd['nombre'];


	$marca=$pd['marca'];


	$modelo=$pd['modelo'];
?>
<div class='container'>
	<div class='card'>
		<div class='card-header'>Inventario</div>
		<div class='card-body'>
			<div class='row'>
				<div class='col-2'>
					<label>Numero:</label>
					<input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de compra" readonly>
				</div>
				<div class='col-4'>
					<label >Nombre:</label>
					<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre" readonly>
				</div>
				<div class='col-4'>
					<label >Marca:</label>
					<input type="text" class="form-control" name="marca" id="marca" value="<?php echo $marca; ?>" placeholder="Marca" readonly>
				</div>
				<div class='col-4'>
					<label >Modelo:</label>
					<input type="text" class="form-control" name="modelo" id="modelo" value="<?php echo $modelo; ?>" placeholder="Modelo" readonly>
				</div>

			</div>
		</div>
		<div class='card-body' id='pedido'>
			<?php
				$pd = $db->inventario_detalle($id);

				echo "<table class='table'>";
				echo "<tr>

				<th>Clave</th>
				<th>Nombre</th>
				<th>Color</th>
				<th>Tipo</th>
				<th>Total</th>
				<th>Precio Compra</th>
				<th>Precio Venta</th>
				<th>Entrada</th>
				<th><center>Entregados</center></th>
				<th>--</th></tr>";
				$gtotal=0;
				$idpaquete=0;
				$contar=1;

				for($i=0;$i<count($pd);$i++){
					echo "<tr id='".$pd[$i]['id']."' class='edit-t' >";
					//echo "<td><button class='btn btn-info btn-fill pull-left btn-sm' id='edit_bodega'><i class='fa fa-edit'></i> Editar</button>";

					echo "<td>".$pd[$i]['clave']."</td>";
					echo "<td>".$pd[$i]['descripcion']."</td>";
					echo "<td>".$pd[$i]['color']."</td>";
					echo "<td>".$pd[$i]['tipo']."</td>";
					echo "<td>".$pd[$i]['total']."</td>";
					echo "<td>".number_format($pd[$i]['precio'],2)."</td>";
					echo "<td>".number_format($pd[$i]['pventa'],2)."</td>";
					echo "<td>".$pd[$i]['fecha']."</td>";
					echo "</tr>";
				}
			?>
		</div>

	</div>
</div>
