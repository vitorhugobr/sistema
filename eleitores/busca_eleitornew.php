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
				$codigo = $dados_busca['CODIGO'];
				$nome = $dados_busca['NOME'];
				$sexo = $dados_busca['SEXO'];
				$dtnasc = $dados_busca['DTNASC'];
				$grupo = $dados_busca['GRUPO'];
				$origem = $dados_busca['ORIGEM'];
				$cpf = $dados_busca['CPF'];
				$pai_mae = $dados_busca['PAI_MAE'];
				$zonal = $dados_busca['ZONAL'];
				$seccao = $dados_busca['SECCAO'];
				$email = $dados_busca['EMAIL'];
				if ($dados_busca["FILIADO"]==0){
					$filiado = false; 
				}else{
					$filiado = true;	
				}
				if ($dados_busca["RECEBEMAIL"]==0){
					$recebemail = false;	
				}else{
					$recebemail = true;	
				}
				if ($dados_busca["VOTOU"]==0){
					$votou =false;	
				}else{
					$votou =true;	
				}
				if ($dados_busca["IMPRESSO"]==0){
					$impresso =false;	
				}else{
					$impresso = true;	
				}
				$fone_res = $dados_busca['FONE_RES'];
				$fone_cel = $dados_busca['FONE_CEL'];
				$fone_com = $dados_busca['FONE_COM'];
				$profissao = $dados_busca['PROFISSAO'];
				$empresa = $dados_busca['EMPRESA'];
				$cargo = $dados_busca['CARGO'];
				$ramo = $dados_busca['RAMO'];
				$dtcad = FormatDateTime( $dados_busca['DTCAD'],8);
				$dtultalt = FormatDateTime($dados_busca['DTULTALT'],8);
				$respcadastro = $dados_busca['RESPCADASTRO'];
				$campanha = $dados_busca['CAMPANHA'];			
				$facebook = $dados_busca['FACEBOOK'];			
				$twitter = $dados_busca['TWITTER'];			
				$apelido = $dados_busca['APELIDO'];			
				$outrarede = $dados_busca['OUTRAREDE'];			
				$est_civil = $dados_busca['EST_CIVIL'];			
				$classi = $dados_busca['CLASSI'];	
				$obs =  $dados_busca['OBS'];	
				$arquivo = "../imagens/fotos/".$dados_busca['CODIGO'].".jpg";
				if (file_exists($arquivo)) {
					$imagem = $arquivo;	
				} else {
					$imagem = "../imagens/fotos/sem.jpg";	
				}		

			}	
			
			//-------- endereços -----------------------------------------------------------------------------------------
			
			$endrel='';
			$query = "SELECT * from enderecos_view WHERE codigo = ".$codigo.' order by padrao desc';
			$mysql_query = $_con->query($query);
			if ($mysql_query->num_rows>0) {
				while ($dados_endereco = $mysql_query->fetch_assoc()) {
					$id= $dados_endereco["id"];
					$codigo= $dados_endereco["codigo"];
					$cep= $dados_endereco["cep"];
					$cep_ed = substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
					$tipolog= $dados_endereco["tipolog"];
					$rua= $dados_endereco["rua"];
					$bairro= $dados_endereco["bairro"];
					$cidade= $dados_endereco["cidade"];
					$uf= $dados_endereco["uf"];
					$numero= $dados_endereco["numero"];
					$compl = $dados_endereco["complemento"];
					$padrao= $dados_endereco["padrao"];
					if ($padrao=="S"){
						$padrao="SIM";
					}else{
						$padrao= "NÃO";
					}
					$tipo= $dados_endereco["tipo"];			

					$reg= $dados_endereco["reg"];			
					$nome= $dados_endereco["nome"];			
					$param = $tipolog.' '.$rua.','.$numero.' '.$compl.' '.$bairro.' '.$cidade.' '.$uf.' '.$cep_ed;
					$enderecoed = '<div class="text-center"><i class="fas fa-home" aria-hidden="true"></i>&nbsp'.$tipolog.' '.$rua.', '.$numero.' '.$compl.' '.$bairro.' '.$cidade.', '.$uf.' - '.$cep_ed.', Brasil<br><strong>CDD:&nbsp</strong>'.$reg.' <strong>Tipo: </strong>'.$tipo.' <strong>Endereço Padrão: </strong>'.$padrao.'<br><button type="button" class="btn btn-sm btn-warning" onClick="AlteraEnd('.$id.')"><i class="fas fa-save" aria-hidden="true"></i> Alterar</button>';
					$endereco = $rua.' '.$tipolog.'+'.$rua.',+'.$numero.',+'.$bairro.',+'.$cidade.',+'.$uf;
					$enderecoed .= '<button type="button" class="btn btn-sm btn-danger" onClick="Exclui_ender('.$id.')"><i class="fas fa-trash" aria-hidden="true"></i> Excluir</button><a href="https://maps.google.com.br/maps?q='.$endereco.'" target="_blank" class="btn btn-success btn-sm" role="button" ><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Ver no Google Maps</a>';
				}
			}	
			
			// ----------- visitas -------------------------------------------------------
			
			$query = "SELECT * from visitas WHERE Visitante = ".$codigo." order by DataDaVisita desc";

			$mysql_query = $_con->query($query);
			$visitas=0;
			if ($mysql_query->num_rows>0) {
				$dadosvisita = '<div class="row bg-dark text-white"><div class="col-md-1"></div><div class="col-md-2">Data</div><div class="col-md-6">Assunto</div><div class="col-md-3"></div></div>';	
				$corbg = 1;
				while ($dados_visitas = $mysql_query->fetch_assoc()) {
					if ($corbg == 1){
						$colorbg = "bg-light";
						$corbg = 0;
					}else{
						$colorbg = "bg-white";
						$corbg = 1;
					}
					$dadosvisita .= '<div class="row '.$colorbg.'"><div class="col-1"></div><div class="col-2">'.FormatDateTime($dados_visitas["DataDaVisita"],7).'</div><div class="col-6">'.$dados_visitas["Assunto"].'</div><div class="col-3"><button type="button" class="btn btn-sm btn-danger" onClick="exclui_visita('.$dados_visitas["Visita"].')"><i class="fas fa-trash"></i> Excluir</button></div></div>';
					$visitas .= FormatDateTime($dados_visitas["DataDaVisita"],7)." - ".$dados_visitas["Assunto"].'\n';
				}
			}else{
				$dadosvisita = "Sem contatos";
			}
			//echo $dadosvisita;
			
