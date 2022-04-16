<?php

$local_acesso = "acesso local";

$arqconfig = md5("mapa").".txt";

if (!file_exists($arqconfig)) {
	echo 'IMPOSSÍVEL ACESSAR O SISTEMA.<br>Arquivo de configuração excluído ou danificado! ';
	die;
} 	

$linhas = explode("\n", file_get_contents($arqconfig));
$_SESSION['cod_usuario'] = $linhas[0]; // usuario =A(100,80);

//----------------------------------------------------------------------------

//----------------------------------------------------------------------------
// Vitor POA
switch ($_SESSION['cod_usuario']) {
	case 1:  //Dr Thiago   www.drthiagoduarte.com.br
		$_SESSION['servidor'] = "191.252.101.58";
		$_SESSION['banco'] = "drthiago_sigre";
		$_SESSION['usuario'] = "sigre";
		$_SESSION['senha'] = "sigre2018";
		//	senha cpanel:   usuário: 
		//Acesso FTP
		//Host: 191.252.101.58:21
		//Usuário: sigre
		//Senha: sig-2021		
		break;
	case 2:  // Emerson
		$_SESSION['servidor'] = "www.serverwebdb.com.br";
		$_SESSION['banco'] = "chaplinb_chaplin";
		$_SESSION['usuario'] = "chaplinb_chaplin";
		$_SESSION['senha'] = "HpcOKYN7b2E-";
		//	senha cpanel: "QjT#mW@TxWgJ"  usuário: "chaplinbebidasco"		
		break;
	case 3:  // Mauro Pinheiro
		break;
	case 4:  // PSC
		$_SESSION['servidor'] = "www.vitor.poa.br";
		$_SESSION['banco'] = "vitorpoa_psc";
		$_SESSION['usuario'] = "vitorpoa_psc";
		$_SESSION['senha'] = "vhmo@2022";
		//	senha cpanel: "K_8zE{VmHQy1"  usuário: "vitorpoa"
		break;
	case 5:  // 
		break;
	case 6:  // 
		break;
	case 7:  // Sebastião Melo
		$_SESSION['servidor'] = "www.sebastiaomelo.poa.br";
		$_SESSION['usuario'] = "sebastia_melo";
		$_SESSION['senha'] = "lmqY{uxa(WrL";
		$_SESSION['banco'] = "sebastia_sigre"; 
		//	senha cpanel: "@H2n,?9#l0pR"  usuário: "sebastiaomelopoa"
		break;
	case 8:  // 
		break;
	case 9:  // 
	        break;		
}
// --------INIBIR LINHAS ABAIXO QDO PRODUÇÃO----------------------------------------
//		$_SESSION['servidor'] = "localhost";
//		$_SESSION['usuario'] = "root";
//		$_SESSION['senha'] = "";
//		$_SESSION['banco'] = "sigre_local"; 

// -------------------------------------------------------------------------
$_SESSION['servidorcomum'] = "www.vitor.poa.br";
$_SESSION['bancocomum'] = "vitorpoa_teste";
$_SESSION['usuariocomum'] = "vitorpoa_user";
$_SESSION['senhacomum'] = "vhmo@2017";
//----------------------------------------------------------------------------

define("ACESSO_LOC", $local_acesso);
?>