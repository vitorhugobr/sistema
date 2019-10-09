<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$codigo = $_GET['codigo'];
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
		<link rel="icon" href="../imagens/favicon.ico">
    <title>How to Use Webcam In PHP</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  	<link href="../css/formata_textos.css" rel="stylesheet">
  <link href="../css/all.css" rel="stylesheet">

	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
  	<link href="../css/botoes.css" rel="stylesheet">
   </head>

  <body>
	<?php include_once("../utilitarios/cabecalho.php");?>
    <div class="container">
        <div class="row"></div>
        <div class="col-md-6">
            <div class="text-center">
        <div id="camera_info"></div>
    <div id="camera"></div><br>
    <button id="take_snapshots" class="btn btn-incluir btn-sm"><i class="fas fa-user"></i> Tirar Foto</button>
      </div>
        </div>
        <div class="col-md-6">
            <table class="table table-borderless">
            <thead>
                <tr>
                    <th>Foto de <?php echo $codigo?></th>
                </tr>
            </thead>
            <tbody>
            <div id="imagelist" hidden=""></div>
            
            </tbody>
        </table>
        </div>
    </div> <!-- /container -->
	<?php include_once("../utilitarios/rodape.php");?>
  </body>
</html>
<style>
#camera {
  width: 300px;
  height: 400px;
}

</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="jpeg_camera/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
<script>
    var options = {
      shutter_ogg_url: "jpeg_camera/shutter.ogg",
      shutter_mp3_url: "jpeg_camera/shutter.mp3",
      swf_url: "jpeg_camera/jpeg_camera.swf",
    };
    var camera = new JpegCamera("#camera", options);
  
  $('#take_snapshots').click(function(){
    var snapshot = camera.capture();
    snapshot.show();
    
    snapshot.upload({api_url: "action.php"}).done(function(response) {
$('#imagelist').prepend("<tr><td><img src='"+response+"' width='130px' height='100px'></td><td>"+response+"</td></tr>");
}).fail(function(response) {
  alert("Upload failed with status " + response);
});
})
//-----------------------------------------------------------------------------------------------------
function done(){
    $('#snapshots').html("uploaded");
}
//-----------------------------------------------------------------------------------------------------
function reload_foto() {
	location.reload();
  }
//-----------------------------------------------------------------------------------------------------
</script>
