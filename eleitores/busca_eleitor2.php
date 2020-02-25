<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$codigo = $_GET['codigo'];
if (isset($codigo)){
	if ($codigo==0 ){
		$_SESSION['ult_eleitor_pesquisado'] = 0;
	}else{
		$query = "SELECT * from cadastro WHERE cadastro.CODIGO = $codigo";
//		echo $query;
		$mysql_query = $_con->query($query);
		if ($mysql_query->num_rows<1) {
			echo '<script>alert("ELEITOR não cadastrado!");document.form1.txtCodigo.focus();</script>';					
		}else{
			while ($dados_busca = $mysql_query->fetch_assoc()) {
				$_SESSION['ult_eleitor_pesquisado'] = $dados_busca['CODIGO'];
				echo '<script>';
				echo 'document.form1.txtCodigo.value = "'.$dados_busca['CODIGO'].'";';
				echo 'document.form1.txtNome.value = "'.$dados_busca['NOME'].'";';
				echo 'document.getElementById("lblnome0").innerHTML ="'.$dados_busca['NOME'].'";';		
				echo 'document.getElementById("lblnome1").innerHTML ="'.$dados_busca['NOME'].'";';		
				echo 'document.getElementById("lblnome2").innerHTML ="'.$dados_busca['NOME'].'";';		
				echo 'document.getElementById("lblnome3").innerHTML ="'.$dados_busca['NOME'].'";';		
				echo 'document.getElementById("lblnome4").innerHTML ="'.$dados_busca['NOME'].'";';		
				echo 'document.getElementById("lblnome5").innerHTML ="'.$dados_busca['NOME'].'";';		
				echo 'document.getElementById("lblnome6").innerHTML ="'.$dados_busca['NOME'].'";';		
				echo 'document.form1.txtSexo.value = "'.$dados_busca['SEXO'].'";';
				echo 'document.form1.txtDataNascimento.value = "'.$dados_busca['DTNASC'].'";';
				echo 'document.form1.txtGrupo.value= "'.$dados_busca['GRUPO'].'";';
				echo 'document.form1.txtOrigem.value="'.$dados_busca['ORIGEM'].'";';
				echo 'document.form1.txtCPF.value = "'.$dados_busca['CPF'].'";';
				echo 'document.form1.txtPaiMae.value = "'.$dados_busca['PAI_MAE'].'";';
				echo 'document.form1.txtZona.value = "'.$dados_busca['ZONAL'].'";';
				echo 'document.form1.txtSecao.value = "'.$dados_busca['SECCAO'].'";';
				echo 'document.form1.txtEmail.value = "'.$dados_busca['EMAIL'].'";';
				if ($dados_busca["FILIADO"]==0){
					echo 'document.form1.chkFiliado.checked=false;'; 
				}else{
					echo 'document.form1.chkFiliado.checked=true;'; 	
				}
				if ($dados_busca["RECEBEMAIL"]==0){
					echo 'document.form1.chkEmail.checked=false;';	
				}else{
					echo 'document.form1.chkEmail.checked=true;';	
				}
				if ($dados_busca["VOTOU"]==0){
					echo 'document.form1.chkVotou.checked=false;';	
				}else{
					echo 'document.form1.chkVotou.checked=true;';	
				}
				if ($dados_busca["IMPRESSO"]==0){
					echo 'document.form1.chkImpresso.checked=false;';	
				}else{
					echo 'document.form1.chkImpresso.checked=true;';	
				}
				echo 'document.form1.txtResidencial.value = "'.$dados_busca['FONE_RES'].'";';
				echo 'document.form1.txtCelular.value = "'.$dados_busca['FONE_CEL'].'";';
				echo 'document.form1.txtComercial.value = "'.$dados_busca['FONE_COM'].'";';
				echo 'document.form1.txtProfissao.value ="'. $dados_busca['PROFISSAO'].'";';
				echo 'document.form1.txtEmpresa.value = "'.$dados_busca['EMPRESA'].'";';
				echo 'document.form1.txtCargo.value = "'.$dados_busca['CARGO'].'";';
				echo 'document.form1.txtRamo.value ="'. $dados_busca['RAMO'].'";';
				echo 'document.getElementById("lbldtcad").innerHTML ="'.FormatDateTime( $dados_busca['DTCAD'],8).'";';
				echo 'document.getElementById("lbldtultalt").innerHTML = "'.FormatDateTime($dados_busca['DTULTALT'],8).'";';
				echo 'document.getElementById("lblrespcad").innerHTML = "'.$dados_busca['RESPCADASTRO'].'";';
				echo 'document.form1.txtCampanha.value = "'.$dados_busca['CAMPANHA'].'";';			
				echo 'document.form1.txtFace.value = "'.$dados_busca['FACEBOOK'].'";';			
				echo 'document.form1.txtTwitter.value = "'.$dados_busca['TWITTER'].'";';			
				echo 'document.form1.txtApelido.value = "'.$dados_busca['APELIDO'].'";';			
				echo 'document.form1.txtOutra.value = "'.$dados_busca['OUTRAREDE'].'";';			
				echo 'document.form1.txtEstadoCivil.value = "'.$dados_busca['EST_CIVIL'].'";';			
				echo 'document.form1.txtClass.value = "'.$dados_busca['CLASSI'].'";';	
				echo 'document.form1.txtObs.value = "'.$dados_busca['OBS'].'";';	
				echo 'document.getElementById("btnincvis").disabled = false;';
				$arquivo = "../imagens/fotos/".$dados_busca['CODIGO'].".jpg";
				if (file_exists($arquivo)) {
					echo 'document.getElementById("imgfoto").src = "'.$arquivo.'";';	
				} else {
					echo 'document.getElementById("imgfoto").src = "../imagens/fotos/sem.jpg";';	
				}		

			}		
			echo "</script>";
			$_SESSION['tab']= 0;
		}
	}
}

//---------------------------------------------------------------------------------------------------------------

?>



