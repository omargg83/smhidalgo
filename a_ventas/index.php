<?php
	require_once("../form/control_db.php");
	$bdd = new Venta();
?>
<div class="row">
	<div class="col-md-12">

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<div class='btn-group'>
						<button class="btn btn-outline-secondary" id='new_ventas' type="button"><i class='fas fa-plus-circle'></i> Nueva</button>
						<button class="btn btn-outline-secondary" id='lista_ventas' type="button"><i class='fas fas fa-list-ol'></i> Lista</button>
						</div>
					</li>
				</ul>
				
			</div>
		</nav>
		</div>
		<hr>
		<div id='trabajo'>
			<?php
				include 'lista.php';
			?>
		</div>
	</div>
</div>

