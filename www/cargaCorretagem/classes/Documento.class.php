<?php

class Documento {

	public function __construct(){
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ){
	    $mongoBD = new DocumentoDAO();
	    $result = $mongoBD->selectById( $id );
	    $result = self::trataDados($result);
		return $result;
	}
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------	
	/**
	 * 
	 * @param array $arrayFilter      - campos de pesquisa
	 * @param array $arraySort        - ordenação
	 * @param number $skip            - paginação
	 * @param number $limit           - qtd de registro
	 * @param boolean $resultFormDin  - resulta para apresentar no formDin ou não
	 * @return NULL|array
	 */
	public static function selectAll( $arraySort=null ,$arrayFilter=null ,$limit=null ,$skip=null ,$resultFormDin=true  ){
	    if( !empty($arrayFilter) ){
	       $arrayFilter  = self::filtrosBusca( $arrayFilter );
	    }
	    
		$arraySort = array( 'sort' => array('dt'=>-1) );  //Faz ordenação DECRESCENTE pela data de publicacao / decisão
		
		if( empty($limit) ){
		    $limit  = 1000 ; //Limita os resultados aos 1.000 registros
		}
	    
	    //https://code.tutsplus.com/tutorials/full-text-search-in-mongodb--cms-24835
	    //https://dzone.com/articles/find-mongo-document-by-id-using-the-php-library
	    $mongoBD = new DocumentoDAO();
	    $result = $mongoBD->selectAll($arraySort ,$arrayFilter ,$limit ,$skip ,$resultFormDin);
	    if($resultFormDin){
	        $result = self::trataDados($result);
	    }
		return $result;
	}
	//--------------------------------------------------------------------------------	
	/***
	 * Trata o arquivo temp movendo para a pasta definitiva.
	 * @param DocumentoVO $objVo
	 * @return DocumentoVO
	 */
	private static function trataArquivo( DocumentoVO $objVo ){
	    $arquivo = new Arquivo();
	    $arquivo->setTipo($objVo->getTipo());
	    $arquivo->setNumero($objVo->getNumero());
	    $arquivo->setData($objVo->getDt());
	    $arquivo->setMetadadosHTTP($objVo->getArquivo());
	    $link = $arquivo->getLink();
	    //As duas linhas abaixo serão utilizadas para gravar os arquivos tambem no file system
	    $arquivo->setDiretorioRaiz(DIR_ARQ_DIARIO);
	    $arquivo->moveArquivoParaDestino();
		$objVo->setLink($link);
	    
	    $arquivoTMP = $objVo->getArquivo();
	    $arquivoTMP['arquivo_name'] = $arquivo->getNome();
		$arquivoTMP['arquivo_name_apache'] = $arquivo->getNomeCanonico();
		$arquivoTMP['arquivo_name'] = 't.pdf';
		$arquivoTMP['arquivo_name_apache'] = $arquivoTMP['arquivo_temp_name'];
	    $objVo->setArquivo($arquivoTMP);
	    
		$inteiroTeor = pdfParser::parseFile($arquivoTMP['arquivo_temp_name']);
		//$inteiroTeor = pdfParser::parseFile('../NotaCorretagem_30487_20181008.pdf');
	    $objVo->setTrecho($inteiroTeor);
	    
	    return $objVo;
	}
	
	public static function getAno( $data ){
	    $data = explode('/', $data);
	    return $data[2];
	}
	//--------------------------------------------------------------------------------
	public static function save( DocumentoVO $objVo ){
		$result = null;

		$objVo = self::trataArquivo($objVo);
		
		$result = 1;
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
	    $result = self::selectById($id);	    
	    $hasArray = ArrayHelper::has('PDF', $result);
	    if($hasArray){
	        $oid=get_object_vars($result['PDF'][0]);
	        File::delete($oid['oid']);
	    }
	    $mongoBD = new DocumentoDAO();
	    $result = $mongoBD->delete( $id );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function openFile( $idFile ,$arquivoTmp ){
	    $mongoBD = new DocumentoDAO();
	    $result = $mongoBD->openFile( $idFile ,$arquivoTmp );
	    return $result;
	}
}
?>