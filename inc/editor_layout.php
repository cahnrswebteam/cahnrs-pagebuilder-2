<?php namespace cahnrswp\pagebuilder2;?>
<div id="<?php echo $row_id;?>" class="pagebuilder-row">
	<header>
    	<a class="pg-edit-row-settings" href="#" title="Edit Row Name">
			<?php echo $row_id;?>
        <a class="pg-edit-row-remove" href="#" title="Remove Row">x</a>
	</header>
    <?php for( $c = 1; $c <= 4; $c++ ):?>
    	<?php $column_count = ( isset( $row_layout ) )? count( $row_layout ) : 1;?> 
    	<?php $status = ( $c <= $column_count )? '' : 'disabled';?>
        <?php $current_column = '_pagebuilder2['.$row_id.']['.( $c - 1 ).']';?>
        <?php $column = '_pagebuilder2['.$row_id.']['.( $c - 1 ).']';?>
        <div class="pagebuilder-column column-<?php echo $c;?> <?php echo $status;?>">
    	<header class="pb-form-parent">
            <div class="pg-settings-form">
                <div class="pb-settings-form-inner">
                  <input  <?php if( $status ) echo 'disabled="disabled"';?> style=" " type="text" name="<?php echo $current_column;?>[ID]" value="<?php echo $c;?>">
                </div>
            </div>
        </header>
        <?php if( isset( $row_data[( $c - 1 )]->items ) && $row_data[( $c - 1 )]->items  ) {
			foreach( $row_data[( $c - 1 )]->items as $item_key => $item ){
				include DIR.'inc/editor_layout_item.php';
			}
		};?>
    </div>
    <?php endfor;?>
</div>