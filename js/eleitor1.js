/// JavaScript Document
function AtualizaEleitor(y_funcao) {
//	alert("function AtualizaEleitor");
	var CadArray = new Array(37);
	
	CadArray[0]  = document.form1.txtCodigo.value;
	CadArray[1]  = document.form1.txtNome.value;
	CadArray[2]  = document.form1.txtSexo.value;
	if (y_funcao=="A"){
		CadArray[3]  = document.getElementById('lbldtcad').innerHTML;  // data cadastramento
	}else{
		  CadArray[3]  =  "";
	}
	CadArray[4]  = document.form1.txtDataNascimento.value;
	CadArray[5]  = document.form1.txtCargo.value;
	CadArray[6]  = document.form1.txtResidencial.value;					
	CadArray[7]  = document.form1.txtCelular.value;
	CadArray[8]  = document.form1.txtComercial.value;
	CadArray[9]  = document.form1.txtCPF.value;
	CadArray[10] = document.form1.txtObs.value;						
	CadArray[11] = "A";						
	CadArray[12] = document.form1.txtEmail.value;
	CadArray[13] = document.form1.txtGrupo.value;	
	CadArray[14] = document.form1.txtOrigem.value;
	CadArray[15] = document.form1.txtProfissao.value;
	CadArray[16] = document.form1.txtZona.value;
	CadArray[17] = document.form1.txtSecao.value;
	CadArray[18] = document.form1.txtPaiMae.value;				
	if (document.form1.chkFiliado.checked){
		CadArray[19] = 1;		
	}else{
		CadArray[19] = 0;	
	}																
	CadArray[20] = 0;		
	CadArray[21] = "X"; //responsavel pelo cadastro, será colocado na pagina php
	CadArray[22] = "X"; //data da ultima alteraçao será inicializada na pagina php
	CadArray[23] = document.form1.txtEmpresa.value;
	if (document.form1.chkVotou.checked){
		CadArray[24] = 1;		
	}else{
		CadArray[24] = 0;	
	}		
	CadArray[25] = document.form1.txtRamo.value;
	if (document.form1.chkEmail.checked){
		CadArray[26] = 1;		
	}else{
		CadArray[26] = 0;	
	}
	if (document.form1.chkImpresso.checked){
		CadArray[27] = 1;		
	}else{
		CadArray[27] = 0;	
	}
	CadArray[28] = "" //document.getElementById('output').innerHTML;  
//	alert (CadArray[28]);
	CadArray[29] = document.form1.txtCampanha.value;	
	CadArray[30] = document.form1.txtFace.value;	
	CadArray[31] = document.form1.txtTwitter.value;	
	CadArray[32] = document.form1.txtOutra.value;	
	CadArray[33] = 0;	
	CadArray[34] = document.form1.txtApelido.value;	
	CadArray[35] = document.form1.txtEstadoCivil.value;	
	CadArray[36] = document.form1.txtClass.value;	
	// montagem dos parâmetros para passar
	var parString="";
	for (var i=0; i<37; i++) {
		if (i==0){
			parString = "P"+i+"="+CadArray[i];	
		}else{
			parString = parString+"&P"+i+"="+CadArray[i];	
		}
	}
//	alert(y_funcao);
//	alert (parString);
	if (y_funcao=="I") {
		if (confirm("Confirma a Inclusão do registro de "+document.form1.txtNome.value)){
			ajax('inclui_eleitor.php?'+parString,'modal');	
		}
	}else{ 
		if (y_funcao=="A"){
			if (confirm("Confirma a Alteração no registro de "+document.form1.txtNome.value)){
				ajax2('altera_eleitor.php?'+parString,'modal');
			}
		}else{
			if (y_funcao=="P"){
				var parametro = 'imprime_eleitor.php?'+parString;
			  	open(parametro,null,'height=600,width=1200,top=100,left=100,status=no,titlebar=no,toolbar=no,scrollbars=yes,menubar=no,location=no');
			}else{
				if (confirm("Confirma a Exclusão do registro de"+document.form1.txtNome.value)){
					ajax('exclui_eleitor.php?'+parString,'modal');
				}
			}
		}	
	}
}

