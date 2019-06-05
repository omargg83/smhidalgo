<?php 
	require_once("control_db.php");
	$bdd = new Venta();
	
	$desde=$_REQUEST['desde'];
	$hasta=$_REQUEST['hasta'];
	
	$pd = $bdd->lineas_lista($desde,$hasta);
?>
	<table class="table table-hover table-striped" id="myTable">
	<thead>
	<th>Tipo</th>
	<th>Observaciones</th>
	<th>Fecha</th>
	<th>Sucursal</th>
	<th>Pago</th>
	<th>Estado</th>
	<th>Comentarios</th>
	
	<th><input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" onkeyup="myFunction()" id="myInput">
	</thead>
	<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
			$tienda = $bdd->tienda($pd[$i]["idtienda"]);
		?>
			<tr id="<?php echo $pd[$i]['id']; ?>" class="edit-t">
				<td><?php 
					if ($pd[$i]["unico"]==0){ echo "Almacén";}
					if ($pd[$i]["unico"]==1){ echo "Unico";}
					if ($pd[$i]["unico"]==2){ echo "Registro";}
					if ($pd[$i]["unico"]==3){ echo "Pago de linea";}
					if ($pd[$i]["unico"]==4){ echo "Reparación";}
				?></td>
				<td><?php echo $pd[$i]["observaciones"]; ?></td>
				<td><?php echo $pd[$i]["fecha"]; ?></td>
				<td><?php echo $tienda["nombre"]; ?></td>
				<td><?php echo number_format($pd[$i]["gtotalv"],2); ?></td>
				<td>
				<?php 
				
					if ($pd[$i]["lineapagada"]=='') { echo "Pendiente"; }
					if ($pd[$i]["lineapagada"]=='Pagada') { echo "Pagada"; }
				
				
				?></td>
				<td><?php echo $pd[$i]["observaciones2"]; ?></td>
				<td class="edit">
					<div class="btn-group">
					<button class="btn btn-info btn-fill pull-left btn-sm" id="edit_pagolinea"><i class="fa fa-edit"></i> Editar</button>
				</div></td>
			</tr>
		<?php
			}
		?>
	</tbody>
	</table>