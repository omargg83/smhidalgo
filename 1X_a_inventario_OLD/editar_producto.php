<?php
  require_once("db_.php");
  $id=$_REQUEST['id'];
  $id2=$_REQUEST['id2'];

  $pd = $db->inventario($id2);
  $descripcion=$pd['nombre'];
  $clave="";
  $pventa="";
  $cantidad="1";
  $precio=$pd['preciocompra'];
  $pventa=$pd['pvgeneral'];
  $unidad=$pd['unidad'];
  $color="";
  $colores=$db->color();
  $material="";
  $codigo=$pd['codigo'];
  $rapido=$pd['rapido'];
  $imei=$pd['imei'];
  if($id>0){
    $inven=$db->bodega_edit($id);
    $descripcion=$inven['descripcion'];
    $clave=$inven['clave'];
    $pventa=$inven['pventa'];
    $precio=$inven['precio'];
    $unidad=$inven['unidad'];
    $color=$inven['color'];
    $material=$inven['material'];
    $codigo=$inven['codigo'];
    $rapido=$inven['rapido'];
    $imei=$inven['imei'];
  }

  echo "<form action='' id='form_venta' data-lugar='a_inventario/db_' data-funcion='guardar_bodega'  data-destino='a_inventario/form_detalle' >";
  echo "<input type='hidden' name='id' id='id' placeholder='Editar' value='$id' class='form-control'>";
  echo "<input type='hidden' name='valor' id='valor' placeholder='Editar' value='$id' class='form-control'>";
  echo "<input type='hidden' name='idprod' id='idprod' placeholder='Editar' value='$id2' class='form-control'>";
?>
<div class="card">
  <div class="card-header">Editar producto</div>
  <div class="card-body" >
    <div class='row'>
      <div class="col-6">
        <label>Descripción</label>
        <input type="text" class="form-control" name="descripcion" id='descripcion' value='<?php echo $descripcion; ?>'>
      </div>

      <div class="col-2">
        <label>Unidad</label>
        <input type="text" class="form-control" name="unidad" id='unidad' value='<?php echo $unidad; ?>' readonly>
      </div>

      <?php
        echo "<div class='col-2'>";
            echo "<label>Color</label>";
            echo  "<select class='form-control' name='color' id='color'>";
            echo  "<option value='' selected></option>";
            foreach($colores as $v2){
              echo  "<option value='".$v2['color']."'";
              if($v2['color']==$color){ echo "selected ";}
              echo  ">".$v2['color']."</option>";
            }
            echo  "</select>";
        echo "</div>";

        echo "<div class='col-2'>";
          echo "<label>Material</label>";
          echo  "<select class='form-control' name='material' id='material'>";
          echo  "<option value=''"; if($material==""){ echo "selected ";} echo "></option>";
          echo  "<option value='PREPAGO' "; if($material=="PREPAGO"){ echo "selected ";} echo ">PREPAGO</option>";
          echo  "<option value='TARIFARIO' "; if($material=="TARIFARIO"){ echo "selected ";} echo ">TARIFARIO</option>";
          echo  "<option value='AMIGO CHIP' "; if($material=="AMIGO CHIP"){ echo "selected ";} echo ">AMIGO CHIP</option>";
          echo  "<option value='LIBRES' "; if($material=="LIBRES"){ echo "selected ";} echo ">LIBRES</option>";
          echo  "<option value='CONSIGNA' "; if($material=="CONSIGNA"){ echo "selected ";} echo ">CONSIGNA</option>";
          echo  "</select>";
        echo "</div>";
      ?>

      <div class="col-4">
        <label>Cantidad</label>
        <input type="text" class="form-control" name="cantidad" id='cantidad' value='<?php echo $cantidad; ?>' readonly>
      </div>

      <div class="col-4">
        <label>Precio compra</label>
        <input type="text" class="form-control" name="precio" id='precio' value='<?php echo $precio; ?>'>
      </div>

      <div class="col-4">
        <label>Precio venta</label>
        <input type="text" class="form-control" name="pventa" id='pventa' value='<?php echo $pventa; ?>'>
      </div>

      <div class='col-4'>
        <label>Código de barras</label>
        <input type='text' class='form-control input-sm' id='codigo' name='codigo' value='<?php echo $codigo; ?>' readonly>
      </div>

      <div class='col-4'>
        <label>Rápido</label>
        <input type='text' class='form-control input-sm' id='rapido' name='rapido' value='<?php echo $rapido; ?>' readonly>
      </div>

      <div class="col-4">
        <label>Clave/IMEI</label>
        <input type="text" class="form-control" name="imei" id='imei' value='<?php echo $imei; ?>'>
      </div>
    </div>
  </div>
</div>

<div class="card-footer">
  <div class='btn-group'>
    <button class='btn btn-outline-secondary btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>
    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cerrar</button>
  </div>
</div>
</div>
</form>
