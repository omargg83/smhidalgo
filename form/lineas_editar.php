<?php 
	require_once("control_db.php");
	$bdd = new Venta();
		
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	$i=0;
	$pd = $bdd->bodega($id);
	
	$id=$pd['id'];
	$descripcion=$pd['descripcion'];
	$observaciones2=$pd['observaciones2'];
	$lineapagada=$pd['lineapagada'];
	if(strlen($pd['fpago'])>1){
		$fecha = $pd['fpago'];
		list($anyo,$mes,$dia) = explode("-",$fecha);
		$fpago=$dia."-".$mes."-".$anyo;
	}
	else{
		$fpago = date("d-m-Y");
	}
?>
<div class="container">
	<div class='card'>
		<div class='card-body'>
			<form>
				<div class="header">
					<h4 class="title">Editar Productos</h4>
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					<input type="hidden" name="idpersona" id="idpersona" value="<?php echo $_SESSION['idusuario']?>">
					<hr>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2">Descripción:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="descripcion" id="descripcion" value="<?php echo $descripcion ;?>" placeholder="Descripción">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-sm-2">Estado:</label>
					<div class="col-sm-10">
					<?php
						echo "<select class='form-control' name='lineapagada' id='lineapagada'>";
							echo "<option value=''"; if ($lineapagada=='') { echo "selected";} echo ">Pendiente</option>";
							echo "<option value='Pagada' "; if ($lineapagada=='Pagada') { echo "selected";} echo ">Pagada</option>";
						echo "</select>";
					?>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-sm-2">Fecha de pago:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="fpago" id="fpago" value="<?php echo $fpago ;?>" placeholder="Descripción">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-sm-2">Observaciones:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="observaciones2" id="observaciones2" value="<?php echo $observaciones2 ;?>" placeholder="Observaciones">
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-sm-12 btn-group">
						<button class="btn btn-info btn-fill pull-left" id='guardar_lineabodega'><i class="far fa-save"></i> Guardar</button>
						
					</div>
				</div>
			</form>
		</div>
	</div>
</form>
<script type="text/javascript">	
	$(document).ready(function(){
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
		$("#fpago").datepicker({ dateFormat: 'dd-mm-yy' });
		
	}
 </script>