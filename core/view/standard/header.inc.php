<?php
	// Turn off all error reporting
	#error_reporting(0);
	// Report simple running errors
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	require_once $GLOBALS['dirCore'].'/config.inc.php';
	require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
	require_once $GLOBALS['dirCore'].'/common.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CodeWithMe</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Benjamin Hammer">
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />

	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

	<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" />-->
	<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/bootstrap/js/bootstrap.min.js"></script>
	<link href="<?php echo $GLOBALS['urlLibs']; ?>/external/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

	<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/bootstrap/js/plugins/button.js"></script>

	<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/jQuery-Storage/jquery.storageapi.min.js"></script>
	<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/CryptoJS/sha1.js"></script>
	<!--<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha1.js"></script>-->

	<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/json/json2.js"></script>

	<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/simplemvc/simple.mvc.js"></script>

	<script src="<?php echo $GLOBALS['urlLibs']; ?>/internal/cwmProjectHandler.js"></script>
	<script src="<?php echo $GLOBALS['urlLibs']; ?>/internal/common.js"></script>

	<link href="<?php echo $GLOBALS['urlCore']; ?>/view/standard/css/main.css" rel="stylesheet" />

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="../../libs/html5shiv/html5shiv.js"></script>
	  <![endif]-->
</head>
<body>