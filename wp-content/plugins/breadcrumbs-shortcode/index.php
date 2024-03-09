<?php
/*
 * Plugin Name:		Breadcrumbs Shortcode
 * Description:		Show breadcrumbs for posts
 * Text Domain:		breadcrumbs-shortcode
 * Domain Path:		/languages
 * Version:		1.45
 * WordPress URI:	https://wordpress.org/plugins/breadcrumbs-shortcode/
 * Plugin URI:		https://puvox.software/software/wordpress-plugins/?plugin=breadcrumbs-shortcode
 * Contributors: 	puvoxsoftware,ttodua
 * Author:		Puvox.software
 * Author URI:		https://puvox.software/
 * Donate Link:		https://paypal.me/Puvox
 * License:		GPL-3.0
 * License URI:		https://www.gnu.org/licenses/gpl-3.0.html
 
 * @copyright:		Puvox.software
*/


namespace BreadcrumbsShortcode
{
  if (!defined('ABSPATH')) exit;
  require_once( __DIR__."/library.php" );
  require_once( __DIR__."/library_wp.php" );
  
  class PluginClass extends \Puvox\wp_plugin
  {

	public function declare_settings()
	{
		$this->initial_static_options	= 
		[
			'has_pro_version'        => 0, 
            'show_opts'              => true, 
            'show_rating_message'    => true, 
            'show_donation_footer'   => true, 
            'show_donation_popup'    => true, 
            'menu_pages'             => [
                'first' =>[
                    'title'           => 'Breadcrumbs Shortcode', 
                    'default_managed' => 'network',            // network | singlesite
                    'required_role'   => 'install_plugins',
                    'level'           => 'submenu', 
                    'page_title'      => 'Breadcrumbs Shortcode',
                    'tabs'            => [],
                ],
            ]
		];

		$this->initial_user_options		= 
		[ 
			//'&raquo;';
			'show_in_content_start'	=> false, 
			'bs_shortcode_default'	=> false,
		];

		$this->shortcodes	=[
			$this->shortcode_name1 =>[
				'description'=>__('Output the breadcrumbs in any place.', 'breadcrumbs-shortcode'),
				'atts'=>[ 
					[ 'is_category', 		false,		__('This is important parameter. For example, you placed the shortcode in post-template, and visitor opens <code>Category</code> (or <code>Archive</code>) listing - so, the shortcode doens\'t know itself, what it should show: <br/>A) breadcrumb for that (current) Category, &nbsp; &nbsp; &nbsp;  <br/> or <br/> B) for the looped post\'s breadcrumb. <br/>So, set to <code>true/false</code> depending you want for category or for looped post (but, if you use for looped-post, then ensure the shortcode is used inside loop:<code style="font-style:italic;">...while (have_posts()) : the_post()..... [shortcode] ... endwhile..</code>, otherwise it can\'t access looped-post\'s information)', 'breadcrumbs-shortcode') ], 
					[ 'post_types', 		'post,page',__('If you want to output that only for specific post types, then insert them comma-delimited, like:  <code>post,page,my-custom-post</code>', 'breadcrumbs-shortcode') ],
					[ 'on_homepage',		false,  	__('If you want shortcode to be outputed on homepage', 'breadcrumbs-shortcode') ],
					[ 'delimiter',			'&gt;', 	__('Your desired delimiter', 'breadcrumbs-shortcode') ],
					[ 'exclude',			'', 		__('List of category IDs (i.e. <code>32,84</code>) you want to be excluded from breadcrumbs.', 'breadcrumbs-shortcode') ],
					[ 'prefixed',			true, 		__('If you want to show appropriate phrases (adjustable from "phrases" tab) before breadcrumbs.', 'breadcrumbs-shortcode') ],
					[ 'clearfix',			true, 		__('Include <code>&lt;div style="clear:both;"&gt;&lt;/div&gt;</code> before&after the breadcrumbs element.', 'breadcrumbs-shortcode') ],
					[ 'id', 				'',			__('Post ID (Regular users can ignore this parameter. The shortcode automatically can obtain current POST-ID, but in rare cases (if you want to use shortcode programatically in dynamic code), then you can explicitly set this parameter to show breadcrumbs for specific POST-ID)', 'breadcrumbs-shortcode') ]
				]
			] 
		];
	}


