<?php
session_start();
require_once './core/dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
require_once $GLOBALS['dirCore'].'/auth.inc.php';
$f3=require($GLOBALS['dirLibs'].'/external/fatfree/lib/base.php');
//setcookie("uid", "OK", time()+3600, "/");
//var_dump($_COOKIE);
$f3->route('GET /',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/login.php';
    }
);
$f3->route('GET /manage',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/manage.php';
    }
);
$f3->route('GET /shares',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/myFileShares.php';
    }
);
$f3->route('GET /share/file/@id',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/viewSolutionFile.php';
    }
);
$f3->route('GET /settings',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/settings.php';
    }
);
$f3->route('GET /logout',
    function($f3) {
    	header("Location: core/controller/logout.php");
    }
);

// API
$f3->route('GET /api/generate',
    function($f3) {
    	require_once $GLOBALS['dirRoot'].'/api/generate.php';
    }
);
$f3->sync('SESSION');
$f3->sync('COOKIE');
$f3->run();
?>