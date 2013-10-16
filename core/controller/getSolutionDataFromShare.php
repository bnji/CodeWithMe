<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
$fileShare = DB::queryFirstRow("SELECT FileId FROM CWM_Share WHERE Url=%?", $_GET['url']);
$fileData = DB::queryFirstRow("SELECT * FROM CWM_File WHERE Id=%?", $fileShare['FileId']);
echo json_encode(array('solutionName' => $fileData['SolutionName'], 'projectName' => $fileData['ProjectName'], 'fileName' => $fileData['Name']));
?>