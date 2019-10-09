// JavaScript Document
//-----------------------------------------------------------------------------------------------------------------
function grava_visita() {
		$cod = document.visitas.txtcodigo.value;
		$data = document.visitas.txtdata.value;
		$assunto = document.visitas.txtassunto.value;
		//alert($cod+' - '+$data+' - '+$assunto); 
		ajax5('inclui_visita.php?codigo='+$cod+'&data='+$data+'&assunto='+$assunto, 'carregando');
	}

//--------------------------------------------------------------------------------------------------------------------			

