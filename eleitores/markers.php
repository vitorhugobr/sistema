<?php
session_start();
require_once 'gmaps.class.php';
$gmaps = new gMaps;

# Adicionar marcador por endereco
//$gmaps->addMarkerAddress("RUA, NUMERO, CIDADE, SIGLA UF");
$endereco =  $_SESSION['tipolog']." ".$_SESSION['rua'].", ".$_SESSION['numero'].", ".$_SESSION['cidade'].", ".$_SESSION['uf'];

$gmaps->addMarkerAddress( $endereco);

# Retornar todos os markers adicionados em JSon
$gmaps->getMarkers();
?>