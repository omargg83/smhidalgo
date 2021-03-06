<?php
require_once("db_.php");
$id=$_REQUEST['id'];
if($id>0){
	$pd = $db->traspaso($id);
	$id=$pd['id'];
	$nombre=$pd['nombre'];
	$idde=$pd['idde'];
	$idpara=$pd['idpara'];
	$estado=$pd['estado'];
	$fecha=fecha($pd['fecha']);
}
else{
	$id=0;
	$nombre="";
	$idde=$_SESSION['idtienda'];
	$idpara=$_SESSION['idtienda'];
	$estado="Activa";
	$fecha=date("d-m-Y");
}
$readonly="";
if($estado!="Activa"){
	$readonly="readonly";
}

?>

<div class="container">
	<div class='card'>
		<form action="" id="form_traspaso" data-lugar="a_inventario/db_" data-funcion="guardar_traspaso" data-destino='a_inventario/form_traspaso'>
			<div class='card-header'>Traspaso <?php echo $id; ?></div>
			<div class='card-body'>
				<div class='row'>
					<div class='col-2'>
						<label>Numero:</label>
						<input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de traspaso" readonly>
					</div>
					<div class='col-3'>
						<label>Nombre:</label>
						<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre del traspaso" required <?php echo $readonly ;?> >
					</div>

					<div class='col-3'>

						<?php
						if($idde==$_SESSION['idtienda']){
							$tienda = $db->tiendas_global();
							echo "<label>Para:</label>";
						}
						else{
							$tienda = $db->tiendas_global($idde);
							echo "<label>De:</label>";
						}
							echo "<select class='form-control' name='idpara' id='idpara' $readonly>";
							for($i=0;$i<count($tienda);$i++){
								echo '<option value="'.$tienda[$i]['id'].'"';
								if($tienda[$i]['id']==$idpara){
									echo " selected";
								}
								echo '>'.$tienda[$i]['nombre'].'</option>';
							}
							echo "</select>";

						?>
					</div>
					<div class='col-2'>
						<label>Estado:</label>
						<input type="text" class="form-control" name="estado" id="estado" value="<?php echo $estado ;?>" placeholder="Estado del traspaso" readonly >
					</div>

					<div class='col-2'>
						<label>Fecha:</label>
						<input type="text" class="form-control" name="fecha" idfechaid" value="<?php echo $fecha ;?>" placeholder="Numero de traspaso" readonly>
					</div>
				</div>

			</div>
			<div class='card-footer'>
				<div class='row'>
					<div class='col-12'>
						<div class="btn-group">
							<?php
							if($estado=="Activa"){
								echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>";
							}
							if($id>0 and $estado=="Activa"){
								echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='0' data-id2='$id' data-lugar='a_inventario/form_producto'><i class='fas fa-plus'></i> Productos</button>";
								echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='enviatraspaso()'><i class='fas fa-car-side'></i> Enviar</button>";
							}
							?>
							<button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_inventario/traspasos' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php
		if($id>0){
			echo "<div class='card-body' id='movimientos'>";
			include 'lista_traspasos.php';
			echo "</div>";
		}
		?>
	</div>
</div>
