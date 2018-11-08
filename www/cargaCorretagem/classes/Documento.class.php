<?php

class Documento {

	public function __construct(){
	}
	//--------------------------------------------------------------------------------	
	/***
	 * Trata o arquivo temp movendo para a pasta definitiva.
	 * @param DocumentoVO $objVo
	 * @return DocumentoVO
	 */
	private static function trataArquivo( DocumentoVO $objVo ){

		$format = 'YmdHis';
		$data = DateTimeHelper::getNowFormat($format);
		$objVo->setDt_inclusao( $data );

		$arquivoTMP = $objVo->getArquivo();

		$arquivo = new Arquivo();
		$arquivo->setNome( $arquivoTMP['arquivo_name'] );
	    $arquivo->setData($objVo->getDt_inclusao());
	    $arquivo->setMetadadosHTTP($objVo->getArquivo());
	    $link = $arquivo->getLink();
	    //As duas linhas abaixo serão utilizadas para gravar os arquivos tambem no file system
	    $arquivo->setDiretorioRaiz(DIR_ARQ_DIARIO);
	    $arquivo->moveArquivoParaDestino();
		$objVo->setLink($link);	    
	    
	    $arquivoTMP['arquivo_name'] = $arquivo->getNome();
		$arquivoTMP['arquivo_name_apache'] = $arquivo->getNomeCanonico();
	    $objVo->setArquivo($arquivoTMP);
		
		$arquivo_caminho_completo = $arquivo->getNomeCanonico();
		$inteiroTeor = pdfParser::parseFile( $arquivo_caminho_completo );
	    $objVo->setTrecho($inteiroTeor);
	    
	    return $objVo;
	}
	//--------------------------------------------------------------------------------
	public static function save( DocumentoVO $objVo ){
		$result = null;

		$objVo = self::trataArquivo($objVo);
		
		$result = 1;
		return $result;
	}
}
?>