<?php
	require_once("control_db.php");
	$bdd = new Venta();

	$tipo=$_POST['tipo'];

	if($tipo=="entrada"){		//////////////Guarda datos de factura de entrada
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['numero'])){$numero=$_POST['numero'];}
		if (isset($_POST['id_prove'])){$id_prove=$_POST['id_prove'];}
		if (isset($_POST['idcompra'])){$idcompra=$_POST['idcompra'];}
		if (isset($_POST['estado'])){$estado=$_POST['estado'];}
		if (isset($_POST['unico'])){$unico=$_POST['unico'];}

		$values = array('numero'=>$numero, 'id_prove'=>$id_prove, 'idcompra'=>$idcompra, 'estado'=>$estado );
		if($id==0){
			echo $bdd->insert('et_entrada', $values);
		}
		else{
			echo $bdd->update('et_entrada',array('identrada'=>$id), $values);
		}
	}
	if($tipo=="traspaso"){		//////////////Guarda datos de factura de entrada
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['nombre'])){$nombre=$_POST['nombre'];}
		if (isset($_POST['idde'])){$idde=$_POST['idde'];}
		if (isset($_POST['idpara'])){$idpara=$_POST['idpara'];}
		if (isset($_POST['estado'])){$estado=$_POST['estado'];}

		$values = array('nombre'=>$nombre, 'estado'=>$estado, 'idde'=>$idde, 'idpara'=>$idpara );

		if($id==0){
			echo $bdd->insert('et_traspaso', $values);
		}
		else{
			echo $bdd->update('et_traspaso',array('id'=>$id), $values);
		}

	}



	if($tipo=="ventas"){		//////////////Guarda datos de la venta
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['idcliente'])){$idcliente=$_POST['idcliente'];}
		if (isset($_POST['idtienda'])){$idtienda=$_POST['idtienda'];}
		if (isset($_POST['iddescuento'])){$iddescuento=$_POST['iddescuento'];}
		if (isset($_POST['lugar'])){$lugar=$_POST['lugar'];}
		if (isset($_POST['entregarp'])){$entregarp=$_POST['entregarp'];} else{$entregarp=0;}
		if (isset($_POST['estado'])){$estado=$_POST['estado'];}
		if (isset($_POST['factura'])){$factura=$_POST['factura'];}
		$date=date("Y-m-d H:i:s");

		$values = array('idcliente'=>$idcliente, 'idtienda'=>$idtienda,'iddescuento'=>$iddescuento,'lugar'=>$lugar, 'estado'=>$estado,'entregar'=>$entregarp, 'factura'=>$factura, 'fecha'=>$date);

		if($id==0){
			echo $bdd->insert('et_venta',$values);

		}
		else{
			echo $bdd->update('et_venta',array('idventa'=>$id), $values);
		}

	}


	
	if($tipo=="bodega"){		//////////////Guarda datos de bodega
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['clave'])){$clave=$_POST['clave'];}
		if (isset($_POST['descripcion'])){$descripcion=$_POST['descripcion'];}
		if (isset($_POST['color'])){$color=$_POST['color'];}
		if (isset($_POST['material'])){$material=$_POST['material'];}
		if (isset($_POST['pventa'])){$pventa=$_POST['pventa'];}
		$values = array("clave"=>$clave, "descripcion"=>$descripcion, "color"=>$color, "tipo"=>$material, "pventa"=>$pventa);
		echo $bdd->update('et_bodega',array('id'=>$id), $values);
	}
	if($tipo=="lineabodega"){		//////////////Guarda datos de bodega
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['observaciones2'])){$observaciones2=$_POST['observaciones2'];}
		if (isset($_POST['lineapagada'])){$lineapagada=$_POST['lineapagada'];}
		if (isset($_POST['fpago'])){$fpago=$_POST['fpago'];}
		if (isset($_POST['idpersona'])){$idpersona=$_POST['idpersona'];}

		list($dia,$mes,$anio)=explode("-",$fpago);
		$fpago=$anio."-".$mes."-".$dia;

		$values = array("observaciones2"=>$observaciones2, "lineapagada"=>$lineapagada, "fpago"=>$fpago, "idpersona"=>$idpersona);
		echo $bdd->update('et_bodega',array('id'=>$id), $values);
	}

	if($tipo=="agregaprod"){	//////////////Agrega producto a las compras/ventas/etc
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['idproducto'])){$idproducto=$_POST['idproducto'];}
		if (isset($_POST['modulo'])){$modulo=$_POST['modulo'];}
		if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
		if (isset($_POST['idtienda'])){$idtienda=$_POST['idtienda'];}
		if (isset($_POST['nombre'])){$nombre=$_POST['nombre'];}
		if (isset($_POST['precio'])){$precio=$_POST['precio'];}
		if (isset($_POST['clave'])){$clave=$_POST['clave'];}
		if (isset($_POST['unico'])){$unico=$_POST['unico'];}
		if (isset($_POST['idbodega'])){$idbodega=$_POST['idbodega'];}
		if (isset($_POST['precioventa'])){$precioventa=$_POST['precioventa'];}
		if (isset($_POST['color'])){$color=$_POST['color'];}
		if (isset($_POST['material'])){$material=$_POST['material'];}

		if($modulo=="compras"){
			$values = array('id_invent'=>$idproducto, 'idcompra'=>$id, 'cantidad_oc'=>$cantidad, 'precio_oc'=>0 );
			echo $bdd->insert('et_comprapedido', $values);
		}

		if($modulo=="entrada"){
			$num=$cantidad;
			$gtotal=$cantidad*$precio;
			$values = array('identrada'=>$id, 'id_invent'=>$idproducto, 'cantidad'=>$num, 'total'=>$cantidad, 'idtienda'=>$idtienda, 'descripcion'=>$nombre, 'pendiente'=>0, 'precio'=>$precio,  'unico'=>$unico, 'gtotal'=>$gtotal, 'color'=>$color, 'tipo'=>$material);
			if($unico==1){
				$values['clave']=$clave;
			}
			$values['pventa']=$precioventa;
			echo $bdd->insert('et_bodega', $values);


			$invent = array('preciocompra'=>$precio);
			echo $bdd->update('et_invent',array('id_invent'=>$idproducto), $invent);
		}
		if($modulo=="traspasos"){
			$num=$cantidad*-1;
			if($unico==0){			///////////////insumo control
				$gtotal=$cantidad*$precio;
				$values = array('idtraspaso'=>$id, 'id_invent'=>$idproducto, 'cantidad'=>$num, 'pendiente'=>"0", 'total'=>$cantidad, 'descripcion'=>$nombre, 'idtienda'=>$idtienda, 'precio'=>$precio, 'unico'=>$unico, 'gtotal'=>$gtotal);
				echo $bdd->insert('et_bodega', $values);
			}
			if($unico==1){			///////////////insumo unico
				$values = array('idtraspaso'=>$id, 'idtienda'=>null, 'pendiente'=>$cantidad, 'cantidad'=>"0");
				echo $bdd->update('et_bodega',array('id'=>$idbodega), $values);
			}
		}
		if($modulo=="ventas"){
			$num=$cantidad*-1;
			if($unico==0){			///////////////insumo control
				$gtotal=$cantidad*$precioventa;
				$values = array('idventa'=>$id, 'id_invent'=>$idproducto, 'cantidad'=>$num, 'pendiente'=>"0", 'total'=>$cantidad, 'descripcion'=>$nombre, 'precio'=>$precio , 'pventa'=>$precio , 'idtienda'=>$idtienda, 'unico'=>$unico, 'gtotalv'=>$gtotal );
				echo $bdd->insert('et_bodega', $values);
			}
			if($unico==1){			///////////////insumo unico
				$gtotal=$cantidad*$precioventa;
				$values = array('idventa'=>$id, 'pendiente'=>$cantidad, 'cantidad'=>"0", 'gtotalv'=>$gtotal, 'pventa'=>$precio);
				echo $bdd->update('et_bodega',array('id'=>$idbodega), $values);
			}
			if($unico==2 or $unico==3 or $unico==4){			///////////////insumo control
				$gtotal=$cantidad*$precio;
				$values = array('idventa'=>$id, 'id_invent'=>$idproducto, 'cantidad'=>0, 'pendiente'=>"0", 'total'=>$cantidad, 'descripcion'=>$nombre , 'precio'=>$precio, 'pventa'=>$precio , 'idtienda'=>$idtienda, 'unico'=>$unico, 'gtotalv'=>$gtotal );
				echo $bdd->insert('et_bodega', $values);
			}
		}
	}
	if($tipo=="borrarregistro"){//////////////Borra registro de listado
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['modulo'])){$modulo=$_POST['modulo'];}
		if (isset($_POST['registro'])){$registro=$_POST['registro'];}
		if (isset($_POST['idtienda'])){$idtienda=$_POST['idtienda'];}
		if (isset($_POST['pendiente'])){$pendiente=$_POST['pendiente'];}
		if (isset($_POST['unico'])){$unico=$_POST['unico'];}

		if($modulo=="compras"){
			echo $bdd->borrar('et_comprapedido', $registro);
		}
		if($modulo=="entrada"){
			echo $bdd->borrar('et_bodega', $registro);
		}
		if($modulo=="traspasos"){
			if($unico==0){
				echo $bdd->borrar('et_bodega', $registro);
			}
			if($unico==1){
				$values = array('idtraspaso'=>null, 'idtienda'=>$idtienda, 'pendiente'=>"0", 'cantidad'=>$pendiente);
				echo $bdd->update('et_bodega',array('id'=>$registro), $values);
			}
		}
		if($modulo=="ventas"){
			if($unico==0 or $unico==2 or $unico==3 or $unico==4){
				echo $bdd->borrar('et_bodega', $registro);
			}
			if($unico==1){
				$values = array('idventa'=>null, 'pendiente'=>"0", 'cantidad'=>"1");
				echo $bdd->update('et_bodega',array('id'=>$registro), $values);
			}
		}

	}
	if($tipo=="comentarios"){
		if (isset($_POST['registro'])){$registro=$_POST['registro'];}
		if (isset($_POST['modulo'])){$modulo=$_POST['modulo'];}
		if (isset($_POST['comentario'])){$comentario=$_POST['comentario'];}
		if($modulo=="traspasos" or $modulo=="entrada" or $modulo=="ventas"){
			$values = array('observaciones'=>$comentario);
			echo $bdd->update('et_bodega',array('id'=>$registro), $values);
		}
	}

	if($tipo=="finalizar"){		///////////////Finaliza los traspasos
		if (isset($_POST['id'])){$id=$_POST['id'];}
		$estado="Enviada";
		$values = array('estado'=>$estado);
		echo $bdd->update('et_traspaso',array('id'=>$id), $values);
	}

	?>