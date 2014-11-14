<?php namespace cahnrswp\pagebuilder2;
if( 'two-column-aside-right' == $row_data->settings->layout && !isset( $row_data->columns[1] ) ) 
	$row_data->settings->layout = 'two-column-aside-right-empty';
?>
<div id="<?php echo $row_data->ID;?>" class="pagebuilder-row <?php echo $row_data->settings->layout;?>">
    <?php for( $c = 1; $c <= $row_data->column_count; $c++ ):?> 
        <div class="pagebuilder-column column-<?php echo $c;?>">
        	<?php if( isset( $row_data->columns[( $c - 1 )]->items ) ){
            	foreach( $row_data->columns[( $c - 1 )]->items as $item_key => $item_value ){
					/*if( isset( $this->layout_model->items->$item_value ) ){
						$item_class = explode( '|' , $item_value );
						$item_class = $item_class[0];
						$settings = ( isset( $this->layout_model->items->$item_value->settings ) )? 
							$this->layout_model->items->$item_value->settings : array();
							var_dump( $item_class );
							\the_widget( $item_class, $settings, array() );
					}*/
				};
			};?>
        </div>
   	<?php endfor;?>
</div>