// ----------------Demandas -----------------------------------------------------------------------------------------
			
			$query = "SELECT * from encaminhamentos_view WHERE codigo = ".$codigo." order by data desc";
			$mysql_query = $_con->query($query);
			$problemas=0;

			if ($mysql_query->num_rows>0) {
				while ($dados_demandas = $mysql_query->fetch_assoc()) {
					$numero = $dados_demandas['numero'];
					$situacao = $dados_demandas['situacao'];
					switch($situacao) {				
					  case 0:
						$temresposta= '<font color="#00CC33"><strong>Sem NENHUMA resposta</strong></font>';
						break;
					  case 1:	
						$temresposta= '<font color="#0000FF"><strong>Aberta</strong></font>';
						break;
					  case 2:
						$temresposta= '<font color="#FF6633"><strong>Encerrada</strong></font>';
						break;
					  default:			
						  break;
					}
				
					$dadosproblemas = '<div class="row"><div class="col-1"></div><div class="col-2"><strong>Data:&nbsp;<span class="text-success">'.FormatDateTime($dados_demandas["data"],7).'</span></strong></div><div class="col-7"><strong>Assunto:&nbsp;</strong>'.$dados_demandas["assunto"].'</div><div class="col-2"><strong>Situação:&nbsp;</strong>'.$temresposta.'</div></div><div class="row"><div class="col-1"></div><div class="col-11"><strong>DESCRIÇÃO: </strong>'.$dados_demandas["descricao"].'</div></div>';
										
					$query2 = "SELECT * from historico_encaminhamentos WHERE numero = ".$numero." order by data desc";
					$mysql_query2 = $_con->query($query2);
					if ($mysql_query2->num_rows>0) {
						$qtderesp=TRUE;
						while ($dados_demandas = $mysql_query2->fetch_assoc()) {
							$dadosproblemas .= '<div class="row"><div class="col-1"></div>';
							$dadosproblemas .= '<div class="col-11">Em&nbsp;'.FormatDateTime($dados_demandas["data"],7).'&nbsp;'.$dados_demandas['retorno'].'&nbsp;por&nbsp;'.$dados_demandas['usuario'].'</div></div>';
						}
						$dadosproblemas .= '<hr />';
					}
				}
			}else{
				$dadosproblemas = "Sem Demandas";
			}
			
