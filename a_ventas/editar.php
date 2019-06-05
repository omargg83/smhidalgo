<?php 
	require_once("../form/control_db.php");
	$bdd = new Venta();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	$clientes = $bdd->clientes_lista();
	$tiendas = $bdd->tiendas_lista();
	$descuento = $bdd->descuento_lista();
	
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
		$pd = $bdd->venta($id);
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
		<div class='card-body'>
			<form>
				<div class="header">
					<h4 class="title">Editar Venta</h4>
					<hr>
				</div>
				<div class="form-group row">
				   <label class="col-2 col-form-label" for="">Numero:</label>
				    <div class="col-10">
					 <input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de compra" required readonly>
				   </div>
				 </div>

				<div class="form-group row">
				  <label class="control-label col-sm-2" for="">Cliente:</label>
				  <div class="col-sm-10">
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
				</div>
				
				<div class="form-group row">
				  <label class="control-label col-sm-2">Tienda:</label>
				  <div class="col-sm-10">
					<?php
					  echo "<select class='form-control' name='idtienda' id='idtienda' readonly>";
						echo '<option disabled>Seleccione una tienda</option>';
						for($i=0;$i<count($tiendas);$i++){
							echo '<option value="'.$tiendas[$i]['id'].'"';
							if($tiendas[$i]['id']==$idtienda){
								echo " selected";
							}
							echo '>'.$tiendas[$i]["nombre"].'</option>';
						}
					  echo "</select>";
					?>
				  </div>
				</div>
				
				<div class="form-group row">
				  <label class="control-label col-sm-2">Forma de pago:</label>
				  <div class="col-sm-10">
					<?php
					  echo "<select class='form-control' name='iddescuento' id='iddescuento' required>";
						echo '<option disabled>Seleccione tipo de pago</option>';
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
				</div>
				<div class="form-group row">
				   <label class="control-label col-sm-2">Factura:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control" name="factura" id="factura" value="<?php echo $factura ;?>" placeholder="Factura">
				   </div>
				 </div>
				
				<div class="form-group row">
					<label class="control-label col-sm-2">Entregar:</label>
					 <div class="col-sm-10">
					<input type="checkbox" class="form-control" name="entregarp" id="entregarp" value="1"  <?php if($entregar==1) echo " checked"; ?>   >
					</div>
				</div>
				
				<div class="form-group row">
				   <label class="control-label col-sm-2">Lugar:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control" name="lugar" id="lugar" value="<?php echo $lugar ;?>" placeholder="Lugar de entrega">
				   </div>
				 </div>
				 
				 <div class="form-group row">
				  <label class="control-label col-sm-2">Estado:</label>
				  <div class="col-sm-10">
					<?php
					  echo "<select class='form-control' name='estado' id='estado' required>";
						echo '<option disabled>Seleccione un descuento</option>';
						  echo '<option value="Activa"'; if($estado=="Activa"){ echo " selected"; } echo '>Activa</option>';
						  echo '<option value="Pagada"'; if($estado=="Pagada"){ echo " selected"; } echo '>Pagada</option>';
						  echo '<option value="Cerrada"'; if($estado=="Cerrada"){ echo " selected"; } echo '>Cerrada</option>';
					  echo "</select>";
					
					?>
				  </div>
				</div>
				
				
				<div class="form-group row">
					<div class="col-sm-12">
						<button class="btn btn-info btn-fill pull-left" type='submit' id='guardar_ventas'><i class="far fa-save"></i> Guardar</button>
					</div>
				</div>
			</form>
				
		</div>
	</div>
</div>
<div id='alertas'></div>
