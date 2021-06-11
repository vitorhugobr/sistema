<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina

require_once('../utilitarios/funcoes.php');

// função abaixo usada somente aqui
function liberado_aqui($usuario,$funcao){
    $_cono  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);	if(!$_cono) {  
		echo "Não foi possível conectar ao MySQL. Erro " .
				mysqli_connect_errno() . " : " . mysql_connect_error();
		exit;
	}
	
	
	$_sql = "SELECT * from liberacao WHERE username = '$usuario' and funcao = $funcao";
	$_res = $_cono->query($_sql);
	if (mysqli_affected_rows($_cono) > 0) {
		$volta = true;
	}else{
		$volta = false;
	}
	$_cono->close();
	
	return $volta;
}


$usuario = $_GET['user'];
$query = "SELECT * from menu where liberada_sistema = 1 order by cod_item_menu";
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows<1) {
	echo '<script>alert("Tabela MENU não encontrada! Informe ao Suporte");</script>';					
}else{
	$nivelant = "";
	$coluna = 1;
	$marcar="M";
	$linha = 0;
	$tablib = '<table class="table table-sm table-bordless table-striped">
				<tr>
				  <thead class="thead-dark">
				  <th width="7%" align="center" valign="middle" nowrap="nowrap">Liberar</th>
				  <th width="43%" align="left" valign="middle" nowrap="nowrap" >Função</th>
				  <th width="7%" align="center" valign="middle" nowrap="nowrap">Liberar</th>
				  <th width="43%" align="left" valign="middle" nowrap="nowrap">Função</th>
				  </thead>
				</tr>';
  
  	$tablib .='<tr>
				<td width="7%" align="center" valign="middle" nowrap="nowrap">
				<input name="marcall" type="checkbox" class="form-control form-control-sm" value="marcall" onclick="selecionar_todos()"/>
				</td>    
				<td width="43%" align="left" valign="middle" nowrap="nowrap">Marcar Todos
				</td>    
				<td width="7%" align="center" valign="middle" nowrap="nowrap">
				<input name="marcall2" type="checkbox" class="form-control form-control-sm" value="marcall2" onclick="deselecionar_todos()"/>
				</td>    
				<td width="43%" align="left" valign="middle" nowrap="nowrap">
				<span>Desmarcar Todos
				</span>
				</td>  
			  </tr>
			  </table>';
	$tablib .= '<table width="100%" border="0" cellspacing="0">';
	$coratual="#FFCC99";
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$descricao_menu = $dados_s['descricao_menu'];	
		$cod_item_menu = $dados_s['cod_item_menu'];
		$entidade = $dados_s['entidade'];
		$nivel = $dados_s['nivel'];
		if (liberado_aqui($usuario,$cod_item_menu)){
			$checado = 'checked = "checked"';
		}else{
			$checado = '';
		}
		if ($nivel == 1){
			if ($coluna==2){
				$tablib .= '<td width="7%">
							</td>
							<td width="43%">
							</td>
							</tr>';
				$coluna==1;
			}
			$tablib .= '<tr>
						  <td bgcolor="#FFFFCC" width="7%" align="center" valign="middle" nowrap="nowrap">
							<input name="'.$cod_item_menu.'" type="checkbox" class="form-control form-control-sm" value="'.$cod_item_menu.'" '.$checado.'/>
						  </td>  
						  <td bgcolor="#FFFFCC" colspan="3" width="93%" valign="middle" nowrap="nowrap">'.$descricao_menu.'
						  </td>
						</tr>';
		}else{
			if ($coluna==1){
				$coluna = 2;
				$tablib .=  '<tr>
								<td width="7%" align="center" valign="middle" nowrap="nowrap" class="subliberada">
									<input name="'.$cod_item_menu.'" type="checkbox" class="form-control form-control-sm" value="'.$cod_item_menu.'" '.$checado.'/>
								</td>
								<td width="43%" valign="middle" nowrap="nowrap" class="subliberada">'.$descricao_menu.'
								</td>';
			}else{
				$tablib .= '<td width="7%" align="center" valign="middle" nowrap="nowrap" class="subliberada">
								<input name="'.$cod_item_menu.'" type="checkbox" class="form-control form-control-sm"  value="'.$cod_item_menu.'" '.$checado.'/>
							</td>
							<td width="43%" valign="middle" nowrap="nowrap" class="subliberada">'.$descricao_menu.'
							</td>
							</tr>';
				$coluna = 1;
				if ($coratual=="#FFFFCC"){
					$coratual = "#FFCC99";
				}else{
					$coratual = "#FFFFCC";
				}				
			}
			
		}
	}	
/*	echo '<script>alert("'.$coluna.'");</script>';
*/	
	if ($coluna==1){
		$tablib .= '<td width="7%" bgcolor="'.$coratual.'">
					</td>
					<td width="43%" bgcolor="'.$coratual.'">
					</td>
					</tr>';
	}
	$tablib .= '</table>';		
	echo $tablib;
}
?>



