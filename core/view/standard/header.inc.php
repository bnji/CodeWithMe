<?php
	#session_start();
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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
	<meta name="author" content="Benjamin Hammer">
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
    <link rel="shortcut icon" href="<?php echo $GLOBALS['urlRoot']; ?>/assets/ico/favicon.png">

	<title>CodeWithMe</title>

	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" />-->
	<link href="<?php echo $GLOBALS['urlLibs']; ?>/external/bootstrap/css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $GLOBALS['urlCore']; ?>/view/standard/css/main.css" rel="stylesheet" />
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $GLOBALS['urlLibs']; ?>/external/bootstrap/assets/js/html5shiv.js"></script>
      <script src="<?php echo $GLOBALS['urlLibs']; ?>/external/bootstrap/assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>