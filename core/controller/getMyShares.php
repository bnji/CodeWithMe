<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';

$results = DB::query("SELECT sh.Url, sol.SolutionName, sol.ProjectName, sol.FileName, sol.FileData FROM CWM_Share as sh JOIN CWM_Solution sol ON sh.SolutionId = sol.Id WHERE sh.UserId=%?", $_COOKIE['uid']);
$data = array();
foreach($results as $row)
{
  array_push($data, array(
    'solution' => $row['SolutionName'],
    'project' => $row['ProjectName'],
    'url' => $row['Url'],
    'fileName' => $row['FileName'],
    'fileData' => $row['FileData']
    )
  );
}
echo json_encode($data);
?>