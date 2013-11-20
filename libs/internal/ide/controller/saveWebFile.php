<?php
	require_once '../../../../core/dirHandler.php';
	require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
	require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
	require_once $GLOBALS['dirCore'].'/config.inc.php';
	require_once $GLOBALS['dirCore'].'/common.inc.php';

	$file = '../web_render/'.$_POST['file'];
	$content = $_POST['content'];
	#$file = $GLOBALS['dirRoot'].'/assets/web_render/'.$_POST['file'];
	echo file_put_contents($file, $content);
?>