	public $shortcode_name1='breadcrumbs';

	public function __construct_my()
	{
		add_filter('the_content',	[$this, 'the_content_filter']);
		$this->helpers->register_stylescript('wp', 'style', 'breadcrumbs_styles', 'assets/breadcrumbs.css');
	}

	// ============================================================================================================== //
	// ============================================================================================================== //


	public function breadcrumbs($atts, $content=false)
	{
		$args	= $this->helpers->shortcode_atts( $this->shortcode_name1, $this->shortcodes[$this->shortcode_name1]['atts'], $atts);
		return $this->breadcrumbs_wrapper($args);
	}

	// based on "wp_bac_breadcrumb_upd20180915" function
	public function breadcrumbs_wrapper($args=[]) 
	{
		$res = '';
		//Variable (symbol >> encoded) and can be styled separately.
		//Use >> for different level categories (parent >> child >> grandchild)
		$delimiter = '<span class="delimiter"> '. $args['delimiter'] .' </span>';
		//Use bullets for same level categories ( parent . parent )
		$delimiter1 = '<span class="delimiter1"> &bull; </span>';

		$excluded_cats = (!empty($args['exclude']) ? explode(",", $args['exclude']) : []);
		//Display only the first 30 characters of the post title.
		$maxLength= 30;
	 
		/*is_front_page(): If the front of the site is displayed, whether it is posts or a Page. This is true
		when the main blog page is being displayed and the 'Settings > Reading ->Front page displays'
		is set to "Your latest posts", or when 'Settings > Reading ->Front page displays' is set to
		"A static page" and the "Front Page" value is the current Page being displayed. In this case
		no need to add breadcrumb navigation. is_home() is a subset of is_front_page() */
		//Check if NOT the front page (whether your latest posts or a static page) is displayed. Then add breadcrumb trail.
		$trigger = ( $args['on_homepage']=="true" || !is_front_page() || !empty($args['id']) );
		if ( $trigger ) 
		{
			//If Breadcrump exists, wrap it up in a div container for styling.
			//You need to define the breadcrumb class in CSS file. 

			//global WordPress variable $post. Needed to display multi-page navigations.
			global $post, $cat;
			//A safe way of getting values for a named option from the options database table.
			$homeLink = get_option('home'); //same as: $homeLink = get_bloginfo('url');
			//If you don't like "You are here:", just remove it.
			//$res .= empty($args['home']) ? '' : '<a href="' . $homeLink . '">' . $args['home'] . '</a>' . $delimiter;    
	 
			$post	= (!empty($args['id']) ? get_post($args['id']) : ( is_singular() ? $GLOBALS['post'] : $GLOBALS['post'] ) );
			//if singular, or either in looped post (i.e. in archive page)
			if(is_singular() || !empty($post) )
			{
				$pID	= $post->ID;
				$pType	= $post->post_type;

				$pt_array = $this->helpers->string_to_array( $args['post_types'], ',' );

				//Display breadcrumb for single post
				if ( in_array($pType, $pt_array) ) 
				{
					//if page
					if ( $pType=='page' ) 
					{  
						// Check if this is a subpage (submenu) being displayed.
						if ( $post->post_parent ) 
						{
							//get the ancestor of the current page/post_id, with the numeric ID
							//of the current post as the argument.
							//get_post_ancestors() returns an indexed array containing the list of all the parent categories.
							$post_array = get_post_ancestors($post);

							//Sorts in descending order by key, since the array is from top category to bottom.
							krsort($post_array); 

							$res .= ($args['prefixed'] ? $this->phrase('Page:').' ' : '' );
							//Loop through every post id which we pass as an argument to the get_post() function.
							//$post_id contains a lot of info about the post, but we only need the title.
							foreach($post_array as $key=>$postid){
								$post_2 = get_post($postid);
								$res .= $delimiter . '<a href="' . get_permalink($post_2) . '">' . $post_2->post_title . '</a>' ;
							}
							//$res .= get_the_title(); //returns the title of the current page.
						}
					}
					else
					{
						//check if any single post is being displayed.
						//Returns an array of objects, one object for each category assigned to the post.
						//This code does not work well (wrong delimiters) if a single post is listed
						//at the same time in a top category AND in a sub-category. But this is highly unlikel
						$post_cat = get_the_category()[0];
						$res .= ($args['prefixed'] ? '<span clas="b_title">'. $this->phrase('Post Category:') .'</span> ' : '') . $this->get_cat_parents_helper($post_cat->term_id, $delimiter, $excluded_cats, false);
					}
				}
			}
			
			//Display breadcrumb for category and sub-category archive
			elseif (is_archive()) {
				$res .= ($args['prefixed'] ? '<span clas="b_title">'. $this->phrase('Category:') .'</span> ' : '') . $this->get_cat_parents_helper($cat, $delimiter, $excluded_cats, true );
			}
			//Display breadcrumb for tag archive
			elseif ( is_tag() ) { //Check if a Tag archive page is being displayed.
				//returns the current tag title for the current page.
				$res .= ($args['prefixed'] ? '<span clas="b_title">'. $this->phrase('Tagged with:') .'</span> ' : '') . single_tag_title("", false) . '"';
			}
			//Display breadcrumb for calendar (day, month, year) archive
			elseif ( is_day() ) 
			{
				$arc_year		= get_the_time('Y');
				$arc_month		= get_the_time('F');
				$url_year		= get_year_link($arc_year);
				$url_month		= get_month_link($arc_year,$arc_month);
				$arc_day		= get_the_time('d');
				$arc_day_full	= get_the_time('l');  

				$res .= 
					'<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . ' '.
					'<a href="' . $url_month . '">' . $arc_month . '</a> ' . $delimiter . $arc_day . ' (' . $arc_day_full . ')';
			}
			elseif ( is_month() ) 
			{
				$arc_year		= get_the_time('Y');
				$arc_month		= get_the_time('F');
				$url_year		= get_year_link($arc_year);
				$res .= '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . $arc_month;
			}
			elseif ( is_year() ) 
			{
				$arc_year		= get_the_time('Y');
				$res .= $arc_year;
			}
			//Display breadcrumb for search result page
			elseif ( is_search() ) {  //Check if search result page archive is being displayed.
				$res .= ($args['prefixed'] ? '<span clas="b_title">'. $this->phrase('Search:') .'</span> ' : '') . '<span class="authored">"' . get_search_query() . '"</span>';
			}
			//Display breadcrumb for author archive
			elseif ( is_author() ) {//Check if an Author archive page is being displayed.
				global $author;
				//returns the user's data, where it can be retrieved using member variables.
				$user_info = get_userdata($author);
				$res .= ($args['prefixed'] ? '<span clas="b_title">'. $this->phrase('Authored by:') .'</span> ' : '') . '<span class="authored">'. $user_info->display_name .'</span>';
			}
			//Display breadcrumb for 404 Error
			elseif ( is_404() ) {//checks if 404 error is being displayed
				//$res .=  'Error 404 - Not Found.';
			}
			else {
				//All other cases that I missed. No Breadcrumb trail.
			}

			// final output
			if(!empty($res))	{ 
				$res = '<div class="'. $this->helpers->prefix_ .'breadcrumbs">'. $res .'</div>'; 
			}
			if($args['clearfix']) { $res = '<div style="clear:both;"></div>'. $res .'<div style="clear:both;"></div>'; }
		}
		return apply_filters( 'breadcrumbs_wrapper', $res, $args );
	} 




