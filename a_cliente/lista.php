<?php
	require_once("db_cliente.php");
	$bdd = new Cliente();
	$pd = $bdd->clientes_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

	<table id='x_cliente' class='dataTable compact hover row-border' style='font-size:10pt;'>
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
				echo "<tr id='".$pd[$i]['idcliente']."'' class='edit-t'>";
					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-secondary btn-sm' id='edit_persona' title='Editar' data-lugar='a_cliente/editar'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";
					echo "<td>".$pd[$i]["razon_social_prove"]."</td>";
					echo "<td>".$pd[$i]["rfc_prove"]."</td>";
					echo "<td>".$pd[$i]["contacto_prove"]."</td>";
					echo "<td>".$pd[$i]["direccion_prove"]."</td>";
				echo "</tr>";
			}
		?>



	</div>
	</tbody>
	</table>
</div>
<script>
	$(document).ready( function () {
		lista("x_cliente");
	});
</script>
