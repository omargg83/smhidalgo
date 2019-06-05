<?php
	require_once("control_db.php");

	$bdd = new Venta();
	
	$id = $_REQUEST['id'];

	$traspaso = $bdd->traspaso($id);
	$estado=$traspaso['estado'];
	$pedido = $bdd->traspaso_pedido($id);
	
	echo "<table class='table table-sm'>";
	echo "<tr>
	<th>Codigo</th>
	<th>Clave</th>
	<th>Nombre</th>
	<th><center>Cantidad</center></th>
	<th>--</th>";
	echo "</tr>";
	$gtotal=0;
	$idpaquete=0;
	$contar=1;
	
	for($i=0;$i<count($pedido);$i++){
		echo "<tr id='".$pedido[$i]['id']."' pendiente='".$pedido[$i]['pendiente']."' unico='".$pedido[$i]['unico']."' class='edit-t'>";
		echo "<td>".$pedido[$i]['codigo']."</td>";
		echo "<td>".$pedido[$i]['clave']."</td>";
		echo "<td>".$pedido[$i]['nombre'];
			if(strlen($pedido[$i]['observaciones'])>0){
				echo "<br><span style='font-size:10px;font-weight: bold;'>".$pedido[$i]['observaciones']."</span>";
			}
		echo "</td>";
		echo "<td align='center'>".$pedido[$i]['total']."</td>";
		
		echo "<td class=edit>";
		if($estado=="Activa" and $pedido[$i]['recibido']!=1){
			echo '<div class="btn-group"><a id="remove" class="btn btn-info btn-fill btn-sm" title="Eliminar registro"><i class="fas fa-trash-alt"></i></a>';
			echo '<div class="btn-group"><a id="observaciones" class="btn btn-info btn-fill btn-sm" title="Agregar notas"><i class="far fa-file-alt"></i></a>';
		}
		else{
			echo $pedido[$i]['frecibido'];
		}
		
		echo "</td>";
		echo "</tr>";
		
		
	}
	
	
?>