//---------------------------------------------------------------------------------------

function carga_foto(){
//	alert ('veio');
  var cod = document.form1.txtCodigo.value;
  if (document.form1.txtCodigo.value==""){
	alert ("Nenhum Eleitor consultado\nPor favor faça a consulta!");
	document.form1.txtNome.focus();
	return false;
  }else{
	var parametros = 'tirar_foto.php?codigo='+cod;
	open(parametros,null,'height=600,width=500,top=100,status=yes,toolbar=no,menubar=no,location=no');
  }
}

//----------------------------------------------------------------------------------------------------------------
function consisteCondicao(){
	var cond = document.form1.txtCondicao.value;
	if (cond=="A"){
		//document.getElementById('descCond').innerHTML = 'Ativo';
	}
}
//--------------------------------------------------------------------------
function EditSolution(id){
	//--- aqui vai incluir um problema, por isso a variavel otipo recebe I
	var cod = document.form1.txtCodigo.value;
	var nome = document.form1.txtNome.value;
	var param = 'solution.php?otipo=A&cod='+cod+'&nome='+nome+'&id='+id;
	open(param,null,'height=350,width=770,top=200,status=yes,toolbar=no,menubar=no,location=no');
}

//---------------------------------------------------------------------------------------


function Exclui_ender(id) {

	if (confirm("Confirma a Exclusão do Endereço?")){
		ajax('exclui_endereco.php?id='+id,'modal');			
	}

}

//------------------------------------------------------------------------------------
function excluir_receituario(id) {
	// esta function salva os medicamentos do recituario no banco
	//alert("function salvar remedio");
	var parString = "exclui_receituario.php?id="+id;
//	alert(parString);
	if (confirm("Confirma a Exclusão do Receituário")){
		ajax(parString,'modal');	
	}
}
//------------------------------------------------------------------------------

function excluir_remedio(id) {
	// esta function salva os medicamentos do recituario no banco
	//alert("function salvar remedio");
	var parString = "exclui_remedio.php?id="+id;
//	alert(parString);
	if (confirm("Confirma a Exclusão do medicamento")){
		ajax(parString,'modal');	
	}
}
//------------------------------------------------------------------------------

function exclui_visita(id) {

	if (confirm("Confirma a Exclusão do Contato?")){
		ajax('exclui_visita.php?id='+id,'modal');			
	}

}

//----------------------------------------------------------------------------------
function getDados(objForm){
	var params = new Array();
	for (var i=0; i<objForm.elements.length;i++){
		var parametro = encodeURIComponent(objForm.elements[i].name);
		parametro += "=";
		parametro += encodeURIComponent(objForm.elements[i].value);
		params.push(parametro)
	}
	return params.join("&");
}
//---------------------------------------------------------------------------------------------------------
function grava_prontuario(){
//	var id = document.form1.id_prontuario.value;falta
//	var diagnos = CKEDITOR.instances.diagnostic.getData();
//	alert(parametros);
	if (confirm("Confirma a gravação do Prontuário ")){
		ajaxPost("gravar_prontuario.php","carregando");
	}
}

