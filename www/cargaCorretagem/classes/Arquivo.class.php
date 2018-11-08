<?php

class Arquivo {
    private $nome = null;
    private $data = null;

    
    /**
     * O caminho absoluto do diretório raiz.
     * @var string
     */
    private $diretorioRaiz = '';
    
    private $isAlteracaoArquivo = null;
    
    /**
     * O tamanho do arquivo em bytes.
     * @var int
     */
    private $tamanhoemBytes = 0;
    
    /**
     * O tamanho máximo, em bytes, que o arquivo pode possuir.
     * @var int
     */
    private $tamanhoMaximoemBytes = 0;
    
    /**
     * Corresponde ao valor de uma chave do vetor $_FILES relativa ao arquivo enviado.
     * @var array()
     */
    private $metadadosHTTP = array();

    public function __construct(){
    }
    //-------------------------------------------------------------------------    
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getNome()
    {
        return $this->nome;
    }
    //-------------------------------------------------------------------------
    public function setData($data)
    {
        $this->data = $data;
    }
    public function getData()
    {
        return $this->data;
    }    
    //-------------------------------------------------------------------------
    /**
     * Setter para Arquivo::$diretorioRaiz.
     * @param string $diretorioRaiz
     * @see Arquivo::$diretorioRaiz
     * @throws InvalidArgumentException
     */
    public function setDiretorioRaiz($diretorioRaiz){
        if(!is_string($diretorioRaiz)) {
            throw new InvalidArgumentException(Mensagem::ERRO_NOME_DIRETORIO);
        }
        $this->diretorioRaiz = $diretorioRaiz;
    }
    /**
     * Getter para Arquivo::$diretorioRaiz.
     * @return string
     * @see Arquivo::$diretorioRaiz
     */
    public function getDiretorioRaiz(){
        return $this->diretorioRaiz;
    }
    //-------------------------------------------------------------------------
    public function setIsAlteracaoArquivo($isAlteracaoArquivo) {
        $this->isAlteracaoArquivo = $isAlteracaoArquivo;
    }
    public function getIsAlteracaoArquivo() {
        return $this->isAlteracaoArquivo;
    }
    //-------------------------------------------------------------------------
    /**
     * Setter para Arquivo::$tamanhoemBytes
     * @param int $tamanhoemBytes
     * @see Arquivo::$tamanhoemBytes
     * @throws InvalidArgumentException
     */
    public function setTamanhoemBytes($tamanhoemBytes){
        if(!is_numeric($tamanhoemBytes)) {
            throw new InvalidArgumentException(Mensagem::ERRO_PROGRAMACAO);
        }
        $this->tamanhoemBytes = $tamanhoemBytes;
    }
    /**
     * Getter para Arquivo::$tamanhoemBytes.
     * @return int
     * @see Arquivo::$tamanhoemBytes
     */
    public function getTamanhoemBytes(){
        return $this->tamanhoemBytes;
    }
    //-------------------------------------------------------------------------
    /**
     * Setter para Arquivo::$tamanhoMaximoemBytes.
     * @param int $tamanhoMaximoemBytes
     * @see Arquivo::$tamanhoMaximoemBytes
     * @throws InvalidArgumentException
     */
    public function setTamanhoMaximoemBytes($tamanhoMaximoemBytes){
        if(!is_numeric($tamanhoMaximoemBytes)) {
            throw new InvalidArgumentException(Mensagem::ERRO_PROGRAMACAO);
        }
        $this->tamanhoMaximoemBytes = $tamanhoMaximoemBytes;
    }
    /**
     * Getter para Arquivo::$tamanhoMaximoemBytes.
     * @return int
     * @see Arquivo::$tamanhoMaximoemBytes
     */
    public function getTamanhoMaximoemBytes(){
        return $this->tamanhoMaximoemBytes;
    }
    
