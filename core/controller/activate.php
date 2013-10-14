<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirRoot'].'/libs/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
$emailHash = $_GET['id'];
$account = DB::queryFirstRow("SELECT Id, Status FROM CWM_User WHERE EmailHash=%?", $emailHash);
if(!is_null($account) && $account['Status'] == 0)
{
	DB::update('CWM_User', array('Status' => 1), "Id=%s", $account['Id']);
	header("Location: ".$GLOBALS['urlRoot']."/manage.php");
}
?>