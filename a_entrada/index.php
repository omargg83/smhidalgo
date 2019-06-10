<?php
require_once("db_.php");

echo "<nav class='navbar navbar-expand-lg navbar-light bg-light '>
<a class='navbar-brand' ><i class='fas fa-user-check'></i> Entrada</a>
<button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
<span class='navbar-toggler-icon'></span>
</button>
<div class='collapse navbar-collapse' id='navbarSupportedContent'>
<ul class='navbar-nav mr-auto'>";
echo"<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_entrada/lista'><i class='fas fa-list-ul'></i><span>Lista</span></a></li>";


echo"<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_entrada/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>";

echo "</ul>";
echo "
</div>
</nav>";

echo "<div id='trabajo'>";
include 'lista.php';
echo "</div>";
?>
<script type="text/javascript">
$(document).on('keypress','#prod_entra',function(e){
	if(e.which == 13) {
		e.preventDefault();
		e.stopPropagation();
		buscar();
	}
});

$(document).on('click','#buscar_prodentra',function(e){
	e.preventDefault();
	e.stopPropagation();
	buscar();
});

function buscar(){
	var texto=$("#prod_entra").val();
	if(texto.length>=-1){
		$.ajax({
			data:  {
				"texto":texto,
				"function":"busca_producto"
			},
			url:   "a_entrada/db_.php",
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

$(document).on('click','#entradasel',function(e){
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
		url:   "a_entrada/db_.php",
		type:  'post',
		beforeSend: function () {

		},
		success: function (response) {
			$("#resultadosx").html(response);
		}
	});
});

$(document).on('click','#entradaend',function(e){
	var id = $("#id").val();
	$.confirm({
		title: 'Cerrar entrada',
		content: '¿Desea cerrar la entrada?<br>ya no se podrán agregar mas productos.',
		buttons: {
			Aceptar: function () {
				$.ajax({
					data:  {"id":id,"function":"cerrarentrada"},
					url:   "a_entrada/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						$("#trabajo").load("a_entrada/editar.php?id="+id);
					}
				});
			},
			Cancelar: function () {
			}
		}
	});
});

</script>
