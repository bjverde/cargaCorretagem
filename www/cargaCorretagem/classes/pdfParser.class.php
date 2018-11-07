<?php

class pdfParser {
    
	public function __construct(){
	}
	
	/***
	 * Metodo generico por indefinição inicial do projeto qual seria
	 * a forma de fazer o parse do PDF
	 * @param string $arquivo
	 * @return string
	 */
	public static function parseFile($arquivo)
	{
	    //$arquivo = RAIZ_APP.DS.'documento.pdf';
	    //$arquivo = RAIZ_APP.DS.'portaria_1692018_0024080.pdf';
	    $result  = self::phpApacheTika($arquivo);
	    return $result;
	}
	
	/**
	 * Recupera o texto do arquivo via Apache Tika
	 * @link https://github.com/vaites/php-apache-tika
	 * @link https://packagist.org/packages/vaites/php-apache-tika
	 * @link https://stackoverflow.com/questions/12231630/how-to-use-tika-in-server-mode
	 * @link https://wiki.apache.org/tika/TikaJAXRS
	 * @param string $arquivo
	 * @return string
	 */
	public static function phpApacheTika($arquivo)
	{
	    $host  = ServidorConfig::getInstancia()->getConfigParam('tika_server');
	    $porta = ServidorConfig::getInstancia()->getConfigParam('tika_port');
	    $client = \Vaites\ApacheTika\Client::make($host, $porta);
	    //$metadata = $client->getMetadata($arquivo);
	    $text = $client->getText($arquivo);	    
	    return $text;
	}
}