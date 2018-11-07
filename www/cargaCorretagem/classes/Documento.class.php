<?php

class Documento {

	public function __construct(){
	}
	//--------------------------------------------------------------------------------
	private static function trataDadosById($id ,$field ,$dados){
	    $result = null;
	    if( is_array($dados) && !empty($dados) ){
	        foreach ($dados as $key => $value) {
	            $result['ID'][$key] = $key;
	            $result['IDDOC'][$key] = $id;
	            $result[$field][$key] = $value;
	        }
	    }
	    return $result;
	}
	//--------------------------------------------------------------------------------
	/**
	 * Retorna o array do campo desejado
	 * @param string $id  - ID do documento 
	 * @param string $field - Nome do campo 
	 * @return array|null
	 */
	public static function selectFieldByIdDoc( $id, $field ){
	    $mongoBD = new DocumentoDAO();
	    $result = $mongoBD->selectById( $id );
	    $listObjInteressado = $result[$field];
	    $listObjInteressado = $mongoBD->convertMongoElement2String($listObjInteressado);
	    $listInteressado = self::trataDadosById($id ,$field ,$listObjInteressado[0]);
	    return $listInteressado;
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ){
	    $mongoBD = new DocumentoDAO();
	    $result = $mongoBD->selectById( $id );
	    $result = self::trataDados($result);
		return $result;
	}
	//--------------------------------------------------------------------------------
	private static function getFiltrosTextual($arrayFilter) {
		$camposPesquisa = array('publicacao', 'ementa', 'trecho', 'assunto');
		$result = null;
		$textoPesquisa = null;
		foreach ($arrayFilter as $key => $value) {
			if( in_array($key, $camposPesquisa, true) ){
				$textoPesquisa = $textoPesquisa.' '.$value;
			}else{
				$result[ $key ] = $value;
			}
		}
		if( !empty($textoPesquisa) ){
			$arrayTextSearch = array('$text' => array('$search'=> $textoPesquisa));
			$arrayFilter = array_merge($result, $arrayTextSearch);
		}else {
			$arrayFilter = $result;
		}
		return $arrayFilter;
	}
	private static function getFiltrosTextualLike($arrayFilter) {
	    $camposPesquisa = array('interessado','relator','orgaoOrigem');
	    $result = null;
	    //$textoPesquisa = null;
	    foreach ($arrayFilter as $key => $value) {
	        if( in_array($key, $camposPesquisa, true) ){
	            $regex = new MongoDB\BSON\Regex ( $value, 'i' ); //maneira mais comum
	            //$regex = array('$regex' => '(?i)'.$value );    //forma alternativa
	            $result[ $key ] = $regex;
	        }else{
	            $result[ $key ] = $value;
	        }
	    }
	    $arrayFilter = $result;
	    return $arrayFilter;
	}
	//--------------------------------------------------------------------------------
	private static function getFiltrosNumericos($arrayFilter) {
		$camposPesquisa = array('numero');
		$result = null;
		foreach ($arrayFilter as $key => $value) {
			if( in_array($key, $camposPesquisa, true) ){
				$result[ $key ] = intval($value);
			}else{
				$result[ $key ] = $value;
			}
		}
		$arrayFilter = $result;
		return $arrayFilter;
	}
	//--------------------------------------------------------------------------------
	private static function getFiltrosDatas($arrayFilter) {
		$camposPesquisa = array('dt_publicacao','dt_decisao');
		$result = null;
		foreach ($arrayFilter as $key => $value) {
			if( in_array($key, $camposPesquisa, true) ){
				$result[ 'dt' ] = mongoFormDin::date2MongoDateTime($value);
			}else{
				$result[ $key ] = $value;
			}
		}
		$arrayFilter = $result;
		return $arrayFilter;
	}
	//--------------------------------------------------------------------------------
	private static function filtrosBusca( $arrayFilter ){
		$arrayFilter = mongoFormDin::clearArrayFilter($arrayFilter);
		if( is_array($arrayFilter) && !empty($arrayFilter) ){
		  $arrayFilter = self::getFiltrosTextual($arrayFilter);
		  $arrayFilter = self::getFiltrosTextualLike($arrayFilter);
		  $arrayFilter = self::getFiltrosNumericos($arrayFilter);
		  $arrayFilter = self::getFiltrosDatas($arrayFilter);
		}
		return $arrayFilter;
	}
	//--------------------------------------------------------------------------------
	public static function count( $arrayFilter=null){
	    if( !empty($arrayFilter) ){
	        $arrayFilter  = self::filtrosBusca( $arrayFilter );
	    }
	    $mongoBD = new DocumentoDAO();
	    $result = $mongoBD->count($arrayFilter);
	    return $result;
	}
	//--------------------------------------------------------------------------------
	public static function trataDadosCombo($dados){
	    $result = null;
	    if( isset($dados) && is_array($dados) ){
	        foreach ($dados['NUMERO'] as $key => $value) {
	            $result['ID'][$key] = $dados['ID'][$key];
	            $result['NOME'][$key]  = $value.' - '.$dados['DT'][$key];;
	        }
	    }
	    return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectComboJulgamento(){
	    $arrayFilter = array('tipo'=> DocumentoDAO::TIPO_JULGAMENTOS );
	    $result = self::selectAll(null,$arrayFilter);
	    $result = self::trataDadosCombo($result);
	    return $result;
	}
	//--------------------------------------------------------------------------------
	public static function trataDados($dados){
	    if( isset($dados) && is_array($dados) ){
	        foreach ($dados['NUMERO'] as $key => $value) {
	            //Arquivo no Apache
	            //$link = $dados['LINK'][$key];
	            //Arquivo no Mongo
	            $link = $dados['PDF'][$key];
	            if( empty($link) ){
	                $linkCompleto = $dados['NUMERO'][$key];
	            } else {	                
	                $linkCompleto = '<a href="'.URL_DADOS.$link.'" target="_blank">'.$value.'</a>';
	            }
	            $dados['NUMERO_LINK'][$key]  = $linkCompleto;
	        }
	    }
	    return $dados;
	}	
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
		/*
	    $arquivo = new Arquivo();
	    $arquivo->setTipo($objVo->getTipo());
	    $arquivo->setNumero($objVo->getNumero());
	    $arquivo->setData($objVo->getDt());
	    $arquivo->setMetadadosHTTP($objVo->getArquivo());
	    $link = $arquivo->getLink();
	    //As duas linhas abaixo serão utilizadas para gravar os arquivos tambem no file system
	    //$arquivo->setDiretorioRaiz(DIR_ARQ_DIARIO);
	    //$arquivo->moveArquivoParaDestino();
		$objVo->setLink($link);
		*/ 
	    
	    $arquivoTMP = $objVo->getArquivo();
	    //$arquivoTMP['arquivo_name'] = $arquivo->getNome();
		//$arquivoTMP['arquivo_name_apache'] = $arquivo->getNomeCanonico();
		//$arquivoTMP['arquivo_name'] = 't.pdf';
		//$arquivoTMP['arquivo_name_apache'] = $arquivoTMP['arquivo_temp_name'];
	    $objVo->setArquivo($arquivoTMP);
	    
		//$inteiroTeor = pdfParser::parseFile($arquivoTMP['arquivo_temp_name']);
		$inteiroTeor = pdfParser::parseFile('../NotaCorretagem_30487_20181008.pdf');
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