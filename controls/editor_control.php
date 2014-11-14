<?php namespace cahnrswp\pagebuilder2;

class editor_control{
	
	public function add_editor(){
		global $post; // Get global post object
		$layout_model = new layout_model( $post , $post->post_content ); // Set editor model
		$layout_model->set_items_models();
		$editor_view = new editor_view( $this , $layout_model ); // Set editor view
		$editor_view->print_editor(); // Render View
	}
	
	public function remove_default_editor(){
		//\remove_post_type_support( 'page', 'editor' );
	}
	
	public function save_post( $post_id ){
		$post = get_post( $post_id );
		$save_model = new save_model( $post );
		$save_view = new save_view( $this , $save_model );
		
		/** Do a check to see if we should actually save **/
		if( !$this->check_save( $post_id ) ) return;
		
		/** To Do: Find a better way to do this - need to modify the *
		* post_content while the $_POST variable is accessible */
		remove_action( 'save_post', array( $this , 'save_post' ) );
			wp_update_post( array( 'ID' => $post_id, 'post_content' => $save_view->get_view() ) );
		add_action( 'save_post', array( $this , 'save_post' ) );
	}
	
	private function check_save( $post_id ){
		if ( wp_is_post_revision( $post_id ) ) return false;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) return false;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) return false;
		}
		return true;
	}
}
?>