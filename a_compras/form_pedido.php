<?php
	require_once("db_.php");
	$bdd = new Compra();

	$id = $_REQUEST['id'];
	$compra = $bdd->compra($id);
	$pedido = $bdd->compras_pedido($id);
	if($estado=="Activa"){
		echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='0' data-id2='$id' data-lugar='a_compras/form_producto'><i class='fas fa-plus'></i> Productos</button>";

	}
	echo "<table class='table'>";
	echo "<tr>
	<th>-</th>
	<th>Codigo</th>
	<th>Nombre</th>
	<th><center>Cantidad</center></th>
	<th>Unidad</th>
	</tr>";
	$gtotal=0;
	$idpaquete=0;
	$contar=1;
	$estado=$compra['estado'];

	for($i=0;$i<count($pedido);$i++){
		echo "<tr id='".$pedido[$i]['id']."' class='edit-t'>";
		echo "<td>";
		if($estado=="Activa"){
			echo '<div class="btn-group"><a id="remove" class="btn btn-outline-secondary btn-sm"><i class="fas fa-trash-alt"></i></a>';
		}
		echo "</td>";
		echo "<td>".$pedido[$i]['codigo']."</td>";
		echo "<td>".$pedido[$i]['nombre']."</td>";
		echo "<td align='center'>".$pedido[$i]['cantidad_oc']."</td>";
		echo "<td align='center'>".$pedido[$i]['unidad']."</td>";
		echo "</tr>";
	}
?>
