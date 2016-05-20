<?php
_module('product');
$product_obj = new product();

if (!isset($req) || (isset($req['slug']) && !empty($req['slug']) && $req['action'] != 'ajax' && $req['slug'] != 'do')) {
	$theme = 'front';
	$template = getTemplate();
}

if (isset($req['parent']) && in_array($req['parent'], array('preview'))) {
	$theme = 'default';
	$template = getTemplate();
	$layout_path = _layout('no-header-footer');
}