// --------------- Vai buscar exames se for Dr Thiago ------------
			
			//echo "Usuário ID; ".$_SESSION['id']."<br>";
			if ($_SESSION['id']==1){
				$query = "SELECT * from exames_view WHERE cod_cadastro = ".$codigo." order by id desc, data desc";
				$mysql_query = $_con->query($query);
				$qtderegs = $mysql_query->num_rows;
				$tabela_exames = '<div class="table-responsive container-fluid"><table class="table-striped">
					<tr>
						<td colspan="5">
							<button type="button" onclick="javascript:inclui_exames('.$codigo.')" class="btn btn-sm btn-primary"><i class="fas fa-plus" aria-hidden="true"></i> Novo Exame </button>		
						</td>
					</tr>';
				if ($qtderegs ==0) {
					$tabela_exames .= '<tr><td><strong>SEM EXAMES</strong></td></tr>';
				}else{
					$linha = 1;
					$id_anterior = 0;
					while ($dados_exames = $mysql_query->fetch_assoc()) {
						$anohj = substr($dados_exames["data"],0,4);
						$meshj = substr($dados_exames["data"],5,2);
						$diahj = substr($dados_exames["data"],8,2);
						//echo $anohj." ".$meshj." ".$diahj."<br>"; 
						$arquivo = "../imagens/exames/".str_pad($dados_exames['cod_cadastro'],6,"0",STR_PAD_LEFT).$anohj.$meshj.$diahj.str_pad($dados_exames['cod_exame'],3,"0",STR_PAD_LEFT).str_pad($dados_exames['id'],3,"0",STR_PAD_LEFT).".jpg";
						if (file_exists($arquivo)) {
				//			echo $arquivo."<br>";
							$habilita_ver_imagem = true;	
						} else {
							$habilita_ver_imagem = false;	
						}		
						if ($dados_exames["id"]==$id_anterior){
							$tabela_exames .='<tr '.$classe.'>
								<td align="right" width="10%"></td>
								<td colspan="2" width="85%">'.$dados_exames["descricao"].'</td>
								<td width="10%">';
							if ($habilita_ver_imagem){	
									$tabela_exames .= '<a href="#" onclick="javascript:ver_exame_solicitado('.$dados_exames['cod_cadastro'].','.$anohj.$meshj.$diahj.','.$dados_exames['cod_exame'].','.$dados_exames['id'].')" class="btn btn-sm btn-warning btn-block" /><i class="fas fa-x-ray" aria-hidden="true"></i> Ver Exame 
									</a>';
							}
							$tabela_exames .= '</td>
								<td width="10%">
									<a href="#" title="Excluir o exame '.$dados_exames["descricao"].'" onclick="javascript:exclui_exame_solicitado('.$dados_exames['id'].')" class="btn btn-sm btn-danger btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir Item
									</a>
								</td>
								</tr>';
						}else{
							if ($linha == 1) {
								$classe = 'class="bg-light"';
								$linha =2;
							}else {
								$classe = 'class="bg-white"';
								$linha =1;
							}
							$tabela_exames .='<tr '.$classe.'>
								<td align="right" width="10%"><strong>Data:&nbsp;</strong></td>
								<td width="20%" class="text-primary"><strong>'.FormatDateTime($dados_exames["data"],7).'</strong></td>
								<td width="50%" class="text-secondary">#'.$dados_exames["id"].'</td>
								<td width="10%">
									<a href="#" title="Excluir TODOS Exames Solitados" onclick="javascript:exclui_exame('.$dados_exames['id'].')" class="btn btn-sm btn-warning btn-block" /><i class="fas fa-notes-medical" aria-hidden="true"></i> Excluir Solicitação
									</a>
								</td>
								<td width="10%">
									<a href="#" title="Imprimir Solicitação do exame" onclick="javascript:imprime_exames('.$dados_exames['cod_cadastro'].','.$dados_exames['id'].')" class="btn btn-sm btn-info btn-block" /><i class="fas fa-print" aria-hidden="true"></i> Imprimir
									</a>
								</td>
								</tr>
								<tr '.$classe.'>
								<td width="10%" align="right"><strong>Exame:&nbsp;</strong></td>
								<td colspan="2" width="70%">'.$dados_exames['descricao'].'</td>
								<td width="10%">';
							if ($habilita_ver_imagem){	
									$tabela_exames .= '<a href="#" onclick="javascript:ver_exame_solicitado('.$dados_exames['cod_cadastro'].','.$anohj.$meshj.$diahj.','.$dados_exames['cod_exame'].','.$dados_exames['id'].')" class="btn btn-sm btn-warning btn-block" /><i class="fas fa-x-ray" aria-hidden="true"></i> Ver Exame 
									</a>';
							}
							$tabela_exames .= '</td>
								<td width="10%">
									<a href="#" title="Excluir o exame '.$dados_exames["descricao"].'" onclick="javascript:exclui_exame_solicitado('.$dados_exames['id'].')" class="btn btn-sm btn-danger btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir Item
									</a>
								</td>
								</tr>';
						}
						$id_anterior = $dados_exames["id"];

					}		
				}
				$tabela_exames .='</table></div>';
				
// ---------------- Vai buscar prontuários --------------------------------------------------------------
				
				$prontuarios='';

				$queryf = "SELECT * from agenda_dia_clinica WHERE cod_cadastro = ".$codigo." and situacao = 2 order by data_agenda desc";
				$mysql_queryf = $_con->query($queryf);
				$qtderegsf = $mysql_queryf->num_rows;
				$msg = "";
				//echo "<br><br><br><br>".$query."<br>".$qtderegs."<br>";
				if ($qtderegsf>0) {
					while ($dadof = $mysql_queryf->fetch_assoc()) {
						$id = $dadof['id'];
						$data_agenda = $dadof['data_agenda']; 
						$msg .= " - ".FormatDateTime($data_agenda,7);
					}
					$prontuarios .= "<div style=\"height: 40px\" class=\"alert alert-danger text-center alert-dismissible fade show\" role=\"alert\">
						<font color=\"#E50206\"><strong>Paciente já faltou ".$qtderegsf." consulta(s) em ".$msg."</strong></font>
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Fechar\">
						<span aria-hidden=\"true\">&times;</span>
						</button>
						</div>";
				}

				$query = 'SELECT * from prontuario_view WHERE cod_cadastro = '.$codigo.' order by data_consulta desc';
				$mysql_query = $_con->query($query);
				$prontuarios .= '<div class=\"table-responsive container-fluid\"><table class=\"table-striped\">
					<tr>
						<td colspan=\"4\">';
				$prontuarios .= '<a href="#" title="Imprime atestado padrão" onclick="javascript:imprime_atestado('.$codigo.')" class="btn btn-sm btn-info" />			<i class="fas fa-file-medical" aria-hidden="true"></i> Atestado</a>';
				$prontuarios .='</td>
						</tr>';
				if ($mysql_query->num_rows==0) {
					$prontuarios .= '<tr><td><strong>SEM PRONTUÁRIOS</strong></td></tr>';
				}else{
					$linha = 1;
					while ($dados_prontuario = $mysql_query->fetch_assoc()) {
						if ($linha == 1) {
							$classe = 'class="bg-light"';
							$linha =2;
						}else {
							$classe = 'class="bg-white"';
							$linha =1;
						}
						$diago = $dados_prontuario['diagnostico'];
						$prontuarios .= '  
							<tr '.$classe.'>
							<td align="right" width="10%"><strong>Data da Consulta:&nbsp;</strong></td>
							<td width="80%">'.FormatDateTime($dados_prontuario['data_consulta'],7).'</td>
							<td width="5%">
								<button type="button" onclick="javascript:mostra_prontuario('.$dados_prontuario['id'].')" class="btn btn-sm btn-warning"><i class="fas fa-edit" aria-hidden="true"></i> Editar</button>
							</td>
							<td width="5%">
								<a href=\"#\" onclick="javascript:exclui_prontuario('.$dados_prontuario['id'].')" class="btn btn-sm btn-danger btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir
								</a>
							</td>
							</tr>
							<tr '.$classe.'>
							<td align="right"><strong>Clínica:&nbsp; </strong></td>
							<td colspan="3">'.$dados_prontuario['nome_clinica'].'</td>
							</tr>
							<tr '.$classe.'>
							<td align="right" valign="top"><strong>Diagnóstico:&nbsp;</strong></td>
							<td colspan="3" valign="top">'.htmlspecialchars_decode($diago).'</td>
							</tr>
				</tr>';

					}		
				}
				$prontuarios .='</table></div>';
				
// ---------------------- Vai buscar receitas ----------------------------------------------------------------
				$primeira=true;
				$query = "SELECT * from receituario_view WHERE cod_cadastro = ".$codigo." order by data desc";
				$mysql_query = $_con->query($query);
				$qtderegs = $mysql_query->num_rows;
				$receitas = '<div class="table-responsive container-fluid"><table class="table-bordless">
							<tr>
								<td colspan="4">
									<button type="button" onclick="javascript:inclui_receituario('.$codigo.')" class="btn btn-sm btn-primary"><i class="fas fa-plus" aria-hidden="true"></i> Novo Receituário </button>
								</td>
							</tr>';


				if ($qtderegs==0) {
					$receitas .= '<strong>SEM RECEITAS</strong>';
				}else{
					$linha = 1;
					while ($dados_receita = $mysql_query->fetch_assoc()) {
						if ($linha == 1) {
							$classe = 'class="bg-light"';
							$linha =2;
						}else {
							$classe = 'class="bg-transparent"';
							$linha =1;
						}
						$tp_uso = $dados_receita['tp_uso'];
						if ($tp_uso == 0){
							$tp_uso = "Interno";
						}else {
							$tp_uso = "Externo";
						}
						$diago = "";
						$controlado = $dados_receita['controlado'];
						if ($controlado == 0){
							$controlado = "Não";
						}else {
							$controlado = "Sim";
						}
						$receitas .= '  
							<tr '.$classe.'>
							<td align="right" width="10%"><strong>Data da Receita:&nbsp;</strong></td>
							<td width="75%">'.FormatDateTime($dados_receita["data"],7).'</td>
							<td width="5%">
								<button type="button" onclick="javascript:mostra_receituario('.$dados_receita['id'].')" class="btn btn-sm btn-warning btn-block"><i class="fas fa-edit" aria-hidden="true"></i> Editar</button>
							</td>
							<td width="5%">
								<button type="button" onclick="';
								if ($controlado=="Sim"){
									$tabela .= "imprime_receituario_especial(".$dados_receita['id'].")";
								}else{
									$tabela .= "imprime_receituario(".$dados_receita['id'].")";
								}					
								$tabela .= '" class="btn btn-sm btn-success btn-block"><i class="fas fa-print" aria-hidden="true"></i> Imprimir</button>
							</td>
							<td width="5%">
								<a href="#" onclick="javascript:excluir_receituario('.$dados_receita['id'].')" class="btn btn-sm btn-danger btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir
								</a>
							</td>
							</tr>
							<tr '.$classe.'>
							<td align="right" valign="top"><strong>Controle Especial:&nbsp;</strong></td>
							<td colspan="4" valign="top">'.$controlado.'</td>
							</tr>
							<tr '.$classe.'>
							<td align="right" valign="top"><strong>Tipo de Uso:&nbsp;</strong></td>
							<td colspan="4" valign="top">'.$tp_uso.'</td>
							</td>
							</tr>
					</tr>
						<tr '.$classe.'>
							<td align="right" valign="top"><strong>Medicamento(s):&nbsp;</strong></td>';
						$query2 = "SELECT * from dados_receita WHERE cod_receita = ".$dados_receita['id'];
						$mysql_query2 = $_con->query($query2);
						$primeiro = 0;
						if ($mysql_query2->num_rows==0) {
							$receitas .= '<td colspan ="4"><span class="text-danger"><strong>SEM MEDICAMENTOS NESTA RECEITA</strong></span></td></tr>';
						}else{
							while ($remedios = $mysql_query2->fetch_assoc()) {
								$medicamento = $remedios['medicamento'];
								$qtde = $remedios['qtde'];
								$posologia = $remedios['posologia'];
								if ($primeiro==0){
									$receitas .= 
										'<td colspan="4" width="80%" align="left"><strong>'.$medicamento.'&nbsp;&nbsp;->'.$qtde.'</strong></td>
										</tr>
										<tr '.$classe.'>
											<td width="5%"></td>
											<td colspan="4" align="left">'.$posologia.'</td>
										</tr>';	
									$primeiro=1;	
								}else{
									$receitas .= 
										'<tr '.$classe.'>
											<td width="5%"></td>
											<td colspan="4" width="80%" align="left"><strong>'.$medicamento.'&nbsp;&nbsp;->'.$qtde.'</strong></td>
										</tr>
										<tr '.$classe.'>
											<td width="5%"></td>
											<td colspan="4" align="left">'.$posologia.'</td>
										</tr>';				
									}

							}
						}
					}		
				}
				$receitas .='</table></div>';
			}
