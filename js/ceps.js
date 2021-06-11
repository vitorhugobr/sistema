// JavaScript Document

function altera_Cep() {
	var cod = document.form1.cep.value;
	if (isNaN(cod)) {
		alert ("Por favor informe somente números no CEP");
		document.form1.txtCodigo.focus();
		return false;
	}
	if(cod.length<8) {
		alert('favor informar cep e consultar');
		document.form1.textfield.focus();
		return false;
	}

	var CadArray = new Array(11);
	CadArray[0]  = document.form1.cep.value;
	CadArray[1]  = document.form1.tipologia.value;
	CadArray[2]  = document.form1.rua.value;
	CadArray[3]  = document.form1.numeracao.value; 
	CadArray[4]  = document.form1.bairro.value;
	CadArray[5]  = document.form1.bairro2.value;
	CadArray[6]  = document.form1.cidade.value;					
	CadArray[7]  = document.form1.uf.value;
	CadArray[8]  = "";
	CadArray[9] = "";	
	CadArray[10] = document.form1.reg.value;
		
		// montagem dos parâmetros para passar
	var parString="";
	for (var i=0; i<11; i++) {
		if (i==0){
			parString = "P"+i+"="+CadArray[i];	
		}else{
			parString = parString+"&P"+i+"="+CadArray[i];	
		}
	}

//	alert(parString);
	if (confirm("Confirma a Alteração do CEP..: "+cod+"?")){
		ajax('altera_cep.php?'+parString,'modal');
	}
}	

//--------------------------------------------------------------------------------------------------------------------

function inclui_Cep() {
	var cod = document.form1.cep.value;
	if (isNaN(cod)) {
		alert ("Por favor informe somente números no CEP");
		document.form1.cep.focus();
		return false;
	}
	if(cod.length<7) {
		alert('favor informar CEP');
		document.form1.cep.focus();
		return false;
	}
	var CadArray = new Array(11);
	CadArray[0]  = document.form1.cep.value;
	CadArray[1]  = document.form1.tipologia.value;
	CadArray[2]  = document.form1.rua.value;
	CadArray[3]  = document.form1.numeracao.value;  
	CadArray[4]  = document.form1.bairro.value;
	CadArray[5]  = document.form1.bairro2.value;
	CadArray[6]  = document.form1.cidade.value;					
	CadArray[7]  = document.form1.uf.value;
	CadArray[8]  = "";// data cadastramento
	CadArray[9]  = "";
	CadArray[10] = document.form1.reg.value;
	if(CadArray[1].length<2) {
		alert('favor informar Tipologia');
		document.form1.tipologia.focus();
		return false;
	}
	if(CadArray[2].length<1) {
		alert('favor informar a Rua');
		document.form1.rua.focus();
		return false;
	}
	if(CadArray[4].length<1) {
		alert('favor informar Bairro');
		document.form1.bairro.focus();
		return false;
	}
	if(CadArray[6].length<1) {
		alert('favor informar Cidade');
		document.form1.cidade.focus();
		return false;
	}
	if(CadArray[7].length<1) {
		alert('favor informar UF');
		document.form1.uf.focus();
		return false;
	}
	if(CadArray[10].length<1) {
		alert('favor informar Regi\u00e3o de Entrega dos Correios');
		document.form1.reg.focus();
		return false;
	}

		// montagem dos parâmetros para passar
	var parString="";
	for (var i=0; i<11; i++) {
		if (i==0){
			parString = "P"+i+"="+CadArray[i];	
		}else{
			parString = parString+"&P"+i+"="+CadArray[i];	
		}
	}

	//alert(parString);
	ajax('inclui_cep.php?'+parString,'modal');
}	
//-------------------------------------------------------------------------------------------------------------
function exclui_Cep() {
	var cod = document.form1.cep.value;
	if (isNaN(cod)) {
		alert ("Por favor informe somente números no CEP");
		document.form1.cep.focus();
		return false;
	}
	if(cod.length<8) {
		alert('favor informar CEP');
		document.form1.cep.focus();
		return false;
	}
	
	if (confirm("Confirma a Exclusão do CEP..: "+cod+"?")){
		ajax('exclui_cep.php?cep='+cod,'modal');
	}
}	
//-------------------------------------------------------------------------------------------------------------
function busca_Cep(cod) {
//	alert (cod);
	document.form1.cep.value = cod;
	if (isNaN(cod)) {
		alert ("Por favor informe somente números no CEP");
		document.form1.cep.focus();
		return false;
	}
	if(cod.length<8) {
		alert('favor informar CEP');
		document.form1.cep.focus();
		return false;
	}
	ajax('pesquisa_ajax.php?cep='+cod+'&consulta=cep','modal');}	
//-------------------------------------------------------------------------------------------------------------