<?php
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
require_once $GLOBALS['dirRoot'].'/api/ApiAuth.class.php';
$results = array();
$tokenValue = $f3->get('PARAMS.tokenValue');
if(CWM_API::IsTokenValid($tokenValue))
{
	$userId = DB::queryOneField("Id", "SELECT * FROM CWM_ApiKeySession aks JOIN CWM_User as u ON aks.UserId = u.Id WHERE TokenValue=%?", $tokenValue);
	$results = DB::query("SELECT * FROM CWM_Solution WHERE UserId=%?", $userId);
}
echo json_encode($results);
?>