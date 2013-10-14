<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$solution = $_GET['solution'];
$results = DB::query("SELECT DISTINCT ProjectName FROM CWM_Solution WHERE UserId=%? AND SolutionName=%?", $_COOKIE["uid"], $solution);
$data = array();
foreach ($results as $row) {
  	array_push($data, $row['ProjectName']);
}
echo json_encode($data);
?>