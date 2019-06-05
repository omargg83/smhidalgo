<?php 
	require_once("../control_db.php");
	$id=$_REQUEST['id'];
	$bdd = new Venta();
	
	
	$pd = $bdd->entrada($id);
	$pedido = $bdd->entrada_pedido($id);
	$empresa = $bdd->empresa();
	
	$id=$pd['identrada'];
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
		
		$pdf->addText(0,740,12,"<b>HOJA DE ENTRADA</b>",600,'center');
	
		$pdf->addText(120,720,9,"<b># Entrada:</b>",200,'left');
		$pdf->addText(120,710,9,"$id",200,'left');
		
		
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
			'clave'=>'<b>Clave</b>',
			'descripcion'=>'<b>DESCRIPCION</b>',
			'cantidad'=>'<b>CANTIDAD</b>',
			'unidad'=>'<b>UNIDAD</b>',
			'precio'=>'<b>PRECIO</b>',
			'total'=>'<b>TOTAL</b>'
			);
					
		$data=array();
		$i=0;
		$contar=1;
		$total=0;
		for($i=0;$i<count($pedido);$i++){
			
			$data[$i]=array('numero'=>$contar,
			'codigo'=>$pedido[$i]['codigo'],
			'clave'=>$pedido[$i]['clave'],
			'descripcion'=>$pedido[$i]['nombre'],
			'cantidad'=>$pedido[$i]['total'],
			'unidad'=>$pedido[$i]['unidad'],	
			'precio'=>number_format($pedido[$i]['precio'],2),
			'total'=>number_format($pedido[$i]['gtotal'],2));	
			$total+=$pedido[$i]['gtotal'];
			$contar++;
		}
		
		$subtotal=$total/1.16;
		$iva=$total-$subtotal;
		
		$data[$i++]=array('numero'=>"",'codigo'=>"",'clave'=>"",'descripcion'=>"",'cantidad'=>"",'unidad'=>"",'precio'=>"Subtotal:",'total'=>number_format($subtotal,2));	
		$data[$i++]=array('numero'=>"",'codigo'=>"",'clave'=>"",'descripcion'=>"",'cantidad'=>"",'unidad'=>"",'precio'=>"Iva:",'total'=>number_format($iva,2));	
		$data[$i++]=array('numero'=>"",'codigo'=>"",'clave'=>"",'descripcion'=>"",'cantidad'=>"",'unidad'=>"",'precio'=>"Total:",'total'=>number_format($total,2));	
		
			
		$pdf->ezTable($data,$cols,"",array('xPos'=>'left','rowGrap'=>55,
			'shadeHeadingCol'=>array(.5960, .6985, .8784),
			'xOrientation'=>'right',
			'shaded'=>0,'showHeadings'=>1,'gridlines'=>31,'innerLineThickness' => 0.5,'outerLineThickness' =>0.5,
		
			'cols'=>array('numero'=>array('width'=>30,'justification'=>'center'),
			'cantidad'=>array('bgcolor'=>array(0.9,0.9,0.7),'width'=>60,'justification'=>'center')
			,'codigo'=>array('width'=>80,'justification'=>'center')
			,'clave'=>array('width'=>80,'justification'=>'center')
			,'descripcion'=>array('width'=>150,'justification'=>'left')
			,'unidad'=>array('width'=>60,'justification'=>'center')
			,'precio'=>array('width'=>60,'justification'=>'right')
			,'total'=>array('width'=>60,'justification'=>'right')
			),'fontSize' => 9));
	
	
	$pdf->ezStream();
	
?>