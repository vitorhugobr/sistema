// JavaScript Document
//-----------------------------------------------------------------------------------------------------------------
function grava_relation() {
		$cod = document.relations.txtcodigo.value;
		$son = document.relations.txtson.value;
		$tipo = document.relations.txttipo.value;
		//alert($cod+' - '+$data+' - '+$assunto); 
		ajax5('inclui_relation.php?codigo='+$cod+'&son='+$son+'&tipo='+$tipo, 'carregando');
	}

//--------------------------------------------------------------------------------------------------------------------			

function PesqCodigo($cod){
		ajax4('busca_relation.php?cod='+$cod+'&nome='+document.form1.txtNome.value, 'carregando');
}

//--------------------------------------------------------------------------------------------------------------------			

function novoeleitor(cod){
	alert('here');
	ajax3('muda_codigo.php?cod='+$cod, 'carregando');
}

//--------------------------------------------------------------------------------------------------------------------			
