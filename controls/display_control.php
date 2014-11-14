<?php namespace cahnrswp\pagebuilder2;

class display_control{
	
	public function get_public_display( $content ){
		global $post; // Get global post object
		$layout_model = new layout_model( $post , $post->post_content ); // Set editor model
		$display_view = new display_view( $this , $layout_model );
		ob_start();
			$display_view->get_view();
		return ob_get_clean();
	}
}
?>