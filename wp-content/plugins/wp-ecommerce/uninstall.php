<?php
//dinh nghia hanh dong khi plugin bi go cai dat
//register_uninstall_hook('__FILE__','');
if(!defined('WP_UNINSTALL_PLUGIN')){
  die;
}
//xoa csdl
include_once wp_ecom_PATH.'includes/db/migration_rollback.php';
//xoa option
delete_option('wp_settings_options');
