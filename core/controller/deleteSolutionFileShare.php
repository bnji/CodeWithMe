<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirRoot'].'/libs/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
DB::delete('CWM_Share', "Url=%?", $_GET['url']);
#echo $_GET['url'];
?>