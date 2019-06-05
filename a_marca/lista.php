<?php 
	require_once("db_marca.php");
	$bdd = new Marca();
	$pd = $bdd->marca_lista();
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

	<table class="table table-hover table-striped" id="x_lista">
	<thead>
	<th>#</th>
	<th>Marca</th>
	</thead>
	<tbody>
		<?php
			for($i=0;$i<count($pd);$i++){
				echo "<tr id='".$pd[$i]['idmarca']."'' class='edit-t'>";
					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-secondary btn-sm' id='edit_persona' title='Editar' data-lugar='a_marca/editar'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";
					echo "<td>".$pd[$i]["marca"]."</td>";
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


		
