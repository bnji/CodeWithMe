<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$solutionId = DB::queryFirstRow("SELECT SolutionId FROM CWM_Share WHERE Url=%?", $_GET['url']);
$solutionData = DB::queryFirstRow("SELECT * FROM CWM_Solution WHERE Id=%?", $solutionId['SolutionId']);
echo json_encode(array('solutionName' => $solutionData['SolutionName'], 'projectName' => $solutionData['ProjectName'], 'fileName' => $solutionData['FileName']));
?>