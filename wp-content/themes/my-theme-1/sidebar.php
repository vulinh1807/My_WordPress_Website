<?php
if (is_active_sidebar('main-sidebar')) {
	// code...
	dynamic_sidebar('main-sidebar');
} else {
	_e('This is sidebar, you have to add some widget','linhvu');
}
?>
<!-- can cai dat widget Monster tren sidebar -->