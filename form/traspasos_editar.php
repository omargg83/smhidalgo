<?php 
	require_once("control_db.php");
	$bdd = new Venta();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	
	$tienda = $bdd->tiendas_lista();
	if($id>0){	
		$pd = $bdd->traspaso($id);
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
		<div class='card-body'>
			<form>
				<div class="header">
				<h4 class="title">Editar Traspaso</h4>
				<hr>
				</div>
			 
				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Numero:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de traspaso" readonly>
				   </div>
				 </div>
				 
				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Nombre:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre del traspaso" required>
				   </div>
				 </div>

				<div class="form-group row">
				  <label class="control-label col-sm-2" for="">De:</label>
				  <div class="col-sm-10">
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
				</div>
				
				<div class="form-group row">
				  <label class="control-label col-sm-2" for="">Para:</label>
				  <div class="col-sm-10">
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
				  </div><div class="form-group row">
				 <label class="control-label col-sm-2" for="">Estado:</label>
				  <div class="col-sm-10">
					<select class="form-control" name="estado" id="estado">
					  <option value="Activa"<?php if($estado=="Activa") echo "selected"; ?> >Activa</option>
					  <option value="Enviada"<?php if($estado=="Enviada") echo "selected"; ?> >Enviada</option>
					  <option value="Entregada"<?php if($estado=="Entregada") echo "selected"; ?> >Entregada</option>
					</select>
				  </div>
				</div>
				</div>
				
				

				<div class="form-group row">
					<div class="col-sm-12">
						<button class="btn btn-info btn-fill pull-left" type='submit' id='guardar_traspaso'><i class="far fa-save"></i> Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