	public function get_cat_parents_helper($cat_id, $delimiter, $excluded_cats, $exclude_current )
	{
		//$delimiter = '' . $delimiter . ''; 
		$parents	= get_ancestors( $cat_id, 'category' );     //  get_term_parents_list($cat, 'category', ['separator'=> $delmtr, 'inclusive'=>false ]); 
		$this_with_parents	=array_merge( [$cat_id] , $parents );
		if(empty($this_with_parents)) return '';
		//change order backwards
		$parents = array_reverse( $this_with_parents );
		//remove excluded category
		$parents = array_diff( $parents, $excluded_cats ); 
		//remove current category
		if($exclude_current) $parents = array_diff( $parents, [$cat_id] ); 
		$list='';   
		foreach ( $parents as $term_id ) {
			$parent = get_term( $term_id, 'category'  );
			$list .= '<a href="' . esc_url( get_term_link( $parent->term_id, 'category'  ) ) .'">'. $parent->name . '</a>'.$delimiter;
		}
		// remove last delimiter
		$list=substr($list, 0, -strlen($delimiter));
		return '<span class="cats_list">'. $list .'</span>';
	}









	// ====================================================  VISUAL  ==============================================//



	public function the_content_filter($content){ 
		if($this->opts['show_in_content_start'])
		{
 			$content = do_shortcode($this->opts['bs_shortcode_default']). $content;
		}
		return $content;
	}