// ---------------ENCERRA BUSCA DE DADOS DO ELEITOR. AGORA VAI MOSTRAR NA TELA --------------------------------------------	
			?>
			<script>
			document.form1.txtCodigo.value = '<?php echo $codigo ?>';
			document.form1.txtNome.value = '<?php echo $nome ?>';
			document.form1.txtSexo.value = '<?php echo $sexo ?>';
			document.getElementById("lblnome0").innerHTML =document.getElementById("lblnome1").innerHTML =document.getElementById("lblnome2").innerHTML =document.getElementById("lblnome3").innerHTML =document.getElementById("lblnome4").innerHTML =document.getElementById("lblnome5").innerHTML =document.getElementById("lblnome6").innerHTML ='<?php echo $nome ?>';		

			document.form1.txtDataNascimento.value = '<?php echo $dtnasc ?>';
			document.form1.txtGrupo.value= '<?php echo $grupo ?>';
			document.form1.txtOrigem.value='<?php echo $origem ?>';
			document.form1.txtCPF.value = '<?php echo $cpf ?>';
			document.form1.txtPaiMae.value = '<?php echo $pai_mae ?>';
			document.form1.txtZona.value = '<?php echo $zonal ?>';
			document.form1.txtSecao.value = '<?php echo $seccao ?>';
			document.form1.txtEmail.value = '<?php echo $email ?>';
			document.form1.chkFiliado.checked='<?php echo $filiado ?>'; 
			document.form1.chkEmail.checked='<?php echo $recebemail ?>';	
			document.form1.chkVotou.checked='<?php echo $votou ?>';	
			document.form1.chkImpresso.checked='<?php echo $impresso ?>';	
			document.form1.txtResidencial.value = '<?php echo $fone_res ?>';
			document.form1.txtCelular.value = '<?php echo $fone_cel ?>';
			document.form1.txtComercial.value = '<?php echo $fone_com ?>';
			document.form1.txtProfissao.value = '<?php echo $profissao ?>';
			document.form1.txtEmpresa.value = '<?php echo $empresa ?>';
			document.form1.txtCargo.value = '<?php echo $cargo ?>';
			document.form1.txtRamo.value = '<?php echo $ramo ?>';
			document.getElementById("lbldtcad").innerHTML = '<?php echo $dtcad ?>';
			document.getElementById("lbldtultalt").innerHTML = '<?php echo $dtultalt ?>';
			document.getElementById("lblrespcad").innerHTML = '<?php echo $respcadastro ?>';
			document.form1.txtCampanha.value = '<?php echo $campanha ?>';			
			document.form1.txtFace.value = '<?php echo $facebook ?>';			
			document.form1.txtTwitter.value = '<?php echo $twitter ?>';			
			document.form1.txtApelido.value = '<?php echo $apelido ?>';			
			document.form1.txtOutra.value = '<?php echo $outrarede ?>';			
			document.form1.txtEstadoCivil.value = '<?php echo $est_civil ?>';			
			document.form1.txtClass.value = '<?php echo $classi ?>';	
			document.form1.txtObs.value = '<?php echo $obs ?>';	
			document.getElementById("btnincvis").disabled = false;
			document.getElementById("imgfoto").src = '<?php echo $arquivo ?>';	

			document.getElementById("dados").innerHTML = '<?php echo $enderecoed ?>';
			document.form1.txtEnderecos.value = '<?php echo $param ?>';	
			document.getElementById("visit").innerHTML = '<?php echo $dadosvisita ?>';
			document.form1.txtVisitas.value = '<?php echo $visitas ?>';	
			document.getElementById("solution").innerHTML = '<?php echo $dadosproblemas ?>';
			
			</script>
			<?php

		}		
	}
}



?>



