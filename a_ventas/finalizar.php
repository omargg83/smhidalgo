<?php
require_once("db_.php");
$id=$_REQUEST['id'];

$pd = $db->venta($id);
$total=number_format($pd['total'],2);

?>
<form action="" id="form_venta" data-lugar="a_ventas/db_" data-funcion="finalizar_venta" data-destino='a_ventas/editar'>
  <input type='hidden' name='id' id='id' placeholder='buscar producto' value='<?php echo $id; ?>' class='form-control'>
  <div class="modal-header">
    <h5 class="modal-title">Finalizar venta</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <div class="modal-body" style='max-height:580px;overflow: auto;'>
    <div clas='row'>
      <div class='col-12'>
        <label>Total</label>
        <input type='text' name='total' id='total' style='text-align:right' placeholder='Total' value='<?php echo $total; ?>' class='form-control' readonly>
      </div>

      <div class='col-12'>
        <label>Efectivo</label>
        <input type='text' name='efectivo' id='efectivo' style='text-align:right' placeholder='efectivo' value='' class='form-control' required>
      </div>

      <div class='col-12'>
        <label>Cambio</label>
        <input type='text' name='cambio' id='cambio' style='text-align:right' placeholder='cambio' value='' class='form-control' required>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <div class='btn-group'>
      <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="fas fa-cash-register"></i>Finalizar</button>
      <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cancelar</button>
    </div>
  </div>
</form>
