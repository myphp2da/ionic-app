<?php
	_module('page');
	$page_obj = new page();

    if(isset($req['parent']) && in_array($req['parent'], array('gca-club-house','association'))) {
        $req['auth'] = false;
    }
	
	if(!isset($req) || (isset($req['slug']) && !empty($req['slug']) && $req['action'] != 'ajax' && $req['slug'] != 'do')) {
		$theme = 'front';
		$template = getTemplate();
		
		if(!isset($req)) {
			$layout_path = _layout('home');
		}
	}
	
	if(isset($req['parent']) && in_array($req['parent'], array('preview'))) {
			$theme = 'default';
			$template = getTemplate();
		$layout_path = _layout('no-header-footer');
	} elseif(isset($req['parent']) && in_array($req['parent'], array('gca-club-house','association','about-gca'))) {
		$theme = 'front';
		$template = getTemplate();
	}

	
	if(isset($req['slug']) && $req['slug'] != 'do') {
		$where = "p.strSlug='".$req['slug']."'";
		$page = $page_obj->getPage($where); //echo $module_theme_path.$page['template']; exit;//pr($page);
		
		if(!empty($page['strTemplate']) && isset($page['strTemplate']) && file_exists($module_theme_path.$page['strTemplate'])) {
			$template = $module_theme_path.'/'.$page['strTemplate'];
		}
	}

    if(isset($req['action']) && in_array($req['slug'], array('case-studies', 'researches', 'news', 'events', 'studios', 'products'))) {
        $req['auth'] = false;
        $template = _template('content', 'list');
    }