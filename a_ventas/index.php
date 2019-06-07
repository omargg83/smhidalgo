<?php
	require_once("db_.php");

	echo "<nav class='navbar navbar-expand-lg navbar-light bg-light '>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Ventas</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>";
			echo"<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_ventas/lista'><i class='fas fa-list-ul'></i><span>Lista</span></a></li>";


			echo"<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_ventas/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>";

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
$(document).on('keypress','#prod_venta',function(e){
	if(e.which == 13) {
		e.preventDefault();
		e.stopPropagation();
		buscar_venta();
	}
});

$(document).on('click','#buscar_prodventa',function(e){
	e.preventDefault();
	e.stopPropagation();
	buscar_venta();
});

function buscar_venta(){
	var texto=$("#prod_venta").val();
	var idtienda=$("#idtienda").val();
	if(texto.length>=-1){
		$.ajax({
			data:  {
				"texto":texto,
				"idtienda":idtienda,
				"function":"busca_producto"
			},
			url:   "a_ventas/db_.php",
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

$(document).on('click','#ventasel',function(e){
	e.preventDefault();
	e.stopPropagation();
	var id=$(this).closest(".edit-t").attr("id");
	var identrada = $("#id").val();
	$.ajax({
	  data: {
	    "id":id,
	    "identrada":identrada,
	    "function":"pre_sel"
	  },
	  url:   "a_ventas/db_.php",
	  type:  'post',
	  beforeSend: function () {

	  },
	  success: function (response) {
	      $("#resultadosx").html(response);
	  }
	});
});

function ventraprod(idbodega){
	var idventa =$("#id").val();

	$.confirm({
		title: 'Agregar',
		content: '¿Desea traspasar el articulo?',
		buttons: {
			Aceptar: function () {
				$.ajax({
					data:  {
						"idventa":idventa,
						"idbodega":idbodega,
						"function":"agregaventa"
					},
					url:   "a_ventas/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						if (isNaN(response)){
							alert(response);
						}
						else{
							$("#resultadosx").html("");
							$("#compras").load("a_ventas/lista_pedido.php?id="+idventa);
						}
					}
				});
			},
			Cancelar: function () {

			}
		}
	});
}



</script>
