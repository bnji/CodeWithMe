<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$solution = $_GET['solution'];
$project = $_GET['project'];
$results = DB::query("SELECT FileName FROM CWM_Solution WHERE UserId=%? AND SolutionName=%? AND ProjectName=%?", $_COOKIE["uid"], $solution, $project);
$data = array();
foreach ($results as $row) {
  	array_push($data, $row['FileName']);
}
echo json_encode($data);

?>