<?php
	require_once("db_prove.php");
	$bdd = new Prove();
	$pd = $bdd->proveedores_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

			<table class="table table-hover table-striped" id="x_lista">
			<thead>
			<th>#</th>
			<th>Razón Social</th>
			<th>R.F.C.</th>
			<th>Nombre Contacto</th>
			<th>Dirección</th>
			</thead>
			<tbody>
			<?php
				for($i=0;$i<count($pd);$i++){
					echo "<tr id='".$pd[$i]['id_prove']."'' class='edit-t'>";
						echo "<td>";
						echo "<div class='btn-group'>";
						echo "<button class='btn btn-outline-secondary btn-sm' id='edit_persona' title='Editar' data-lugar='a_proveedores/editar'><i class='fas fa-pencil-alt'></i></button>";
						echo "</div>";
						echo "</td>";
						echo "<td>".$pd[$i]["razon_social_prove"]."</td>";
						echo "<td>".$pd[$i]["rfc_prove"]."</td>";
						echo "<td>".$pd[$i]["contacto_prove"]."</td>";
						echo "<td>".$pd[$i]["direccion_prove"]."</td>";
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
