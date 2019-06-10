<?php
  require_once("db_.php");
  $id=$_REQUEST['id'];
  $id2=$_REQUEST['id2'];
  $inven=$db->bodega_edit($id);
  $descripcion=$inven['descripcion'];
  $clave=$inven['clave'];


  echo "<form action='' id='form_venta' data-lugar='a_inventario/db_' data-funcion='guardar_bodega'  data-destino='a_inventario/form_detalle' >";
  echo "<input type='hidden' name='id' id='id' placeholder='Editar' value='$id' class='form-control'>";
  echo "<input type='hidden' name='idprod' id='idprod' placeholder='Editar' value='$id2' class='form-control'>";
?>
<div class="card">
  <div class="card-header">Editar producto</div>
  <div class="card-body" >
    <div clas='row'>
      <div class="col-4">
        <label>Clave/IMEI</label>
        <input type="text" class="form-control" name="clave" id='clave' value='<?php echo $clave; ?>'>
      </div>

      <div class="col-4">
        <label>Descripción</label>
        <input type="text" class="form-control" name="descripcion" id='descripcion' value='<?php echo $descripcion; ?>'>
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
