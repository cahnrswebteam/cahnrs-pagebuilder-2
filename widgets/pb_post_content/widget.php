<?php 
class pb_post_content extends \WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'pb_post_content', // Base ID
			'Post Content', // Name
			array( 'description' => 'Default content for the post.', ) // Args
		);

	}

	
	public function widget( $args, $instance ) {
		echo 'hello world';
	}

	public function form( $instance ) {
		echo 'hello world';
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}
add_action( 'widgets_init', function(){ register_widget( 'pb_post_content' ); });

?>