<?php namespace cahnrswp\pagebuilder2;

class editor_view{
	private $controller;
	private $layout_model;
	
	public function __construct( $controller , $layout_model ){
		$this->controller = $controller;
		$this->layout_model = $layout_model;
	}
	
	public function print_editor(){
		$this->get_layout_editor();
		$this->get_content_editor();
	}
	
	public function get_layout_editor(){
		
		if( isset( $this->layout_model->layout ) && $this->layout_model->layout ){
			foreach( $this->layout_model->layout as $row_key => $row_data ){
				include DIR.'inc/editor_layout.php';
			}
		}
	}
	
	public function get_content_editor(){
		\wp_editor( $this->layout_model->clean_content, '_pagebuilder_content' );
	}
}
?>