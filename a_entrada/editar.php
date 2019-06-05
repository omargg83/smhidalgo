<?php
	require_once("db_.php");
  $id=$_REQUEST['id'];
	$proveedores = $db->proveedores_lista();
	$compras = $db->compras_lista();
	$i=0;
	if($id>0){
		$pd = $db->entrada($id);
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
    <div class='card-header'>Entrada de productos #<?php echo $id; ?></div>
    <form action="" id="form_cliente" data-lugar="a_entrada/db_" data-funcion="guardar_entrada" data-destino='a_entrada/editar'>
		<div class='card-body'>
      <div class='row'>
				<div class='col-2'>
					<label>Entrada:</label>
					<input type="text" name="id" id="id" value="<?php echo $id?>" class="form-control" readonly>
				</div>
        <div class="col-3">
          <label >Folio de Factura:</label>
          <input type="text" class="form-control" name="numero" id="numero" value="<?php echo $numero ;?>" placeholder="Número de Factura">
        </div>
        <div class="col-3">
				  <label >Proveedor:</label>
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
        <div class="col-3">
				  <label >Compras:</label>
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
        <div class="col-2">
         <label>Estado:</label>
          <select class="form-control" name="estado" id="estado">
            <option value="Activa"<?php if($estado=="Activa") echo "selected"; ?> >Activa</option>
            <option value="Finalizada"<?php if($estado=="Finalizada") echo "selected"; ?> >Finalizada</option>
          </select>
        </div>
      </div>
    </div>
    <div class='card-footer'>
      <div class="row">
        <div class="col-sm-12">
          <div class="btn-group">
		          <button class="btn btn-outline-secondary btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
              <?php
                if($id>0 and $estado=="Activa"){
                    echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='0' data-id2='$id' data-lugar='a_entrada/form_producto'><i class='fas fa-plus'></i> Productos</button>";
                }
              ?>
              <button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_entrada/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
           </div>
         </div>
      </div>
    </div>
		</form>
    <?php

      if($id>0){
        echo "<div class='card-body' id='pedidos'>";
          include 'form_pedido.php';
        echo "</div>";
      }

    ?>
		</div>
	</div>
