<?php
	require_once("db_.php");
?>
<nav class='navbar navbar-expand-lg navbar-light bg-light '>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Ventas</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>";
				<div class='form-inline my-2 my-lg-0' id='daigual' action='' >
					<div class="input-group  mr-sm-2">
						<input type="text" class="form-control form-control-sm" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2"  id='buscar' onkeyup='Javascript: if (event.keyCode==13) buscarx()'>
						<div class="input-group-append">
							<button class="btn btn-outline-primary btn-sm" type="button" onclick='buscarx()'><i class='fas fa-search'></i></button>
						</div>
					</div>
				</div>

				<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_ventas/editar'><i class='fas fa-plus'></i><span>Nueva venta</span></a></li>

				<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_ventas/lista'><i class='fas fa-list-ul'></i><span>Abiertas</span></a></li>

				<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_reporte' data-lugar='a_ventas/reporte1'><i class='fas fa-list-ul'></i><span>Reporte</span></a></li>

			<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_reporte2' data-lugar='a_ventas/reporte2'><i class='fas fa-list-ul'></i><span>Reporte 2</span></a></li>

			</ul>
	  </div>
	</nav>

<div id='trabajo'>
	<?php
	include 'lista.php';
	?>
</div>

<script type="text/javascript">

function buscar_producto(idventa){
	var texto=$("#prod_venta").val();
	var idtienda=$("#idtienda").val();
	if(texto.length>=-1){
		$.ajax({
			data:  {
				"texto":texto,
				"idtienda":idtienda,
				"idventa":idventa,
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
function sel_prod(idproducto,idventa){
	$.ajax({
		data:  {
			"idproducto":idproducto,
			"idventa":idventa,
			"function":"selecciona_producto"
		},
		url:   "a_ventas/db_.php",
		type:  'post',
		success:  function (response) {
			$("#resultadosx").html(response);
		}
	});
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

	$.confirm({
		title: 'Producto',
		content: '¿Desea agregar el producto para su venta?',
		buttons: {
			Aceptar: function () {
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
			},
			Cancelar: function () {

			}
		}
	});
}
function imprime(id){
	$.confirm({
		title: 'Producto',
		content: '¿Desea imprimir la venta seleccionada?',
		buttons: {
			Aceptar: function () {
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
						var datos = JSON.parse(response);
						if (datos.error==0){
							Swal.fire({
								type: 'success',
								title: "Se mandó imprimir correctamente",
								showConfirmButton: false,
								timer: 1000
							});
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
function cambio_total(){
	var total_g=$("#total_g").val();
	var efectivo_g=$("#efectivo_g").val();
	var total=(efectivo_g-total_g)*100;
	$("#cambio_g").val(Math.round(total)/100);
}


</script>
