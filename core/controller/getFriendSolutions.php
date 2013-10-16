<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
$uid = $_GET['uid'];
$results = DB::query("SELECT * FROM CWM_SharedSolution as ss JOIN CWM_Solution as s JOIN CWM_User as u ON ss.SolutionId = s.Id AND ss.OwnerUserId = u.Id WHERE FriendUserId=%?", $uid);
$data = array();
foreach ($results as $row) {
	array_push($data, array('solutionId' => $row['SolutionId'], 'solutionName' => $row['Name'], 'ownerId' => $row['OwnerUserId'], 'ownerEmail' => $row['Email']));
}
echo json_encode($data);
?>