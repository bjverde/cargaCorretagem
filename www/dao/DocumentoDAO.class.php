<?php
class DocumentoDAO extends mongoFormDin {
    const TIPO_JULGAMENTOS = 'julgamentos';
    const TIPO_ATOS_NORMAS = 'atos-e-normas';
    
	public function __construct(){
	    parent::__construct('documentos');
	    $this->setDataBase(MONGO_DATABASE);
	}
	//--------------------------------------------------------------------------------
	/**
	 * Grava as informação sobre o arquivo
	 * @param DocumentoVO $objVo
	 * @return DocumentoVO
	 */
	public function uploadArquivo(DocumentoVO $objVo){
	    $arquivo = $objVo->getArquivo();
	    $nameFile = $arquivo['arquivo_name'];
	    $fullPathFile = $arquivo['arquivo_temp_name'];
	    $fileId = $this->uploadFileMongo($nameFile, $fullPathFile);
	    $objVo->setPdf($fileId);
	    
	    return $objVo;
	}
	
	public function openFile( $idFile ,$arquivoTmp ){
	    $result = $this->openFileMongo( $idFile ,$arquivoTmp );
	    return $result;
	}
	//--------------------------------------------------------------------------------
	public function insert( $arrayCampos ){
	    $collection = $this->getCollection();
	    $insertOneResult = $collection->insertOne( $arrayCampos );
		$result = $insertOneResult->getInsertedId();
		return $result;
	}
	
	public function update ( $arrayCampos ,$idDocumento ) {
	    $mongoObjectsId = $this->convertId2MongoObjectsId( $idDocumento );
	    $filterArray = array('_id' => $mongoObjectsId );
	    $collection  = $this->getCollection();
	    $updateResult= $collection->updateOne($filterArray,['$set'=>$arrayCampos]);
	    return $updateResult;
	}	
}
?>