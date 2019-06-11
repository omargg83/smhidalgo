<?php
	require_once("db_.php");
	$pd = $db->traspaso_lista();
	$pd2 = $db->traspaso_llegada();

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";

?>
<div class="content table-responsive table-full-width">
	<h5>Enviados</h5>
	<table class="table table-hover table-striped">
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
		echo '</div>';
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
</div><br>
<?php
echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
echo "<br>";
?>
<h5>Recibidos</h5>

<table class="table table-hover table-striped">
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
		for($i=0;$i<count($pd2);$i++){
			echo '<tr id="'.$pd2[$i]['id'].'" class="edit-t">';
			echo '<td class="edit">';
			echo '<div class="btn-group">';
			echo '<a class="btn btn-outline-secondary btn-sm" id="edit_traspaso" data-lugar="a_inventario/form_traspaso"><i class="fas fa-pencil-alt"></i></a>';
			echo '</div>';
			echo '<td>'.$pd2[$i]['id'].'</td>';
			echo '<td>'.$pd2[$i]['nombre'].'</td>';
			echo '<td>'.$pd2[$i]['fecha'].'</td>';
			echo '<td>'.$pd2[$i]['nde'].'</td>';
			echo '<td>'.$pd2[$i]['npara'].'</td>';
			echo '<td>'.$pd2[$i]['estado'].'</td>';
			echo '</tr>';
		}
		?>

	</tbody>
	</table>
</div>

<script>
	$(document).ready( function () {
		$('table.table').DataTable({
		 "pageLength": 100,
					 "language": {
			 "sSearch": "Buscar aqui",
			 "lengthMenu": "Mostrar _MENU_ registros",
			 "zeroRecords": "No se encontró",
			 "info": " Página _PAGE_ de _PAGES_",
			 "infoEmpty": "No records available",
			 "infoFiltered": "(filtered from _MAX_ total records)",
			 "paginate": {
				 "first":      "Primero",
				 "last":       "Ultimo",
				 "next":       "Siguiente",
				 "previous":   "Anterior"
			 },
		 }
		});
	});
</script>
