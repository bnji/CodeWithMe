<?php
	require_once '../../../../core/dirHandler.php';
	require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
	require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
	require_once $GLOBALS['dirCore'].'/config.inc.php';
	require_once $GLOBALS['dirCore'].'/common.inc.php';

	$language = $_POST['language'];
	rrmdir($GLOBALS['dirLibs'].'/internal/ide/code_output/'.$language.'/'.$url);

	echo DB::delete('CWM_SourceDraft', "Url=%?", $url);
?>