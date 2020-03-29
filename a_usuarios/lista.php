<?php
	require_once("db_.php");
	$pd = $db->usuario_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
?>

	<table id='x_user' class='dataTable compact hover row-border' style='font-size:10pt;'>
	<thead>
	<th>Numero</th>
	<th>Nombre</th>
	<th>Usuario</th>
	<th>Nivel</th>
	<th>Tienda</th>
	<th>Activo</th>
	</thead>
	<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
				echo '<tr id="'.$pd[$i]['idusuario'].'" class="edit-t">';
					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-primary btn-sm' id='edit_persona' title='Editar' data-lugar='a_usuarios/editar'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";
				echo '<td>'.$pd[$i]['nombre'].'</td>';
				echo '<td>'.$pd[$i]['user'].'</td>';
				echo '<td>'.$pd[$i]['nivel'].'</td>';
				echo '<td>'.$pd[$i]['tienda'].'</td>';
				echo '<td>';
				if ($pd[$i]['activo']==0) { echo "Inactivo"; }
				if ($pd[$i]['activo']==1) { echo "Activo"; }
				echo '</td>';
				echo '</tr>';
			}
		?>
	</tbody>
	</table>
</div>

<script>
	$(document).ready( function () {
		lista("x_user");
	});
</script>
