<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$results = DB::query("SELECT sh.Url, f.SolutionName, f.ProjectName, f.Name, f.Data FROM CWM_Share as sh JOIN CWM_File f ON sh.FileId = f.Id WHERE sh.UserId=%?", $_COOKIE['uid']);
$data = array();
foreach($results as $row)
{
  array_push($data, array(
    'solution' => $row['SolutionName'],
    'project' => $row['ProjectName'],
    'url' => $row['Url'],
    'fileName' => $row['Name'],
    'fileData' => $row['Data']
    )
  );
}
echo json_encode($data);
?>