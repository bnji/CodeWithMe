<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$projectId = $_GET['projectId'];
$results = DB::query("SELECT * FROM CWM_File WHERE ProjectId=%? AND UserId=%?", $projectId, $_GET['uid']);
$data = array();
foreach ($results as $row) {
	$shareId = $row['ShareId'];
	$shareUrl = "";
	if(!is_null($shareId)) {
		$shareUrl = DB::queryOneField("Url", "SELECT * FROM CWM_Share WHERE FileId=%?", $row['Id']);
	}
  	array_push($data, array('name' => $row['Name'], 'solutionName' => $row['SolutionName'], 'projectName' => $row['ProjectName'], 'shareUrl' => $shareUrl));
}
echo json_encode($data);
?>