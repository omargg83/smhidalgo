<?php
	require_once("db_.php");
	$bdd = new Compra();
	
	$id = $_REQUEST['id'];
	$compra = $bdd->compra($id);
	$pedido = $bdd->compras_pedido($id);
	
	echo "<table class='table'>";
	echo "<tr>
	<th>Codigo</th>
	<th>Nombre</th>
	<th><center>Cantidad</center></th>
	<th>Unidad</th>
	<th>--</th></tr>";
	$gtotal=0;
	$idpaquete=0;
	$contar=1;
	$estado=$compra['estado'];
	
	for($i=0;$i<count($pedido);$i++){
		echo "<tr id='".$pedido[$i]['id']."' class='edit-t'>";
		echo "<td>".$pedido[$i]['codigo']."</td>";
		echo "<td>".$pedido[$i]['nombre']."</td>";
		echo "<td align='center'>".$pedido[$i]['cantidad_oc']."</td>";
		echo "<td align='center'>".$pedido[$i]['unidad']."</td>";
		echo "<td>";
		if($estado=="Activa"){
			echo '<div class="btn-group"><a id="remove" class="btn btn-info btn-fill btn-sm"><i class="fas fa-trash-alt"></i></a>';
		}
		echo "</td>";
		echo "</tr>";
	}
?>


