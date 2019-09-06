<?php
  require_once("db_.php");
  $id=$_REQUEST['id'];
  $id2=$_REQUEST['id2'];
  $inven=$db->bodega_edit($id);
  $descripcion=$inven['descripcion'];
  $clave=$inven['clave'];
  $pventa=$inven['pventa'];

  echo "<form action='' id='form_venta' data-lugar='a_inventario/db_' data-funcion='guardar_bodega'  data-destino='a_inventario/form_detalle' >";
  echo "<input type='hidden' name='id' id='id' placeholder='Editar' value='$id' class='form-control'>";
  echo "<input type='hidden' name='idprod' id='idprod' placeholder='Editar' value='$id2' class='form-control'>";
?>
<div class="card">
  <div class="card-header">Editar producto</div>
  <div class="card-body" >
    <div class='row'>
      <div class="col-6">
        <label>Clave/IMEI</label>
        <input type="text" class="form-control" name="clave" id='clave' value='<?php echo $clave; ?>'>
      </div>

      <div class="col-6">
        <label>Descripción</label>
        <input type="text" class="form-control" name="descripcion" id='descripcion' value='<?php echo $descripcion; ?>'>
      </div>

      <div class="col-6">
        <label>Precio venta</label>
        <input type="text" class="form-control" name="pventa" id='pventa' value='<?php echo $pventa; ?>'>
      </div>
    </div>
  </div>
</div>

<div class="card-footer">
  <div class='btn-group'>
    <button class='btn btn-outline-secondary btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>
    <button class='btn btn-outline-secondary btn-sm' id='imprime_comision' title='Imprimir' data-lugar='a_inventario/imprimir' data-tipo='1' type='button'><i class='fas fa-print'></i>Imprimir</button>
    <button class='btn btn-outline-secondary btn-sm' onclick='barras(<?php echo $id; ?>)' type='button'><i class="fas fa-barcode"></i>Barras</button>
    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cerrar</button>
  </div>
</div>
</div>
</form>
