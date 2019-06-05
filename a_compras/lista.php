<?php
	require_once("db_.php");
	$bdd = new Compra();
	$pd = $bdd->compras_lista();
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>
		<div class="content table-responsive table-full-width">
			<table class="table table-hover table-striped" id="x_lista">
			<thead>
			<th>#</th>
			<th>Numero</th>
			<th>Fecha</th>
			<th>Proveedor</th>
			<th>Estado</th>
			</thead>
			<tbody>
			<?php
				for($i=0;$i<count($pd);$i++){
					echo '<tr id="'.$pd[$i]['idcompra'].'" class="edit-t">';
					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-secondary btn-sm' id='edit_persona' title='Editar' data-lugar='a_compras/editar'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";
					echo '<td>'.$pd[$i]['idcompra'].'</td>';

					echo '<td>'.$pd[$i]['fecha'].'</td>';
					echo '<td>'.$pd[$i]['razon_social_prove'].'</td>';
					echo '<td>'.$pd[$i]['estado'].'</td>';
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
