<?php
class DocumentoVO {
	private $id = null;
	private $tipo = null;
	private $categoria = null;
	private $dt = null;
	private $dt_publicacao = null;
	private $numero = null;
	private $orgaojulgador = null;
	private $publicacao = null;
	private $status = null;
	private $relator = null;
	private $link = null;
	private $descricao = null;
	private $trecho = null;
	private $natureza = null;
	private $dt_decisao = null;
	private $interessado = null;
	private $assunto = null;
	private $orgaoorigem = null;
	private $ano = null;
	private $arquivo = null;
	private $dt_inclusao = null;
	private $pdf = null;
	public function __construct( $id=null
	                           , $tipo=null
	                           , $categoria=null
	                           , $dt=null
	                           , $dt_publicacao=null
	                           , $numero=null
	                           , $orgaojulgador=null
	                           , $publicacao=null
	                           , $status=null
	                           , $relator=null
	                           , $link=null
	                           , $descricao=null
	                           , $trecho=null
	                           , $natureza=null
	                           , $dt_decisao=null
	                           , $interessado=null
	                           , $assunto=null
	                           , $orgaoorigem=null 
	                           , $ano=null
	                           , $arquivo=null
	                           , $dt_inclusao=null
	                           , $pdf=null
	                           ) {
		$this->setId( $id );
		$this->setTipo( $tipo );
		$this->setCategoria( $categoria );
		$this->setDt( $dt );
		$this->setDt_publicacao( $dt_publicacao );
		$this->setNumero( $numero );
		$this->setOrgaojulgador( $orgaojulgador );
		$this->setPublicacao( $publicacao );
		$this->setStatus( $status );
		$this->setRelator( $relator );
		$this->setLink( $link );
		$this->setDescricao( $descricao );
		$this->setTrecho( $trecho );
		$this->setNatureza( $natureza );
		$this->setDt_decisao( $dt_decisao );
		$this->setInteressado( $interessado );
		$this->setAssunto( $assunto );
		$this->setOrgaoorigem( $orgaoorigem );
		$this->setAno( $ano );
		$this->setArquivo( $arquivo );
		$this->setDt_inclusao( $dt_inclusao );
	}
    //--------------------------------------------------------------------------------
	function setId( $strNewValue = null )
	{
		$this->id = $strNewValue;
	}
	function getId()
	{
		return $this->id;
	}
	//--------------------------------------------------------------------------------
	function setTipo( $strNewValue = null )
	{
		$this->tipo = $strNewValue;
	}
	function getTipo()
	{
		return $this->tipo;
	}
	//--------------------------------------------------------------------------------
	function setCategoria( $strNewValue = null )
	{
		$this->categoria = $strNewValue;
	}
	function getCategoria()
	{
		return $this->categoria;
	}
	//--------------------------------------------------------------------------------
	function setDt( $strNewValue = null )
	{
	    $this->dt = $strNewValue;
	}
	function getDt()
	{
	    return $this->dt;
	}
	//--------------------------------------------------------------------------------
	function setDt_publicacao( $strNewValue = null )
	{
		$this->dt_publicacao = $strNewValue;
	}
	function getDt_publicacao()
	{
		return $this->dt_publicacao;
	}
	//--------------------------------------------------------------------------------
	function setNumero( $strNewValue = null )
	{
		$this->numero = $strNewValue;
	}
	function getNumero()
	{
		return $this->numero;
	}
	//--------------------------------------------------------------------------------
	function setOrgaojulgador( $strNewValue = null )
	{
		$this->orgaojulgador = $strNewValue;
	}
	function getOrgaojulgador()
	{
		return $this->orgaojulgador;
	}
	//--------------------------------------------------------------------------------
	function setPublicacao( $strNewValue = null )
	{
		$this->publicacao = $strNewValue;
	}
	function getPublicacao()
	{
		return $this->publicacao;
	}
	//--------------------------------------------------------------------------------
	public function setStatus( $strNewValue = null )
	{
		$this->status = $strNewValue;
	}
	public function getStatus()
	{
		return $this->status;
	}
	//--------------------------------------------------------------------------------
	public function setRelator( $strNewValue = null )
	{
		$this->relator = $strNewValue;
	}
	public function getRelator()
	{
		return $this->relator;
	}
	//--------------------------------------------------------------------------------
	public function setLink( $strNewValue = null )
	{
		$this->link = $strNewValue;
	}
	public function getLink()
	{
		return $this->link;
	}
	//--------------------------------------------------------------------------------
	public function setDescricao( $strNewValue = null )
	{
		$this->descricao = $strNewValue;
	}
	public function getDescricao()
	{
		return $this->descricao;
	}
	//--------------------------------------------------------------------------------
	public function setTrecho( $strNewValue = null )
	{
		$this->trecho = $strNewValue;
	}
	public function getTrecho()
	{
		return $this->trecho;
	}
	//--------------------------------------------------------------------------------
	public function setNatureza( $strNewValue = null )
	{
		$this->natureza = $strNewValue;
	}
	public function getNatureza()
	{
		return $this->natureza;
	}
	//--------------------------------------------------------------------------------
	public function setDt_decisao( $strNewValue = null )
	{
		$this->dt_decisao = $strNewValue;
	}
	public function getDt_decisao()
	{
		return $this->dt_decisao;
	}
	//--------------------------------------------------------------------------------
	public function setInteressado( $strNewValue = null )
	{
		$this->interessado = $strNewValue;
	}
	public function getInteressado()
	{
		return $this->interessado;
	}
	//--------------------------------------------------------------------------------
	public function setAssunto( $strNewValue = null )
	{
		$this->assunto = $strNewValue;
	}
	public function getAssunto()
	{
		return $this->assunto;
	}
	//--------------------------------------------------------------------------------
	public function setOrgaoorigem( $strNewValue = null )
	{
		$this->orgaoorigem = $strNewValue;
	}
	public function getOrgaoorigem()
	{
		return $this->orgaoorigem;
	}
	//--------------------------------------------------------------------------------
	public function getAno()
	{
	    return $this->ano;
	}	
	public function setAno($ano)
	{
	    $this->ano = $ano;
	}
	//--------------------------------------------------------------------------------
	public function setArquivo( $arquivo = null )
	{
	    $this->arquivo = $arquivo;
	}
	public function getArquivo()
	{
	    return $this->arquivo;
	}
	//--------------------------------------------------------------------------------
	public function setDt_inclusao( $strNewValue = null )
	{
	    $this->dt_inclusao = $strNewValue;
	}
	public function getDt_inclusao()
	{
	    return $this->dt_inclusao;
	}
	//--------------------------------------------------------------------------------
	public function setPdf( $strNewValue = null )
	{
	    $this->pdf= $strNewValue;
	}
	public function getPdf()
	{
	    return $this->pdf;
	}
}
?>