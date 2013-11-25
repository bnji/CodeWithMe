<?php
session_start();
// Turn off all error reporting
#error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once './core/dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/auth.inc.php';
require_once $GLOBALS['dirRoot'].'/api/ApiAuth.class.php';
require_once $GLOBALS['dirRoot'].'/api/Object.class.php';
$apiBaseUrl = '/api/1';
$dbCfg = $GLOBALS['dirCore'].'/dbConfig.inc.php';
$f3 = require($GLOBALS['dirLibs'].'/external/fatfree/lib/base.php');

if(file_exists($dbCfg)) {
    require_once $dbCfg;
}
else {
    require_once $GLOBALS['dirCore'].'/pages/install.php';
}

$f3->route('GET /',
    function($f3) {
        require_once $GLOBALS['dirCore'].'/pages/login.php';
    }
);
$f3->route('GET /install',
    function($f3) {
        if(file_exists($GLOBALS['dirCore'].'/pages/install.php')) {
            require_once $GLOBALS['dirCore'].'/pages/install.php';
        }
        else {
            header("Location: /");
        }
    }
);
$f3->route('GET /manage',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/manage.php';
    }
);
$f3->route('GET /shares',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/myFileShares.php';
    }
);
$f3->route('GET /share/file/@id',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/viewSolutionFile.php';
    }
);
$f3->route('GET /settings',
    function($f3) {
    	require_once $GLOBALS['dirCore'].'/pages/settings.php';
    }
);
$f3->route('GET /logout',
    function($f3) {
        header("Location: core/controller/logout.php");
    }
);
$f3->route('GET /compile',
    function($f3) {
        require_once $GLOBALS['dirCore'].'/pages/compileIndex.php';
    }
);
$f3->route('GET /compile/@id',
    function($f3) {
        require_once $GLOBALS['dirCore'].'/pages/compileMain.php';
    }
);

// API

