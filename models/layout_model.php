<?php namespace cahnrswp\pagebuilder2;

class layout_model {
	public $layout_key = '<!-- pagebuilder_layout ';
	public $layout_regex; 
	public $items_key = '<!-- pagebuilder_items ';
	public $post;
	public $meta;
	public $layout;
	public $clean_content;
	public $layout_data = array(
		'single-column' => array( 1 ),
		'two-column-aside-right' => array( 0.7 , 0.3 ),
		'two-column-half' => array( 0.5 , 0.3 ),
		'two-column-left-third' => array( 0.33 , 0.66 ),
		'two-column-right-third' => array( 0.66 , 0.33 ),
		'three-column' => array( 0.33 , 0.33 , 0.33 ),
		'four-column' => array( 0.25 , 0.25 , 0.25 , 0.25 ),
	);

	
	public function __construct( $post , $content = false ){
		if( !$content && $post ) $content = $post->post_content;
		$this->layout_regex = '/'.$this->layout_key.'.(.*?)-->/is';
		$this->post = $post; // Set post object
		$this->meta = \get_post_meta( $this->post->ID );
		$this->layout = $this->get_layout(); // Get the layout object
		$this->clean_content = ( $content )? $this->get_clean_content( $content ) : false ;
		$this->items = $this->get_items();
	}
	
	private function get_layout(){
		/** Check for post content string ***/
		if( strpos( $this->post->post_content , $this->layout_key ) !== false ){
			preg_match( $this->layout_regex , $this->post->post_content, $matches );
			if( $matches ){
				$layout = str_replace ( array( $this->layout_key , ' -->' ) , '' , $matches[0] );
				$layout = json_decode( $layout );
				return $layout;
			} else {
				$layout = json_encode( $this->get_default_layout() ); // Return default layout
			}
		} else { // No meta
			$layout = json_encode( $this->get_default_layout() ); // Return default layout
		} // End if
		return json_decode( $layout );
	} // End method
	
	private function get_clean_content( $content ){
		$content = preg_replace( $this->layout_regex , '' , $content );
		return $content;
	}
	
	private function get_items(){
		/** Let's check and see if meta data is set ***/
		if( isset( $this->meta['_pagebuilder_items_2'] ) && $this->meta['_pagebuilder_items_2'][0] ){
			return $this->meta['_pagebuilder_items_2'][0]; // Return pagebuilder meta data
		} else { // No meta
			return $this->get_default_items(); // Return default layout
		} // End if
	}
	private function get_default_items(){
		return array(
			'row-100' => array( 
				'title' => 'Header',
				'layout' => 'single-column',
				),
			'row-1' => array( 
				'title' => 'Content',
				'layout' => 'two-column-aside-right',
				),
			'row-200' => array( 
				'title' => 'Footer',
				'layout' => 'single-column',
				),
			'post_content-00000' => array('title' => 'Primary Content', 'is_content' => 1 ),
			);
	}
	
	public function get_default_layout(){
		$default = array(
			'row-100' => array(
				array( 'ID' => 1 ), // Column
				),
			'row-1' => array(
				array( 'ID' => 1 , 'items' => array( 'post_content-00000' ) ),// Column
				array('ID' => 2 ), // Column
				),
			'row-200' => array(
				array( 'ID' => 1 ), // Column
				),
			);
		return $default;
	}
};?>