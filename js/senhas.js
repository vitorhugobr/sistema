// JavaScript Document
function grava_senha() {
		$cod = document.form1.txtCodigo.value;
		$atual = document.form1.txtSenha0.value;
		$senha = document.form1.txtSenha1.value;		
		if ($senha == $atual){
			var r = confirm("Confirma a alteração da Senha?");
			if (r == true) {
				ajax('altera_senha.php?cod='+$cod+'&senha='+$senha, 'carregando');
			} else {
				alert("Operação CANCELADA pelo usuário!");
				return false;
			}
		}else{
			alert('Senha e Confirma Senha estão diferentes.\nTente novamente');
			document.form1.txtSenha0.value = '';
			document.form1.txtSenha1.value ='';			
			document.form1.txtSenha0.focus();
			return;
		}
	}
//-----------------------------------------------------------------------------------------------------------------------
function busca_usuario() {
//		alert('Usuario: '+document.form1.txtUser.value);
		var usuar = document.form1.txtUser.value;
		if (usuar==""){
			alert ("Por favor informe o Usuário");
			document.form1.txtUser.focus();
			return false;
		}
		ajax('busca_user.php?user='+usuar+'&prg=ps', 'carregando');
	}
			
//--------------------------------------------------------------------------------------------------------------------			
