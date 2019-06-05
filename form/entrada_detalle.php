<?php 
	require_once("control_db.php");
	$bdd = new Venta();
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}
	
	$pd = $bdd->entrada($id);

	$id=$pd['identrada'];
	$fecha=$pd['fecha'];
	$estado=$pd['estado'];
	
	$id_prove=$pd['id_prove'];
	$prove = $bdd->proveedor($id_prove);
?>
	<div class='container'>
		<div class='card'>
			<div class='card-header'>Entrada</div>
			<div class='card-body'>
				<div class='row'>
					<div class='col-2'>
						<label>Numero:</label>
						 <input type="text" class="form-control" name="id" id="id" value="<?php echo $id ;?>" placeholder="Numero de compra" readonly>
						 <input type="hidden" class="form-control" name="modulo" id="modulo" value="entrada"  readonly>
						 <input type="hidden" class="form-control" name="idtienda" id="idtienda" value="<?php echo $_SESSION['idtienda'] ;?>"  readonly>
				   </div>
				   <div class='col-2'>
						<label >Fecha:</label>
						<input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha ;?>" placeholder="Fecha" readonly>
				   </div>
				   <div class='col-2'>
						<label >Proveedor:</label>
						<input type="text" class="form-control" name="cliente" id="cliente" value="<?php echo $prove['razon_social_prove'] ;?>" placeholder="Proveedor" readonly>
				   </div>
			   </div>
			</div>  
			<div class='card-body'>
				<div class='btn-group'>
			   <?php
					if($estado=="Activa"){
				?>
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
					 <i class="fas fa-plus"></i> Productos
					</button>
				
				<?php
					}
				?>
					<button type="button" class="btn btn-info" id='imprimir_entrada'>
						<i class="fas fa-print"></i> Imprimir
					</button>
				</div>  	
			</div>  	
				
			<div class='card-body' id='pedido'>
			
			</div>
		</div>
	 </div>
	 
	  <!-- Modal -->
            <div class="modal fade bs-example-modal-xs" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
                  </div>
                  <div class="modal-body">
                    
						<div class='row'>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="q_prod" placeholder="Buscar productos" onkeyup="buscar_prod()" autocomplete=off>
							</div>
							<div class="col-sm-2">
								<button type="button" class="btn btn-info btn-sm" onclick="buscar_prod()"><i class="fab fa-searchengin"></i> Buscar</button>
							</div>
						</div>
                  
                    <div id="loader" style="position: absolute; text-align: center; top: 55px;  width: 100%;display:none;"></div><!-- Carga gif animado -->
                    <div class="outer_div" style='height:350px; overflow:auto;'>
					
					</div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
			
<script type="text/javascript">		
	$(document).ready(function(){
		var id;
		id=document.getElementById("id").value;
		$("#pedido").load('form/entrada_pedido.php?id='+id);
	});
 </script>