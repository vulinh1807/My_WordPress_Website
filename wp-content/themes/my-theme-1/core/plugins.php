<?php
function linhvu_plugin_activation() {
	//khai bao plugin can cai dat
	$plugins = array(
		array(
			'name' => 'Redux Framework',
			'slug' => 'redux-framework',
			'required' => true
		)
	);
	//thiet lap TGM
	$configs = array(
		'menu' => 'lv_plugin_install',
		'has_notice' => true,
		'dismissable' => false,
		'is_automatic'=> true
	);
	tgmpa($plugins, $configs);
}
add_action('tgmpa_register','linhvu_plugin_activation');
?>