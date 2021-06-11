<?php

require_once('../entitymanager/EntityManager.php');

class Reclamacao {

	private $id;
	private $nomeReclamante;
	private $mail;
	private $fone;
	private $cpf;
	private $empresa;
	private $endereco;
	private $problema;
	private $cidade;
	private $documento;
	private $mimeType;
	private $origem;
	private $tipo;
	private $protocolo;
	private $situacao;
	private $dataIns;
	private $empresaFornecedor;
	private $estado;
	
	private $cepEmpresa;
	private $enderecoEmpresa;
	private $siteEmpresa;
	private $idbairroE;
	private $DescidbairroE;
	private $motivo_corona_2020;		
	

	public function getCepEmpresa(){
		return $this->cepEmpresa;
	}
	public function setCepEmpresa($p_CepEmpresa){
		$this->cepEmpresa = $p_CepEmpresa;
	}

	public function getEnderecoEmpresa(){
		return $this->enderecoEmpresa;
	}
	public function setEnderecoEmpresa($p_EnderecoEmpresa){
		$this->enderecoEmpresa = $p_EnderecoEmpresa;
	}

	public function getSiteEmpresa(){
		return $this->siteEmpresa;
	}
	public function setSiteEmpresa($p_SiteEmpresa){
		$this->siteEmpresa = $p_SiteEmpresa;
	}


	public function getDescidbairroE(){
		return $this->DescidbairroE;
	}
	public function setDescidbairroE($p_idbairroE){
		$this->DescidbairroE= $p_idbairroE;
	}

	public function getidbairroE(){
		return $this->idbairroE;
	}
	public function setidbairroE($p_idbairroE){
		$this->idbairroE = $p_idbairroE;
	}
	
	public function getMotivo_corona_2020(){
		return $this->motivo_corona_2020;
	}
	public function setMotivo_corona_2020($p_motivo_corona_2020){
		$this->motivo_corona_2020 = $p_motivo_corona_2020;
	}
	
	public function getEmpresaFornecedor(){
		return $this->empresaFornecedor;
	}
	public function setEmpresaFornecedor($p_empresaFornecedor){
		$this->empresaFornecedor = $p_empresaFornecedor;
	}

	public function getDataIns() {
		return $this->dataIns;
	}
	public function setDataIns($p_dataIns){
		$this->dataIns = $p_dataIns;
	}
	public function setOrigem($p_origem){
		$this->origem = $p_origem;
	}

	public function setSituacao($p_situacao) {
		$this->situacao = $p_situacao;
	}

	public function getSituacao() {
		return $this->situacao;
	}

    public function getId() {
        return $this->id;
    }

