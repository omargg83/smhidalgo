<?php 
	require_once("control_db.php");
	$bdd = new Venta();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	$proveedores = $bdd->proveedores_lista();
	$compras = $bdd->compras_lista();
	$i=0;
	if($id>0){
		$pd = $bdd->entrada($id);
		$id=$pd['identrada'];
		$numero=$pd['numero'];
		$id_prove=$pd['id_prove'];
		$idcompra=$pd['idcompra'];
		$estado=$pd['estado'];
	}
	else{
		$id=0;
		$id_prove=1;
		$idcompra=1;
		$numero="";
		$estado="Activa";
	}
?>
<div class="container">
	<div class='card'>
		<div class='card-body'>
			<form>
				<div class="header">
					<h4 class="title">Editar Factura entrada</h4>
				</div>

				<div class="form-group row">
					<label class="control-label col-sm-2">Entrada:</label>
					<div class="col-sm-10">
						<input type="text" name="id" id="id" value="<?php echo $id?>" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2">Folio de Factura:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="numero" id="numero" value="<?php echo $numero ;?>" placeholder="Número de Factura">
					</div>
				</div>
				
				<div class="form-group row">
				  <label class="control-label col-sm-2" for="">Proveedor:</label>
				  <div class="col-sm-10">
					<?php
						echo "<select class='form-control' name='id_prove' id='id_prove'>";
						echo '<option disabled>Seleccione el cliente</option>';
						for($i=0;$i<count($proveedores);$i++){
							echo '<option value="'.$proveedores[$i]['id_prove'].'"';
							if($proveedores[$i]['id_prove']==$id_prove){
								echo " selected";
							}
							echo '>'.$proveedores[$i]["razon_social_prove"].'</option>';
						}
						echo "</select>";
					?>
				  </div>
				</div>
				
				<div class="form-group row">
				  <label class="control-label col-sm-2" for="">Compras:</label>
				  <div class="col-sm-10">
					<?php
						echo "<select class='form-control' name='idcompra' id='idcompra'>";
						echo '<option disabled>Seleccione el cliente</option>';
						for($i=0;$i<count($compras);$i++){
							echo '<option value="'.$compras[$i]['idcompra'].'"';
							if($compras[$i]['idcompra']==$idcompra){
								echo " selected";
							}
							echo '>'.$compras[$i]["idcompra"]."-".$compras[$i]["razon_social_prove"].'</option>';
						}
						echo "</select>";
					?>
				  </div>
				</div>
				<div class="form-group row">
				 <label class="control-label col-sm-2" for="">Estado:</label>
				  <div class="col-sm-10">
					<select class="form-control" name="estado" id="estado">
					  <option value="Activa"<?php if($estado=="Activa") echo "selected"; ?> >Activa</option>
					  <option value="Finalizada"<?php if($estado=="Finalizada") echo "selected"; ?> >Finalizada</option>
					</select>
				  </div>
				</div>
				
				<div class="form-group row">
					<div class="col-sm-12">
						<button class="btn btn-info btn-fill pull-left" type='submit' id='guardar_entrada'><i class="far fa-save"></i> Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</form>