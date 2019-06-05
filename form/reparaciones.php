<?php
	require_once("control_db.php");
	$bdd = new Venta();
	$tiendas = $bdd->tiendas_lista();
?>
<div class="row">
	<div class="col-md-12">
		<div class="header">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand" href="#">Reparaciones</a>	
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="nav navbar-nav">
					<li class="nav-item">
						<?php
							$fhasta = date("d-m-Y");
							
							$fecha=date("d-m-Y");
			
							$nuevafecha = strtotime ( '-1 month' , strtotime ( $fhasta ) ) ;
							$fdesde = date ( "d-m-Y" , $nuevafecha );
	
						
							
							echo "<input class='form-control' type='text' id='fdesder' NAME='fdesder' value='$fdesde' maxlength='13' placeholder='Fecha'>";
						?>
					</li>	
					<li class="nav-item">	
						<?php
							echo "<input class='form-control' type='text' id='fhastar' NAME='fhastar' value='$fhasta' maxlength='13' placeholder='Fecha'>";
						?>
					</li>
					<li class="nav-item">
						<div class='btn-group'>
						
						</div>
					</li>
				</ul>
			</div>
		</nav>
		</div>
		<hr>
		<div id='trabajo'>
		</div>
	</div>
</div>

<script type="text/javascript">		
	$(document).ready(function(){
		var desde;
		var hasta;
		desde=document.getElementById("fdesder").value;
		hasta=document.getElementById("fhastar").value;
		$("#trabajo").load('form/reparaciones_lista.php?desde='+desde+'&hasta='+hasta);
		fecha_x();
	});
	
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
		 dateFormat: 'dd/mm/yy',
		 firstDay: 1,
		 isRTL: false,
		 showMonthAfterYear: false,
		 yearSuffix: ''
	};
	 
	function fecha_x() {
		$.datepicker.setDefaults($.datepicker.regional['es']);
		$("#fdesder").datepicker({ dateFormat: 'dd-mm-yy' });
		$("#fhastar").datepicker({ dateFormat: 'dd-mm-yy' });
	}
</script>

