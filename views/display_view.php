<?php namespace cahnrswp\pagebuilder2;

class display_view{
	public $layout_model;
	public $display_controller;
	
	public function __construct( $display_controller , $layout_model ){
		$this->layout_model = $layout_model;
		$this->display_controller = $display_controller;
	}
	
	public function get_view(){
		if( isset( $this->layout_model->layout ) && $this->layout_model->layout ){
			foreach( $this->layout_model->layout as $row_key => $row_data ){
				include DIR.'inc/public_layout.php';
			}
		}
	}
}
?>