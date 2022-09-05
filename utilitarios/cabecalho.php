 <div class="nav fixed-top container-fluid shadow mt-0 mb-0 bg-white rounded sticky-top"> 	
	<div class='col-1 text-center'>
		<img class="float" src="../imagens/vhmo.png" width="22" height="22"/>
		<span class="mr-1 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['sistemaabrev']?></span> 
		<span class="rodape"><?php echo $_SESSION['versao'].'-'.$_SESSION['id'];?></span> 
	</div>
	<div class="col-2 text-center" align="center"> 
		<?php 
		$imgpartido = "../imagens/".$_SESSION['partido'].".png";	
		?>
		<img src="<?php echo $imgpartido; ?>" height="30">
	</div>
	<div class='col-3' align="center">
		<span class="politico"><img src="<?php echo $_SESSION['imagem_camp']?>" height="30"><?php echo $_SESSION['politico'] ?>
		</span>
	</div>
	<div class='col-1 text-center'>
		<div id="carregando"></div>
	</div>
	<div class='col-2 text-center'>
		<span class="mr-1 d-none d-lg-inline text-gray-600 large"><?php echo $_SESSION['funcao']?></span>
	</div>
	<div class='col-3 text-right'>
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['primnome']?></span>
		<?php
			$arquivo = "../imagens/fotos/users/".$_SESSION['foto'];
			echo '<img class="img-profile rounded-circle" src="'.$arquivo.'" height="40px" width="40px">';
		?>
        <a href="../logout.php")>
            <img src="../imagens/sair.png" title="Sair do Sistema" height="25">
        </a>    
    </div>
</div>
<div id="results"><!-- Results are displayed here --></div>
<div id="fade"></div>
<div id="modal">
    <img id="loader" src="../imagens/aguarde_engrenagens.gif" />
</div>