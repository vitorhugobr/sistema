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
	case 2:  // Pujol
		$_SESSION['servidor'] = "www.rpujol.com.br";
		$_SESSION['banco'] = "rpujolco_pujol";
		$_SESSION['usuario'] = "rpujolco_pujol";
		$_SESSION['senha'] = "vhm@2019";
		//  senha cpanel: "@H2n,?9#l0pR"  usuário: "rpujolcom"
		break;
	case 3:  // Mauro Pinheiro
		$_SESSION['servidor'] = "www.mauropinheiro.net.br";
		$_SESSION['banco'] = "mauropin_mauro";
		$_SESSION['usuario'] = "mauropin_mauro";
		$_SESSION['senha'] = "vitor@2020";
		//	senha cpanel: ".@ypt?0iM_xF"  usuário: "mauropinheironet"
		break;
	case 4:  // Domingos Cunha
		$_SESSION['servidor'] = "www.domingoscunha.com.br";
		$_SESSION['banco'] = "domingos_domingos";
		$_SESSION['usuario'] = "domingos_domingo";
		$_SESSION['senha'] = "domi@2019";
		//	senha cpanel: "%Yb[2,XNP=D%"  usuário: "domingoscunhacom"
		break;
	case 5:  // Tessaro
		$_SESSION['servidor'] = "www.vereadortessaro.com.br";
		$_SESSION['banco'] = "vereador_sigre";
		$_SESSION['usuario'] = "vereador_tessaro";
		$_SESSION['senha'] = "tessaro@2019";
		//	senha cpanel: "cKGm;!X$aNdZ"    usuário: "vereadortessaroc"
		break;
	case 6:  // Democratas Porto Alegre
		$_SESSION['servidor'] = "www.rpujol.com.br";
		$_SESSION['banco'] = "rpujolco_dem";
		$_SESSION['usuario'] = "rpujolco_dem";
		$_SESSION['senha'] = "democrataspoa@2019";
		//	senha cpanel: "VHMO@@2019"  usuário: "rpujolcom"
		break;
	case 7:  // Sebastião Melo
		$_SESSION['servidor'] = "www.sebastiaomelo.poa.br";
		$_SESSION['usuario'] = "sebastia_melo";
		$_SESSION['senha'] = "lmqY{uxa(WrL";
		$_SESSION['banco'] = "sebastia_sigre"; 
		//	senha cpanel: "@H2n,?9#l0pR"  usuário: "sebastiaomelopoa"
		break;
	case 8:  // Luiz Braz
		$_SESSION['servidor'] = "www.vitor.poa.br";
		$_SESSION['usuario'] = "vitorpoa_luiz";
		$_SESSION['senha'] = "braz@2020";
		$_SESSION['banco'] = "vitorpoa_luizbraz"; 
		//	senha cpanel: "K_8zE{VmHQy1"  usuário: "vitorpoa"
		break;
	case 9:  // Local Testes
		$_SESSION['servidor'] = "localhost";
		$_SESSION['usuario'] = "root";
		$_SESSION['senha'] = "";
		$_SESSION['banco'] = "sigre_local"; 
/*      $_SESSION['servidor'] = "www.vitor.poa.br";
        $_SESSION['banco'] = "vitorpoa_teste";
        $_SESSION['usuario'] = "vitorpoa_user";
        $_SESSION['senha'] = "vhmo@2017";
*/		
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