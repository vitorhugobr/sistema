<nav class="navbar shadow mt-0 mb-0 bg-transparent rounded  fixed-bottom">
  <div class="container-fluid"> 
  	<span class="rodape"><?php echo $_SESSION['autor']?></span>
  	<span class="rodapeSigla"><?php echo $_SESSION['sistemaabrev']?>
    </span> 
	<a href="<?php $_SERVER['SERVER_NAME']?>/sigre/manual/manual.html" class="rodape" target="_blank"> Manual do Sistema <clique AQUI></a>
  	<span class="rodape">
			<?php echo $_SESSION['sistema'].' - '.'Versão '.$_SESSION['versao'];?>
    </span>
  </div>
</nav>