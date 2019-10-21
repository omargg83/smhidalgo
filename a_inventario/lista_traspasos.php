<?php
  require_once("db_.php");

	$id = $_REQUEST['id'];

	$traspaso = $db->traspaso($id);
	$estado=$traspaso['estado'];
  $idpara=$traspaso['idpara'];
	$pedido = $db->traspaso_pedido($id);

	echo "<table class='table table-sm'>";
	echo "<tr>
  <th>--</th>
  <th>Cantidad</th>
	<th>Codigo</th>
	<th>Clave</th>
	<th>Nombre</th>
  <th>Color</th>
	";
	echo "</tr>";
	$gtotal=0;
	$idpaquete=0;
	$contar=1;
  foreach($pedido as $key){
		echo "<tr id='".$key['id']."' class='edit-t'>";
    echo "<td class=edit>";
      echo "<div class='btn-group'>";
      if($estado=="Activa"){
        echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_comision' data-lugar='a_inventario/db_' data-destino='a_inventario/lista_traspasos' data-id='".$key['id']."'
         data-iddest='$id' data-funcion='borrar_traspaso' data-div='movimientos'><i class='far fa-trash-alt'></i></button>";
      }
      else{
        if($key['recibido']!=1){
            echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='recibir(".$key['id'].")'><i class='fas fa-people-carry'></i>Recibir</button>";
        }
      }
      echo "</div>";
    echo "</td>";
    echo "<td>".$key['cantidad'];
		echo "<td>".$key['codigo']."</td>";
		echo "<td>".$key['clave']."</td>";
		echo "<td>".$key['nombre'];
    echo "<td>".$key['color'];

		if(strlen($key['observaciones'])>0){
			echo "<br><span style='font-size:10px;font-weight: bold;'>".$key['observaciones']."</span>";
		}
		echo "</td>";
		echo "</tr>";
	}
  echo "</table>";


?>
