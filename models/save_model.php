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
		foreach( $this->save_layout_model as $row_key => $row_data ){
			/** Compare row IDs **/
			if( $row_data['ID'] != $this->default_layout[ $row_key ]['ID'] ) return false;
			/** Check for empty columns **/
			if( !isset( $row_data['columns'] ) && isset( $this->default_layout[ $row_key ]['columns'] ) ) return false;
			/** If columns exist **/
			if( isset( $row_data['columns'] ) ){
				/** Check reverse empty columns **/
				if( !isset( $this->default_layout[ $row_key ]['columns'] ) ) return false;
				/** Check number of items in column **/
				if( count( $row_data['columns'] ) != count( $this->default_layout[ $row_key ]['columns'] )) return false;
				/** Loop through items **/
				foreach( $row_data['columns'] as $item_key => $item ){
					/** Compare items **/
					if( $item != $this->default_layout[ $row_key ]['columns'][$item_key] ) return false;
				} // End foreach - items
			} // End if - columns exist
		} // end foreach - rows
		return true;
	}
	
	private function sanitize_pagebuilder(){
		return $_POST['_pagebuilder2'];
	}
	
};?>