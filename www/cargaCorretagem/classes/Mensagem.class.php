<?php
/**
 * Classe de constantes contendo as mensagens do sistema. 
 * @author Mauro Martins Pagnez
 * @final
 */
final class Mensagem {
	
    const INFO_CONT_PRO_CONT = 'Se o problema persistir, entre em contato com o STI.';    
    const INFORME_TI   = 'Entre em contato com o STI para relatar o caso.';    
    const ERRO_INTERNO = 'Ocorreu um erro interno. Por favor, entre em contato com o STI para relatar o problema.';
    
    const OPERACAO_FALHOU = 'Operação não realizada.';
	
	/**
	 * É utilizada quando o arquivo enviado apresenta problemas ou quando algum dado é perdido durante o envio.
	 */
	const ERRO_NO_ENVIO_DE_ARQUIVO = 'Ocorreu uma falha durante o envio do arquivo. Por favor,\n verifique se o arquivo não apresenta problemas.';
	
	/**
	 * É utilizada quando, por algum motivo, o arquivo enviado não chega ao servidor.
	 */
	const ERRO_ARQUIVO_NAO_ENVIADO = 'Por algum motivo o arquivo enviado não conseguiu chegar ao\n seu destino. Tente novamente.'.self::INFO_CONT_PRO_CONT;
	
	/**
	 * É utilizada toda vez que o arquivo enviado for de um tipo diferente de ".pdf".
	 */
	const TIPO_DE_ARQUIVO_INVALIDO = 'O arquivo enviado deve ser um arquivo do tipo \".pdf\".';
	
	/**
	 * É utilizada toda vez que o arquivo exede o tamanho estabelecido pelo sistema: TAM_MAX_MATERIA para matérias e TAM_MAX_DIARIO para o diário.
	 */
	const ARQUIVO_EXCEDEU_TAMANHO = 'O arquivo enviado possui tamanho maior que o estabelecido.\n Compare o limite do sistema com o tamanho do arquivo e tente novamente.';
	
	/**
	 * Mensagem exibida quando o sistema tenta copiar o arquivo da pasta temporária do PHP para a pasta específica do sistema.
	 */
	const ERRO_AO_COPIAR_ARQUIVO = 'Ocorreu um erro ao copiar o arquivo para sua pasta de destino.\n Tente novamente em alguns instantes.'.self::INFO_CONT_PRO_CONT;
	
	/**
	 * Mensagem exibida quando ocorre um erro interno, sendo ou não de programação e que não pode ser facilmente explicado ao usuário final.
	 */
	const ERRO_ARQUIVO = 'Arquivo não encontrado na pasta de origem. '.self::INFORME_TI;
	
	const ERRO_EXECUCAO = 'Ocorreu um erro durante a execução. Tente em alguns instantes.\n '.self::INFO_CONT_PRO_CONT;
	
	const ERRO_NOME_ARQUIVO = 'Nome do arquivo inválido. '.self::INFORME_TI;
	
	const ERRO_NOME_DIRETORIO = 'Nome do diretório inválido. '.self::INFORME_TI;
	
	const ERRO_PROGRAMACAO = 'Existe um erro interno no sistema. '.self::INFORME_TI;
	
	const ERRO_CONFIG_BANCO = 'Falhou ao pegar o Host de banco. '.self::INFORME_TI;
	
	const ERRO_CONFIG_USUARIOS = 'Falha de configuração, lista de usuarios em Branco! '.self::INFORME_TI;
	
}	

?>