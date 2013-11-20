<?php
	require_once '../../../../core/dirHandler.php';
	require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
	require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
	require_once $GLOBALS['dirCore'].'/config.inc.php';
	require_once $GLOBALS['dirCore'].'/common.inc.php';

	require_once $GLOBALS['dirLibs'].'/internal/ide/compileLib.inc.php';

	$compileLib = new CompileLib();

	$randomHashUrl = mt_rand_str(11, '0123456789abcdefghijklmnoprstuvwqxyzABCDEFGHIJKLMNOPRSTUVWQXYZ');
	$language = $_POST['language'];
	$content = $_POST['content'];
	$theme = $_POST['theme'];

	$templateData = $compileLib->ExtractProject($language, $randomHashUrl);

	if(strlen($content) == 0) {
		$content = $templateData;
	}

	/*if(strlen($content) == 0) {
		$content = $compileLib->GetFile($language);
	}*/

	DB::insert('CWM_SourceDraft', array(
		'Id' => 0, // auto increment
		'Content' => $content,
		'Language' => $language,
		'Url' => $randomHashUrl,
		'Theme' => $theme
	));
	echo $randomHashUrl;
?>