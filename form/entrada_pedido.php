<?php
	require_once("control_db.php");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	$bdd = new Venta();
	
	$id = $_REQUEST['id'];

	$entrada = $bdd->entrada($id);
	$estado=$entrada['estado'];
	$pedido = $bdd->entrada_pedido($id);
	
	
	echo "<table class='table'>";
	echo "<tr>
	<th>Codigo</th>
	<th>Clave</th>
	<th>Nombre</th>
	<th><center>Pendientes X entregar</center></th>
	<th><center>Entregados</center></th>
	<th><center>Cantidad</center></th>
	<th>Precio</th>
	<th>Total</th>
	<th>--</th></tr>";
	$gtotal=0;
	$idpaquete=0;
	$contar=1;
	
	for($i=0;$i<count($pedido);$i++){
		echo "<tr id='".$pedido[$i]['id']."' class='edit-t'>";
		echo "<td>".$pedido[$i]['codigo']."</td>";
		echo "<td>".$pedido[$i]['clave']."</td>";
		echo "<td>".$pedido[$i]['nombre'];
			if(strlen($pedido[$i]['observaciones'])>0){
				echo "<br><span style='font-size:10px;font-weight: bold;'>".$pedido[$i]['observaciones']."</span>";
			}
			if(strlen($pedido[$i]['color'])>0){
				echo "<br><span style='font-size:10px;font-weight: bold;'>".$pedido[$i]['color']."</span>";
			}
			if(strlen($pedido[$i]['tipo'])>0){
				echo " - <span style='font-size:10px;font-weight: bold;'>".$pedido[$i]['tipo']."</span>";
			}
		echo "</td>";
		echo "<td align='center'>".$pedido[$i]['pendiente']."</td>";
		echo "<td align='center'>".$pedido[$i]['cantidad']."</td>";
		echo "<td align='center'>".number_format($pedido[$i]['gtotal'],2)."</td>";
		echo "<td >".number_format($pedido[$i]['precio'],2)."</td>";
		
			$total=$pedido[$i]['gtotal'];
			echo "<td >";
				echo number_format($total,2);
			echo "</td>";
			$gtotal+=$total;
			
			echo "<td class=edit>";
			
			if($estado=="Activa"){
				echo '<div class="btn-group"><a id="remove" class="btn btn-info btn-fill btn-sm"><i class="fas fa-trash-alt"></i></a>';
				echo '<div class="btn-group"><a id="observaciones" class="btn btn-info btn-fill btn-sm" title="Agregar notas"><i class="far fa-file-alt"></i></a>';
				/*
				if($pedido[$i]['pendiente']>0){
					$sql="select COALESCE(sum(cantidad),0) as total from et_bodega where et_bodega.id_invent='".$pedido[$i]['id_invent']."' and et_bodega.idtienda='".$pedido[$i]['idtienda']."'";
					$exis = $bdd->general($sql);
					
					if($exis['total']==$pedido[$i]['pendiente']){
						echo '<a id="entregar_ve" class="btn btn-info btn-fill btn-sm" data-toggle="modal" data-target="#entregar"><i class="fas fa-arrow-circle-right"></i> Entrega</a>';
					}
				}
				*/
			}
			
			echo "</td>";
		echo "</tr>";
	}
	
	
	$subtotal=$gtotal/1.16;
	$iva=$gtotal-$subtotal;
	
	
	$values = array('total'=>$gtotal);
	$bdd->update('et_entrada',array('identrada'=>$id), $values);
?>
<div class='col-md-12'>
   <table style="float: right;margin-right: 70px;">
      <tr>
         <td><span class="pull-right">SUBTOTAL $</span></td>
         <td><span class="pull-right"><input class="form-control" value='<?php echo number_format($subtotal,2); ?>' disabled readonly style="direction: rtl;" /></span></td>
         <td></td>
      </tr>
      <tr>
         <td ><span class="pull-right">IVA 16 %</span></td>
         <td><span class="pull-right"><input class="form-control" value='<?php echo number_format($iva,2); ?>' disabled readonly style="direction: rtl;" /></span></td>
         <td></td>
      </tr>
      <tr>
         <td ><span class="pull-right">TOTAL $</span></td>
         <td><span class="pull-right" value="0"><input class="form-control" value='<?php echo number_format($gtotal,2); ?>' disabled readonly style="direction: rtl;" /></span></td>
         <td></td>
      </tr>

		  
   </table>
</div>