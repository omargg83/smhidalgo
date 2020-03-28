<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];
	$venta="";
	$pedido="";
	$estado="";
	$gtotal="0";
	$subtotal="0";
	$iva="0";

	if($id>0){
		$pedido = $db->ventas_pedido($id);
		$estado=$pd['estado'];
		$gtotal=$pd['total'];
		$subtotal=$pd['subtotal'];
		$iva=$pd['iva'];
	}

	echo "<div id='tablax'>";
		echo "<div class='row' >";
			echo "<div class='col-1'>";

			echo "</div>";
			echo "<div class='col-5'>";
				echo "<B>NOMBRE</B>";
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
		if($id>0){
			foreach($pedido as $key){
				echo "<div class='row' id='div_".$key['id']."'>";
					echo "<div class='col-1'>";
						if($estado=="Activa"){
							echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_pedido' data-lugar='a_ventas/db_' data-destino='a_ventas/editar' data-id='".$key['id']."' data-iddest='$id' data-funcion='borrar_venta' data-div='trabajo'><i class='far fa-trash-alt'></i></i></button>";
						}
					echo "</div>";
					echo "<div class='col-5'>";
						echo $key['nombre'];
						if(strlen($key['observaciones'])>0){
							echo "<br><span style='font-size:10px;font-weight: bold;'>".$key['observaciones']."</span>";
						}
					echo "</div>";

					echo "<div class='col-2 text-center'>";
						echo number_format($key['v_cantidad']);
					echo "</div>";

					echo "<div class='col-2 text-right'>";
						echo number_format($key['v_precio'],2);
					echo "</div>";

					$total=$key['v_total'];
					echo "<div class='col-2 text-right'>";
						echo number_format($key['v_total'],2);
					echo "</div>";
				echo "</div>";
			}
		}
?>
<div class='row'>
	<div class='col-10 text-right'>
		<b>SUBTOTAL $</b>
	</div>
	<div class='col-2'>
	  <span class="pull-right"><input class="form-control" id="sub_x" name="sub_x" value='<?php echo number_format($subtotal,2); ?>' disabled readonly style="direction: rtl;" />
	</div>
</div>
<div class='row'>
	<div class='col-10 text-right'>
		<b>IVA 16 %</b>
	</div>
	<div class='col-2'>
		<input class="form-control" id="iva_x" name="iva_x" value='<?php echo number_format($iva,2); ?>' disabled readonly style="direction: rtl;" />
	</div>
</div>
<div class='row'>
	<div class='col-10 text-right'>
		<b>TOTAL $</b>
	</div>
	<div class='col-2'>
		<input class="form-control" id="total_x" name="total_x" value='<?php echo number_format($gtotal,2); ?>' disabled readonly style="direction: rtl;" />
	</div>
</div>
