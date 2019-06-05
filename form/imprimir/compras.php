<?php 
	require_once("../control_db.php");
	$id=$_REQUEST['id'];
	$bdd = new Venta();
	
	
	$pd = $bdd->compra($id);
	$pedido = $bdd->compras_pedido($id);
	$empresa = $bdd->empresa();
	
	$idcompra=$pd['idcompra'];
	$id_prove=$pd['id_prove'];
	$fecha=$pd['fecha'];
	$estado=$pd['estado'];
	$proveedor = $bdd->proveedor($id_prove);
	
	error_reporting(E_ALL);
	set_time_limit(1800);
	set_include_path('../../librerias/pdf/src/' . PATH_SEPARATOR . get_include_path());
	
	$start = microtime(true);
	include 'Cezpdf.php';
	class Creport extends Cezpdf{
		function Creport($p,$o){
			$this->__construct($p, $o,'none',array());
		}
	}
	$pdf = new Creport('letter','portrait');
	$pdf->cacheTimeout = 0;
	$pdf->targetEncoding = 'ISO-8859-1';
	$pdf->targetEncoding = 'cp1252';
	$pdf->ezSetMargins(20,20,20,20);
	$pdf->openHere('Fit');
	$pdf->selectFont('Helvetica');
	
		$pdf->addPngFromFile("../../img/logo.png",27,690,80);
		
		$pdf->addText(0,740,12,"<b>HOJA DE COMPRAS</b>",600,'center');
	
		$pdf->addText(120,720,9,"<b># Compra:</b>",200,'left');
		$pdf->addText(120,710,9,"$idcompra",200,'left');
		
		
		$pdf->addText(120,700,9,"<b>Fecha:</b>",200,'left');
		$pdf->addText(120,690,9,"$fecha",200,'left');
		
		$pdf->addText(400,720,10,"<b>Datos del emisor</b>");
		$pdf->addText(400,710,9,$empresa['razon_social_empresa']);
		$pdf->addText(400,700,9,$empresa['rfc_empresa']);
		$pdf->addText(400,690,9,$empresa['direccion_empresa']);
		
		$pdf->line(20,40,590,40);
		$pdf->ezStartPageNumbers(50,30,8,'de','',1);
		$pdf->addText(0,30,8,date("d")." / ".strtoupper(date("m"))." / ".date("Y"),580,'right');
		
		$pdf->ezText(" ",50);
		$pdf->ezText(" ",30);

		
		$cols = array('numero'=>'<b>#</b>',
			'codigo'=>'<b>CODIGO</b>',
			'descripcion'=>'<b>DESCRIPCION</b>',
			'cantidad'=>'<b>CANTIDAD</b>',
			'unidad'=>'<b>UNIDAD</b>');
					
		$data=array();
		$i=0;
		$contar=1;
		for($i=0;$i<count($pedido);$i++){
			$data[$i]=array('numero'=>$contar,
			'codigo'=>$pedido[$i]['codigo'],
			'descripcion'=>$pedido[$i]['nombre'],
			'cantidad'=>$pedido[$i]['cantidad_oc'],
			'unidad'=>$pedido[$i]['unidad']);	
			$contar++;
		}
		
			
		$pdf->ezTable($data,$cols,"",array('xPos'=>'left','rowGrap'=>55,
			'shadeHeadingCol'=>array(.5960, .6985, .8784),
			'xOrientation'=>'right',
			'shaded'=>0,'showHeadings'=>1,'gridlines'=>31,'innerLineThickness' => 0.5,'outerLineThickness' =>0.5,
		
			'cols'=>array('numero'=>array('width'=>30,'justification'=>'center'),
			'cantidad'=>array('bgcolor'=>array(0.9,0.9,0.7),'width'=>60,'justification'=>'center')
			,'codigo'=>array('width'=>80,'justification'=>'center')
			,'descripcion'=>array('width'=>340,'justification'=>'left')
			,'unidad'=>array('width'=>60,'justification'=>'center')
			),'fontSize' => 9));
	
	
	$pdf->ezStream();
	
?>