// Generate public/private key pairs
$f3->route('GET ' . $apiBaseUrl . '/generate',
    function($f3) {
    	echo CWM_API::generate();
    }
);
// Authorize user
$f3->route('POST ' . $apiBaseUrl . '/authorize/@data/@key/@hash',
    function($f3) {
        $data = $f3->get('PARAMS.data');
        $publicApiKey = $f3->get('PARAMS.key');
        $hash = $f3->get('PARAMS.hash');
        echo CWM_API::authorize($data, $publicApiKey, $hash);
    }
);
// Deauthorize user
$f3->route('POST ' . $apiBaseUrl . '/deauthorize/@tokenValue',
    function($f3) {
    	$tokenValue = $f3->get('PARAMS.tokenValue');
    	echo CWM_API::deAuthorize($tokenValue);
    }
);
// Get user
$f3->route('GET ' . $apiBaseUrl . '/user/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/User.class.php';
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $user = CWM_User::getFromToken($tokenValue);
        if(!is_null($user)) {
            echo $user->getAsJson();
        }
        else {
            echo -1;
        }
    }
);
// Get user solution
//GET ' . $apiBaseUrl . '/solution/ConsoleApplication4/99f2cf0ac462b748e050a7bebe11f4f98de00881
$f3->route('GET ' . $apiBaseUrl . '/solution/@solutionName/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/Solution.class.php';
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $solution = CWM_Solution::get($f3->get('PARAMS.solutionName'), $tokenValue);
        if(!is_null($solution)) {
           echo $solution->getAsJson();
        }
        else {
            echo -1;
        }
    }
);
// Get list of user solutions
//http://localhost/CodeWithMe/api/solutions/99f2cf0ac462b748e050a7bebe11f4f98de00881
$f3->route('GET ' . $apiBaseUrl . '/solutions/@tokenValue',
    function($f3) {
    	#require_once $GLOBALS['dirRoot'].'/api/getUserSolutions.php';
    	require_once $GLOBALS['dirRoot'].'/api/Solution.class.php';
		$tokenValue = $f3->get('PARAMS.tokenValue');
        $solutions = CWM_Solution::getList($tokenValue);
        echo CWM_API::getAsJson($solutions);
    }
);
// Create solution
$f3->route('POST ' . $apiBaseUrl . '/solution/create/@tokenValue',
    function($f3) {
    	require_once $GLOBALS['dirRoot'].'/api/Solution.class.php';
    	$tokenValue = $f3->get('PARAMS.tokenValue');
        if(CWM_API::isTokenValid($tokenValue)) {
            $jsonData = json_decode($f3->get('BODY'));
            $_userId = CWM_API::getUserId($tokenValue); //$jsonData->{'UserId'};
            $_name = $jsonData->{'Name'};
            $_solution = new CWM_Solution(-1, $_userId, $_name);
            $_solution->create();
            echo $_solution->ID; //json_encode(array('ID' => $_project->ID));
        }
        else {
            echo -1;
        }
    }
);
// Returns a project
$f3->route('GET ' . $apiBaseUrl . '/project/@solutionId/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/Project.class.php';
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $project = CWM_Project::get($f3->get('PARAMS.solutionId'), $tokenValue);
        if(!is_null($project)) {
           echo $project->getAsJson();
        }
        else {
            echo -1;
        }
    }
);
// Get solution projects
$f3->route('GET ' . $apiBaseUrl . '/projects/@solutionId/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/Project.class.php';
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $projects = CWM_Project::getList($f3->get('PARAMS.solutionId'), $tokenValue);
        echo CWM_API::getAsJson($projects);
    }
);
// Create project and adds a relation between solution and the project
$f3->route('POST ' . $apiBaseUrl . '/project/create/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/Project.class.php';
        $tokenValue = $f3->get('PARAMS.tokenValue');
        if(CWM_API::isTokenValid($tokenValue)) {
            $jsonData = json_decode($f3->get('BODY'));
            $_id = $jsonData->{'ID'};
            $_name = $jsonData->{'Name'};
            $_description = $jsonData->{'Description'};
            $_solutionId = $jsonData->{'SolutionId'};
            $_project = new CWM_Project($_id, $_name, $_description, $_solutionId);
            $_project->create();
            echo $_project->ID; //json_encode(array('ID' => $_project->ID));
        }
        else {
            echo -1;
        }
    }
);
// Not used... needed?
$f3->route('POST ' . $apiBaseUrl . '/solution/addProject/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/Solution.class.php';
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $jsonData = json_decode($f3->get('BODY'));
        $solutionId = $jsonData->{'SolutionId'};
        $projectId = $jsonData->{'ProjectId'};
        echo CWM_Solution::AddProject($solutionId, $projectId, $tokenValue);

        #$solutionId = $f3->get('PARAMS.solutionId');
        #$projectId = $f3->get('PARAMS.projectId');
        #$tokenValue = $f3->get('PARAMS.tokenValue');
        #echo CWM_Solution::AddProject($solutionId, $projectId, $tokenValue);
    }
);
// Get project files
$f3->route('GET ' . $apiBaseUrl . '/files/@projectId/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/File.class.php';
        $projectId = $f3->get('PARAMS.projectId');
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $files = CWM_File::getList($projectId, $tokenValue);
        echo CWM_API::getAsJson($files);
    }
);
// Get a file by file ID
$f3->route('GET ' . $apiBaseUrl . '/file/@fileId/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/File.class.php';
        $fileId = $f3->get('PARAMS.fileId');
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $file = CWM_File::get($fileId, $tokenValue);
        echo CWM_API::getAsJson($file);
    }
);
// Get a file by project ID and file name
$f3->route('GET ' . $apiBaseUrl . '/file/@projectId/@fileName/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/File.class.php';
        $projectId = $f3->get('PARAMS.projectId');
        $fileName = $f3->get('PARAMS.fileName');
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $file = CWM_File::getByProjectIdFileName($projectId, $fileName, $tokenValue);
        echo CWM_API::getAsJson($file);
    }
);
// Create a file
$f3->route('POST ' . $apiBaseUrl . '/file/create/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/File.class.php';
        $tokenValue = $f3->get('PARAMS.tokenValue');
        if(CWM_API::isTokenValid($tokenValue)) {
            $jsonData = json_decode($f3->get('BODY'));
            $_projectId = $jsonData->{'ProjectId'};
            $_fileName = $jsonData->{'Name'};
            $_fileData = $jsonData->{'Data'};
            $_userId = CWM_API::getUserId($tokenValue);
            $_solutionName = $jsonData->{'SolutionName'};
            $_projectName = $jsonData->{'ProjectName'};
            $_file = new CWM_File(-1, $_projectId, $_fileName, $_fileData, $_userId, $_solutionName, $_projectName, null);
            $_file->create();
            echo $_file->ID; //json_encode(array('ID' => $_file->ID));
        }
        else {
            echo -1;
        }
    }
);
// Update a file
$f3->route('PUT ' . $apiBaseUrl . '/file/update/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/File.class.php';
        $jsonData = json_decode($f3->get('BODY'));
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $fileId = $jsonData->{'ID'};
        $fileName = $jsonData->{'Name'};
        $fileData = $jsonData->{'Data'};
        echo CWM_File::update($fileId, $fileName, $fileData, $tokenValue);
    }
);
// Delete a file
$f3->route('POST ' . $apiBaseUrl . '/file/delete/@tokenValue',
    function($f3) {
        require_once $GLOBALS['dirRoot'].'/api/File.class.php';
        $jsonData = json_decode($f3->get('BODY'));
        $tokenValue = $f3->get('PARAMS.tokenValue');
        $fileId = $jsonData->{'ID'}; //$f3->get('PARAMS.fileId');
        echo CWM_File::delete($fileId, $tokenValue);
    }
);

$f3->sync('SESSION');
$f3->sync('COOKIE');
$f3->run();
?>