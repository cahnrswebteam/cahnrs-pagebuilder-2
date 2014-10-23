<?php namespace cahnrswp\pagebuilder2;

class save_view{
	private $controller;
	private $save_model;
	
	public function __construct( $controller , $save_model ){
		$this->controller = $controller;
		$this->save_model = $save_model;
	}
	
	public function get_view(){
		
		$content = $_POST['_pagebuilder_content'];
		return $content.$this->save_model->save_layout_encoded;
	}
	
	private function get_layout_string(){
	}
	
	public function check_set( $array , $name , $default = 'na' ){
		//$set = ( isset( $array[ $name ] ) ) ?  $array[ $name ] : '';
		//if( 'na' != $default && '' === $set ) return $default;
		//return $set;
	}
}
?>