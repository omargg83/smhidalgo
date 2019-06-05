<?php
	require_once("control_db.php");
	$bdd = new Venta();
	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	$q=$_REQUEST['q'];
	$idtienda=$_REQUEST['idtienda'];
	$modulo=$_REQUEST['modulo'];
		
	if($modulo=="compras" or $modulo=="entrada"){
		$sql="select et_invent.id_invent, et_invent.unico, et_invent.codigo, et_invent.nombre, et_invent.pvgeneral, et_invent.preciocompra from et_invent where (et_invent.unico=0 or et_invent.unico=1 ) and (et_invent.nombre like '%$q%' or et_invent.codigo like '%$q%') order by et_invent.unico desc limit 10";
	}
	if($modulo=="traspasos" or $modulo=="ventas"){
		$sql="SELECT et_bodega.id, et_invent.id_invent, et_invent.unico, et_invent.codigo, et_invent.nombre, et_invent.pvgeneral, et_bodega.clave,
			(SELECT if(unico!=1,COALESCE (sum(cantidad), 0),1) AS total FROM et_bodega WHERE et_bodega.id_invent = et_invent.id_invent AND et_bodega.idtienda = '".$_SESSION['idtienda']."') AS conteo, et_bodega.pventa, et_bodega.observaciones
			FROM et_bodega
				LEFT OUTER JOIN et_invent ON et_invent.id_invent = et_bodega.id_invent
				WHERE et_bodega.idtienda = '".$_SESSION['idtienda']."' and et_bodega.cantidad>0 AND (et_bodega.clave LIKE '%$q%' OR et_invent.codigo LIKE '%$q%' OR et_invent.nombre LIKE '%$q%')
				GROUP BY et_bodega.id_invent, et_bodega.clave";
	}
	if($modulo=="ventas"){
		$sql.=" union select '0' as id, et_invent.id_invent, et_invent.unico, et_invent.codigo, et_invent.nombre, et_invent.pvgeneral, null as clave, '1' as conteo, et_invent.pvgeneral as pventa, '' as observaciones from et_invent where (unico=2 or unico=3 or unico=4 )and (et_invent.nombre LIKE '%$q%' or et_invent.codigo LIKE '%$q%')";
	}
	// echo "modulo:".$modulo;
	// echo "<br>sql:".$sql;
	$row = $bdd->general2($sql);
	
	$unico="";
	echo "<div class='table-responsive'>";
		echo "<table class='table table-sm'>";
			echo "<tr>";
			echo "<th>Código</th>";
			if($modulo=="traspasos" or $modulo=="ventas"){
				echo "<th><span class='pull-right'>Clave</span></th>";
			}
			echo "<th>Descripción</th>";
			if($modulo=="ventas" or $modulo=="traspasos"){
				echo "<th>Existencias</th>";
			}
			echo "<th><span class='pull-right'>Cantidad</span></th>";
			
			if($modulo=="ventas"){
				echo "<th><span class='pull-right'>Precio</span></th>";
			}
			
			if($modulo=="entrada"){
				echo "<th><span class='pull-right'>Precio</span></th>";
				echo "<th><span class='pull-right'>Material</span></th>";
				echo "<th><span class='pull-right'>Color</span></th>";
				echo "<th><span class='pull-right'>Clave/IMEI</span></th>";
			}
			
			echo "<th><span class='pull-right'></span></th>";
			echo "</tr>";
			for($i=0;$i<count($row);$i++){
				$unico="";
				$id_producto=$row[$i]['id_invent'];
				$nombre_producto=$row[$i]['nombre'];
				$precio_venta=$row[$i]['pvgeneral'];
				if($modulo=="entrada"){
					$precio_compra=$row[$i]['preciocompra'];
				}
				if($modulo=="ventas"){
					$precio_venta=$row[$i]['pventa'];
				}
				
				if(isset($row[$i]['unico'])){ $unico=$row[$i]['unico']; } else { $unico=0; }
				if(isset($row[$i]['id'])){ $idbodega=$row[$i]['id']; } else { $idbodega=0; }
				if(isset($row[$i]['clave'])){ $clave=$row[$i]['clave']; } else { $clave=0; }
				
				echo "<tr class='edit-l' data-nombre='".$row[$i]['nombre']."' data-idproducto='".$id_producto."' data-unico='".$unico."' data-idbodega='".$idbodega."' data-clavedb='".$clave."' data-preciodb='".$precio_venta."' >";
				
				echo "<td>".$row[$i]['codigo']."</td>";
				if($modulo=="traspasos" or $modulo=="ventas"){
					echo "<td class='col-xs-2'>".$row[$i]['clave']."</td>";
				}
				
				echo "<td>".$row[$i]['nombre']."";
				if($modulo=="traspasos" or $modulo=="ventas"){
					echo "<br><span style='font-size:10px;font-weight: bold;'>";
					echo $row[$i]['observaciones'];
					echo "</span>";
				}
				echo "</td>";
				
				if($modulo=="ventas" or $modulo=="traspasos"){
					echo "<td class='col-xs-1'>
						<div class='pull-right'>
							<input type='text' class='form-control input-sm' style='text-align:right' id='existencias_".$id_producto."'  value='".$row[$i]['conteo']."' readonly>
						</div>
					</td>";
				}
				
				if($unico==1){
					$unico="readonly";
				}
				
				if($modulo=="compras"){
					$unico="";
				}
				
				echo "<td class='col-xs-1'>
					<div class='pull-right'>
						<input type='text' class='form-control input-sm' style='text-align:right' id='cantidad_".$id_producto."' value='1' $unico>
					</div>
				</td>";
				
				if($modulo=="ventas"){
					echo "<td class='col-xs-2'>
						<div class='pull-right'>
							<input type='text' class='form-control input-sm' style='text-align:right' id='precio_".$id_producto."'  value='$precio_venta'";
							if($unico==1 or $unico==0){
								echo " readonly";
							}
							echo ">
						</div>
					</td>";
				}
				
				if($modulo=="entrada"){
					echo "<td class='col-xs-2'>
						<div class='pull-right'>
							<input type='text' class='form-control input-sm' style='text-align:right' id='precio_".$id_producto."'  value='$precio_compra' >
						</div>
					</td>";

					echo "<td class='col-xs-2'>";
						echo "<select class='form-control' name='material_".$id_producto."' id='material_".$id_producto."'>";
							echo "<option value=''></option>";
							echo "<option value='PREPAGO'>PREPAGO</option>";
							echo "<option value='TARIFARIO'>TARIFARIO</option>";
							echo "<option value='AMIGO CHIP'>AMIGO CHIP</option>";
							echo "<option value='LIBRES'>LIBRES</option>";
							echo "<option value='CONSIGNA'>CONSIGNA</option>";
						echo "</select>";
					echo "</td>";
					
					echo "<td class='col-xs-2'>";
					if($unico=="readonly"){
						echo "<div class='pull-right'>
							<input type='text' class='form-control input-sm' id='color_".$id_producto."'  value='' placeholder='Color'>
						</div>";
					}
					echo "</td>";
					
					
					echo "<td class='col-xs-2'>";
					if($unico=="readonly"){
						echo "<div class='pull-right'>
							<input type='text' class='form-control input-sm' id='clave_".$id_producto."'  value='' placeholder='Clave'>
						</div>";
					}
					echo "</td>";
					
					
					
					
				}
				
				
				echo "<td class='col-xs-6'>";
					echo "<div class='btn-group'>";
					if($modulo=="compras" or $modulo=="traspasos" or $modulo=="entrada" or $modulo=="ventas"){
						echo "<a href='#' id='agregarc' class='btn btn-info btn-fill pull-left btn-sm'><i class='fas fa-plus'></i></a>";
					}
					
					if($modulo=="ventas"){
						//echo "<a href='#' onclick='agregar_compro(\"$id_producto\")' class='btn btn-info btn-fill pull-left btn-sm'><i class='far fa-question-circle'></i> Pendiente</a>";
					}
					echo "</div>";
				echo "</td>";
				echo "</tr>";
			}
		?>
	  </table>
	</div>