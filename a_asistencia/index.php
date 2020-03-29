<?php
	require_once("db_.php");
	$pd = $db->lista_acceso();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

	<table id='x_lista' class='dataTable compact hover row-border' style='font-size:10pt;'>
	<thead>
	<th>-</th>
	<th>Fecha</th>
	<th>Usuario</th>
	<th>Nombre</th>
	<th>Descripción</th>
	</thead>
	<tbody>
		<?php
			$contar=1;
			for($i=0;$i<count($pd);$i++){
				echo '<tr id="'.$pd[$i]['idusuario'].'" class="edit-t">';
				echo "<td>".$contar."</th>";
				$contar++;
				echo '<td>'.$pd[$i]['fecha'].'</td>';
				echo '<td>'.$pd[$i]['user'].'</td>';
				echo '<td>'.$pd[$i]['nombre'].'</td>';
				echo '<td>'.$pd[$i]['descripcion'].'</td>';


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
