<?php
	require_once("control_db.php");
	$bdd = new Venta();
	$usuario = $bdd->usuario_lista();
?>
<div class="row">
	<div class="col-md-12">
		<div class="header">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand" href="#">Acceso</a>	
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="nav navbar-nav">
					<li class="nav-item"><a href="#" class="nav-link">Personal:</a></li>
					<li class="nav-item">
						<?php
							echo "<select class='form-control' name='idusuariox' id='idusuariox'>";
								echo '<option disabled>Seleccione personal</option>';
								for($i=0;$i<count($usuario);$i++){
									echo '<option value="'.$usuario[$i]['idusuario'].'"';
									echo '>'.$usuario[$i]["nombre"].'</option>';
								}
							echo "</select>";
						?>
					</li>
					<li class="nav-item">
						<div class='btn-group'>
						
						</div>
					</li>
				</ul>
			</div>
		</nav>
		</div>
		<hr>
		<div id='trabajo'>
		</div>
	</div>
</div>

<script type="text/javascript">		
	$(document).ready(function(){
		var id;
		id=document.getElementById("idusuariox").value;
		$("#trabajo").load('form/acceso_lista.php?id='+id);
	});
</script>
