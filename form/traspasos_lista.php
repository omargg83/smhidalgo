<?php 
	require_once("control_db.php");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	$bdd = new Venta();
	$pd = $bdd->traspaso_lista();
?>

<div class="content table-responsive table-full-width">
	<table class="table table-hover table-striped" id="myTable">
	<thead>
	
	<th>Numero</th>
	<th>Nombre</th>
	<th>Fecha</th>
	<th>De</th>
	<th>Para</th>
	<th>Estado</th>
	<th><input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" onkeyup="myFunction()" id="myInput">
	</thead>
	<tbody>
	<?php 

	for($i=0;$i<count($pd);$i++){
		echo '<tr id="'.$pd[$i]['id'].'" class="edit-t">';

		echo '<td>'.$pd[$i]['id'].'</td>';
		echo '<td>'.$pd[$i]['nombre'].'</td>';
		echo '<td>'.$pd[$i]['fecha'].'</td>';
		echo '<td>'.$pd[$i]['nde'].'</td>';
		echo '<td>'.$pd[$i]['npara'].'</td>';
		echo '<td>'.$pd[$i]['estado'].'</td>';
		echo '<td class="edit">
		<div class="btn-group">';
			if($pd[$i]['idde']==$_SESSION['idtienda']){
				echo '<a class="btn btn-info btn-fill btn-sm" id="edit_traspaso"><i class="fa fa-edit"></i>Editar</a>';
			}
			echo '<a class="btn btn-info btn-fill btn-sm" id="deta_traspaso"><i class="fas fa-pencil-alt"></i>Articulos</a></div></td>';
			echo '</tr>';
	}
	
	?>   
	</tbody>
	</table>
</div>
								