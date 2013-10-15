<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$solutionId = $_GET['solutionId'];
$results = DB::query("SELECT * FROM CWM_Project JOIN CWM_SolutionProject WHERE CWM_Project.SolutionId = CWM_SolutionProject.SolutionId AND CWM_Project.SolutionId=%?", $solutionId);
$data = array();
foreach ($results as $row) {
	array_push($data, array('id' => $row['ProjectId'], 'name' => $row['Name'], 'description' => $row['Description']));
}
echo json_encode($data);
?>