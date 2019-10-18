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
				$("#prod_venta").val();
			}
		});
	}
}
function ventraprod(idx,tipo){
	var idventa =$("#id").val();
	var idcliente =$("#idcliente").val();
	var idbodega="";
	var id_invent="";
	if(tipo==1){
		idbodega=idx;
	}
	if(tipo==2){
		id_invent=idx;
	}
	var precio=parseInt($("#precio_"+idx).val());
	var observa=$("#observa_"+idx).val();

	$.ajax({
		data:  {
			"idventa":idventa,
			"idcliente":idcliente,
			"precio":precio,
			"observa":observa,
			"idbodega":idbodega,
			"id_invent":id_invent,
			"tipo":tipo,
			"function":"agregaventa"
		},
		url:   "a_ventas/db_.php",
		type:  'post',
		success:  function (response) {
			var data = JSON.parse(response);
			$("#id").val(data.idventa);
			$("#sub_x").val(data.subtotal);
			$("#iva_x").val(data.iva);
			$("#total_x").val(data.total);

			$("#tablax").append(data.datax);

			Swal.fire({
				type: 'success',
				title: "Se agregó correctamente",
				showConfirmButton: false,
				timer: 500
			});
		}
	});
}
function imprime(id){
	$.ajax({
		data:  {
			"id":id,
			"function":"imprimir"
		},
		url:   "a_ventas/db_.php",
		type:  'post',
		beforeSend: function () {

		},
		success:  function (response) {
			if (isNaN(response)){
				alert(response);
			}
			else {
				Swal.fire({
					type: 'success',
					title: "Se mandó imprimir correctamente",
					showConfirmButton: false,
					timer: 1000
				});
			}
		}
	});
}
function cambio_total(){
	var total_g=$("#total_g").val();
	var efectivo_g=$("#efectivo_g").val();
	var total=(efectivo_g-total_g)*100;
	$("#cambio_g").val(Math.round(total)/100);
}
function borra_venta(id){

	$.confirm({
		title: 'Guardar',
		content: '¿Desea borrar el registro seleccionado?',
		buttons: {
			Aceptar: function () {
				var parametros={
					"id":id,
					"function":"borrar_venta"
				};
				$.ajax({
					data:  parametros,
					url: "a_ventas/db_.php",
					type:  'post',
					success:  function (response) {
						var data = JSON.parse(response);
						$("#sub_x").val(data.subtotal);
						$("#iva_x").val(data.iva);
						$("#total_x").val(data.total);
						$("#div_"+data.id).remove();

						Swal.fire({
							type: 'success',
							title: "Se éliminó correctamente",
							showConfirmButton: false,
							timer: 500
						});
					}
				});
			},
			Cancelar: function () {

			}
		}
	});

}

</script>
