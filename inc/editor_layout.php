<?php namespace cahnrswp\pagebuilder2;?>
<div id="<?php echo $row_data->ID;?>" class="pagebuilder-row <?php echo $row_data->settings->layout;?>">
	<header>
    	<a class="pg-edit-row-settings" href="#" title="Edit Row Name">
			<?php echo $row_data->settings->title;?>
        <a class="pg-edit-row-remove" href="#" title="Remove Row">x</a>
        <input type="text" name="_pagebuilder2[<?php echo $row_key;?>][ID]" value="<?php echo $row_data->ID;?>" />
	</header>
    <?php for( $c = 1; $c <= 4; $c++ ):?>
    	<?php $column_name = '_pagebuilder2['.$row_key.'][columns]['.( $c - 1 ).']';?>
        <div class="pagebuilder-column column-<?php echo $c;?>">
        	+ Add Item
        	<?php if( isset( $row_data->columns[ ( $c - 1 ) ]->items ) ) {
				foreach( $row_data->columns[ ( $c - 1 ) ]->items as $item ){
					include DIR.'inc/editor_layout_item.php';
				}
			};?>
        </div>
   	<?php endfor;?>
</div>