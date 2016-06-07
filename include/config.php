<?php
	/* Different Environment */
	define('ENV', 1);		// 1 = Developement, 2 = Production, 3 = Demo Testing
	
	/* Paging Variables */
	define('PER_PAGE', 50);
	
	/* Date Variables */
	define('TODAY_DATE', date('Y-m-d'));
	define('TODAY_DATETIME', date('Y-m-d H:i:s'));
	define('TIME', time());
	
	/* General Variables */
	define('PASSWORD_HASH', '2016mvf05inheritlab13');
	define('USERIP', $_SERVER['REMOTE_ADDR']);
	
	// Default theme for the website
	$theme = 'default';
	$layout = 'default';
	
	// Default module to load
	$module = 'page';

    /** Key for webservices */
    define('KEY', 'ca966ceb77c7ef7');
	
	/** Prefix for session variables */
	define('PF', 'MVF_');