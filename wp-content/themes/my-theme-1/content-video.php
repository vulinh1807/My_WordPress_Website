<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<div class="entry-header">
		<?php linhvu_entry_header(); ?>
	</div>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php (is_single() ? linhvu_entry_tag() : ''); ?>
	</div>
</article>