<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$data = DB::queryFirstRow("SELECT Data FROM CWM_File WHERE SolutionName=%? AND ProjectName=%? AND Name=%?", $_GET['solution'], $_GET['project'], $_GET['title']);
echo $data['Data'];
?>