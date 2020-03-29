<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];
	$codigo="";
	$nombre="";
	$unidad="";
	$precio="";
	$marca="";
	$modelo="";
	$descripcion="";
	$tipo="";
	$activo="1";
	$rapido="";
	$color="";
	$material="";
	$cantidad="";
	$imei="";
	$preciocompra="";
	$idventa="";

	if($id>0){
		$per = $db->producto_editar($id);
		$codigo=$per->codigo;
		$nombre=$per->nombre;
		$unidad=$per->unidad;
		$marca=$per->marca;
		$modelo=$per->modelo;
		$descripcion=$per->descripcion;
		$tipo=$per->tipo;
		$activo=$per->activo;
		$rapido=$per->rapido;
		$color=$per->color;
		$material=$per->material;
		$cantidad=$per->cantidad;
		$imei=$per->imei;
		$precio=$per->precio;
		$preciocompra=$per->preciocompra;
		$idventa=$per->idventa;
	}
	if($id>0){
		if($tipo==3){
			$sql="select sum(cantidad) as total from bodega where idproducto=$id";
			$sth = $db->dbh->prepare($sql);
			$sth->execute();
			$total=$sth->fetch(PDO::FETCH_OBJ);
			$existencia=$total->total;
			$arreglo =array();
			$arreglo = array('cantidad'=>$existencia);
			$db->update('productos',array('id'=>$id), $arreglo);
			$cantidad=$existencia;
		}
	}

?>

