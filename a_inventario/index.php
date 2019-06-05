<?php
	require_once("db_.php");
	$bdd = new Inventario();
	$tiendas = $bdd->tiendas_lista();

	echo "<nav class='navbar navbar-expand-lg navbar-light bg-light '>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Inventario</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>";

			echo "<li class='nav-item'>";
			echo "<select class='form-control' name='idtienda' id='idtienda'>";
				echo '<option disabled>Seleccione una tienda</option>';
				for($i=0;$i<count($tiendas);$i++){
					echo '<option value="'.$tiendas[$i]['id'].'"';
					if($tiendas[$i]['id']==$_SESSION['idtienda']){
						echo " selected";
					}
					echo '>'.$tiendas[$i]["nombre"].'</option>';
				}
			  echo "</select>";
			echo "</li>";

			echo "<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_inventario/bodega'><i class='fas fa-plus'></i><span>En tránsito</span></a></li>";
			echo "<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_inventario/lista'><i class='fas fa-list-ul'></i><span>Lista</span></a></li>";
			echo "</ul>";
		echo "
	  </div>
	</nav>";
?>


		<div id='trabajo'>
		</div>


<script type="text/javascript">
	$(document).ready(function(){
		var id;
		id=document.getElementById("idtienda").value;
		$("#trabajo").load('a_inventario/lista.php?id='+id);
	});

	$(document).on('change','#idtienda', function() {
		var id =$(this).val();
		var parametros={
			"id":id
		};
		$.ajax({
			data: parametros,
			url: "a_inventario/lista.php",
			type: "post",
			beforeSend: function () {
					$("#trabajo").html("Procesando, espere por favor...");
				},
				success:  function (response) {
					$("#trabajo").html('');
					$("#trabajo").html(response);
				}
		});

	});
 </script>