    /**
     * Setter para Arquivo::$metadadosHTTP.
     * @param array() $metadadosHTTP
     * @throws InvalidArgumentException
     * @see Arquivo::$metadadosHTTP
     */
    public function setMetadadosHTTP($metadadosHTTP){
        $this->validarEnvidoArquivo($metadadosHTTP);
        $alteracao = ArrayHelper::has('arquivo_old_temp_name', $metadadosHTTP);
        if($alteracao){
            $this->setIsAlteracaoArquivo(true);
        }else{
            $this->setIsAlteracaoArquivo(false);
        }
        $this->metadadosHTTP = $metadadosHTTP;
    }
    /**
     * Getter para Arquivo::$metadadosHTTP.
     * @return array()
     * @see Arquivo::$metadadosHTTP
     */
    public function getMetadadosHTTP(){
        return $this->metadadosHTTP;
    }
    
    /**
     * Verifica se o arquivo foi enviado
     * @param string $caminhoArquivosTMP - caminho real do arquivo
     * @return boolean
     */
    public static function arquivoExiste($metadadosHTTP){
        $retorno = false;
        $caminhoArquivosTMP = $metadadosHTTP['arquivo_temp_name'];
        if(Arquivo::arquivoEnviadoUploadHttp($metadadosHTTP)){
            if(is_uploaded_file($caminhoArquivosTMP)){
                $retorno = true;
            }else{
                $retorno = false;
            }
        }else{
            if(file_exists($caminhoArquivosTMP)){
                $retorno = true;
            }else{
                $retorno = false;
            }
        }
        return $retorno;
    }
    
    /**
     * Move o arquivo da pasta temporaria para o caminho correto e verifica se isso acontece de forma correta
     * @param string $caminhoArquivosTMP  - caminho real do arquivo TMP
     * @param string $nome_canonico   - caminho real do arquivo destino final
     * @return boolean
     */
    public static function moveArquivoEnviadoVerifica($metadadosHTTP,$nome_canonico){
        $result = false;
        if( self::arquivoExiste($metadadosHTTP) ) {
            $http = Arquivo::arquivoEnviadoUploadHttp($metadadosHTTP);
            $caminhoArquivosTMP = $metadadosHTTP['arquivo_temp_name'];
            if($http){
                $result = move_uploaded_file($caminhoArquivosTMP, $nome_canonico);
            }else{
                rename($caminhoArquivosTMP,$nome_canonico);
            }
            $result = file_exists($nome_canonico);
        }
        return $result;
    }
    
    /**
     * Verifica se o arquivo foi enviado via HTTP (TRUE) ou JavaScript (FALSE)
     * @param string $metadadosHTTP - informações do envio do arquivo
     * @return boolean
     */
    public static function arquivoEnviadoUploadHttp($metadadosHTTP){
        $nomeOriginal = $metadadosHTTP['arquivo_name'];
        $nomeTemp     = $metadadosHTTP['arquivo_temp_name'];
        $arrayCaminhoArquivosTMP = null;
        if (PHP_OS == "Linux") {
            $arrayCaminhoArquivosTMP = explode(DS,$nomeTemp);
        }else{
            $arrayCaminhoArquivosTMP = explode('\\',$nomeTemp);
        }
        if(in_array($nomeOriginal, $arrayCaminhoArquivosTMP)){
            $retorno = true;
        }else{
            $retorno = false;
        }
        return $retorno;
    }
    
