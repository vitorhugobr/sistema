//------------------------------------------
function update_event(tipo) {

	if(document.agenda.titulo.value.length<3) {
		alert('Obrigatório informar o título');
		document.agenda.titulo.focus();
		return false;
	}
//	alert("Update Evento "+tipo);
	var id = document.agenda.cod_evento.value;  //
	var titulo = document.agenda.titulo.value;  //
	var url = "";  //
	var inicio = document.agenda.datainicio.value;  //
	var fim  = document.agenda.datafim.value;  //
	var endereco  = document.agenda.endereco.value;  //
	var cor = document.agenda.cor.value;  //
	var cor = cor.replace("#", "");
	var tododia ;  //
	if (document.agenda.tododia.checked){
		tododia = 1;		
	}else{
		tododia = 0;	
	}		
	var holiday ;  //
	if (document.agenda.holiday.checked){
		holiday = 1;		
	}else{
		holiday = 0;	
	}		
	var opcao="";
	if (tipo=='A'){
		opcao= "Alteração";
	}else{
		if (tipo=='I'){
			opcao= "Inclusão";
		}else{
			opcao= "Exclusão";
		}
	}
	var parString="";
	parString = 'title='+ titulo+'&id='+ id+'&start='+ inicio +'&end='+ fim +'&allDay='+ tododia+'&color='+ cor+'&url='+ url+'&endereco='+ endereco+'&holiday='+ holiday ;
	if (confirm("Confirma a "+opcao+" do evento?")){
		if (tipo=='A'){
	//		alert(parString);
			ajax5('update_events.php?'+parString, 'carregando');
		}else{
			if (tipo=='I'){
				ajax5('add_events.php?'+parString, 'carregando');
			}else{
				ajax5('delete_events.php?id='+id, 'carregando');			
			}
		}
	}
}

//------------------------------------------------------------------
