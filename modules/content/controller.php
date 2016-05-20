<?php
	_module('content');
	$cont_obj = new content();

    if(!isset($req) || (isset($req['slug']) && !empty($req['slug']) && $req['action'] != 'ajax' && $req['slug'] != 'do')) {
		$theme = 'front';
		$template = getTemplate();
	}
	
	if(isset($req['parent']) && in_array($req['parent'], array('preview'))) {
		$layout_path = _layout('no-header-footer');
	}

    if(isset($req['parent']) && in_array($req['parent'], array('case-study', 'research', 'news', 'event', 'studio', 'product'))) {
        $req['auth'] = false;
    }