<div class='container'>
		<div class='card'>
			<div class='card-header'>
				<?php echo $nombre;?>
				<ul class='nav nav-tabs card-header-tabs nav-fill' id='myTab' role='tablist'>
					<li class='nav-item'>
						<a class='nav-link active' id='ssh-tab' data-toggle='tab' href='#ssh' role='ssh' aria-controls='home' aria-selected='true'>Editar producto</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link $disabled' id='home-tab' data-toggle='tab' href='#home' role='tab' aria-controls='home' aria-selected='true'>Registro</a>
					</li>
				</ul>
			</div>
			<div class='card-body'>
				<div class='tab-content' id='myTabContent'>
					<div class='tab-pane fade show active' id='ssh' role='tabpanel' aria-labelledby='ssh-tab'>
						<form id='form_producto' action='' data-lugar='a_productos/db_' data-destino='a_productos/editar' data-funcion='guardar_producto'>
							<input type="hidden" class="form-control form-control-sm" id="id" name='id' value="<?php echo $id; ?>">
							<div class='row'>
								<div class="col-12">
								 <label>Tipo de producto</label>
									<select class="form-control form-control-sm" name="tipo" id="tipo" <?php if ($id>0){ echo "disabled";}  ?> onchange='tipo_cambio()' required>
										<option value='' disabled selected>Seleccione una opción</option>
										<option value="3"<?php if($tipo=="3") echo "selected"; ?> > Volúmen (Se controla el inventario por volúmen: fundas, accesorios)</option>
										<option value="4"<?php if($tipo=="4") echo "selected"; ?> > Unico (se controla inventario por pieza única: Fichas Amigo, Equipos)</option>
										<!-- <option value="1"<?php if($tipo=="1") echo "selected"; ?> > Pago de linea</option> -->
										<option value="2"<?php if($tipo=="2") echo "selected"; ?> > Reparación</option>
										<option value="0"<?php if($tipo=="0") echo "selected"; ?> > Registro (solo registra ventas, no es necesario registrar entrada: tiempo aire)</option>
									</select>
								</div>
							</div>
							<hr>
							<div class='row'>
								<div class="col-3">
								 <label>Codigo Barras</label>
								 <input type="text" class="form-control form-control-sm" id="codigo" name='codigo' placeholder="Codigo" value="<?php echo $codigo; ?>" readonly>
								</div>
								<div class="col-2">
								 <label>Busqueda rapida</label>
								 <input type="text" class="form-control form-control-sm" id="rapido" name='rapido' placeholder="rapido" value="<?php echo $rapido; ?>" maxlength=4>
								</div>
								<div class="col-2">
								 <label>Unidad</label>
								 <select class='form-control form-control-sm' name='unidad' id='unidad'>
								 	<option value='pieza'  <?php if($unidad=="pieza"){ echo "selected ";} ?> >Pieza</option>
								 </select>
								</div>
								<div class="col-5">
								 <label>Nombre</label>
								 <input type="text" class="form-control form-control-sm" id="nombre" name='nombre' placeholder="Descripción" value="<?php echo $nombre; ?>" required>
								</div>
								<div class="col-12">
								 <label>Descripción</label>
								 <input type="text" class="form-control form-control-sm" id="descripcion" name='descripcion' placeholder="Descripción" value="<?php echo $descripcion; ?>">
								</div>
							</div>
							<div class='row'>
								<div class="col-3">
								 <label>Precio compra</label>
								 <input type="text" class="form-control form-control-sm" id="preciocompra" name='preciocompra' placeholder="Precio" value="<?php echo $preciocompra; ?>">
								</div>
								<div class="col-3">
								 <label>Precio Venta</label>
								 <input type="text" class="form-control form-control-sm" id="precio" name='precio' placeholder="Precio" value="<?php echo $precio; ?>" required>
								</div>

								<div class="col-3">
								 <label>Existencia</label>
								 <input type="text" readonly class="form-control form-control-sm" id="cantidad" name='cantidad' placeholder="Cantidad" value="<?php echo $cantidad; ?>">
								</div>

								<div class="col-3">
								 <label>Activo</label>
									<select class="form-control form-control-sm" name="activo" id="activo"  >
										<option value="0"<?php if($activo=="0") echo "selected"; ?> > Inactivo</option>
										<option value="1"<?php if($activo=="1") echo "selected"; ?> > Activo</option>
									</select>
								</div>

							</div>
							<hr>

							<div class='row'>
								<div class="col-3" id='div_marca'>
								 <label>Marca</label>
								 <input type="text" class="form-control form-control-sm" id="marca" name='marca' placeholder="Marca" value="<?php echo $marca; ?>">
								</div>

								<div class="col-3"  id='div_modelo'>
								 <label>Modelo</label>
								 <input type="text" class="form-control form-control-sm" id="modelo" name='modelo' placeholder="Modelo" value="<?php echo $modelo; ?>">
								</div>

								<div class="col-3"  id='div_color'>
					        <label>Color</label>
					        <input type="text" class="form-control form-control-sm" name="color" id='color' placeholder="Color" value='<?php echo $color; ?>'>
					      </div>

								<div class='col-3' id='div_material'>
				          <label>Material</label>
				          <select class='form-control form-control-sm' name='material' id='material'>
				          <option value='' <?php if($material==""){ echo "selected ";} ?> ></option>
				          <option value='PREPAGO'  <?php if($material=="PREPAGO"){ echo "selected ";} ?> >PREPAGO</option>
				          <option value='TARIFARIO'  <?php if($material=="TARIFARIO"){ echo "selected ";} ?> >TARIFARIO</option>
				          <option value='AMIGO CHIP' <?php  if($material=="AMIGO CHIP"){ echo "selected ";} ?> >AMIGO CHIP</option>
				          <option value='LIBRES'  <?php if($material=="LIBRES"){ echo "selected ";} ?> >LIBRES</option>
				          <option value='CONSIGNA'  <?php if($material=="CONSIGNA"){ echo "selected ";} ?> >CONSIGNA</option>
				          </select>
				        </div>

								<div class="col-3" id='div_imei'>
									<label>IMEI</label>
									<input type="text" class="form-control form-control-sm" name="imei" id='imei' placeholder="IMEI" value='<?php echo $imei; ?>'>
								</div>
							</div>

							<hr>

							<div class='row'>
								<div class="col-12">
									<div class='btn-group'>
										<?php
											if(strlen($idventa)==0){
												echo "<button type='submit' class='btn btn-outline-primary btn-sm'><i class='far fa-save'></i>Guardar</button>";
											}

											if($id>0){
												echo "<button type='button' class='btn btn-outline-primary btn-sm' onclick='clonar_nuevo()'><i class='far fa-clone'></i>Nuevo</button>";
												echo "<button type='button' class='btn btn-outline-primary btn-sm' id='imprime_comision' title='Imprimir' data-lugar='a_productos/imprimir' data-tipo='1' type='button'><i class='fas fa-barcode'></i>Imprimir</button>";

												if($tipo==3){
													echo "<button type='button' class='btn btn-outline-primary btn-sm' id='winmodal_pass' data-id='0' data-id2='$id' data-lugar='a_productos/form_agrega' title='Agregar existencias' ><i class='far fa-plus-square'></i></i>Agregar existencias</button>";
												}
											}
										?>
										<button type='button' class='btn btn-outline-primary btn-sm' id='lista_cat' data-lugar='a_productos/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class='tab-pane fade show' id='home' role='tabpanel' aria-labelledby='home-tab'>
						<?php
						if($id>0){
							if($tipo==3){
								echo "<button type='button' class='btn btn-outline-primary btn-sm' id='winmodal_pass' data-id='0' data-id2='$id' data-lugar='a_productos/form_agrega' title='Agregar existencias' ><i class='far fa-plus-square'></i></i>Agregar existencias</button>";
							}
							$row=$db->productos_inventario($id);
								echo "<table class='table table-sm' style='font-size:12px'>";
								echo "<tr><th>-</th><th>Fecha</th><th>Cantidad</th><th>Nota de compra</th>
								<th># Venta</th>
								<th>Observaciones</th>
								<th>Cantidad</th>
								<th>Precio</th>
								<th>Total</th>
								</tr>";
								$total=0;
								foreach($row as $key){
									echo "<tr id='".$key->id."' class='edit-t'>";
										echo "<td>";
											echo "<div class='btn-group'>";
											if(!$key->idventa){
												echo "<button class='btn btn-outline-primary btn-sm' id='eliminar_prodn".$key->id."' data-lugar='a_productos/db_' data-destino='a_productos/editar' data-id='".$key->id."' data-iddest='$id' data-funcion='borrar_ingreso' data-div='trabajo'><i class='far fa-trash-alt'></i></i></button>";
											}
											echo "</div>";
										echo "</td>";
										echo "<td>";
											echo fecha($key->fecha);
										echo "</td>";
										echo "<td>";
											echo $key->cantidad;
										echo "</td>";
										echo "<td>";
											echo $key->nota;
										echo "</td>";
										echo "<td>";
											echo $key->idventa;
										echo "</td>";
										echo "<td>";
											echo $key->observaciones;
										echo "</td>";
										echo "<td>";
											echo $key->v_cantidad;
										echo "</td>";
										echo "<td>";
											echo moneda($key->v_precio);
										echo "</td>";
										echo "<td>";
											echo moneda($key->v_total);
										echo "</td>";
									echo "</tr>";
								}
								echo "</table>";
							}
						 ?>
					</div>
				</div>
			</div>
		</div>
</div>

<script>
	$(function() {
		tipo_cambio();
	});
</script>
