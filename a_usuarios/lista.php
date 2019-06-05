<?php 
	require_once("db_.php");
	$bdd = new Usuario();
	$pd = $bdd->usuario_lista();
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

	<table class="table table-hover table-striped" id="x_lista">
	<thead>
	<th>Numero</th>
	<th>Nombre</th>
	<th>Usuario</th>
	<th>Contraseña</th>
	<th>Nivel</th>
	<th>Tienda</th>
	</thead>
	<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
		
				echo '<tr id="'.$pd[$i]['idusuario'].'" class="edit-t">';

					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-secondary btn-sm' id='edit_persona' title='Editar' data-lugar='a_usuarios/editar'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";

				echo '<td>'.$pd[$i]['nombre'].'</td>';
				echo '<td>'.$pd[$i]['user'].'</td>';
				echo '<td>'.$pd[$i]['pass'].'</td>';
				echo '<td>'.$pd[$i]['nivel'].'</td>';
				echo '<td>'.$pd[$i]['tienda'].'</td>';
			
				echo '</tr>';
			}
		?>
	</tbody>
	</table>
</div>

<script>
	$(document).ready( function () {
		lista("x_lista");
	});	
</script>


		