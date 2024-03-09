<?php 
/**
 * @khai bao hang gia tri
 * @THEME_URL= lay duong dan thu muc theme
 * @CORE = lay duong dam cua thu muc /core
 **/
 define('THEME_URL', get_stylesheet_directory());
 define('CORE',THEME_URL,"/core");

 /**
  * @Nhung file /core/init.php
  **/
  require_one( CORE . "/init.php");

  /*TGM plugin activation */
  require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

  /** Thiet lap chieu rong noi dung
   **/
  if (!isset($content_width)) {
   	// code...
   	$content_width = 620;
   }
   /**
    * @khai bao chuc nang cua theme
    **/
   if (!function_exists('thachpham_theme_setup')) {
    	// code...
   	function thachpham_theme_exist(){
   		/**Thiet lap textdomain**/
   		$language_folder=THEME_URL . '/language';
   		load_theme_textdomain(linh95,$language_folder);
   		
   		/*tu dong them link RSS len <head>*/
   		add_theme_support('automatic-feed-links');

   		/*them thumbnail cho post*/
   		add_theme_support('post-thumbnails');

   		/* post format */
   		add_theme_support('post-format',array(
   			'image','video','gallery','quote','link'));

   		/* them title-tag */
   		add_theme_support('title-tag');

        /* Theme custom background*/
        $default_background = array(
            'default-color'=> '#e8e8e8');
        add_theme_support('custom-background',);

        /*theme menu*/
        register_nav_menu('primary-menu','Primary Menu');

        /*Tao sidebar*/
        $sidebar = array(
            'name'=> __('Main Sidebar','linh');
            'id'=>'main-sidebar',
            'description'=>__('Defaut sidebar'),
            'class'=>'main-sidebar',
            'before_title'=>'<h3 class="widgettitle">',
            'after_title'=>'</h3>');
        register_sidebar( $sidebar );
   	}
   	add_action('init','thachpham_theme_setup');
    }

    /*TEMPLATE FUNCTION*/
    /** Thiet lap ham hien thi logo **/
    if(!function_exists('linhvu_logo')){
        function linhvu_logo() { ?>
            <div class="logo">
                <div class="site-name">
                        <?php
                            if(is_home()){
                            printf(
                                '<h1><a href="%1$s" title="%2$s">%3$s</a></h1>',
                                get_bloginfo('url'),
                                get_bloginfo('description'),
                                get_bloginfo('sitename'));  
                            } else {
                            printf(
                                '<p><a href="%1$s" title="%2$s">%3$s</a></p>',
                                get_bloginfo('url'),
                                get_bloginfo('description'),
                                get_bloginfo('sitename'));
                            } //endif
                        ?>
                    </div>
                    <div class="site-description"><?php bloginfo('description'); ?></div>
                    <img src="<?php echo $lv_options['logo-image']['url']; ?>"/>
                <?php endif; ?>
                </div>
                
            </div>
            <?php
        }
    }
    /**
     * Thiet lap menu
     **/
    if(!function_exists('linhvu_menu') ){
        function linhvu_menu($slug){
            $menu = array(
                'theme_location'=>$slug,
                'container'=>'nav',
                'container_class'=> $slug
                // 'item_wrap'=>'<ul id="%1$s" class="%2$s sf-menu">%3$s</ul>'
            );
            wp_nav_menu($menu);

        }
    }

    /**
     * Ham tao phan trang don gian*/
    if(!function_exists('linhvu_pagination')){
        function linhvu_pagination() {
            if($$GLOBALS['wp_query']=>max_num_page < 2){
                return '';
            } ?>
            <nav class="pagination" role="navigation">
                <?php if(get_next_post_link() ) : ?>
                    <div class="prev"><?php next_posts_link( __('Older Posts','linhvu') ); ?></div>
                <?php endif; ?>
                <?php if (get_previous_posts_link() ) : ?>
                    <div class="next"><?php get_previuos_posts_link( __('Newest Posts','linhvu') ); ?></div>
                <?php endif; ?>     
            </nav>
        <?php }
    }

/** ham hien thi thmubnail**/
if(function_exists('linhvu_thumbnail')){
    function linhvu_thumbnail($size) {
        if( !is_single() && has_post_thumbnail() && !post_password_required() || has_post_format('image')):?>
            <figure class="post-thumbnail"><?php the_post_thumbnail($size); ?>
            </figure>
        <?php endif; ?>
    <?php }
}

/** linhvu_entry_header = hien thi tieu de post **/
if(function_exists('linhvu_entry_header'))
{
    function linhvu_entry_header() { ?>
        <?php if(is_single() ) : ?>
            <h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
        <?php else : ?>
            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
        <?php endif; ?>    
    <?php }
}

/** linhvu_entry_meta = lay du lieu post **/
if(!function_exists('linhvu_entry_meta'))
{
    function linhvu_entry_meta(){?>
        <?php if(!is_page() ) : ?>
            <div class="entry-meta">
                <?php
                printf(__('<span class="author">Posted by %1$s','linhvu'),get_the_author() );
                printf(__('<span class="date-published">at %1$s','linhvu'), get_the_date() );
                printf(__('<span class="category">in %1$s ','linhvu'), get_the_category_list(',') );
                if( comment_open() ) : 
                echo "<span class="meta-reply">";
                comment_popup_link(
                    __('Leave a comment','linhvu'),
                    __('One comment','linhvu'),
                    __('% comments','linhvu'),
                    __('Read all comments', 'linhvu'),
                );
                echo "</span>";
                endif; 
                ?>
            </div>
            <?php endif; ?>    
    <?php }
}

/** linhvu_entry_content= ham hien thi noi dung cua post/page */
if(!function_exist('linhvu_entry_content') )
{
    function linhvu_entry_content()
    {
        if(!is_single() && !is_page())
        {
            the_exerpt();
        } else {
            the_content();
            /* phan trang trong single */
            $link_pages = array(
                'before' => __('<p>Page:', 'linhvu'),
                'after' => '</p>',
                'nextpagelink' => __('Next Page','linhvu'),
                'previous' => __('Previous page','linhvu')
            );
            wp_link_pages($link_pages);
        }
    }
}
function linhvu_readmore(){
    return '<a class="read-more" href="'.get_permalink(get_the_ID() ) .'">' ._('...[Read More]','linhvu').'</a>';
}
add_filter('excerpt')

/** linhvu_entry_tag= hien thi tag **/
if(!function_exists('linhvu_entry_tag'))
{
    function linhvu_entry_tag()
    {
        if(has_tag()):
            echo '<div class="entry-tag">';
            printf(__('Tagged in %1$s','linhvu'),get_the_tag_list('',','));
            echo '</div>';
        endif;
    }
}

/* Nhung file style.css */
function linhvu_style(){
    wp_register_style('main-style',get_template_directory_url(),"/style.css",'all');
    wp_enqueue_style('main-style');
    wp_register_style('reset-style',get_template_directory_url(),"/reset.css",'all');
    wp_enqueue_style('reset-style');

    //Superfish menu
    wp_register_style('superfish-style',get_template_directory_url(),"/superfish.css",'all');
    wp_enqueue_style('superfish-style');
    wp_register_script('superfish-script',get_template_directory_url(),"/superfish.js",array('jquery'));
    wp_enqueue_script('superfish-script');

    //custom script
    wp_register_script('custom-script',get_template_directory_url(),"/custom.js",array('jquery'));
    wp_enqueue_script('custom-script');
}
add_action('wp_enqueue_scripts','linhvu_style');