<?php 
	require_once("control_db.php");
	$bdd = new Venta();
	$id=$_REQUEST['id'];
	
	$pd = $bdd->acceso_lista($id);
?>
	<table class="table table-hover table-striped" id="myTable">
	<thead>
	<th>Fecha</th>
	<th>Registro</th>
	</thead>
	<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
		?>
			<tr id="<?php echo $pd[$i]['id_invent']; ?>" class="edit-t">
				<td ><?php echo $pd[$i]["fecha"]; ?></td>
				<td ><?php echo $pd[$i]["descripcion"]; ?></td>
				
			</tr>
		<?php
			}
		?>
	</tbody>
	</table>