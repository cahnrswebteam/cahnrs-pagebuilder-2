<?php namespace cahnrswp\pagebuilder2;?>
<div class="pagebuilder-item">
	<input <?php if( $status ) echo 'disabled="disabled"';?> type="text" name="<?php echo $current_column;?>[items][]" value="<?php echo $item;?>">
</div>