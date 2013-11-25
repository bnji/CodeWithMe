<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
$dbPrefix = $_POST['dbPrefix'];
$dbUser = $_POST['dbUser'];
$dbPassword = $_POST['dbPassword'];
$dbName = $_POST['dbName'];
$dbHost = $_POST['dbHost'];
$dbPort = $_POST['dbPort'];
$dbEncoding = $_POST['dbEncoding'];

$dbCfg = $GLOBALS['dirCore'].'/dbConfig.inc.php';
$data = '<?php
DB::$user = "'.$dbUser.'";
DB::$password = "'.$dbPassword.'";
DB::$dbName = "'.$dbName.'";
DB::$host = "'.$dbHost.'";
DB::$port = "'.$dbPort.'";
DB::$encoding = "'.$dbEncoding.'";
?>';
#file_put_contents($dbCfg, $data);
require_once $dbCfg;
#$sqlQuery = readfile($GLOBALS['dirRoot'].'/model/CodeWithMe.sql');
#$sqlQuery = str_replace('CWM_', $dbPrefix, $sqlQuery);
#$sqlQuery = str_replace('CHARSET=utf8', 'CHARSET='.$dbEncoding, $sqlQuery);
#$sqlQuery = mysql_query($sqlQuery);
#DB::queryRaw($sqlQuery);
#print_r($sqlQuery);
?>