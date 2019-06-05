<?php 
	require_once("control_db.php");
	$bdd = new Venta();
	$id=$_REQUEST['id'];

	$pd = $bdd->inventario_detalle($id);
	
	
	echo "<table class='table'>";
	echo "<tr>
	<th></th>
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
		echo "<td><button class='btn btn-info btn-fill pull-left btn-sm' id='edit_bodega'><i class='fa fa-edit'></i> Editar</button>";
		
		echo "<td>".$pd[$i]['clave']."</td>";
		echo "<td>".$pd[$i]['descripcion']."</td>";
		echo "<td>".$pd[$i]['color']."</td>";
		echo "<td>".$pd[$i]['tipo']."</td>";
		echo "<td>".$pd[$i]['total']."</td>";
		echo "<td>".number_format($pd[$i]['precio'],2)."</td>";
		echo "<td>".number_format($pd[$i]['pventa'],2)."</td>";
		echo "<td>".$pd[$i]['date']."</td>";
		echo "</tr>";
	}
?>