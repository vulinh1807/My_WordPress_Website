<?php get_header(); ?>
<div class="content">
	<div id="main-content">
		<?php 
		_e('<h2>404 not found</h2>','linhvu');
		_e('<p>The article, what you has searched for, is not found, but you might try to search again','linhvu');
		get_search_form();
		_e('<h3>Content categories: </h3>','linhvu');
		echo '<div class="404-cat-list">';
			wp_list_categories(array('title_li'=>''));
		echo '</div>';
		_e('Tag cloud','linhvu');
		?>	
	</div>
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>