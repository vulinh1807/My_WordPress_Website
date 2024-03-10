<?php
/*
 * Plugin Name:       My-WP-Ecommerce
 * Plugin URI:        #
 * Description:       My plugin for ecommerce.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Vu Linh
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        #
 * Text Domain:       mywp-ecommerce
 * Domain Path:       /languages
 */
 //Dinh nghia cac hang so cua plugin
 define('mywp_ecom_PATH',plugin_dir_path(__FILE__));
 define('mywp_ecom_URI',plugin_dir_url(__FILE__));
 
 //tai file ngôn ngữ
 add_action('init','mywp_load_textdomain');
function mywp_load_textdomain()
{
  load_plugin_textdomain('mywp-ecommerce',false,mywp_ecom_PATH.'/languages');
}
function mywp_load_textdomain_mofile($mofile,$domain)
{
  if('mywp-ecommerce'===$domain && false !== strpos($mofile,WP_LANG_DIR.'/plugins/'))
  {
    $locale = apply_filters('plugin_locale',determine_locale(),$domain);
    $mofile = mywp_ecom_PATH . '/languages/' . $domain . '-' . $locale . '.mo';
  }
  return $mofile;
}
add_filter('load_textdomain_mofile','mywp_load_textdomain_mofile',10,2);
//dinh nghia hang dong khi plugin kich hoat
register_activation_hook(__FILE__,'mywp_ecommerce_activation');
function mywp_ecommerce_activation(){
  //tao CSDL
  include_once mywp_ecom_PATH.'includes/db/migration.php';
  //tao du lieu mau
  include_once mywp_ecom_PATH.'includes/db/seeder.php';
  //tao option
  update_option('mywp_settings_options',[]) ;
}

//dinh nghia hanh dong khi plugin tat di
register_deactivation_hook(__FILE__,'mywp_ecommerce_deactivation');
function mywp_ecommerce_deactivation() {
  //xoa csdl
  //include_once wp_ecom_PATH.'includes/db/migration_rollback.php';
  //xoa option
  //delete_option('wp_settings_options');
}
include_once mywp_ecom_PATH.'includes/includes.php';