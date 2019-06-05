<?php 
	require_once("db_tienda.php");
	$bdd = new Tienda();
	$pd = $bdd->tiendas_lista();

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

<div class="content table-responsive table-full-width">
	<table class="table table-hover table-striped" id="x_lista">
		<thead>
		<tr>
		<th>Numero</th>
		<th>Nombre</th>
		<th>Ubicación</th>
		
		</thead>
		<tbody>		
		<?php
			for($i=0;$i<count($pd);$i++){
				echo "<tr id='".$pd[$i]['id']."'' class='edit-t'>";
					echo "<td>".$pd[$i]["id"];
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-secondary btn-sm' id='edit_persona' title='Editar' data-lugar='a_tienda/editar'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";
					echo "<td>".$pd[$i]["nombre"]."</td>";
					echo "<td>".$pd[$i]["ubicacion"]."</td>";
				echo "</tr>";
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