    /**
     * Verifica se o arquivo enviado pelo usuário é válido.
     * @throws LogicException
     * @throws RuntimeException
     * @throws DomainException
     */
    public static function validarEnvidoArquivo($metadadosHTTP){
        $PostArquivoMateria = $metadadosHTTP;
        if(!is_array($PostArquivoMateria)){
            throw new DomainException(Mensagem::ERRO_NO_ENVIO_DE_ARQUIVO);
        }else{
            if(empty($metadadosHTTP)){
                throw new InvalidArgumentException(Mensagem::ERRO_PROGRAMACAO.' metadados is null!');
            }
            if(strcmp($PostArquivoMateria['arquivo_type'], 'application/pdf') !== 0) {
                throw new DomainException(Mensagem::TIPO_DE_ARQUIVO_INVALIDO);
            }
            if(strcmp($PostArquivoMateria['arquivo_extension'], 'pdf') !== 0) {
                throw new DomainException(Mensagem::TIPO_DE_ARQUIVO_INVALIDO);
            }
            if(!is_numeric($PostArquivoMateria['arquivo_size'])) {
                throw new InvalidArgumentException(Mensagem::ERRO_PROGRAMACAO.' Arquivo tamanho Zero');
            }
            if(!Arquivo::arquivoExiste($PostArquivoMateria) ) {
                throw new RuntimeException(Mensagem::ERRO_ARQUIVO_NAO_ENVIADO);
            }
        }
    }
    
    /**
     * Gera o nome do arquivo a partir do tipo e data e numero.
     */
    public function getLink(){
        $data = $this->getData();
        $nome = $this->getNome();

        if(empty($data))          throw new InvalidArgumentException(Mensagem::ERRO_EXECUCAO);
        if(empty($nome))          throw new InvalidArgumentException(Mensagem::ERRO_EXECUCAO.' nome em branco');
        
        $nome          = $data.'_'.$nome;
        $this->setNome($nome);        
        $url = $this->getNome();
        return $url;
    }
    
    /**
     * Recolhe o arquivo enviado pelo usuário e o move para a pasta adequada.
     */
    public function moveArquivoParaDestino(){
        $nome_canonico = $this->getNomeCanonico();
        $diretorio     = dirname($nome_canonico);
        if(!file_exists($diretorio)){
            mkdir($diretorio, 0744, true);
        }
        $arquivoMovido = Arquivo::moveArquivoEnviadoVerifica($this->getMetadadosHTTP(),$nome_canonico);
        if(!$arquivoMovido){
            throw new RuntimeException(Mensagem::ERRO_AO_COPIAR_ARQUIVO);
        }
        $this->acoesArquivoAlterado();
    }
    
    /**
     * Retorna o nome canônico do arquivo, ou seja, seu path.
     */
    public function getNomeCanonico(){
        $nomeCanonico = $this->getDiretorioRaiz().DS.$this->getNome();
        return $nomeCanonico;
    }
    
    /**
     * Executa ações no caso de arquivo alterado.
     */
    public function acoesArquivoAlterado(){
        if($this->getIsAlteracaoArquivo()){
            $metadadosHTTP = $this->getMetadadosHTTP();
            $arquivoAntigo = $metadadosHTTP['arquivo_old_temp_name'];
            $diferentes = $this->saoDiferentes($arquivoAntigo, $metadadosHTTP['arquivo_temp_name']);
            if( $diferentes ){
                $this->remover($arquivoAntigo);
            }
        }
    }
    
    
    /**
     * Compara se o nome e a pasta de dois arquivos são iguais.
     * @param string $arquivo1
     * @param string $arquivo2
     * @return bool
     */
    public function saoDiferentes($arquivoAntigo, $arquivoNovo){
        if( strcmp($arquivoAntigo, $arquivoNovo) ) return true;
        return false;
    }
    
    /**
     * Remove um arquivo do sistema de arquivos.
     * @param string $arquivo
     * @throws InvalidArgumentException
     */
    public static function remover($arquivo){
        if( !file_exists($arquivo) ) throw new InvalidArgumentException(Mensagem::ERRO_EXECUCAO.' COD: Arquivo não existe!');
        if( !unlink($arquivo) ) throw new InvalidArgumentException(Mensagem::ERRO_EXECUCAO.' COD: Erro ao apagar arquivo!');
        if( file_exists($arquivo) ) throw new InvalidArgumentException(Mensagem::ERRO_EXECUCAO.' COD: Arquivo não foi apagado!');
    }
}
?>