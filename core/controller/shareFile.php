<?php
	require_once '../dirHandler.php';
	require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
	require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
	require_once $GLOBALS['dirCore'].'/config.inc.php';
	require_once $GLOBALS['dirCore'].'/common.inc.php';

	$randomHashUrl = mt_rand_str(11, '0123456789abcdefghijklmnoprstuvwqxyzABCDEFGHIJKLMNOPRSTUVWQXYZ');
	$solutionName = $_GET['solutionName'];
	$projectName = $_GET['projectName'];
	$fileName = $_GET['fileName'];
	$fileId = DB::queryFirstRow("SELECT Id FROM CWM_File WHERE SolutionName=%? AND ProjectName=%? AND Name=%?", $solutionName, $projectName, $fileName);
	$fileId = $fileId['Id'];
	$share = DB::queryFirstRow("SELECT Url FROM CWM_Share WHERE FileId=%?", $fileId);
	if(is_null($share) == 1)
	{
		DB::insert('CWM_Share', array(
			'Id' => 0, // auto increment
			'Url' => $randomHashUrl,
			'UserId' => $_GET['uid'],
			'FileId' => $fileId
		));
		$shareId = DB::insertId();
		DB::update('CWM_File', array('ShareId' => $shareId), "Id=%?", $fileId);
		echo $randomHashUrl;
	}
	else {
		echo $share['Url'];
	}
?>