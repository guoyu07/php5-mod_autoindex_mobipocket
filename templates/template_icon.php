<?php
/**
 * template_icon.php
 * 
 * (c)2013 mrdragonraaar.com
 */
?>
<img class="mobipocket_cover" itemprop="image" title="<?php echo $mobipocket->title(); ?>" src="data:image/jpg;base64,<?php echo base64_encode($mobipocket->cover()); ?>" />
