<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$data = DB::queryFirstRow("SELECT FileData FROM CWM_Solution WHERE SolutionName=%? AND ProjectName=%? AND FileName=%?", $_GET['solution'], $_GET['project'], $_GET['title']);
echo $data['FileData'];
?>