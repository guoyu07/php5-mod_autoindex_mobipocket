<?php
/**
 * template_filename.php
 * 
 * (c)2013 mrdragonraaar.com
 */
$ICON_TEXT = '/global/icons/fugue-icons/icons/book-open.png';
$ICON_META = '/global/icons/fugue-icons/icons/book-open-bookmark.png';
?>
<!-- Title -->
<h1 class="mobipocket_title"><?php echo $mobipocket->title(); ?></h1>
<!-- END Title -->
<!-- Author(s) -->
<h2 class="mobipocket_author">by <span itemprop="author"><?php echo implode('</span>, <span itemprop="author">', $mobipocket->authors()); ?></span></h2>
<!-- END Author(s) -->
<a class="mobipocket_filename" title="<?php echo $this->filename(); ?>" href="<?php echo $this->filename_url(); ?>"><?php echo $this->filename(); ?></a>
<a title="Text" href="<?php echo $this->filename_url(); ?>?D=T"><img class="mobipocket_icon_text" src="<?php echo $ICON_TEXT; ?>"></a>
<a title="Metadata" href="<?php echo $this->filename_url(); ?>?D=M"><img class="mobipocket_icon_metadata" src="<?php echo $ICON_META; ?>"></a>
