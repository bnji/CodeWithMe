<?php
	require_once '../../../../core/dirHandler.php';
	require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
	require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
	require_once $GLOBALS['dirCore'].'/config.inc.php';
	require_once $GLOBALS['dirCore'].'/common.inc.php';

	$url = $_POST['url'];
	$content = $_POST['content'];
	$theme = $_POST['theme'];
	$ID = DB::queryOneField('Id', "SELECT * FROM CWM_SourceDraft WHERE Url=%?", $url);
	if(!is_null($ID))
	{
		DB::update('CWM_SourceDraft', array('Content' => $content, 'Theme' => $theme), "Id=%?", $ID);
	}
?>