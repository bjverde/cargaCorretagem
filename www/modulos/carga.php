<?php
defined('APLICATIVO') or die();

$whereGrid = ' 1=1 ';
$primaryKey = 'ID';

$frm = new TForm('Carga');
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' );   //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );//Coluna chave da tabela

$frm->addGroupField('gpx1', 'Dados Básicos');
    $arquivo = 'arquivo'; 
    $frm->addFileField($arquivo,'Arquivo:',true,'pdf','10M',40,true); 
$frm->closeGroup();

$frm->addHtmlField('espaco01',null,null,null,20);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$frm->addHtmlField('espaco02',null,null,null,20);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
	    try{
			$postArquivo = getPostArquivo($frm,$arquivo);
			$vo = new DocumentoVO();
			$frm->setVo( $vo );
			$vo->setArquivo($postArquivo);

			$resultado = Documento::save( $vo );
			if($resultado==1) {
				$frm->setMessage('Registro gravado com sucesso!!!');
				unset( $_SESSION[APLICATIVO]['offline'] );
				$frm->clearFields();
			}else{
				$frm->setMessage($resultado);
			}
	    }
	    catch (DomainException $e) {
	        $frm->setMessage( $e->getMessage() );
	    }
	    catch (Exception $e) {
	        MessageHelper::logRecord($e);
	        $frm->setMessage( $e->getMessage() );
	    }
	break;
	//--------------------------------------------------------------------------------
	case 'Limpar':
	    unset( $_SESSION[APLICATIVO]['offline'] );
		$frm->clearFields();
	break;
	//--------------------------------------------------------------------------------
	case 'gd_excluir':
		try{
		    $id = $frm->get( $primaryKey ) ;
		    $resultado = Documento::delete( $id );;
		    if($resultado==1) {
		        $frm->setMessage('Registro excluido com sucesso!!!');
		        unset( $_SESSION[APLICATIVO]['offline'] );
		        $frm->clearFields();
		    }else{
		        $frm->clearFields();
		        $frm->setMessage($resultado);
		    }
		}
		catch (DomainException $e) {
		    $frm->setMessage( $e->getMessage() );
		}
		catch (Exception $e) {
		    MessageHelper::logRecord($e);
		    $frm->setMessage( $e->getMessage() );
		}
	break;
}

function getPostArquivo(&$frm,$arquivo){
    $postArquivoMateria = array();
    $postArquivoMateria['arquivo_name']      = PostHelper::get($arquivo);
    $postArquivoMateria['arquivo_temp_name'] = $frm->getBase().PostHelper::get($arquivo.'_temp_name');
    $postArquivoMateria['arquivo_extension'] = PostHelper::get($arquivo.'_extension');
    $postArquivoMateria['arquivo_size']      = PostHelper::get($arquivo.'_size');
    $postArquivoMateria['arquivo_type']      = PostHelper::get($arquivo.'_type');
    return $postArquivoMateria;
}

function getWhereGridParameters(&$frm){
    $retorno = array('tipo'=>$frm->get('TIPO'));
    if($frm->get('BUSCAR') == 1 ){
        $retorno = array(
             'id'=>$frm->get('ID')
            ,'tipo'=>$frm->get('TIPO')
            ,'categoria'=>$frm->get('CATEGORIA')
            ,'dt_publicacao'=>$frm->get('DT_PUBLICACAO')
            ,'numero'=>$frm->get('NUMERO')
            ,'orgaoJulgador'=>$frm->get('ORGAOJULGADOR')
            ,'publicacao'=>$frm->get('PUBLICACAO')
            ,'status'=>$frm->get('STATUS')
            ,'relator'=>$frm->get('RELATOR')
            ,'link'=>$frm->get('LINK')
            ,'ementa'=>$frm->get('EMENTA')
            ,'trecho'=>$frm->get('TRECHO')
            ,'natureza'=>$frm->get('NATUREZA')
            ,'dt_decisao'=>$frm->get('DT_DECISAO')
            ,'interessado'=>$frm->get('INTERESSADO')
            ,'assunto'=>$frm->get('ASSUNTO')
            ,'orgaoOrigem'=>$frm->get('ORGAOORIGEM')
            ,'relator'=>$frm->get('RELATOR')
        );
    }
    return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
    $maxRows = ROWS_PER_PAGE;
    $whereGrid = getWhereGridParameters($frm);
	//$dados = Documento::selectAll( $primaryKey, $whereGrid );
	$dados = array();
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
	                .',TIPO|TIPO'
	                .',ORGAOJULGADOR|ORGAOJULGADOR'
	                .',NATUREZA|NATUREZA'
	                .',NUMERO|NUMERO'
	                .',CATEGORIA|CATEGORIA'
	                .',DT_DECISAO|DT_DECISAO'
	                .',INTERESSADO|INTERESSADO'
	                .',ASSUNTO|ASSUNTO'
	                .',ORGAOORIGEM|ORGAOORIGEM'
	                .',RELATOR|RELATOR,LINK|LINK,TRECHO|TRECHO';
    $gride = new TGrid( 'gd'                        // id do gride
        ,'Lista de Julgamento' // titulo do gride
        );
    $gride->addKeyField( $primaryKey ); // chave primaria
    $gride->setData( $dados ); // array de dados
    $gride->setMaxRows( $maxRows );
    $gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'carga.php' );
	//$gride->addRowNumColumn();
	//$gride->addColumn('DT_INCLUSAO','Dat Inclusão',null,'center');
	//$gride->addColumn($primaryKey,'id',null,'center');
	//$gride->addColumn('TIPO','TIPO',50,'center');
	$gride->addColumn('NUMERO_LINK','Número',Null,'center');
	$gride->addColumn('DT_DECISAO','Data da Decisão',null,'center');
	$gride->addColumn('ORGAOJULGADOR','Órgão julgador');
	$gride->addColumn('NATUREZA','Natureza',null,'center');
	$gride->addColumn('CATEGORIA','Categoria',null,'center');
	//$gride->addColumn('INTERESSADO','Interessado',null,'center');
	//$gride->addColumn('ASSUNTO','Assunto',50,'center');
	//$gride->addColumn('ORGAOORIGEM','Órgão de origem',null,'center');
	$gride->addColumn('RELATOR','Relator',null);
	$gride->show();
    die();
}

$frm->addHtmlField('gride');
$frm->addJavascript('init()');
$frm->show();

//d($_REQUEST);
//d($_SESSION[APLICATIVO]);

?>
<script>
function init() {
	var Parameters = {"BUSCAR":""
		             ,"ID":""
					 ,"TIPO":""
					 ,"CATEGORIA":""
					 ,"DT_PUBLICACAO":""
					 ,"NUMERO":""
					 ,"ORGAOJULGADOR":""
					 ,"PUBLICACAO":""
					 ,"STATUS":""
					 ,"RELATOR":""
					 ,"LINK":""
					 ,"EMENTA":""
					 ,"TRECHO":""
				     ,"NATUREZA":""
					 ,"DT_DECISAO":""
					 ,"INTERESSADO":""
					 ,"ASSUNTO":""
					 ,"ORGAOORIGEM":""
					 ,"RELATOR":""};
	fwGetGrid('carga.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>