<?php namespace cahnrswp\pagebuilder2;?>
<div class="pagebuilder-item">
	<input type="text" name="<?php echo $column_name;?>[items][]" value="<?php echo $item;?>">
    <?php var_dump( $item );?>
    <?php var_dump( $this->layout_model->items->$item );?>
</div>