//--------------------------------------------------------------------------
function gravar_remedio(id,indice) {
	// esta function salva os medicamentos do recituario no banco
	//alert("function salvar remedio");
  var remedio = document.getElementsByName('remedio');
  var nomeremedio = remedio[indice].value;
  var qtde = document.getElementsByName('qtde');
  var qtde_remedio = qtde[indice].value;
  var posologia = document.getElementsByName('posologia');
  var comotomar = posologia[indice].value;
  var parString="id="+id+"&remedio="+nomeremedio+"&qtde="+qtde_remedio+"&posologia="+comotomar;
	var parString = "gravar_remedio.php?"+parString;
//	alert(parString);
	if (confirm("Confirma a Alteração do medicamento")){
		ajax(parString,'modal');	
	}
}
//------------------------------------------------------------------------------
function imprime() {
	var cod = document.form1.txtCodigo.value;
		if(cod=='') {
			alert('Por Favor informe o código para imprimir');
			document.form1.txtCodigo.focus();
			return;
		}
		//limpaTela();
		ajax('eleitor_fpdf.php','modal');
}	
//-----------------------------------------------------------------------------------------------------------------
function imprime_atestado(cod_cadastro) {
	var parametro = 'imprime_atestado.php?cod_cadastro='+cod_cadastro;
	//alert(parametro);
	open(parametro,null);
}
//-----------------------------------------------------------------------------------------------------------------
function imprime_receituario_especial(id) {
	var parametro = 'imprime_receita_especial.php?id='+id;
	//alert(remedios);
	open(parametro,null,'top=100,left=100,status=no,titlebar=no,toolbar=no,scrollbars=yes,menubar=no,location=no');
}
//-----------------------------------------------------------------------------------------------------------------
function imprime_receituario(id) {
	var parametro = 'imprime_receita.php?id='+id;
	//alert(remedios);
	open(parametro,null,'top=100,left=100,status=no,titlebar=no,toolbar=no,scrollbars=yes,menubar=no,location=no');
}
//-----------------------------------------------------------------------------------------------------------------

function imprimir(formulario){
	AjaxRequest();
	if(!Ajax) {
		alert('Não foi possível iniciar o AJAX');
	return;
	}
	var $dados = getDados(formulario);
	Ajax.onreadystatechange = printcadastro(document.form1.txtCodigo.value);						
	Ajax.open('POST', 'eleitor_fpdf.php', true);
	Ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	Ajax.send($dados);				
	return false;
}

//-----------------------------------------------------------------------------------------------------------------
function AlteraEnd(id){
	"use stricts";
	//alert(comando);
	var comando = 'enderecos.php?otipo=A&id='+id;
	open(comando,'_self');
		
}

//----------------------------------------------------------------------------------

function IncluiEnder(){
	document.form1.sessionCodigo.value = document.form1.txtCodigo.value;
	open('inclui_endereco.php?cod='+document.form1.txtCodigo.value,null,'height=350,width=800,top=150,status=yes,toolbar=no,menubar=no,location=no');
}

//------------------------------------------------------------------------------------
function inclui_receituario(cod_cad){
	// esta function abre o formulário de receituário
	var parametros = 'novo_receituario.php?cod_cad='+cod_cad;
//	alert(parametros);
	window.location.replace(parametros);
}

//------------------------------------------------------------------------------------
function LimpaSessionCod(){
	ajax3('zera_codigo.php','modal');

}

//-------------------------------------------------------------------------------------------------------------
function mostra_mapa(ender) {
	var nome = document.form1.txtNome.value;
	open('SampleGmaps.php?ender='+ender+'&nome='+nome,null,'height=350,width=900,top=150,status=yes,toolbar=no,menubar=no,location=no');	
}

//----------------------------------------------------------------------------------

function mostra_prontuario(prontuario){
	var parametros = 'prontuario.php?id='+prontuario;
//	alert(parametros);
	window.location.replace(parametros);
}

//-----------------------------------------------------------------------------------------------------------------
function mostra_receituario(id){
	var parametros = 'receituario.php?id='+id;
//	alert(parametros);
	window.location.replace(parametros);
}
//-----------------------------------------------------------------------------------------------------------------
function NewEnd(){
	var cod = document.form1.txtCodigo.value;
	var parametros = 'enderecos.php?otipo=I&id='+cod;
	open(parametros,'_self');

	
	
}

//---------------------------------------------

