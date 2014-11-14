<?php namespace cahnrswp\pagebuilder2;

class layout_model {
	public $layout_key = '<!-- pagebuilder_layout ';
	public $layout_regex = false; 
	public $items_key = '<!-- pagebuilder_items ';
	public $items_regex = false;
	public $post = false;
	public $content = false;
	public $meta = false;
	public $layout = false;
	public $clean_content = false;
	public $items = false;
	public $layout_data = array(
		'single-column' => array( 1 ),
		'two-column-aside-right' => array( 0.7 , 0.3 ),
		'two-column-half' => array( 0.5 , 0.3 ),
		'two-column-left-third' => array( 0.33 , 0.66 ),
		'two-column-right-third' => array( 0.66 , 0.33 ),
		'three-column' => array( 0.33 , 0.33 , 0.33 ),
		'four-column' => array( 0.25 , 0.25 , 0.25 , 0.25 ),
	);

	
	public function __construct( $post = false , $content = false ){
		$this->layout_regex = '/'.$this->layout_key.'.(.*?)-->/is';
		$this->items_regex = '/'.$this->items_key.'.(.*?)-->/is'; 
		
		if( $post ){
			$this->post = $post; // Set post object
			$this->meta = \get_post_meta( $this->post->ID );
		};
		
		if( $content ){ $this->content = $content; }
		else if( $post ) { $this->content = $post->post_content; }
		
		if( $this->content ){
			$this->items = $this->get_items();
			$this->layout = $this->get_layout(); // Get the layout object
			$this->set_row_settings();
			$this->clean_content = $this->get_clean_content( $this->content );
			
		}
		
	}
	
	private function get_layout(){
		/** Check for post content string ***/
		if( strpos( $this->content , $this->layout_key ) !== false ){
			preg_match( $this->layout_regex , $this->content, $matches );
			if( $matches ){
				$layout = str_replace ( array( $this->layout_key , ' -->' ) , '' , $matches[0] );
				if( !$layout ) $layout = json_encode( $this->get_default_layout() ); // Return default layout
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
	
	private function set_row_settings(){
		
		/** Make sure layout exists before we do anything **/
		if( !$this->layout ) return false;
		
		/** Loop through layout rows **/
		foreach( $this->layout as $row_key => &$row_data ){
			/** Write settings to row settings property **/
			
			$row_id = $row_data->ID;
			if( isset( $this->items->$row_id ) ) {
				/** Add setting to layout **/ 
				$row_data->settings = $this->items->$row_id;
				$row_data->column_count = ( isset( $this->layout_data[ $row_data->settings->layout ] ) )?
					count( $this->layout_data[ $row_data->settings->layout ] ) : 1;
			}
		}
	}
	
	public function set_items_models(){
		foreach( $this->items as $item_key => &$item ){
			$item_model = $this->get_item_model( $item_key );
			if( $item_model ){
				$item->model = $item_model;
			}
		}
	}
	
	public function get_item_model( $ID ){
		if( strpos( $ID , '|' ) !== false ){
			$item_class = explode( '|' , $ID );
			$item_class = $item_class[0];
			if( class_exists( $item_class ) ) {
				$item_model = new $item_class;
				return $item_model;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function set_item_view(){
		foreach( $this->items as $item_key => &$item ){
			if( strpos( $ID , '|' ) !== false ){
				$item_class = explode( '|' , $ID );
				$item_class = $item_class[0];
			}
		}
	}
	
	private function get_items(){
		if( strpos( $this->content , $this->items_key ) !== false ){
			preg_match( $this->item_regex , $this->content, $matches );
			if( $matches ){
				$items = str_replace ( array( $this->items_key , ' -->' ) , '' , $matches[0] );
				if( !$items ) $items = json_encode( $this->get_default_items() ); // Return default layout
			} else {
				$items = json_encode( $this->get_default_items() ); // Return default layout
			}
		} else { // No meta
			$items = json_encode( $this->get_default_items() ); // Return default layout
		} // End if
		return json_decode( $items );
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
			'pb_post_content|00000' => array('title' => 'Primary Content', 'is_content' => 1 ),
			);
	}
	
	public function get_default_layout(){
		$default = array(
			array( 'ID' => 'row-100' ),
			array(
				'ID' => 'row-1',
				'columns' => array(
					array( 'items' => array( 'pb_post_content|00000' ) ),// Column
					),
				),
			array( 'ID' => 'row-200' ),
			);
		return $default;
	}
};?>