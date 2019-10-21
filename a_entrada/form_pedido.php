<?php
	require_once("db_.php");

	$id = $_REQUEST['id'];
  $pd = $db->entrada($id);
	$pedido = $db->entrada_pedido($id);

	echo "<table class='table table-sm'>";
	echo "<tr>
	<th>-</th>
	<th>Código</th>
	<th>Rápido</th>
	<th>Clave/IMEI</th>
	<th>Nombre</th>
	<th>Color</th>
	<th>Unidad</th>
	<th>Cantidad</th>
	<th>Precio entrada</th>
	<th>Precio Venta</th>
	</tr>";
	$gtotal=0;
	$idpaquete=0;
	$contar=1;
	$estado=$pd['estado'];
	foreach($pedido as $key){
		echo "<tr id='".$key['id']."' class='edit-t'>";
		echo "<td>";
		if($estado=="Activa" and $key['cantidad']>0){
			echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_comision' data-lugar='a_entrada/db_' data-destino='a_entrada/form_pedido' data-id='".$key['id']."' data-iddest='$id' data-funcion='borrar_producto' data-div='pedidos'><i class='far fa-trash-alt'></i></i></button>";	
		}

		echo "</td>";
		echo "<td>".$key['codigo']."</td>";
		echo "<td>".$key['rapido']."</td>";
		echo "<td>".$key['clave']."</td>";
		echo "<td>".$key['nombre']."</td>";
		echo "<td>".$key['color']."</td>";
		echo "<td align='center'>".$key['unidad']."</td>";
		echo "<td align='right'>1</td>";
		echo "<td align='right'>".moneda($key['precio'])."</td>";
		echo "<td align='right'>".moneda($key['pventa'])."</td>";

		echo "</tr>";
	}
?>
