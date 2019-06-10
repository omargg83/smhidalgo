<?php
	require_once("db_.php");
	$pd = $db->traspaso_lista();
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";

?>
<div class="content table-responsive table-full-width">
	<table class="table table-hover table-striped" id="x_lista">
	<thead>
	<th>-</th>
	<th>Numero</th>
	<th>Nombre</th>
	<th>Fecha</th>
	<th>De</th>
	<th>Para</th>
	<th>Estado</th>
	</thead>
	<tbody>
	<?php

	for($i=0;$i<count($pd);$i++){
		echo '<tr id="'.$pd[$i]['id'].'" class="edit-t">';
		echo '<td class="edit">';
		echo '<div class="btn-group">';
		echo '<a class="btn btn-outline-secondary btn-sm" id="edit_traspaso" data-lugar="a_inventario/form_traspaso"><i class="fas fa-pencil-alt"></i></a>';
		echo '<td>'.$pd[$i]['id'].'</td>';
		echo '<td>'.$pd[$i]['nombre'].'</td>';
		echo '<td>'.$pd[$i]['fecha'].'</td>';
		echo '<td>'.$pd[$i]['nde'].'</td>';
		echo '<td>'.$pd[$i]['npara'].'</td>';
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
