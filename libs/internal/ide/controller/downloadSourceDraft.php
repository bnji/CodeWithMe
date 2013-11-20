<?php
$fileName = $_GET['fileName'];
$fileExtension = $_GET['fileExtension'];
$contentType = $_GET['contentType'];
if(!isset($contentType)) {
	$contentType = 'text/plain';
}
header('Content-type: '.$contentType);
header('Content-Disposition: attachment; fileName="'.$fileName.$fileExtension);

require_once '../../../../core/dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
require_once $GLOBALS['dirCore'].'/config.inc.php';
require_once $GLOBALS['dirCore'].'/common.inc.php';
echo DB::queryOneField('Content', "SELECT * FROM CWM_SourceDraft WHERE Url=%?", $fileName);

?>