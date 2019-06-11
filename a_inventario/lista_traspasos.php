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

	for($i=0;$i<count($pedido);$i++){
		echo "<tr id='".$pedido[$i]['id']."' data-pendiente='".$pedido[$i]['pendiente']."' data-unico='".$pedido[$i]['unico']."' class='edit-t'>";
    echo "<td class=edit>";
      echo "<div class='btn-group'>";
    if($estado=="Activa" and $pedido[$i]['recibido']!=1){
      echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_comision' data-lugar='a_inventario/db_' data-destino='a_inventario/lista_traspasos' data-id='".$pedido[$i]['id']."'
       data-iddest='$id' data-funcion='borrar_traspaso' data-div='movimientos'><i class='far fa-trash-alt'></i></button>";
    }
    else{
      if($idpara==$_SESSION['idtienda']){
          echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='recibir'><i class='fas fa-people-carry'></i>Recibir</button>";
      }
    }
    echo "</div>";

    echo "</td>";
    echo "<td>".$pedido[$i]['cantidad'];
		echo "<td>".$pedido[$i]['codigo']."</td>";
		echo "<td>".$pedido[$i]['clave']."</td>";
		echo "<td>".$pedido[$i]['nombre'];
    echo "<td>".$pedido[$i]['color'];

			if(strlen($pedido[$i]['observaciones'])>0){
				echo "<br><span style='font-size:10px;font-weight: bold;'>".$pedido[$i]['observaciones']."</span>";
			}
		echo "</td>";
		echo "</tr>";
	}
  echo "</table>";


?>
