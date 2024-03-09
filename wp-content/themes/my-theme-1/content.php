<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<div class="entry-thumbnail">
		<?php linhvu_thumbnail('thumbnail'); ?>
	</div>
	<div class="entry-header">
		<?php linhvu_entry_header(); ?>
		<?php linhvu_entry_meta(); ?>
	</div>
	<div class="entry-content">
		<?php linhvu_entry_content(); ?>
		<?php (is_single() ? linhvu_entry_tag() : ''); ?>
	</div>
</article>