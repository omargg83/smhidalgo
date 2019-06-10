<?php
require_once("db_.php");
$id=$_REQUEST['id'];

$clientes = $db->clientes_lista();
$tiendas = $db->tiendas_lista();
$descuento = $db->descuento_lista();

if($id==0){
	$idtienda=$_SESSION['idtienda'];
	$idcliente=0;
	$iddescuento=0;
	$factura="";
	$lugar="";
	$dentrega=date("Y-m-d H:i:s");
	$entregar=0;
	$estado="Activa";
}
else{
	$pd = $db->venta($id);
	$id=$pd['idventa'];
	$idcliente=$pd['idcliente'];
	$idtienda=$pd['idtienda'];
	$iddescuento=$pd['iddescuento'];
	$lugar=$pd['lugar'];
	$entregar=$pd['entregar'];
	$dentrega=$pd['dentrega'];
	$estado=$pd['estado'];
	$factura=$pd['factura'];
}
?>
<div class="container">
	<div class='card'>
		<form action="" id="form_venta" data-lugar="a_ventas/db_" data-funcion="guardar_venta" data-destino='a_ventas/editar'>
			<div class='card-header'>Venta <?php echo $id; ?></div>
			<div class='card-body'>
				<div class='row'>
					<div class='col-2'>
						<label >Numero:</label>
						<input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de compra" required readonly>
					</div>
					<div class='col-4'>
						<label >Cliente:</label>
						<?php
						echo "<select class='form-control' name='idcliente' id='idcliente'>";
						echo '<option disabled>Seleccione el cliente</option>';
						for($i=0;$i<count($clientes);$i++){
							echo '<option value="'.$clientes[$i]['idcliente'].'"';
							if($clientes[$i]['idcliente']==$idcliente){
								echo " selected";
							}
							echo '>'.$clientes[$i]["razon_social_prove"].'</option>';
						}
						echo "</select>";
						?>
					</div>

					<div class='col-3'>
						<label>Factura:</label>
						<input type="text" class="form-control" name="factura" id="factura" value="<?php echo $factura ;?>" placeholder="Factura">
					</div>

					<div class='col-3'>
						<label>Estado:</label>
						<input type="text" class="form-control" name="estado" id="estado" value="<?php echo $estado ;?>" placeholder="Lugar de entrega" readonly>
					</div>

					<div class='col-3'>
						<label>Forma de pago:</label>
						<?php
						echo "<select class='form-control' name='iddescuento' id='iddescuento' required>";
						for($i=0;$i<count($descuento);$i++){
							echo '<option value="'.$descuento[$i]['iddescuento'].'"';
							if($descuento[$i]['iddescuento']==$iddescuento){
								echo " selected";
							}
							echo '>'.$descuento[$i]["nombre"].' ('.$descuento[$i]['cantidad'].'%)</option>';
						}
						echo "</select>";
						?>
					</div>

					<div class='col-3'>
						<label>Entregar:</label>
						<input type="checkbox" class="form-control" name="entregarp" id="entregarp" value="1"  <?php if($entregar==1) echo " checked"; ?>   >
					</div>

					<div class='col-3'>
						<label>Entregar:</label>
						<input type="text" class="form-control" name="lugar" id="lugar" value="<?php echo $lugar ;?>" placeholder="Lugar de entrega">
					</div>

				</div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<div class='btn-group'>
							<?php
								if($estado=="Activa"){
									echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>";
								}
                if($id>0 and $estado=="Activa"){
                    echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='0' data-id2='$id' data-lugar='a_ventas/form_producto'><i class='fas fa-plus'></i> Productos</button>";
                }
								if($estado=="Pagada"){
									echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='imprime($id)'><i class='fas fa-print'></i>Imprimir</button>";
								}
              ?>
							<button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_ventas/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<?php
		if($id>0){
			echo "<div class='card-body' id='compras'>";
			include 'lista_pedido.php';
			echo "</div>";
		}
		?>
	</div>
</div>
