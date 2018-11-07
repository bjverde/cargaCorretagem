<?php

class File {

	public function __construct(){
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ){
		$mongoBD = new FileDAO();
	    $result = $mongoBD->selectById( $id );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectAll(){
	    $mongoBD = new FileDAO();
	    $result = $mongoBD->selectAll();
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
	    $mongoBD = new FileDAO();
	    $result = $mongoBD->delete( $id );
		return $result;
	}
}
?>