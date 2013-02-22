<?php
/**
 * template_filename.php
 * 
 * (c)2013 mrdragonraaar.com
 */
$ICON_TEXT = '/global/icons/fugue-icons/icons/book-open.png';
$ICON_META = '/global/icons/fugue-icons/icons/information-frame.png';
?>
<!-- Title -->
<h2 class="mobipocket_title"><?php echo $mobipocket->title(); ?></h2>
<!-- END Title -->
<!-- Author(s) -->
<h3 class="mobipocket_author">by <span itemprop="author"><?php echo implode('</span>, <span itemprop="author">', $mobipocket->authors()); ?></span></h3>
<!-- END Author(s) -->
<a class="mobipocket_filename" title="<?php echo $this->filename(); ?>" href="<?php echo $this->filename_url(); ?>"><?php echo $this->filename(); ?></a>
<a title="Read" href="<?php echo $this->filename_url(); ?>?D=T"><img class="mobipocket_icon_text" src="<?php echo $ICON_TEXT; ?>"></a>
<a title="Book Info" href="<?php echo $this->filename_url(); ?>?D=M"><img class="mobipocket_icon_metadata" src="<?php echo $ICON_META; ?>"></a>
