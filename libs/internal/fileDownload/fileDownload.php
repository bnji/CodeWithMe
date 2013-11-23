<?php
$fileName = $_GET['fileName'];
$fileFullName = $_GET['fileFullName'];
$contentType = $_GET['contentType'];
if(!isset($contentType)) {
	$contentType = 'text/plain';
}
header('Content-type: '.$contentType);
header('Content-Disposition: attachment; filename="'.$fileName);
echo file_get_contents($fileFullName);
?>