	// =================================== Options page ================================ //
	public function opts_page_output()
	{ 
		$this->settings_page_part("start", 'first');
		?> 

		<style>
		p.submit { text-align:center; }
		.settingsTitle{display:none;}
		.myplugin {padding:10px;}
		zzz#mainsubmit-button{display:none;}
		</style>
		
		<?php if ($this->active_tab=="Options") 
		{
			//if form updated
			if( $this->checkSubmission() ) 
			{
				$this->opts['show_in_content_start']	= !empty($_POST[ $this->plugin_slug ]['show_in_content_start']);
				$this->opts['bs_shortcode_default']		= stripslashes( sanitize_text_field($_POST[ $this->plugin_slug ]['bs_shortcode_default']) );
				$this->update_opts(); 
			}
			?> 

			<form class="mainForm" method="post" action="">

			<table class="form-table">
				<tbody>
				<tr class="def">
					<th scope="row">
						<label for="bs_in_content">
							<?php _e('Show breadcrumbs in the top before post-content', 'breadcrumbs-shortcode');?>
						</label>
					</th>
					<td>
						<p class="description"><?php _e('We suggest that you might programatically added the shortcode in functions.php, to hook into template areas (like: <code>add_action("template_area_name", function(){ echo do_shortcode(\'[breadcrumbs ...]\');} )</code>). However, if you are not well-versed in programming or find it hard, then you can check this option, and the breacdrumbs will be automatically integrated in each post/page top area.', 'breadcrumbs-shortcode');?></p>
						<input id="bs_in_content" name="<?php echo $this->plugin_slug;?>[show_in_content_start]" type="checkbox" value="1" <?php checked($this->opts['show_in_content_start']); ?>  />
						<br/>
						<?php if ($this->opts['bs_shortcode_default']===false) 
							$this->opts['bs_shortcode_default']= $this->helpers->shortcode_example_string($this->shortcodes['breadcrumbs'], true) ;
						?>
						<div id="default_content_shortcode_params">
							<label for="bs_shortcode_default">
								<?php _e('Using that automatic mode, what should be the default shortcode command:', 'breadcrumbs-shortcode');?>: 
							</label>
							<input id="bs_shortcode_default" name="<?php echo $this->plugin_slug;?>[bs_shortcode_default]" class="large-text" type="text" value="<?php echo htmlentities($this->opts['bs_shortcode_default']); ?>"  placeholder="" />
							<script>PuvoxLibrary.checkbox_onchange_hider( "#bs_in_content", true, "#default_content_shortcode_params")</script>
						</div>
					</td>
				</tr>
				</tbody>
			</table>

			<?php $this->nonceSubmit(); ?>

			</form>

		<?php 
		} 
		
		
		$this->settings_page_part("end", '');
	} 



  } // End Of Class

  $GLOBALS[__NAMESPACE__] = new PluginClass();

} // End Of NameSpace

?>