<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$codigo = $_GET['codigo'];
unset($_SESSION['msgativo']);
if (isset($codigo)){
#	if ($codigo==0 ){
		$_SESSION['ult_eleitor_pesquisado']=0;
#	}else{
		$querycad = "SELECT 
		  cadastro.CODIGO,
		  cadastro.NOME,
		  cadastro.SEXO,
		  cadastro.DTCAD,
		  cadastro.DTNASC,
		  cadastro.CARGO,
		  cadastro.FONE_RES,
		  cadastro.FONE_CEL,
		  cadastro.FONE_COM,
		  cadastro.CPF,
		  cadastro.CONDICAO,
		  cadastro.EMAIL,
		  cadastro.GRUPO,
		  cadastro.ORIGEM,
		  cadastro.PROFISSAO,
		  cadastro.ZONAL,
		  cadastro.SECCAO,
		  cadastro.PAI_MAE,
		  cadastro.FILIADO,
		  cadastro.RECEBEMAT,
		  cadastro.RESPCADASTRO,
		  cadastro.DTULTALT,
		  cadastro.EMPRESA,
		  cadastro.VOTOU,
		  cadastro.RAMO,
		  cadastro.RECEBEMAIL,
		  cadastro.IMPRESSO,
		  cadastro.ENVIADO,
		  cadastro.CAMPANHA,
		  cadastro.FACEBOOK,
		  cadastro.TWITTER,
		  cadastro.OUTRAREDE,
		  cadastro.APELIDO,
		  cadastro.EST_CIVIL,
		  cadastro.CLASSI,
		  cadastro.OBS,
		  enderecos.id,
		  enderecos.cep,
		  enderecos.tipolog,
		  enderecos.rua,
		  enderecos.reg,
		  enderecos.tipo,
		  enderecos.padrao,
		  enderecos.complemento,
		  enderecos.numero,
		  enderecos.uf,
		  enderecos.cidade,
		  enderecos.bairro
		FROM
		  cadastro
		  LEFT OUTER JOIN enderecos ON (cadastro.CODIGO = enderecos.codigo) WHERE cadastro.CODIGO = $codigo";
//		echo $query;
		$mysql_query = $_con->query($querycad);
		if ($mysql_query->num_rows<1) {
			$_SESSION['ult_eleitor_pesquisado']=0;
			echo '<script>alert("ELEITOR '.$codigo.' não encontrado!");return false;</script>';					
		}else{
			while ($dados_busca = $mysql_query->fetch_assoc()) {
				$codigo = $dados_busca['CODIGO'];
				$_SESSION['ult_eleitor_pesquisado'] = $codigo;
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
				if ($dados_busca["CONDICAO"]==0){
					$condicao = false; 
					$msg_sistema = "<strong> ESTE REGISTRO ESTÁ INATIVO</strong>";  
					$classe_div = "col-12 badge badge-danger animacao";
				}else{
					$msg_sistema = "Campos em VERMELHO - preenchimento obrigatório";
					$condicao = true;
					$classe_div = "col-12 badge badge-danger";
				}
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
				$arquivo = "../imagens/fotos/".$codigo.".jpg";
				if (file_exists($arquivo)) {
					$imagem = $arquivo;	
				} else {
					$imagem = "../imagens/fotos/sem.jpg";	
				}		
				$id_endereco = $dados_busca["id"];
				$cep= $dados_busca["cep"];
				$cep_ed = substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
				$tipolog= $dados_busca["tipolog"];
				$rua= $dados_busca["rua"];
				$bairro= $dados_busca["bairro"];
				$cidade= $dados_busca["cidade"];
				$uf= $dados_busca["uf"];
				$numero= $dados_busca["numero"];
				$compl = $dados_busca["complemento"];
				$padrao= $dados_busca["padrao"];
				$tipo= $dados_busca["tipo"];			
				$reg= $dados_busca["reg"];			

				//echo $imagem;
			}	
			//echo $enderecoed;
			
			// ----------- visitas -------------------------------------------------------
			
			$queryvis = "SELECT * from visitas WHERE Visitante = ".$codigo." order by DataDaVisita desc";

			$mysql_query_vis = $_con->query($queryvis);
			#$visitas=0;
			if ($mysql_query_vis->num_rows>0) {
				$dadosvisita = '<div class="row bg-dark text-white"><div class="col-md-1"></div><div class="col-md-2">Data</div><div class="col-md-6">Assunto</div><div class="col-md-3"></div></div>';	
				$corbg = 1;
				while ($dados_visitas = $mysql_query_vis->fetch_assoc()) {
					if ($corbg == 1){
						$colorbg = "bg-light";
						$corbg = 0;
					}else{
						$colorbg = "bg-white";
						$corbg = 1;
					}
					$dadosvisita .= '<div class="row '.$colorbg.'"><div class="col-1"></div><div class="col-2">'.FormatDateTime($dados_visitas["DataDaVisita"],7).'</div><div class="col-6">'.$dados_visitas["Assunto"].'</div><div class="col-3"><button type="button" class="btn btn-sm btn-excluir" onClick="exclui_visita('.$dados_visitas["Visita"].')"><i class="fas fa-trash"></i> Excluir</button></div></div>';
					#$visitas .= FormatDateTime($dados_visitas["DataDaVisita"],7)." - ".$dados_visitas["Assunto"].'\n';
				}
			}else{
				$dadosvisita = "<strong>SEM CONTATOS</strong>";
			}
			//echo $dadosvisita;
			
// ----------------Demandas -----------------------------------------------------------------------------------------
			
			$queryenc = "SELECT * from encaminhamentos WHERE codigo = ".$codigo." order by data desc";
			$mysql_query_enc = $_con->query($queryenc);
			$problemas=0;
			$dadosproblemas = '';
			if ($mysql_query_enc->num_rows>0) {
				while ($dados_demandas = $mysql_query_enc->fetch_assoc()) {
					$numero = $dados_demandas['numero'];
					$situacao = $dados_demandas['situacao'];
					switch($situacao) {				
					  case 0:
						$temresposta= '<font color="#E80003"><strong>NENHUMA resposta</strong></font>';
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
				
					$dadosproblemas .= '<div class="row"><div class="col-1"></div><div class="col-2"><strong>#'.$numero.'&nbsp;Data:&nbsp;<span class="text-success">'.FormatDateTime($dados_demandas["data"],7).'</span></strong></div><div class="col-6"><strong>Secretaria:&nbsp;</strong>'.busca_secretaria($dados_demandas["assunto"]).'</div><div class="col-3"><strong>Situação:&nbsp;</strong>'.$temresposta.'</div></div><div class="row"><div class="col-1"></div><div class="col-11"><strong>DESCRIÇÃO: </strong>'.$dados_demandas["descricao"].'</div></div>';
										
					$query2 = "SELECT * from historico_encaminhamentos WHERE numero = ".$numero." order by data desc";
					$mysql_query2 = $_con->query($query2);
					if ($mysql_query2->num_rows>0) {
						$qtderesp=TRUE;
						while ($dados_respostas = $mysql_query2->fetch_assoc()) {
							$dadosproblemas .= '<div class="row"><div class="col-1"></div>';
							$dadosproblemas .= '<div class="col-11">Em&nbsp;'.FormatDateTime($dados_respostas["data"],7).'&nbsp;'.$dados_respostas['retorno'].'&nbsp;por&nbsp;'.$dados_respostas['usuario'].'</div></div>';
						}
						
					}
					$dadosproblemas .= '<hr />';
				}
			}else{
				$dadosproblemas = "<strong>SEM DEMANDAS</strong>";
			}
			//echo $dadosproblemas;
			
// --------------- Vai buscar dados se for Dr Thiago ------------
			
			$prontuarios="";
			$relacao_exames="";
			$receitas_eleitor="";
			if ($_SESSION['id']==1){
				//========== Prontuários =========================
// ---------------- Vai buscar faltas do eleitor as consultas --------------------------------------------------------------
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
					$prontuarios .= '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert"><font color="#E50206"><strong>Paciente já faltou '.$qtderegsf.' consulta(s) em '.$msg.'</strong></font><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button></div>';
				}
// ---------------- Vai buscar prontuários --------------------------------------------------------------
				$queryp = 'SELECT * from prontuario_view WHERE cod_cadastro = '.$codigo.' order by data_consulta desc';
				$mysql_queryp = $_con->query($queryp);
				$prontuarios .= '<div class="row"><button type="button" onclick="javascript:imprime_atestado('.$codigo.')" class="btn btn-imprimir btn-sm"><i class="fas fa-file-medical"></i> Imprimir Atestado </button></div>';
				if ($mysql_queryp->num_rows==0) {
					$prontuarios .= '<strong>SEM PRONTUÁRIOS</strong>';
				}else{
					$linha = 1;
					while ($dados_prontuario = $mysql_queryp->fetch_assoc()) {
						$diago = $dados_prontuario['diagnostico'];
						$prontuarios .= '<div class="row"><div class="col-2  text-right"><label><strong>Data da Consulta:</strong></label></div><div class="col-6 text-left">'.FormatDateTime($dados_prontuario['data_consulta'],7).'</div><div class="col-2"><button type="button" onclick="javascript:mostra_prontuario('.$dados_prontuario['id'].')" class="btn btn-sm btn-success"><i class="fas fa-edit" aria-hidden="true"></i> Editar</button></div><div class="col-2"><button type="button" onclick="javascript:exclui_prontuario('.$dados_prontuario['id'].')" class="btn btn-sm btn-excluir"><i class="fas fa-trash" aria-hidden="true"></i> Excluir</button></div></div><div class="row"><div class="col-2 text-right"><label><strong>Clínica:</strong></label></div><div class="col-10 text-left">'.$dados_prontuario['nome_clinica'].'</div></div><div class="row"><div class="col-2 text-right"><label><strong>Diagnóstico:</strong></label></div><div class="col-10 text-left">'.htmlspecialchars_decode($diago).'</div></div>';
						$prontuarios .= '<hr />';
					}
				}
				//echo $prontuarios;
				
// ---------------- Vai buscar exames --------------------------------------------------------------
				$queryex = "SELECT exames.cod_cadastro, exames.`data`, cadastro_exames.descricao, exames.id, exames_itens.cod_exame FROM exames_itens INNER JOIN exames ON (exames_itens.id_exame = exames.id) INNER JOIN cadastro_exames ON (exames_itens.cod_exame = cadastro_exames.id) 
				WHERE exames.cod_cadastro = ".$codigo." order by exames.id desc, exames.data desc";
				$mysql_query_ex = $_con->query($queryex);
				//echo $query;
				$qtderegs = $mysql_query_ex->num_rows;
				$relacao_exames .= '<div class="row"><button type="button" onclick="javascript:inclui_exames('.$codigo.')" class="btn btn-sm btn-incluir"><i class="fas fa-plus" aria-hidden="true"></i> Novo Exame </button></div>';
				if ($qtderegs ==0) {
					$relacao_exames .= '<div class="row"><strong>SEM EXAMES</strong></div>';
				}else{
					$linha = 1;
					$id_anterior = 0;
					while ($dados_exames = $mysql_query_ex->fetch_assoc()) {
						$anohj = substr($dados_exames["data"],0,4);
						$meshj = substr($dados_exames["data"],5,2);
						$diahj = substr($dados_exames["data"],8,2);
						$descricao = $dados_exames["descricao"];
						$cod_cadastro = $dados_exames["cod_cadastro"];
						$cod_exame = $dados_exames["cod_exame"];
						$id = $dados_exames["id"];
						$arquivoex = '../imagens/exames/';
						$arquivoex .= str_pad($dados_exames['cod_cadastro'],6,'0',STR_PAD_LEFT);
						$arquivoex .= $anohj.$meshj.$diahj.str_pad($dados_exames['cod_exame'],3,'0',STR_PAD_LEFT).str_pad($dados_exames['id'],3,"0",STR_PAD_LEFT).".jpg";
						if (file_exists($arquivoex)) {
				//			echo $arquivo."<br>";
							$habilita_ver_imagem = true;	
						} else {
							$habilita_ver_imagem = false;	
						}		
						if ($linha == 1) {
								$classe = 'class="row bg-light"';
								$linha =2;
							}else {
								$classe = 'class="row bg-white"';
								$linha =1;
							}

						if ($dados_exames["id"]==$id_anterior){
							$relacao_exames .='<div '.$classe.'><div class="col-2"></div><div class="col-6">'.$dados_exames["descricao"].'</div><div class="col-2">';
							if ($habilita_ver_imagem){	
									$relacao_exames .= '<a href="#" onclick="javascript:ver_exame_solicitado('.$dados_exames["cod_cadastro"].','.$anohj.$meshj.$diahj.','.$dados_exames["cod_exame"].','.$dados_exames["id"].')" class="btn btn-sm btn-consultar" /><i class="fas fa-x-ray" aria-hidden="true"></i> Ver Exame 
									</a>';
							}else{
								$relacao_exames .= '</div><div class="col-2"><a href="#" title="Excluir o exame '.$dados_exames["descricao"].'" onclick="javascript:excluir_item_exame('.$dados_exames["cod_exame"].','.$dados_exames["id"].')" class="btn btn-sm btn-excluir" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir Item</a></div></div>';
							}
						}else{
							$relacao_exames .= '<div '.$classe.'><div class="col-2 text-primary"><strong>'.FormatDateTime($dados_exames["data"],7).'</strong></div><div class="col-6 text-secondary"> #'.$dados_exames["id"].'</div><div class="col-2"><a href="#" title="Excluir TODOS Exames Solitados" onclick="javascript:exclui_exame('.$dados_exames["id"].')" class="btn btn-sm btn-excluir" /><i class="fas fa-notes-medical" aria-hidden="true"></i> Excluir Solicitação</a></div><div class="col-2"><a href="#" title="Imprimir Solicitação do exame" onclick="javascript:imprime_exames('.$dados_exames["cod_cadastro"].','.$dados_exames["id"].')" class="btn btn-sm btn-imprimir" /><i class="fas fa-print" aria-hidden="true"></i> Imprimir</a></div></div><div '.$classe.'><div class="col-2"><strong>Exame:&nbsp;</strong></div><div class="col-6">'.$dados_exames["descricao"].'</div><div class="col-2">';
							if ($habilita_ver_imagem){	
									$relacao_exames .= '<a href="#" onclick="javascript:ver_exame_solicitado('.$dados_exames["cod_cadastro"].','.$anohj.$meshj.$diahj.','.$dados_exames["cod_exame"].','.$dados_exames["id"].')" class="btn btn-sm btn-consultar" /><i class="fas fa-x-ray" aria-hidden="true"></i> Ver Exame</a>';
							}else{
								$relacao_exames .= '</div><div class="col-2"><a href="#" title="Excluir o exame '.$dados_exames["descricao"].'" onclick="javascript:excluir_item_exame('.$dados_exames["cod_exame"].','.$dados_exames["id"].')" class="btn btn-sm btn-excluir" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir Item</a></div></div>';
							}	
						}
						$id_anterior = $dados_exames["id"];

					}		
				}
				$relacao_exames .='</div>';
			//echo $relacao_exames;
				
// ---------------------- Vai buscar receitas ----------------------------------------------------------------
				$primeira=true;
				$queryrec = "SELECT * from receituario_view WHERE cod_cadastro = ".$codigo." order by data desc";
				$mysql_query_rec = $_con->query($queryrec);
				$qtderegsrec = $mysql_query_rec->num_rows;
				$receitas_eleitor .= '<div class="row"><button type="button" onclick="javascript:inclui_receituario('.$codigo.')" class="btn btn-sm btn-incluir"><i class="fas fa-plus" aria-hidden="true"></i> Novo Receituário </button></div>';
				if ($qtderegsrec==0) {
					$receitas_eleitor .= '<div class="row"><strong>SEM RECEITAS</strong></div>';
				}else{
					$linha = 1;
					while ($dados_receita = $mysql_query_rec->fetch_assoc()) {
						if ($linha == 1) {
							$classe = 'class="row bg-light"';
							$linha =2;
						}else {
							$classe = 'class="row bg-transparent"';
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
						$receitas_eleitor .= '<div '.$classe.'><div class="col-2 text-right"><strong>Data da Receita:&nbsp;</strong></div><div class="col-6">'.FormatDateTime($dados_receita["data"],7).'</div><div class="col-1"><button type="button" onclick="javascript:mostra_receituario('.$dados_receita['id'].')" class="btn btn-sm btn-consultar btn-block"><i class="fas fa-edit" aria-hidden="true"></i> Editar</button></div><div class="col-1"><button type="button" onclick="';
									if ($controlado=="Sim"){
										$receitas_eleitor .= "imprime_receituario_especial(".$dados_receita['id'].")";
									}else{
										$receitas_eleitor .= "imprime_receituario(".$dados_receita['id'].")";
									}					
									$receitas_eleitor .= '" class="btn btn-sm btn-imprimir btn-block"><i class="fas fa-print" aria-hidden="true"></i> Imprimir</button></div><div class="col-1"><a href="#" onclick="javascript:excluir_receituario('.$dados_receita['id'].')" class="btn btn-sm btn-excluir btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir</a></div></div><div '.$classe.'><div class="col-2 text-right"><strong>Controle Especial:&nbsp;</strong></div><div class="col-10">'.$controlado.'</div></div><div '.$classe.'><div class="col-2 text-right"><strong>Tipo de Uso:&nbsp;</strong></div><div class="col-10">'.$tp_uso.'</div></div><div '.$classe.'><div class="col-2 text-right"><strong>Medicamento(s):&nbsp;</strong></div>';
						$query2 = "SELECT * from dados_receita WHERE cod_receita = ".$dados_receita['id'];
						$mysql_query2 = $_con->query($query2);
						$primeiro = 0;
						if ($mysql_query2->num_rows==0) {
							$receitas_eleitor .= '<div class="text-danger"><strong>SEM MEDICAMENTOS NESTA RECEITA</strong></div>';
						}else{
							while ($remedios = $mysql_query2->fetch_assoc()) {
								$medicamento = $remedios['medicamento'];
								$qtde = $remedios['qtde'];
								$posologia = $remedios['posologia'];
								if ($primeiro==0){
									$receitas_eleitor .='<div class="col-10"><strong>'.$medicamento.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$qtde.'</strong></div></div><div '.$classe.'><div class="col-2"> </div><div class="col-10">'.$posologia.'</div></div>';	
									$primeiro=1;	
								}else{
									$receitas_eleitor .= '<div '.$classe.'><div class="col-2"> </div><div class="col-8"><strong>'.$medicamento.'&nbsp;&nbsp;->'.$qtde.'</strong></div></div><div '.$classe.'><div class="col-2"> </div><div class="col-8">'.$posologia.'</div></div>';
									}
							}
						}

					}		
				}
				//echo $receitas_eleitor;
			}
// ---------------ENCERRA BUSCA DE DADOS DO ELEITOR. AGORA VAI MOSTRAR NA TELA --------------------------------------------	
			?>
			<script>
			//alert('info');
			document.form1.txtcodigo.value = '<?php echo $codigo ?>';
			document.form1.txtnome.value = '<?php echo $nome ?>';
			document.form1.txtsexo.value = '<?php echo $sexo ?>';
			document.form1.txtdtnasc.value = '<?php echo $dtnasc ?>';
			document.form1.txtgrupo.value= '<?php echo $grupo ?>';
			document.form1.txtorigem.value='<?php echo $origem ?>';
			document.form1.txtcpf.value = '<?php echo $cpf ?>';
			document.form1.txtpaimae.value = '<?php echo $pai_mae ?>';
			document.form1.txtzona.value = '<?php echo $zonal ?>';
			document.form1.txtsecao.value = '<?php echo $seccao ?>';
			document.form1.txtemail.value = '<?php echo $email ?>';
			document.form1.chkcondicao.checked='<?php echo $condicao ?>'; 
			document.form1.chkfiliado.checked='<?php echo $filiado ?>'; 
			document.form1.chkemail.checked='<?php echo $recebemail ?>';	
			document.form1.chkvotou.checked='<?php echo $votou ?>';	
			document.form1.chkimpresso.checked='<?php echo $impresso ?>';	
			document.form1.txtresidencial.value = '<?php echo $fone_res ?>';
			document.form1.txtcelular.value = '<?php echo $fone_cel ?>';
			document.form1.txtcomercial.value = '<?php echo $fone_com ?>';
			document.form1.txtprofissao.value = '<?php echo $profissao ?>';
			document.form1.txtempresa.value = '<?php echo $empresa ?>';
			document.form1.txtcargo.value = '<?php echo $cargo ?>';
			document.form1.txtramo.value = '<?php echo $ramo ?>';
			document.getElementById('lbldtcad').innerHTML = '<?php echo $dtcad ?>';
			document.getElementById('lbldtultalt').innerHTML = '<?php echo $dtultalt ?>';
			document.getElementById('lblrespcad').innerHTML = '<?php echo $respcadastro ?>';
			document.form1.txtobs.value = '<?php echo $obs ?>';	
			document.form1.txtcampanha.value = '<?php echo $campanha ?>';			
			document.form1.txtface.value = '<?php echo $facebook ?>';			
			document.form1.txttwitter.value = '<?php echo $twitter ?>';			
			document.form1.txtapelido.value = '<?php echo $apelido ?>';			
			document.form1.txtoutra.value = '<?php echo $outrarede ?>';			
			document.form1.txtestadocivil.value = '<?php echo $est_civil ?>';			
			document.form1.txtclass.value = '<?php echo $classi ?>';	
			document.getElementById('visit').innerHTML = '<?php echo $dadosvisita ?>';
			document.form1.rua.value = '<?php echo $rua ?>';	
			document.form1.cep.value = '<?php echo $cep ?>';	
			document.form1.tipolog.value = '<?php echo $tipolog ?>';	
			document.form1.bairro.value = '<?php echo $bairro ?>';	
			document.form1.cidade.value = '<?php echo $cidade ?>';	
			document.form1.uf.value = '<?php echo $uf ?>';	
			document.form1.numero.value = '<?php echo $numero ?>';	
			document.form1.complemento.value = '<?php echo $compl ?>';	
			document.form1.id_endereco.value = '<?php echo $id_endereco ?>';	
			document.form1.reg.value = '<?php echo $reg ?>';	
			document.getElementById('mensagem_sistema').innerHTML = '<?php echo $msg_sistema ?>';
			document.getElementById("mensagem_sistema").className = '<?php echo $classe_div ?>';	
			document.getElementById('solution').innerHTML = '<?php echo $dadosproblemas ?>';
			document.getElementById('btnincvis').disabled = false;
			document.getElementById('btnExcCad').disabled = false;
			document.getElementById('btnAltCad').disabled = false;
			document.getElementById('btnNovo').disabled = true;
            <?php    
			if ($_SESSION['id']==1){ ?>
				document.getElementById('dados_prontuario').innerHTML = '<?php echo $prontuarios ?>';			
				document.getElementById('dados_exames').innerHTML = '<?php echo $relacao_exames ?>';
				document.getElementById('dados_receituario').innerHTML = '<?php echo $receitas_eleitor ?>';
			<?php } ?>
			document.form1.txtnome.focus();
			</script>
			<?php
			gravaoperacoes("cadastro","C", $_SESSION["usuarioUser"],"Consultou cadastro ".$codigo);

		}		
	#}
}
?>