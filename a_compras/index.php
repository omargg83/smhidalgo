<?php
	require_once("db_.php");
	$bdd = new Compra();
	echo "<nav class='navbar navbar-expand-lg navbar-light bg-light '>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Compras</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>";
			echo"<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_compras/lista'><i class='fas fa-list-ul'></i><span>Lista</span></a></li>";


			echo"<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_compras/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>";

			echo "</ul>";
		echo "
	  </div>
	</nav>";

?>
<div id='trabajo'>
	<?php
		include 'lista.php';
	?>
</div>
<script type="text/javascript">
	$(document).on('keypress','#prod_bus',function(e){
		if(e.which == 13) {
			e.preventDefault();
			e.stopPropagation();
			buscar();
		}
	});
	$(document).on('click','#buscar_producto',function(e){
		e.preventDefault();
		e.stopPropagation();
		buscar();
	});

	function buscar(){
		var texto=$("#prod_bus").val();
		if(texto.length>=2){
			$.ajax({
				data:  {
					"texto":texto,
					"function":"busca_producto"
				},
				url:   "a_compras/db_.php",
				type:  'post',
				beforeSend: function () {
					$("#resultadosx").html("buscando...");
				},
				success:  function (response) {
					$("#resultadosx").html(response);
				}
			});
		}
	}

	$(document).on('click','#producto_sel',function(e){
		e.preventDefault();
		e.stopPropagation();
		var id_invent = $(this).closest(".edit-t").attr("id");
		var cantidad = $("#cantidad_"+id_invent).val();
		var idcompra = $("#id").val();
		$.ajax({
			data:  {
				"id_invent":id_invent,
				"idcompra":idcompra,
				"cantidad":cantidad,
				"function":"agregar_producto"
			},
			url:   "a_compras/db_.php",
			type:  'post',
			beforeSend: function () {

			},
			success:  function (response) {
				alert(response);
			}
		});
	});

	</script>
