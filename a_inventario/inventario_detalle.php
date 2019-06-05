<?php 
	require_once("control_db.php");
	$bdd = new Venta();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}

	$pd = $bdd->inventario($id);
	$nombre=$pd['nombre'];
	
	$marca = $bdd->marca($pd['idmarca']);
	$marca=$marca['marca'];
	
	$modelo = $bdd->modelo($pd['idmodelo']);
	$modelo=$modelo['modelo'];
?>
<div class='container'>
	<div class='card'>
		<div class='card-header'>Inventario</div>
		<div class='card-body'>
			<div class='row'>
				<div class='col-2'>
					<label>Numero:</label>
					 <input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de compra" readonly>
					
			   </div>
			   <div class='col-4'>
					<label >Nombre:</label>
					<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre" readonly>
			   </div> 
			   <div class='col-4'>
					<label >Marca:</label>
					<input type="text" class="form-control" name="marca" id="marca" value="<?php echo $marca; ?>" placeholder="Nombre" readonly>
			   </div> 
			   <div class='col-4'>
					<label >Modelo:</label>
					<input type="text" class="form-control" name="modelo" id="modelo" value="<?php echo $modelo; ?>" placeholder="Nombre" readonly>
			   </div>
			  
		   </div>
		</div>  
		<div class='card-body' id='pedido'>

		</div>
			
	</div>
 </div>
	 
	  
<script type="text/javascript">		
	$(document).ready(function(){
		var id;
		id=document.getElementById("id").value;
		$("#pedido").load('form/inventario_pedido.php?id='+id);
	});
 </script>