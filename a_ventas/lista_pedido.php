<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];
	$venta = $db->venta($id);
	$pedido = $db->ventas_pedido($id);

	$estado=$venta['estado'];
	$gtotal=$venta['total'];
	$subtotal=$venta['subtotal'];
	$iva=$venta['iva'];
	echo "<div id='tablax'>";
		echo "<div class='row' >";
			echo "<div class='col-1'>";

			echo "</div>";
			echo "<div class='col-3'>";
				echo "<B>NOMBRE</B>";
			echo "</div>";

			echo "<div class='col-2'>";
				echo "<B>CLAVE</B>";
			echo "</div>";

			echo "<div class='col-2'>";
				echo "<center><B>CANTIDAD</B></center>";
			echo "</div>";
			echo "<div class='col-2'>";
				echo "<B>PRECIO</B>";
			echo "</div>";
			echo "<div class='col-2'>";
				echo "<B>TOTAL</B>";
			echo "</div>";
		echo "</div>";

	foreach($pedido as $key){
		echo "<div class='row' id='div_".$key['id']."'>";
			echo "<div class='col-1'>";
				if($estado=="Activa"){

					echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_pedido' onclick='borra_venta(".$key['id'].")'><i class='far fa-trash-alt'></i></i></button>";

					//echo '<div class="btn-group"><a id="observaciones" class="btn btn-info btn-fill btn-sm" title="Agregar notas"><i class="far fa-file-alt"></i></a>';
				}
			echo "</div>";
			echo "<div class='col-3'>";
				echo $key['nombre'];
				if(strlen($key['observaciones'])>0){
					echo "<br><span style='font-size:10px;font-weight: bold;'>".$key['observaciones']."</span>";
				}
			echo "</div>";

			echo "<div class='col-2'>";
				echo "<span style='font-size:12px'>";
				echo "<B>IMEI:</B>".$key["clave"]." / ";
				echo "<B>BARRAS:</B>".$key["codigo"]." / ";
				echo "<B>RAPIDO:</B>".$key["rapido"];
			echo "</div>";

			echo "<div class='col-2 text-center'>";
				echo number_format($key['total']);
			echo "</div>";

			echo "<div class='col-2 text-right'>";
				echo number_format($key['pventa'],2);
			echo "</div>";

			$total=$key['gtotalv'];
			echo "<div class='col-2 text-right'>";
				echo number_format($total,2);
			echo "</div>";
		echo "</div>";
	}
	echo "</div>";
?>
<div class='col-md-12'>
   <table style="float: right;margin-right: 10px;">
      <tr>
         <td><span class="pull-right">SUBTOTAL $</span></td>
         <td><span class="pull-right"><input class="form-control" id="sub_x" name="sub_x" value='<?php echo number_format($subtotal,2); ?>' disabled readonly style="direction: rtl;" /></span></td>
         <td></td>
      </tr>
      <tr>
         <td ><span class="pull-right">IVA 16 %</span></td>
         <td><span class="pull-right"><input class="form-control" id="iva_x" name="iva_x" value='<?php echo number_format($iva,2); ?>' disabled readonly style="direction: rtl;" /></span></td>
         <td></td>
      </tr>
      <tr>
         <td ><span class="pull-right">TOTAL $</span></td>
         <td><span class="pull-right" value="0"><input class="form-control" id="total_x" name="total_x" value='<?php echo number_format($gtotal,2); ?>' disabled readonly style="direction: rtl;" /></span></td>
         <td></td>
      </tr>
   </table>
</div>
