<?php
	if(empty($template)) {
        echo $template = SITE_PATH.'modules/account/theme/'.$theme.'/login.php';
    }

	_module('default');
	$dftObj = new defaultclass();