    public function getNomeReclamante() {
        return $this->nomeReclamante;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getFone() {
        return $this->fone;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getProblema() {
        return $this->problema;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getDocumento() {
		if (empty($this->documento)) {
			$this->setDocumento(null);
		}
		return $this->documento;
    }

	public function getMimeType() {
		return $this->mimeType;
    }

    public function getOrigem() {
        return $this->origem;
    }

    public function getTipo() {
        return $this->tipo;
    }


    public function setId($id) {
        $this->id = $id;
    }

    public function setNomeReclamante($nomeReclamante) {
        $this->nomeReclamante = $nomeReclamante;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setFone($fone) {
        $this->fone = $fone;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setProblema($problema) {
        $this->problema = $problema;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setDocumento($documento) {
        $this->documento = $documento;
    }

	public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

	public function getProtocolo() {
		return $this->protocolo;
	}

	public function setProtocolo($protocolo) {
		$this->protocolo = $protocolo;
	}

	public function getEstado() {
		return $this->estado;
	}

	public function setEstado($estado) {
		$this->estado = $estado;
	}

	private function geraProtocolo(){
		$queryProtocolo = "select case when MAX(protocolo) is null then 0 else MAX(protocolo) end as maxPro from RECLAMACOES WHERE SUBSTRING(protocolo,-11,6) = '".Date('Ym')."'";
		$entity3 = EntityManager::getInstance();
		$queryResp = $entity3->executeQuery($queryProtocolo);
		$ultimoProtocolo = $queryResp[0][0];
		if($ultimoProtocolo == 0){
			$novoProtocolo = Date('Ym')."00001";
		}else{
			$novoProtocolo = $ultimoProtocolo + 1;
		}
		return $novoProtocolo;
	}

	public function enviarEmail(){
		$assunto = "Procon atendimento";
		$mensagem = "Prezada(o) ".$this->getNomeReclamante().",
					<br><br>
					Sua denúncia foi recebida e devidamente protocolada. Guarde o número abaixo para acompanhar o andamento da sua solicitação.
					Sua demanda será respondida em até 10 dias, acompanhe em seu e-mail, sempre verificando a caixa de SPAM.
					<br>
					<br>Número do protocolo: ". $this->getProtocolo() ."
					<br><br>
					<center>
					<b>Atenção:</b> Esta é uma mensagem automática, não é necessário respondê-la.</center>"; 

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: Procon <no-reply@procon.com.br>' . "\r\n";
		$headers .= 'Reply-to: '.$this->getMail().'' . "\r\n";
		//$headers .= 'Cc: myboss@example.com' . "\r\n";
		mail($this->getMail(), $assunto, $mensagem, $headers);
	}

	public function insert($nomeReclamante, $mail, $fone, $cpf, $empresa, $endereco, $problema, $cidade, $origem, $tipo, $cepEmpresa= null, 
		$siteEmpresa = null, $idbairroE = null, $enderecoEmpresa = null, $motivo_corona_2020 = null,$documento,$mimeTypes, $nomeArquivos){
		//consistencias de dados
        $this->nomeReclamante = $nomeReclamante;
        $this->mail = $mail;
        $this->fone = $fone;
        $this->cpf = $cpf;
        $this->empresa = $empresa;
        $this->endereco = $endereco;
        $this->problema = $problema;
        $this->cidade = $cidade;
        $this->documento = $documento;
        $this->origem = $origem;
        $this->tipo = $tipo;
        $this->mimeType = $mimeType;
		$this->setProtocolo($this->geraProtocolo());
		
		$this->cepEmpresa = ((isset($cepEmpresa) && !is_null($cepEmpresa ))?  $cepEmpresa : null);
		$this->siteEmpresa = ((isset($siteEmpresa) && !is_null($siteEmpresa))? $siteEmpresa : null);
		$this->idbairroE = ((isset($idbairroE) && (!is_null($idbairroE)&&!empty($idbairroE)))? $idbairroE : null);
		$this->enderecoEmpresa = ((isset($enderecoEmpresa) && !is_null($enderecoEmpresa))?$enderecoEmpresa: null);
		
		
		if($motivo_corona_2020 == null || $motivo_corona_2020==''){$motivo_corona_2020=0;}
		$this->motivo_corona_2020 =  $motivo_corona_2020;
		
		$caracteres_invalidos = array(".", "/", "-");
		$cpf_mod = str_replace($caracteres_invalidos,"",$this->getCpf());

		$query = "INSERT INTO RECLAMACOES(nomeReclamante, 
					email, 
					fone, 
					cpf, 
					endereco, 
					cidade, 
					descricaoProblema, 
					origem, 
					tipo, 
					empresa, 
					protocolo, 
					cepEmpresa,
					enderecoEmpresa,
					siteEmpresa,
					bairroEmpresa, 
					motivo_corona_2020) 
					VALUES(:nomeReclamante,:email, :fone, :cpf, :endereco, :cidade, :descricaoProblema, :origem, :tipo, 
					:empresa, :protocolo, :cepEmpresa,:enderecoEmpresa,:siteEmpresa,:bairroEmpresa, :motivo_corona_2020)";
		$args =  array("nomeReclamante" =>$this->getnomeReclamante() ,"email" =>$this->getMail() , "fone" => $this->getFone(), "cpf" => $cpf_mod, "endereco" => $this->getEndereco(),
				   "cidade" => $this->getCidade(), "descricaoProblema" => $this->getProblema(),"origem" => $this->getOrigem(), "tipo" => $this->getTipo(), 
				   "empresa" =>$this->getEmpresa(), "protocolo" =>$this->getProtocolo(),"cepEmpresa"=>$this->cepEmpresa,"enderecoEmpresa" => $this->enderecoEmpresa,
				   "siteEmpresa" => $this->siteEmpresa,"bairroEmpresa" => $this->idbairroE, "motivo_corona_2020" => $this->motivo_corona_2020);

		try{
			$entity = EntityManager::getInstance();
			$IdGravado = $entity->insertWithArgs($query,$args);
			
			if(!is_numeric($IdGravado)) 
				return $IdGravado;
			
			/* Faz o upload do arquivo e grava o nome em RECLAMACOES_ARQUIVOS 	*/				
			for ($i = 0; $i < sizeof($this->documento); $i++) {
				if ($this->documento[$i] != ""){			
					$imgdata = base64_decode($this->documento[$i]);
					$snapshot = fopen('../../uploads/'. $this->getProtocolo() . "_" .$nomeArquivos[$i] , 'w+');
					$nb = fwrite($snapshot, $imgdata);
					fclose($snapshot);	
				}elseif(!isset($p_documento) || is_null($p_documento) ||$p_documento == ""){
					$nomeDocumento = Null;
				}
				$queryRA = "INSERT INTO RECLAMACOES_ARQUIVOS(reclamacao, nomeOriginal,nomeDocumento) 
							VALUES(". $IdGravado.", '" .$nomeArquivos[$i]."', '" . $this->getProtocolo() . "_" . $nomeArquivos[$i] ."')";	
				$a = $entity->insert($queryRA);		
				if(!is_numeric($a)) 
					return $a;
			}	
			
			$this->enviarEmail();

		} catch (Exception $e) {
			return -1;
		}
		
		return $this->getProtocolo();
	}
}

?>
