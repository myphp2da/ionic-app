<?php
	/* Database Detail */

	if(ENV == 1) { // Development
		
		define('DB_SERVER', 'localhost');
		define('DB_USERNAME', 'root');
		define('DB_PASSWORD','allin1server');
		define('DB_SCHEMA','myvegs');

        ini_set('error_reporting', E_ALL);
        error_reporting(E_ALL);
        ini_set('html_errors',true);
        ini_set('display_errors',true);
	}
	
	if(ENV == 2) { // Testing
		define('DB_SERVER','####');
		define('DB_USERNAME','####');
		define('DB_PASSWORD','####');
		define('DB_SCHEMA','####');
		
		ini_set('error_reporting', E_ALL);
		error_reporting(E_ALL);
		ini_set('log_errors',TRUE);
		ini_set('html_errors',FALSE);
		ini_set('error_log', SITE_PATH.'errors/error.log');
		ini_set('display_errors',FALSE);
	}

    if(ENV == 3) { // Demo Testing
        define('DB_SERVER','####');
        define('DB_USERNAME','####');
        define('DB_PASSWORD','####');
        define('DB_SCHEMA','####');

        ini_set('error_reporting', E_ALL);
        error_reporting(E_ALL);
        ini_set('log_errors',TRUE);
        ini_set('html_errors',FALSE);
        ini_set('error_log', SITE_PATH.'errors/error.log');
        ini_set('display_errors',FALSE);
    }
