<?php
session_start();

	$codigo = $_GET['codigo'];
	$_docxml = new DOMDocument('1.0');
	$_resp   = $_docxml->createElement('info');
	$_cod    = $_docxml->createElement('codigo');
	$_id	 = $_docxml->createTextNode($codigo);
	$_cod->appendChild($_id);
	$_resp->appendChild($_cod);
	$_docxml->appendChild($_resp);
	header('Content-type: application/xml');
	echo $_docxml->saveXML();		

?>

