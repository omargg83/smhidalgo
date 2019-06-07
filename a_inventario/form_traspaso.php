<?php
require_once("db_.php");
$id=$_REQUEST['id'];
$tienda = $db->tiendas_lista();
if($id>0){
	$pd = $db->traspaso($id);
	$id=$pd['id'];
	$nombre=$pd['nombre'];
	$idde=$pd['idde'];
	$idpara=$pd['idpara'];
	$estado=$pd['estado'];
}
else{
	$id=0;
	$nombre="";
	$idde=0;
	$idpara=0;
	$estado="Activa";
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
					<div class='col-2'>
						<label>Nombre:</label>
						<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre del traspaso" required>
					</div>
					<div class='col-3'>
						<label>De:</label>
						<?php
						echo "<select class='form-control' name='idde' id='idde'>";
						echo '<option disabled>Seleccione sucursal</option>';
						for($i=0;$i<count($tienda);$i++){
							if($tienda[$i]['id']==$_SESSION['idtienda']){
								echo '<option value="'.$tienda[$i]['id'].'"';
								if($tienda[$i]['id']==$idde){
									echo " selected";
								}
								echo '>'.$tienda[$i]['nombre'].'</option>';
							}
						}
						echo "</select>";
						?>
					</div>
					<div class='col-3'>
						<label>Para:</label>
						<?php
						echo "<select class='form-control' name='idpara' id='idpara' >";
						echo '<option disabled>Seleccione sucursal</option>';
						for($i=0;$i<count($tienda);$i++){
							if($tienda[$i]['id']!=$_SESSION['idtienda']){
								echo '<option value="'.$tienda[$i]['id'].'"';
								if($tienda[$i]['id']==$idpara){
									echo " selected";
								}
								echo '>'.$tienda[$i]['nombre'].'</option>';
							}
						}
						echo "</select>";
						?>
					</div>
					<div class='col-2'>
						<label>Estado:</label>
						<select class="form-control" name="estado" id="estado">
							<option value="Activa"<?php if($estado=="Activa") echo "selected"; ?> >Activa</option>
							<option value="Enviada"<?php if($estado=="Enviada") echo "selected"; ?> >Enviada</option>
							<option value="Entregada"<?php if($estado=="Entregada") echo "selected"; ?> >Entregada</option>
						</select>
					</div>
				</div>

			</div>
			<div class='card-footer'>
				<div class='row'>
					<div class='col-12'>
						<div class="btn-group">
							<button class="btn btn-outline-secondary btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
							<?php
								if($id>0 and $estado=="Activa"){
										echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='0' data-id2='$id' data-lugar='a_inventario/form_producto'><i class='fas fa-plus'></i> Productos</button>";
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
