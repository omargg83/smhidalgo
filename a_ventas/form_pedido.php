<?php
	require_once("db_.php");

	$venta = $db->venta($id);
	$pedido = $db->ventas_pedido($id);

	$estado=$venta['estado'];
	$adelanto=$venta['adelanto'];
	$restan=$venta['restan'];
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
		echo "<tr id='".$pedido[$i]['id']."' class='edit-t' unico='".$pedido[$i]['unico']."'>";
		echo "<td>".$pedido[$i]['codigo']."</td>";
		echo "<td>".$pedido[$i]['clave']."</td>";
		echo "<td>".$pedido[$i]['nombre'];
			if(strlen($pedido[$i]['observaciones'])>0){
				echo "<br><span style='font-size:10px;font-weight: bold;'>".$pedido[$i]['observaciones']."</span>";
			}
		echo "</td>";
		echo "<td align='center'>".$pedido[$i]['pendiente']."</td>";
		echo "<td align='center'>".$pedido[$i]['cantidad']."</td>";
		echo "<td align='center'>".number_format($pedido[$i]['total'])."</td>";
		echo "<td align='right'>".number_format($pedido[$i]['pventa'],2)."</td>";

			$total=$pedido[$i]['gtotalv'];
			echo "<td align='right'>";
				echo number_format($total,2);
			echo "</td>";
			$gtotal+=$total;

			echo "<td class=edit>";
			if($estado=="Activa"){
				echo '<div class="btn-group"><a id="remove" class="btn btn-info btn-fill btn-sm"><i class="fas fa-trash-alt"></i></a>';
				echo '<div class="btn-group"><a id="observaciones" class="btn btn-info btn-fill btn-sm" title="Agregar notas"><i class="far fa-file-alt"></i></a>';

			}
			echo "</td>";
		echo "</tr>";
	}


	$sql="select et_descuento.cantidad from et_descuento left outer join et_venta on et_venta.iddescuento=et_descuento.iddescuento where idventa='$id'";
	$desc = $db->general($sql);

	$subtotal=$gtotal/1.16;
	$iva=$gtotal-$subtotal;
	$descuento=1+($desc['cantidad']/100);
	$ttotal=$gtotal/$descuento;

	$values = array('subtotal'=>$subtotal, 'iva'=>$iva, 'total'=>$gtotal, 'descuento'=>$descuento, 'gtotal'=>$ttotal );
	$db->update('et_venta',array('idventa'=>$id), $values);
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
