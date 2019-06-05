<?php
	session_start();
    if(isset($_SESSION['idpersona']) and $_SESSION['autoriza'] == 1) {

    } else {
		include('acceso/login.php');
		die();
	};
?>

<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SAGYC</title>
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top barra">
	<div class='container'>
	  <a class="navbar-brand home" id='menu_home'><img src='img/sagyc.png' width='20px'>SMHIDALGO</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
		  
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fas fa-shopping-cart'></i>
				  Ventas
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="#a_ventas/index" ><i class='fas fa-shopping-cart'></i> Ventas</a>
				  <a class="dropdown-item" href="#" id='menu_lineas'><i class="fas fa-clipboard-check"></i> S. de lineas</a>
				  <a class="dropdown-item" href="#" id='menu_reparaciones'><i class="fas fa-wrench"></i> Reparaciones</a>
				  <a class="dropdown-item" href="../app/publish.htm" target='_blank'><i class="fas fa-download"></i> Escritorio</a>
				</div>
			</li>
			
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				 <i class='fas fa-money-check-alt'></i> Compras
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="#a_compras/index" id='menu_compras' ><i class='fas fa-money-check-alt'></i> Lista de compras</a>
				  <a class="dropdown-item" href="#" id='menu_entrada'><i class="fas fa-chalkboard-teacher"></i> Entrada</a>
				</div>
			</li>
			
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class='fas fa-boxes'></i> Inventario
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="#a_inventario/index"  ><i class='fas fa-boxes'></i> Productos</a>
				  <a class="dropdown-item" href="#" id='menu_traspaso' ><i class="fas fa-arrows-alt-h"></i> Traspasos</a>
				</div>
			</li>
			
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-clipboard-list"></i> Catalogos
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="#a_usuarios/index" ><i class="fas fa-user-astronaut"></i> Usuarios</a>
				  <a class="dropdown-item" href="#" id='menu_acceso' ><i class="fas fa-user-clock"></i> Acceso</a>
				  <a class="dropdown-item" href="#a_tienda/index"><i class="fas fa-shopping-basket"></i> Tiendas</a>
				  <a class="dropdown-item" href="#a_cliente/index"><i class="fas fa-people-carry"></i> Clientes</a>
				  <a class="dropdown-item" href="#a_proveedores/index" ><i class="fas fa-user-plus"></i> Proveedores</a>
				  <hr>
				  <a class="dropdown-item" href="#a_marca/index" ><i class="fas fa-mobile-alt"></i> Marcas</a>
				  <a class="dropdown-item" href="#a_modelo/index" ><i class="fab fa-android"></i> Modelos</a>
				  <hr>
				  <a class="dropdown-item" href="#a_productos/index" ><i class="fas fa-user-astronaut"></i> Productos</a>
				</div>
			</li>
		</ul> 
		
		  <ul class='nav navbar-nav navbar-right'>
		  <li class="nav-item">
		  <a class="nav-link pull-left" href="acceso/salir.php">
			<i class='fas fa-sign-out-alt'></i> Salir
			</a>
			</li>
		</ul>
		
	  </div>
	 </div>
	</nav>
	
<div class="fijaproceso main animated slideInDown delay-2s" id='contenido'>
					
</div>
	
<div class="loader loader-default is-active" id='cargando' data-text="Cargando">
</div>


<div class="modal animated fadeIn delay-2s" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content" id='modal_form' style='max-height:580px;overflow: auto;'>
		  
	</div>
  </div>
</div>
	
	
	
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>

</body>
	<!--   Core JS Files   -->
	<script src="librerias15/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="librerias15/loader.js"></script>
	
	<!--   url   -->
	<script src="librerias15/jquery/jquery-ui.js"></script>
	
	<!--   Tablas  -->
	<script type="text/javascript" src="librerias15/DataTables/datatables.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="librerias15/DataTables/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="librerias15/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.css"/>
	
	<!-- Animation library for notifications   -->
    <link href="librerias15/animate.min.css" rel="stylesheet"/>
	
	<!--   Alertas   -->
	<script src="librerias15/swal/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="librerias15/swal/dist/sweetalert2.min.css">
	
	<!--   para imprimir   -->
	<script src="librerias15/VentanaCentrada.js" type="text/javascript"></script>
	
	<!--   Cuadros de confirmación y dialogo   -->
	<link rel="stylesheet" href="librerias15/jqueryconfirm/css/jquery-confirm.css">
	<script src="librerias15/jqueryconfirm/js/jquery-confirm.js"></script>
	
	<!--   iconos   -->
	<link rel="stylesheet" href="librerias15/fontawesome-free-5.8.1-web/css/all.css">
	<link rel="stylesheet" href="librerias15/jquery/jquery-ui-1.10.0.custom.css" />
	
	<script src="chat/chat.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="chat/chat.css"/>
	
	<!--   carrusel de imagenes   -->
	<link rel="stylesheet" href="librerias15/baguetteBox.js-dev/baguetteBox.css">
	<script src="librerias15/baguetteBox.js-dev/baguetteBox.js" async></script>
	<script src="librerias15/baguetteBox.js-dev/highlight.min.js" async></script>
	
	<script src="librerias15/popper.js"></script>
	<script src="librerias15/tooltip.js"></script>
	
	<!--   Boostrap   -->
	<link rel="stylesheet" href="librerias15/css/bootstrap.min.css">
	<script src="librerias15/js/bootstrap.js"></script>
	
	<!--   Propios   -->
	<script src="sagyc.js"></script>
	<link rel="stylesheet" type="text/css" href="librerias15/modulos.css"/>
	

</html>