function OpenSolution(){
	//--- aqui vai incluir um problema, por isso a variavel otipo recebe I
	var cod = document.form1.txtCodigo.value;
	var nome = document.form1.txtNome.value;
	var param = 'solution.php?otipo=I&cod='+cod+'&nome='+nome;
	open(param,null,'height=350,width=770,top=200,status=yes,toolbar=no,menubar=no,location=no');
}

//---------------------------------------------------------------------------------------
function OpenVisita(){
	var cod = document.form1.txtCodigo.value;
	var nome = document.form1.txtNome.value;
	var param = 'visitas.php?cod='+cod+'&nome='+nome;
	open(param,null,'height=350,width=770,top=200,status=yes,toolbar=no,menubar=no,location=no');
}

//---------------------------------------------------------------------------------------
function PesquisaEleitor(cod){
	if (cod==0){
		return;
	}
	//var nome = document.form1.txtNome.value;
	//alert(cod);
	ajax('busca_eleitor.php?codigo='+cod,'modal');
	//ajax2('busca_enderecos.php?cod='+cod, 'dados');
//	ajax3('busca_visitas.php?cod='+cod,'visit');
//	ajax6('busca_demandas.php?cod='+cod,'solution');	
//	ajax4('busca_exames.php?cod='+cod,'exames');
//	ajaxP('busca_receitas.php?cod='+cod,'receituario');
//	ajax5('busca_prontuarios.php?cod='+cod,'prontuario');

	//window.location.reload(true);
}
//-----------------------------------------------------------------------------------------------------------------
function pesquisaprontuario(id){
//	alert(id);
	ajax5('busca_prontuario.php?id='+id,'modal');
}

//--------------------------------------------------------------------------
function printcadastro(codigo) {
  if (Ajax.readyState == 1) {
	  document.getElementById('carregando').innerHTML = "<img src='../imagens/ajax-loading2.gif'>";
  }
  if (Ajax.readyState == 4) {					
	  if (Ajax.status == 200) {
		  document.getElementById('carregando').innerHTML = '';
		  document.form1.txtCodigo.value = codigo;
		  PesquisaEleitor(codigo);
	  } else {
		  alert('printcadastro() Erro no Retorno do Servidor ' + Ajax.statusText);
	  }
  }
}

//-----------------------------------------------------------------------------
function valida_cadastro(x_funcao)
{
//	alert(x_funcao);
	if (x_funcao=="A" || x_funcao=="I"){
		if (document.form1.txtNome.value==""){
			alert ("Por favor digite o nome");
			document.form1.txtNome.focus();
			return false;
		} 

		if(document.form1.chkEmail.checked){
			if (document.form1.txtEmail.value=="") { 
				alert ("Para receber e-mail, o mesmo deve ser informado.");
				document.form1.txtEmail.focus();
				return false;
			}
		}
				
		if (!document.form1.txtEmail.value=="") { 
			if (document.form1.txtEmail.value.indexOf('@', 0) == -1 || document.form1.txtEmail.value.indexOf('.', 0) == -1) {
				alert ("E-mail inválido.");
				document.form1.txtEmail.focus();
				return false;
			}
		}
		if (document.form1.txtOrigem.value.length<1 || document.form1.txtOrigem.value==0 || document.form1.txtOrigem.value=="") {
			alert('Campo ORIGEM é obrigatório');
			document.form1.txtOrigem.focus();
			return;
		}
		if (document.form1.txtGrupo.value.length<1 || document.form1.txtGrupo.value==0 || document.form1.txtGrupo.value=="") {
			alert('Campo GRUPO é obrigatório');
			document.form1.txtGrupo.focus();
			return;
		}
	}
	AtualizaEleitor(x_funcao);
return true;

}
//---------------------------------------------------------------------------------------------------------------
function validaI(){valida_cadastro("I");}
//-->
function validaA(){valida_cadastro("A");}
//-->
function validaE(){valida_cadastro("E");}
//-->
function validaP(){valida_cadastro("P");}
//-------------------------------------------------------------------------------------------------
