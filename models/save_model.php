<?php namespace cahnrswp\pagebuilder2;

class save_model extends layout_model {
	public $save_layout_model;
	public $save_layout_encoded;
	public $default_layout;
	public $default_encoded;
	
	
	public function __construct( $post ){
		parent::__construct( $post );
		$this->default_layout = $this->get_default_layout();
		$this->save_layout_model = $this->sanitize_pagebuilder();
		$this->default_encoded = $this->get_default_layout();
		$this->save_layout_encoded = $this->get_layout_encoded();
	}
	
	private function get_layout_encoded(){
		if( $this->is_default_layout() ){
			return '';
		} else {
			return $this->layout_key. json_encode( $this->save_layout_model ) .' -->';
		}
	}
	
	private function is_default_layout(){
		/*****************************************
		* Run throught a series of checks to see if the save layout *
		* is functionally equivalent to the default layout *
		* if so, there is no need to save it *
		*****************************************/
		/** Check for same number of rows **/
		if( count( $this->save_layout_model ) != count( $this->default_layout ) ) return false;
		/** Loop through rows **/
		foreach( $this->save_layout_model as $row_id => $row_data ){
			/** Check that row id's are the same **/
			if( !array_key_exists( $row_id , $this->default_layout ) ) return false;
			/** Chech columns count **/
			if( count( $row_data ) != count( $this->default_layout[$row_id] ) ) return false;
			/** Loop through row columns **/
			foreach( $row_data as $column_key => $column_data ){
				/** Check if same number of items **/
				if( !isset( $column_data['items'] ) && 0 != count( $this->default_layout[$row_id][$column_key]['items'] ) ) return false;
				/** Check if items are set before trying to loop **/
				if( isset($column_data['items'] ) ) {
					/** Loop through all items **/
					foreach( $column_data['items'] as $item_key => $item_data ){
						/** Check if Item Key exists **/
						if( !isset( $this->default_layout[$row_id][$column_key]['items'][ $item_key ] ) ) return false;
						/** Check if Item Values are the same **/
						if( $item_data != $this->default_layout[$row_id][$column_key]['items'][ $item_key ] ) return false;
					}
				}
			}
		}
		return true;
	}
	
	private function is_default_items(){
		/*****************************************
		* Run throught a series of checks to see if the save layout *
		* is functionally equivalent to the default layout *
		* if so, there is no need to save it *
		*****************************************/
		/** Check for same number of rows **/
		if( count( $this->save_layout_model ) != count( $this->default_layout ) ) return false;
		/** Loop through rows **/
		foreach( $this->save_layout_model as $row_id => $row_data ){
			/** Check that row id's are the same **/
			if( !array_key_exists( $row_id , $this->default_layout ) ) return false;
			/** Loop through row settings **/
			foreach( $row_data['settings'] as $row_set_id => $row_set_data ){
				/** Check that settings exist **/
				if( !array_key_exists( $row_set_id , $this->default_layout[$row_id]['settings'] ) ) return false;
				/** Check that settings are the same **/
				if( $row_set_data != $this->default_layout[$row_id]['settings'][ $row_set_id ] ) return false; 
			} //
			/** assign to variable since I'm using it a lot **/
			$row_default_columns = $this->default_layout[$row_id]['columns'];
			/** Chech columns count **/
			if( count( $row_data['columns'] ) != count( $row_default_columns ) ) return false;
			/** Loop through row columns **/
			foreach( $row_data['columns'] as $column_key => $column_data ){
				/** Check if same number of items **/
				if( !isset( $column_data['items'] ) && 0 != count( $row_default_columns[$column_key]['items'] ) ) return false;
				/** Check if items are set before trying to loop **/
				if( isset($column_data['items'] ) ) {
					/** Loop through all items **/
					foreach( $column_data['items'] as $item_key => $item_data ){
						/** Check if Item Key exists **/
						if( !isset( $row_default_columns[$column_key]['items'][ $item_key ] ) ) return false;
						/** Check if Item Values are the same **/
						if( $item_data != $row_default_columns[$column_key]['items'][ $item_key ] ) return false;
					}
				}
			}
		}
		return true;
	}
	
	private function sanitize_pagebuilder(){
		return $_POST['_pagebuilder2'];
	}
	
};?>