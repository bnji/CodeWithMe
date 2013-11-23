<?php
require_once '../../../../core/dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
require_once $GLOBALS['dirCore'].'/config.inc.php';
require_once $GLOBALS['dirCore'].'/common.inc.php';
$selectId = $_POST['selectId'];
$file = $_POST['fileFullName'];
$content = DB::queryOneField('Content', "SELECT * FROM CWM_SourceDraft WHERE Url=%?", $selectId);
echo file_put_contents($file, $content);
?>