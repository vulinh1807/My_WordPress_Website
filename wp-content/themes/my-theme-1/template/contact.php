<?php
	/* Template name: Contact*/ 
?>
<?php
get_header(); ?>
<div class="content">
	<div id="main-content">
		<div class="contact-info">
			<h4>Dia chi lien he</h4>
			<p>ABCXYZ</p>
			<p>123789</p>
		</div>
		<div class="contact-form">
			<?php echo do_shortcode('[contact-form-7 id="1395" title="Contact form 1"]'); ?>
		</div>
	</div>
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?> 
?>