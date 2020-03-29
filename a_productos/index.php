<?php
  require_once("db_.php");
  $_SESSION['nivel_captura']=1;
 ?>

 <nav class='navbar navbar-expand-sm navbar-light bg-light'>
 		  <a class='navbar-brand' ><i class="fab fa-product-hunt"></i>Productos</a>
 		  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
 			<span class='navbar-toggler-icon'></span>
 		  </button>
 		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
 			<ul class='navbar-nav mr-auto'>
        <div class='form-inline my-2 my-lg-0' id='daigual' action='' >
          <div class="input-group  mr-sm-2">
            <input type="text" class="form-control form-control-sm" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2"  id='buscar' onkeyup='Javascript: if (event.keyCode==13) buscarx()'>
            <div class="input-group-append">
              <button class="btn btn-outline-primary btn-sm" type="button" onclick='buscarx()'><i class='fas fa-search'></i></button>
            </div>
          </div>
				</div>

 				<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='new_poliza' data-lugar='a_productos/editar'><i class="fas fa-folder-plus"></i><span>Nuevo</span></a></li>
 				<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_prod' data-lugar='a_productos/lista'><i class="fas fa-list"></i><span>Lista</span></a></li>

      </li>

 			</ul>
 		</div>
 	  </div>
 	</nav>

<?php

   echo "<div id='trabajo' style='margin-top:5px;'>";
    include 'lista.php';
   echo "</div>";

 ?>
<script type="text/javascript">

  function buscarx(){
    var buscar = $("#buscar").val();
    $.ajax({
      data:  {
        "buscar":buscar
      },
      url:   'a_productos/lista.php',
      type:  'post',
      success:  function (response) {
        $("#trabajo").html(response);
      }
    });
  }
  function tipo_cambio(){
    var tipo = $("#tipo").val();
    if (tipo==0){
      $("#div_marca").hide();
      $("#div_modelo").hide();
      $("#div_color").hide();
      $("#div_material").hide();
      $("#div_imei").hide();
    }
    if (tipo==2){
      $("#div_marca").hide();
      $("#div_modelo").hide();
      $("#div_color").hide();
      $("#div_material").hide();
      $("#div_imei").hide();
    }
    if (tipo==3){
      $("#div_imei").hide();
      $("#div_material").hide();
      $("#div_marca").show();
      $("#div_modelo").show();
      $("#div_color").show();
    }
    if (tipo==4){
      $("#div_imei").show();
      $("#div_material").show();
      $("#div_marca").show();
      $("#div_modelo").show();
      $("#div_color").show();
    }
  }
  function clonar_nuevo(){
    $("#id").val("0");
    $("#imei").val("");
    $("#codigo").val("");
    $("#tipo").prop("disabled", false);
  }
  function barras_generar(id){
    $.confirm({
      title: 'Código de barras',
      content: '¿Desea generar un codigo de barras para el producto?',
      buttons: {
        Aceptar: function () {
          $.ajax({
            data:  {
              "id":id,
              "function":"genera_barras"
            },
            url:   'a_productos/db_.php',
            type:  'post',
            success:  function (response) {
              var datos = JSON.parse(response);
              if (datos.error==0){
                $.ajax({
                  data:  {
                    "id":datos.id
                  },
                  url:   'a_productos/editar.php',
                  type:  'post',
                  success:  function (response) {
                    $("#trabajo").html(response);
                  }
                });
                Swal.fire({
                  type: 'success',
                  title: "Se agregó correctamente",
                  showConfirmButton: false,
                  timer: 1000
                });
                $('#myModal').modal('hide');
              }
              else{
                $.alert(datos.terror);
              }
            }
          });
        },
        Cancelar: function () {
          $.alert('Canceled!');
        }
      }
    });
  }


</script>
