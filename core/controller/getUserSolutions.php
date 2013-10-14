<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
$uid = $_GET['uid'];
$results = DB::query("SELECT DISTINCT SolutionName FROM CWM_Solution WHERE UserId=%?", $uid);
$data = array();
foreach ($results as $row) {
	array_push($data, array('name' => $row['SolutionName']));
}
echo json_encode($data);
?>