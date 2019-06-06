<?php
	require_once("db_.php");

	$id = $_REQUEST['id'];
  $pd = $db->entrada($id);
	$pedido = $db->entrada_pedido($id);

	echo "<table class='table table-sm'>";
	echo "<tr>
	<th>-</th>
	<th>Codigo</th>
	<th>Clave/IMEI</th>
	<th>Nombre</th>
	<th><center>Cantidad</center></th>
	<th>Unidad</th>
	<th>Precio</th>
	</tr>";
	$gtotal=0;
	$idpaquete=0;
	$contar=1;
	$estado=$pd['estado'];

	for($i=0;$i<count($pedido);$i++){
		echo "<tr id='".$pedido[$i]['id']."' class='edit-t'>";
		echo "<td>";
		if($estado=="Activa"){
			echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_comision' data-lugar='a_entrada/db_' data-destino='a_entrada/form_pedido' data-id='".$pedido[$i]['id']."' data-iddest='$id' data-funcion='borrar_producto' data-div='pedidos'><i class='far fa-trash-alt'></i></i></button>";
		}
		echo "</td>";
		echo "<td>".$pedido[$i]['codigo']."</td>";
		echo "<td>".$pedido[$i]['clave']."</td>";
		echo "<td>".$pedido[$i]['nombre']."</td>";
		echo "<td align='center'>".$pedido[$i]['cantidad']."</td>";
		echo "<td align='center'>".$pedido[$i]['unidad']."</td>";
		echo "<td align='center'>".$pedido[$i]['precio']."</td>";
		echo "</tr>";
	}
?>
