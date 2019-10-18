<?php
require_once("db_.php");
$id=$_REQUEST['id'];

$clientes = $db->clientes_lista();
//$tiendas = $db->tiendas_lista();
//$descuento = $db->descuento_lista();

if($id==0){
	$idtienda=$_SESSION['idtienda'];
	$idcliente=0;
	$iddescuento=0;

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
						foreach($clientes as $key){
							echo '<option value="'.$key['idcliente'].'"';
							if($key['idcliente']==$idcliente){
								echo " selected";
							}
							echo '>'.$key["razon_social_prove"].'</option>';
						}
						echo "</select>";
						?>
					</div>

					<div class='col-3'>
						<label>Estado:</label>
						<input type="text" class="form-control" name="estado" id="estado" value="<?php echo $estado ;?>" placeholder="Lugar de entrega" readonly>
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
									echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='0' data-id2='$id' data-lugar='a_ventas/form_producto'><i class='fas fa-plus'></i> Productos</button>";

                	if($id>0){
										echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='$id' data-lugar='a_ventas/finalizar'><i class='fas fa-cash-register'></i> Finalizar</button>";
									}
                }
								if($estado=="Pagada"){
									echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='imprime($id)'><i class='fas fa-print'></i>Imprimir</button>";
									echo "<button type='button' class='btn btn-outline-secondary btn-sm' title='Nuevo' id='new_personal' data-lugar='a_ventas/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></button>";
								}
              ?>
							<button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_ventas/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<?php

			echo "<div class='card-body' id='compras'>";
			include 'lista_pedido.php';
			echo "</div>";
		
		?>
	</div>
</div>
