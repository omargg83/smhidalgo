<?php
require_once("db_.php");
$tiendas = $db->tiendas_lista();

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
echo "<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='select_tienda' data-lugar='a_inventario/lista' data-combo='idtienda'><i class='fas fa-list-ul'></i><span>Lista</span></a></li>";
//echo "<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_inventario/lista_transito'><i class='fas fa-plus'></i><span>En tránsito</span></a></li>";
echo "<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_traspaso' data-lugar='a_inventario/traspasos'><i class='fas fa-random'></i><span>Traspasos</span></a></li>";
echo "<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='new_traspaso' data-lugar='a_inventario/form_traspaso'><i class='fas fa-random'></i><span>Nuevo Traspaso</span></a></li>";
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

$(document).on('keypress','#prod_traspaso',function(e){
	if(e.which == 13) {
		e.preventDefault();
		e.stopPropagation();
		buscatraspaso();
	}
});

$(document).on('click','#buscartraspaso',function(e){
	e.preventDefault();
	e.stopPropagation();
	buscatraspaso();
});

function buscatraspaso(){
	var texto=$("#prod_traspaso").val();
	if(texto.length>=-1){
		$.ajax({
			data:  {
				"texto":texto,
				"function":"busca_producto"
			},
			url:   "a_inventario/db_.php",
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

function traspasosel(idbodega){
	var idtraspaso =$("#id").val();
	var cantidad=$("#cantidad_"+idbodega).val();
	$.confirm({
		title: 'Agregar',
		content: '¿Desea traspasar el articulo?',
		buttons: {
			Aceptar: function () {
				$.ajax({
					data:  {
						"idtraspaso":idtraspaso,
						"idbodega":idbodega,
						"cantidad":cantidad,
						"function":"agregatraspaso"
					},
					url:   "a_inventario/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						if (!isNaN(response)){
							$("#resultadosx").html("");
							$("#movimientos").load("a_inventario/lista_traspasos.php?id="+idtraspaso);
						}
						else{
							alert(response);
						}
					}
				});
			},
			Cancelar: function () {

			}
		}
	});
}
$(document).on('click','#recibir',function(e){
	e.preventDefault();
	e.stopPropagation();
	var idtraspaso =$("#id").val();
	var id=$(this).closest(".edit-t").attr("id");


	$.ajax({
		data:  {
			"id":id,
			"function":"recibir"
		},
		url:   "a_inventario/db_.php",
		type:  'post',
		beforeSend: function () {

		},
		success:  function (response) {
			if (!isNaN(response)){
				$("#resultadosx").html("");
				$("#movimientos").load("a_inventario/lista_traspasos.php?id="+idtraspaso);
			}
			else{
				alert(response);
			}
		}
	});
});

$(document).on('click','#enviatraspaso',function(e){
	e.preventDefault();
	e.stopPropagation();
	var idtraspaso =$("#id").val();
	$.confirm({
		title: 'Agregar',
		content: '¿Desea enviar los articulos seleccionados?',
		buttons: {
			Aceptar: function () {
				$.ajax({
					data:  {
						"id":idtraspaso,
						"function":"enviarproducto"
					},
					url:   "a_inventario/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						if (!isNaN(response)){
							$("#trabajo").load("a_inventario/form_traspaso.php?id="+idtraspaso);
						}
						else{
							alert(response);
						}
					}
				});
			},
			Cancelar: function () {

			}
		}
	});
});


</script>
