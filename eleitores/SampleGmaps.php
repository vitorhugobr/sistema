<?php
require'EasyGoogleMap.class.php';
$gm = new EasyGoogleMap("ABQIAAAAoM-kEW8yHxWwveOZAouVXhTkQdzC1XuexHlQDsWmu58XcfHJ8xQB-xtA9nt_7NDWTsfJfHHxosdNZg");
$gm->SetMarkerIconStyle('PIN');
$gm->SetMapZoom(16);
$ender = "Rua Dom Vital 212, casa 23, Porto Alegre, RS, Brasil";
$nome = "Vitor H M Oliveira";
$gm->SetAddress($ender);
$gm->SetInfoWindowText($nome);
$gm->SetMapHeight(300);

?>
<html>
<head>
<title>..: Mapa de <?php echo $nome ;?> ..:</title>
<?php echo $gm->GmapsKey(); ?>
</head>
<body>
<?php echo $gm->MapHolder(); ?>
<?php echo $gm->InitJs(); ?>
<?php echo $gm->GetSideClick(); ?>
<?php echo $gm->UnloadMap(); ?>
</body>
</html>