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
	$rapido="1";
	$color="";
	$material="";
	$cantidad="";
	$imei="";

	if($id>0){
		$per = $db->producto_editar($id);
		$codigo=$per->codigo;
		$nombre=$per->nombre;
		$unidad=$per->unidad;
		$precio=$per->precio;
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
	}
?>
<div class='container'>
	<form id='form_producto' action='' data-lugar='a_productos/db_' data-destino='a_productos/editar' data-funcion='guardar_producto'>
		<div class='card'>
			<div class='card-header'>
				Producto <?php echo $id; ?>
			</div>
			<div class='card-body'>
				<input type="hidden" class="form-control form-control-sm" id="id" name='id' value="<?php echo $id; ?>">
				<div class='row'>
					<div class="col-12">
					 <label>Tipo de producto</label>
						<select class="form-control form-control-sm" name="tipo" id="tipo" <?php if ($id>0){ echo "disabled";}  ?> >
							<option value="0"<?php if($tipo=="0") echo "selected"; ?> > Volúmen (Se controla el inventario por volúmen, fundas, accesorios)</option>
							<option value="1"<?php if($tipo=="1") echo "selected"; ?> > Unico (se controla inventario por pieza única, Fichas Amigo, Equipos)</option>
							<option value="2"<?php if($tipo=="2") echo "selected"; ?> > Registro (solo registra ventas, no es necesario registrar entrada, tiempo aire)</option>
							<option value="3"<?php if($tipo=="3") echo "selected"; ?> > Pago de linea</option>
							<option value="4"<?php if($tipo=="4") echo "selected"; ?> > Reparación</option>
						</select>
					</div>
				</div>
				<hr>
				<div class='row'>
					<div class="col-3">
					 <label>Codigo Barras</label>
					 <input type="text" class="form-control form-control-sm" id="codigo" name='codigo' placeholder="Codigo" value="<?php echo $codigo; ?>" readonly>
					</div>
					<div class="col-3">
					 <label>Busqueda rapida</label>
					 <input type="text" class="form-control form-control-sm" id="rapido" name='rapido' placeholder="rapido" value="<?php echo $rapido; ?>">
					</div>
					<div class="col-2">
					 <label>Unidad</label>
					 <input type="text" class="form-control form-control-sm" id="unidad" name='unidad' placeholder="Unidad" value="<?php echo $unidad; ?>">
					</div>

					<div class="col-4">
					 <label>Activo</label>
						<select class="form-control form-control-sm" name="activo" id="activo"  >
							<option value="0"<?php if($activo=="0") echo "selected"; ?> > Inactivo</option>
							<option value="1"<?php if($activo=="1") echo "selected"; ?> > Activo</option>
						</select>
					</div>

					<div class="col-12">
					 <label>Nombre</label>
					 <input type="text" class="form-control form-control-sm" id="nombre" name='nombre' placeholder="Descripción" value="<?php echo $nombre; ?>">
					</div>


					<div class="col-4">
					 <label>Marca</label>
					 <input type="text" class="form-control form-control-sm" id="marca" name='marca' placeholder="Marca" value="<?php echo $marca; ?>">
					</div>
					<div class="col-4">
					 <label>Modelo</label>
					 <input type="text" class="form-control form-control-sm" id="modelo" name='modelo' placeholder="Modelo" value="<?php echo $modelo; ?>">
					</div>
					<div class="col-12">
					 <label>Descripción</label>
					 <input type="text" class="form-control form-control-sm" id="descripcion" name='descripcion' placeholder="Descripción" value="<?php echo $descripcion; ?>">
					</div>
				</div>
				<div class='row'>
					<div class="col-4">
					 <label>Precio</label>
					 <input type="text" class="form-control form-control-sm" id="precio" name='precio' placeholder="Precio" value="<?php echo $precio; ?>">
					</div>

					<div class="col-4">
					 <label>Existencia</label>
					 <input type="text" readonly class="form-control form-control-sm" id="cantidad" name='cantidad' placeholder="Cantidad" value="<?php echo $cantidad; ?>">
					</div>

				</div>
				<hr>

				<div class='row'>
					<div class="col-2">
		        <label>Color</label>
		        <input type="text" class="form-control form-control-sm" name="color" id='color' placeholder="Color" value='<?php echo $color; ?>'>
		      </div>

					<div class='col-2'>
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

					<div class="col-3">
						<label>IMEI</label>
						<input type="text" class="form-control form-control-sm" name="imei" id='imei' placeholder="IMEI" value='<?php echo $imei; ?>'>
					</div>
				</div>

			</div>


			<div class='card-footer'>
				<div class='btn-group'>
		  		<button type="submit" class="btn btn-outline-info btn-sm"><i class='far fa-save'></i>Guardar</button>
					<?php
						if($id>0){
							echo "<button type='button' class='btn btn-outline-info btn-sm' id='barras' title='Generar código de barras' onclick='barras_generar($id)'><i class='fas fa-barcode'></i>Barras</button>";
							if($tipo==0){
								echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_pass' data-id='0' data-id2='$id' data-lugar='a_productos/form_agrega' title='Cambiar contraseña' ><i class='far fa-plus-square'></i></i>Agregar existencias</button>";
							}
						}
					?>
					<button type='button' class='btn btn-outline-info btn-sm' id='lista_cat' data-lugar='a_productos/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
				</div>
			</div>

			<?php
			if($id>0){
				$row=$db->productos_inventario($id);
				echo "<div class='card-body'>";
					echo "<table class='table table-sm'>";
					echo "<tr><th>-</th><th>Fecha</th><th>Cantidad</th><th>Nota de venta</th></tr>";
					$total=0;
					foreach($row as $key){
						echo "<tr id='".$key->id."' class='edit-t'>";
							echo "<td>";
								echo "<div class='btn-group'>";
									echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_prodn".$key->id."' data-lugar='a_productos/db_' data-destino='a_productos/editar' data-id='".$key->id."' data-iddest='$id' data-funcion='borrar_ingreso' data-div='trabajo'><i class='far fa-trash-alt'></i></i></button>";
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

						echo "</tr>";
					}
				}

			 ?>


		</div>


	</form>
</div>
