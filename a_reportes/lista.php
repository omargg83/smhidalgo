<?php
  require_once("db_.php");
  $pd=$bd->emitidas();

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
  echo "<br><h5>Polizas emitidas</h5>";
	echo "<hr>";
  ?>

  <div class="content table-responsive table-full-width" >
    <table id='x_lista' class='display compact hover' style='font-size:10pt;'>
    <thead>
    <tr>
    <th>-</th>
    <th># Poliza</th>
    <th>Tipo</th>
    <th>Estatus</th>
    <th>Afiliado</th>
    <th>Emision</th>
    <th>Desde</th>
    <th>Hasta</th>
    </tr>
    </thead>
    <tbody>
    <?php
      if (count($pd)>0){
        foreach($pd as $key){
          if($key['status']=='ESPERA') $color='#FFFF99';
          if($key['status']=='ACTIVA') $color='#7EE34B';
          if($key['status']=='RENOVADA') $color='#66CCCC';
          if($key['status']=='CANCELADA') $color='#CC2431';
          if($key['status']=='EXPIRADA') $color='#AAAAAA';

          echo "<tr id='".$key['idafiliado']."' class='edit-t'>";
          echo "<td>";
            echo "<div class='btn-group'>";
              echo "<button class='btn btn-outline-warning btn-sm' id='edit_comision' data-param1='".$key['idseguro']."'  title='Editar' data-lugar='a_polizas/editar'><i class='far fa-arrow-alt-circle-right'></i></button>";
            echo "</div>";
          echo "</td>";

          echo "<td>".$key["idseguro"]."</td>";
          echo "<td>".$key["pago"]."</td>";
          echo "<td bgcolor='$color'>".$key["status"]."</td>";
          echo "<td>".$key["nombre"]."</td>";
          echo "<td>".$key["emision"]."</td>";
          echo "<td>".fecha($key["desde"])."</td>";
          echo "<td>".fecha($key["hasta"])."</td>";
          echo "</tr>";
        }
      }
    ?>
    </tbody>
    </table>
  </div>
</div>

<script>
	$(document).ready( function () {
		lista("x_lista");
	} );
</script>
