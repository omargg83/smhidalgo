	var intval="";
	var intvalx="";
	var chatx="";
	var cuenta="";
	
	$(window).on('hashchange',function(){
		loadContent(location.hash.slice(1));
	});
	var url=window.location.href;
	var hash=url.substring(url.indexOf("#")+1);
	
	if(hash===url || hash===''){
		hash='escritorio/dashboard';
	}
	function loadContent(hash){
		$("#cargando").addClass("is-active");
		var id=$(this).attr('id');
		if(hash===''){
			hash= 'escritorio/dashboard';
		}
		$('html, body').animate({strollTop:0},'600','swing');
		
		var destino=hash + '.php';
		$.ajax({
			data:  {"algo":"algo"},
			url: destino,
			type: "POST",
			beforeSend: function () {
				$("#contenido").html("<div class='container' style='background-color:white; width:300px'><center><img src='img/carga.gif' width='300px'></center></div>");
			},
			success:  function (response) {
				$("#contenido").html(response);
			}
		});
		
		$("#cargando").removeClass("is-active");
	}

	$.ajax({
		data:  {"algo":"algo"},
		url: hash + '.php',
		type: "POST",
		beforeSend: function () {
			$("#contenido").html("<div class='container' style='background-color:white; width:300px'><center><img src='img/carga.gif' width='300px'></center></div>");
		},
		success:  function (response) {
			$("#contenido").html(response);
		}
	});
	
	$(function(){
		var parametros={
			"function":"leerfondo"
		};
		$.ajax({
			data:  parametros,
			url: "acceso_db.php",
			type: "post",
			beforeSend: function () {
			},
			success:  function (response) {
				$("body").css("background-image","url('"+response+"')");
			}
		});
		$("#cargando").removeClass("is-active");
		setTimeout(fondos, 5000);
	});
	
	function fondos(){
		var parametros={
			"function":"fondo_carga"
		};
		$.ajax({
			data:  parametros,
			url: "acceso_db.php",
			type: "post",
			beforeSend: function () {
			},
			success:  function (response) {
				$("#fondo").html(response);
			}
		});
	}

	function lista(id) {
		$('#'+id).DataTable({
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
	}
	function fechas () {
		$.datepicker.regional['es'] = {
			 closeText: 'Cerrar',
			 yearRange: '1910:2040',		 
			 prevText: '<Ant',
			 nextText: 'Sig>',
			 currentText: 'Hoy',
			 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			 weekHeader: 'Sm',
			 dateFormat: 'dd-mm-yy',
			 firstDay: 0,
			 isRTL: false,
			 showMonthAfterYear: false,
			 yearSuffix: ''
		 };
		 
		$.datepicker.setDefaults($.datepicker.regional['es']);
		$(".fechaclass").datepicker();
	};	
	
	//////////////////////subir archivos
	$(document).on("click","[id^='fileup_']",function(e){
		e.preventDefault();
		
		var id = $(this).data('id');
		var ruta = $(this).data('ruta');
		var tipo = $(this).data('tipo');
		var ext = $(this).data('ext');
		var tabla = $(this).data('tabla');
		var campo = $(this).data('campo');
		var keyt = $(this).data('keyt');
		var destino = $(this).data('destino');
		var iddest = $(this).data('iddest');
		var proceso="";
		if ( $(this).data('proceso') ) {
			proceso=$(this).data('proceso');
		}
		
		$("#modal_form").load("archivo.php?id="+id+"&ruta="+ruta+"&ext="+ext+"&tipo="+tipo+"&tabla="+tabla+"&campo="+campo+"&keyt="+keyt+"&destino="+destino+"&iddest="+iddest+"&proceso="+proceso);
	});
	$(document).on('change',"#prefile",function(e){
		e.preventDefault();
		var control=$(this).attr('id');
		var accept=$(this).attr('accept');
		
		var fileSelect = document.getElementById(control);
		var files = fileSelect.files;
		var formData = new FormData();
		for (var i = 0; i < files.length; i++) {
		   var file = files[i];
		   formData.append('photos'+i, file, file.name);
		}
		var tam=(fileSelect.files[0].size/1024)/1024;
		if (tam<10){
			var xhr = new XMLHttpRequest();
			xhr.open('POST','acceso_db.php?function=subir_file');
			xhr.onload = function() {
				
			};
			xhr.upload.onprogress = function (event) {
				var complete = Math.round(event.loaded / event.total * 100);				
				if (event.lengthComputable) {
					btnfile.style.display="none";
					progress_file.style.display="block";
					progress_file.value = progress_file.innerHTML = complete;
					// conteo.innerHTML = "Cargando: "+ nombre +" ( "+complete+" %)";
				}
			};
			xhr.onreadystatechange = function(){
				if(xhr.readyState === 4 && xhr.status === 200){ 
					progress_file.style.display="none";
					btnfile.style.display="block";
					try {
						var data = JSON.parse(xhr.response);
						for (i = 0; i < data.length; i++) {
							$("#contenedor_file").html("<div style='border:0;float:left;margin:10px;'>"+
							"<input type='hidden' id='direccion' name='direccion' value='"+data[i].archivo+"'>"+
							"<img src='historial/"+data[i].archivo+"' width='300px'></div>");
						}
					}
					catch (err) {
					   alert(xhr.response);
					}
				}
			}
			xhr.send(formData);
		}
		else{
			alert("Archivo muy grande");
		}
	});
	$(document).on('submit','#upload_File',function(e){
		e.preventDefault();
		var funcion="guardar_file";
		var destino = $("#destino").val();
		var iddest = $("#iddest").val();
		var proceso="acceso_db.php";
		
		if ( $("#direccion").length ) {
			var dataString = $(this).serialize()+"&function="+funcion;
			$.ajax({
				data:  dataString,
				url: proceso,
				type: "post",
				beforeSend: function () {
						
				},
				success:  function (response) {
					if (!isNaN(response)){
						lugar=destino+".php?id="+iddest;
						$("#trabajo").load(lugar);
						$('#myModal').modal('hide');
						Swal.fire({
						  type: 'success',
						  title: "Se cargó correctamente",
						  showConfirmButton: false,
						  timer: 1000
						});
					}
					else{
						$.alert(response);
					}
				}
			});
		}
		else{
			$.alert('Debe seleccionar un archivo');
		}
		
	});
	
	$(document).on('click','.sidebar a', function() {
       $(".sidebar a").removeClass("activeside");
       $(this).addClass("activeside");
	});
	$(document).on("click","#fondocambia",function(e){
		e.preventDefault();
		var imagen=$("img", this).attr("src");
		
		var lugar='acceso_db.php';
		$.ajax({
			data:  {
				"imagen":imagen,
				"function":"fondo"
			},
			url:   lugar,
			type:  'post',
			beforeSend: function () {
				
			},
			success:  function (response) {
				$("body").css("background-image","url('"+imagen+"')");
			}
		});
	});	
	$(document).on('click','#sidebarCollapse', function () {
		$('#navx').toggleClass('sidenav');
        $('#contenido').toggleClass('fijaproceso');
        $('#sidebar').toggleClass('active');
    });
	$(document).on("click","[id^='edit_'], [id^='lista_'], [id^='new_']",function(e){	//////////// para ir a alguna opcion
		e.preventDefault();
		
		var id=$(this).attr('id');
		var funcion="";
		if ( $(this).data('funcion') ) {
			funcion = $(this).data('funcion');
		}
		var lugar="";
		var contenido="#trabajo";
		var xyId=0;
		var valor="";
		padre=id.split("_")[0]
		opcion=id.split("_")[1];
		$("#cargando").addClass("is-active");
		
		if ( $(this).data('valor')!=undefined ) {
			valor=$("#"+$(this).data('valor')).val();
		}
		
		if ( $(this).data('div')!=undefined ) {
			contenido="#"+$(this).data('div');
		}
		
		if(padre=="edit" || padre=="new" || padre=="lista"){
			lugar = $("#"+id).data('lugar')+".php";
			if(padre=="edit"){
				lugar=$(this).attr("data-lugar")+".php";	
				if ( $(this).closest(".edit-t").attr("id")){
					xyId = $(this).closest(".edit-t").attr("id");
				}
				else{
					xyId = $("#"+id).data('id');
				}
			}
		}
		$.ajax({
			data:  {"algo":"algo","padre":padre,"opcion":opcion,"id":xyId,"nombre":id,"funcion":funcion,"valor":valor},
			url:   lugar,
			type:  'post',
			beforeSend: function () {
				$(contenido).html("<div class='container' style='background-color:white; width:300px'><center><img src='img/carga.gif' width='300px'></center></div>");
			},
			success:  function (response) {
				$(contenido).html(response);
			}
		});
		$("#cargando").removeClass("is-active");
	});
	$(document).on("click","[id^='select_']",function(e){								//////////// para consulta con combo
		var combo=$(this).data('combo');
		var combo2;
		var id2;
		var lugar=$(this).data('lugar')+".php";
		var div;
		if ($(this).data('combo2')){
			combo2=$(this).data('combo2');
			id2=$("#"+combo2).val();
		}
		if ( $(this).data('div') ) {
			div = $(this).data('div');
		}
		else{
			div="trabajo";
		}
		var id=$("#"+combo).val();
		$.ajax({
			data:  {"id":id,"id2":id2},
			url:   lugar,
			type:  'post',
			beforeSend: function () {
				
			},
			success:  function (response) {
				$("#"+div).html(response);
			}
		});
		
	});
	$(document).on("click","[id^='imprimir_'], [id^='imprime_']",function(e){
		e.preventDefault();
		var id=$(this).attr('id');
		var padre=id.split("_")[0]
		var opcion=id.split("_")[1];
		var valor=0;
		var xyId;
		
		if ( $(this).data('valor') ) {
			var control=$(this).data('valor');
			valor = $("#"+control).val();
		}
		
		if(padre=="imprimir"){
			xyId = $(this).closest(".edit-t").attr("id");
		}
		if(padre=="imprime"){
			xyId= $("#id").val();
		}
		
		if( $("#"+id).data('select') ){
			var select=$("#"+id).data('select');
			xyId=$("#"+select).val();
		}
		else{
			
		}
		var lugar = $("#"+id).data('lugar')+".php";
		var tipo = $("#"+id).data('tipo');
		VentanaCentrada(lugar+'?id='+xyId+'&tipo='+tipo+'&valor='+valor,'Impresion','','1024','768','true');  
	});
	
	$(document).on('submit',"[id^='form_']",function(e){
		e.preventDefault();
	
		var id=$(this).attr('id');
		var lugar = $(this).data('lugar')+".php";
		var destino = $(this).data('destino');
		var div;
		var funcion="";
		var cerrar=0;

		if ( $(this).data('funcion') ) {
			var funcion = $(this).data('funcion');
		}
		if ( $(this).data('div') ) {
			div = $(this).data('div');
		}
		else{
			div="trabajo";
		}
		if ( $(this).data('cmodal') ) {
			cerrar=$(this).data('cmodal');
		}
		
		var dataString = $(this).serialize()+"&function="+funcion;
		$.ajax({
			data:  dataString,
			url: lugar,
			type: "post",
			beforeSend: function () {
					
			},
			success:  function (response) {
				if (!isNaN(response)){
					document.getElementById("id").value=response;
					if (destino != undefined) {
						lugar=destino+".php";
						$.ajax({
							data:  {"id":response},
							url:   lugar,
							type:  'post',
							beforeSend: function () {
								
							},
							success:  function (response) {
								$("#"+div).html(response);
							}
						});
					}
					if(cerrar==0){
						$('#myModal').modal('hide');
					}
					Swal.fire({
					  type: 'success',
					  title: "Se guardó correctamente",
					  showConfirmButton: false,
					  timer: 1000
					})
				}
				else{
					$.alert(response);
				}
			}
		});
	});
	
	
	
	$(document).on('submit',"[id^='consulta_']",function(e){
		e.preventDefault();
		var dataString = $(this).serialize();
		var div = $(this).data('div');
		var funcion = $(this).data('funcion');
		
		var destino = $(this).data('destino')+".php?funcion="+funcion;
		$.ajax({
			data:  dataString,
			url: destino,
			type: "post",
			beforeSend: function () {
					
			},
			success:  function (response) {
				$("#"+div).html(response);
			}
		});
	});	
	$(document).on("click","[id^='eliminar_']",function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var lugar = $(this).data('lugar')+".php";
		var destino = $(this).data('destino')+".php";
		var iddest = $(this).data('iddest');
		var div;
		
		if ( $(this).data('funcion') ) {
			var funcion = $(this).data('funcion');
		}
		else{
			console.log("error");
			return;
		}
		
		if ( $(this).data('div') ) {
			div = $(this).data('div');
		}
		else{
			div="trabajo";
		}
		$.confirm({
			title: 'Guardar',
			content: '¿Desea borrar el registro seleccionado?',
			buttons: {
				Aceptar: function () {
					var parametros={
						"id":id,
						"iddest":iddest,
						"function":funcion
					};
					$.ajax({
						data:  parametros,
						url: lugar,
						type:  'post',
						beforeSend: function () {
							
						},
						success:  function (response) {
							if (!isNaN(response)){
								if (destino != undefined) {
									$("#"+div).html("");
									$.ajax({
										data:  {"id":iddest},
										url:   destino,
										type:  'post',
										beforeSend: function () {
											
										},
										success:  function (response) {
											$("#"+div).html(response);
										}
									});
								}
								Swal.fire({
								  type: 'success',
								  title: "Se eliminó correctamente",
								  showConfirmButton: false,
								  timer: 700
								});
								
							}
							else{
								alert(response);
							}
						}
					});
				},
				Cancelar: function () {
					$.alert('Canceled!');
				}
			}
		});		
	});
	$(document).on("change","#yearx_val",function(e){
		e.preventDefault();
		var id=$(this).val();
		$.ajax({
			data:  {
			"id":id,"function":"anioc"},
			url:   "acceso_db.php",
			type:  'post',
			beforeSend: function () {
			},
			success:  function (response) {
				$("#contenido").load('escritorio/dashboard.php');
				Swal.fire({
				  type: 'success',
				  title: response,
				  showConfirmButton: false,
				  timer: 1000
				});
			}
		});
	});
	$(document).on("click","[id^='delfile_']",function(e){
		e.preventDefault();
		var ruta = $(this).data('ruta');
		var keyt = $(this).data('keyt');
		var key = $(this).data('key');
		var tabla = $(this).data('tabla');
		var campo = $(this).data('campo');
		var tipo = $(this).data('tipo');
		var iddest = $(this).data('iddest');
		var divdest = $(this).data('divdest');
		var dest = $(this).data('dest');
		var borrafile=0;
		if ( $(this).data('borrafile') ) {
			borrafile=$(this).data('borrafile');
		}
		
		
		var parametros={
			"ruta":ruta,
			"keyt":keyt,
			"key":key,
			"tabla":tabla,
			"campo":campo,
			"tipo":tipo,
			"borrafile":borrafile,
			"function":"eliminar_file"
		}; 
		
		$.confirm({
			title: 'Eliminar',
			content: '¿Desea eliminar el archivo?',
			buttons: {
				Aceptar: function () {
					$.ajax({
						url: "acceso_db.php",
						type: "POST",
						data: parametros
					}).done(function(echo){
						
						if (!isNaN(echo)){
							$("#"+divdest).load(dest+iddest);
							Swal.fire({
							  type: 'success',
							  title: "Se eliminó correctamente",
							  showConfirmButton: false,
							  timer: 1000
							})
						}
						else{
							$.alert(echo);
						}
					});
				},
				Cancelar: function () {
					$.alert('Canceled!');
				}
			}
		});	
	});
	$(document).on("click","[id^='winmodal_']",function(e){
		e.preventDefault();
		$('#myModal').modal({backdrop: 'static', keyboard: false})
		$('#myModal').modal('show');
		var id = "0";
		var id2 = "0";
		var id3 = "0";
		var lugar = $(this).data('lugar');
		
		if ( $(this).data('id') ) {	
			id = $(this).data('id');
		}
		if ( $(this).data('id2') ) {	
			id2 = $(this).data('id2');
		}
		if ( $(this).data('id3') ) {	
			id3 = $(this).data('id3');
		}
		$.ajax({
			data:  {"id":id,"id2":id2,"id3":id3},
			url:   lugar+".php",
			type:  'post',
			beforeSend: function () {
				$("#modal_form").html("<div class='container' style='background-color:white; width:300px'>Cargando...</div>");
			},
			success:  function (response) {
				$("#modal_form").html(response);
			}
		});
	});
	
	
	$(document).on('submit','#acceso',function(e){
		e.preventDefault();
		var tipo=1;
		var userAcceso=document.getElementById("userAcceso").value;
		var passAcceso=$.md5(document.getElementById("passAcceso").value);
		
		var parametros={
			"tipo":tipo,
			"function":"acceso",
			"userAcceso":userAcceso,
			"passAcceso":passAcceso
		}; 
		
		var btn=$(this).find(':submit');
		$(btn).attr('disabled', 'disabled');
		var tmp=$(btn).children("i").attr('class');
		$(btn).children("i").removeClass();
		$(btn).children("i").addClass("fas fa-spinner fa-pulse");

		$.ajax({
			url: "acceso_db.php",
			type: "POST",
			data: parametros
		}).done(function(echo){
			if (echo==1){
				window.location.replace("");
			}
			else{
				Swal.fire({
					  type: 'error',
					  title: echo,
					  showConfirmButton: false,
					  timer: 1000
				})
			}
			$(btn).children("i").removeClass();
			$(btn).children("i").addClass(tmp);
			$(btn).prop('disabled', false);
		});
	});
	$(document).on("click",'#recuperar',function(e){
		e.preventDefault();
		$.ajax({
			url:   'acceso/recuperar.php',
			  beforeSend: function () {
				$("#data").html("Procesando, espere por favor...");
			  },
			  success:  function (response) {
				$("#data").html('');
				$("#data").html(response);
			  }
		});
	});
	$(document).on('submit','#recovery',function(e){
			e.preventDefault();
			var telefono=document.getElementById("userAcceso").value;
			telefono=telefono.trim();
			if(telefono.length>2){
				var btn=$(this).find(':submit')
				$(btn).attr('disabled', 'disabled');
				var tmp=$(btn).children("i").attr('class');
				$(btn).children("i").removeClass();
				$(btn).children("i").addClass("fas fa-spinner fa-pulse");
				
				var tipo=2;
				var parametros={
					"function":"recuperar",
					"tipo":tipo,
					"telefono":telefono
				}; 
				$.ajax({
					url: "acceso_db.php",
					type: "post",
					data: parametros,
					beforeSend: function(objeto){
						$(btn).children("i").addClass(tmp);
					},
					success:function(response){
						if (response == "") {
							Swal.fire({
							  type: "error",
							  title: response,
							  showConfirmButton: false,
							  timer: 1000
							});
							
						} else {
							Swal.fire({
							  type: 'success',
							  title: response,
							  showConfirmButton: false,
							  timer: 3000
							});
						}	
						$(btn).children("i").removeClass();
						$(btn).children("i").addClass(tmp);
						$(btn).prop('disabled', false);
					}
				});
			}
			else{
				$( "#telefono" ).focus();
				$( "#telefono" ).val("");
			}
		});
	
	
	