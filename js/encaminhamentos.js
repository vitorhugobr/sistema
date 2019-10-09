// JavaScript Document
	var $nivelusu='';
	var $condicao=0;
function traz_encaminha(numero,excluir,responder,imprimir) {
	//alert ('traz_encaminha');
	document.getElementById('numeroinv').innerHTML = "";
	document.getElementById('acaoenc').innerHTML = "";
	document.getElementById('botoes2').innerHTML = "";
	document.getElementById('caixa').innerHTML = "";
	document.getElementById('botoes').innerHTML = "";
	ajax('busca_encaminha.php?numero='+numero+'&exc='+excluir+'&resp='+responder+'&prt='+imprimir, 'caixa');
}

//-----------------------------------------------------------------------------------------------------

function responde_encaminha(numero) {
var $resposta= '<textarea name="txtresposta" cols="80" rows="10" class="form-control" placeholder="Digite a resposta neste campo" autofocus="autofocus"></textarea><br /><input type="checkbox" class="form-check" name="chkenviaemail" id="chkenviaemail" />  <label for="chkenviaemail">Enviar e-mail ao solicitante</label>&nbsp;<button type="button" class="btn btn-sm btn-primary" onclick="grava_Resposta('+numero+')"><i class="fas fa-plus" aria-hidden="true"></i> Incluir Resposta</button>';

document.getElementById('acaoenc').innerHTML = $resposta;
document.form1.txtResposta.focus();
//document.getElementById('botoes2').innerHTML = $botoes;
}

//------------------------------------------------------------------------------------------------------
function grava_Resposta(numero){
	
	var resp = document.form1.txtresposta.value;
	var chk = document.form1.chkenviaemail.checked;
	var param = 'inclui_resposta_encaminha.php?numero='+numero+'&resposta='+resp+'&chk='+chk;
//	alert(param);
	ajax(param, 'carregando');
}

//-------------------------------------------------------------------------------------------------------

function historico_encaminha(numero){
		ajax('busca_historico_encaminha.php?numero='+numero, 'acaoenc');
}

//-----------------------------------------------------------------------------------------------------

function encaminhaI(nivel,codigo) {

var param = 'novo_encaminha.php?codigo='+codigo+'&nivel='+nivel;
open(param,null,'height=400,width=1000,top=200,status=yes,toolbar=no,menubar=no,location=no');
}
			
//-----------------------------------------------------------------------------------------------------
// mostrara os encaminhamentos. Se condicao=0 mostra todos, se =1 mostra em aberto
function mostrarEnc(condicao) {
	$condicao=condicao;
	ajax('encaminha.php?cond='+$condicao, 'mostraE');
}
	
//-------------------------------------------------------------------------------------------------------------
