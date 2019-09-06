<?php
	//require_once("db_.php");
	$idcomision=$_REQUEST['id'];
	$tipo=$_REQUEST['tipo'];

	if($tipo==1){			/////////////////comision pdf

		include 'barcode.php';
		$filepath = (isset($_GET["filepath"])?$_GET["filepath"]:"");
		$text = (isset($_GET["text"])?$_GET["text"]:"0");
		$size = (isset($_GET["size"])?$_GET["size"]:"20");
		$orientation = (isset($_GET["orientation"])?$_GET["orientation"]:"horizontal");
		$code_type = (isset($_GET["codetype"])?$_GET["codetype"]:"code128");
		$print = (isset($_GET["print"])&&$_GET["print"]=='true'?true:false);
		$sizefactor = (isset($_GET["sizefactor"])?$_GET["sizefactor"]:"1");

		$filepath="";
		$text="900000001";
		$size=200;
		$archivo=barcode($filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );

		set_include_path('../librerias15/pdf2/src/'.PATH_SEPARATOR.get_include_path());
		include 'Cezpdf.php';
		$pdf = new Cezpdf('letter','portrait','color',array(255,255,255));
		$pdf->selectFont('Helvetica');
		//$pdf->addJpegFromFile($filepath,100,500,100);
		$pdf->addJpegFromFile($archivo,100,500,100);
		$pdf->ezStream();
	}


	echo "<img src='$filepath'>";
?>
