<?php
require_once '../../../../core/dirHandler.php';

// Config
$baseDir = realpath('../code_output');
$exeFileName = "main";
$sourceContent = $_POST['content'];
$sourceUrl = $_POST['url'];
$sourceLanguage = $_POST['language'];
$path = $baseDir.'/'.$sourceLanguage.'/'.$sourceUrl;
mkdir($path);
$buildCmd = '';
$buildFile = '';

function enableRoot($password) {
	return 'echo '.$password.' | sudo -S';
}

// setup language
switch ($sourceLanguage) {
	case "csharp":
		$buildCmd = '/Applications/MonoDevelop.app/Contents/MacOS/mdtool build';
		$buildFile = $path.'/'.$exeFileName.'.csproj';
		$sourceFile = $path.'/'.$exeFileName.'.cs';
		$exeFile = 'mono '.$path.'/'.$exeFileName.'.exe';
		break;
	case "vbnet":
		$buildCmd = '/Applications/MonoDevelop.app/Contents/MacOS/mdtool build';
		$buildFile = $path.'/'.$exeFileName.'.vbproj';
		$sourceFile = $path.'/'.$exeFileName.'.vb';
		$exeFile = ' mono '.$path.'/'.$exeFileName.'.exe';
		break;
	case "c":
		$buildCmd = 'g++ -o '.$path.'/'.$exeFileName;
		$buildFile = $path.'/main.c';
		$sourceFile = $path.'/main.c';
		$exeFile = ' '.$path.'/'.$exeFileName;
		break;
	case "cpp":
		$buildCmd = 'g++ -o '.$path.'/'.$exeFileName;
		$buildFile = $path.'/main.cpp';
		$sourceFile = $path.'/main.cpp';
		$exeFile = ' '.$path.'/'.$exeFileName;
		break;
	case "java":
		$buildCmd = 'javac -verbose 2>&1'; // Redirect STDERR to STDOUT http://stackoverflow.com/questions/13257927/cant-execute-a-java-jar-file-via-php-on-ubuntu
		$buildFile = $path.'/'.$exeFileName.'.java';
		$sourceFile = $path.'/'.$exeFileName.'.java';
		$exeFile = 'java 2>&1 -cp '.$path.' CodeWithMe';
		break;
	case "ruby":
		$sourceFile = $path.'/'.$exeFileName.'.rb';
		$exeFile = ' ruby '.$path.'/'.$exeFileName.'.rb';
		break;
	case "perl":
		$sourceFile = $path.'/'.$exeFileName.'.pl';
		$exeFile = ' perl '.$path.'/'.$exeFileName.'.pl';
		break;
	case "php":
		$sourceFile = $path.'/'.$exeFileName.'.php';
		$exeFile = 'php '.$path.'/'.$exeFileName.'.php';
		break;
	case "javascript":
		$sourceFile = $path.'/'.$exeFileName.'.js';
		$exeFile = ' rhino '.$path.'/'.$exeFileName.'.js';
		break;
	case "nodejs":
		$sourceFile = $path.'/'.$exeFileName.'.js';
		$exeFile = ' node '.$path.'/'.$exeFileName.'.js';
		break;
	case "processing":
		$sourceFile = $path.'/'.$exeFileName.'.pde';
		$exeFile = ' node '.$path.'/'.$exeFileName.'.pde';
		break;
	default:
		$output = array("Error: missing compiler for selected language!");
		break;
}

// Save the content to the file
file_put_contents($sourceFile, $sourceContent);
// Only compile if it has a build command and buildFile
if(strlen($buildCmd) > 0 && strlen($buildFile) > 0) {
	// Compile the solution
	$lastLine = exec ($buildCmd.' '.$buildFile, $buildOutput, $buildStatus);

}
// run the file
$lastLine = exec($exeFile, $executeOutput, $executeStatus);
// add the output to the array
$output = array("Output:<br />");
#$output = array_merge($output, $buildOutput);
$output = array_merge($output, $executeOutput);
$output = array_merge($output, array($retval));
$output = implode(',', $output);
$output = str_replace(',', '<br />', $output);
$buildOutput = str_replace(',', '<br />', implode(',', $buildOutput));
$executeOutput = str_replace(',', '<br />', implode(',', $executeOutput));
echo json_encode(array('log' => $buildOutput, 'output' => $executeOutput, 'buildStatus' => $buildStatus, 'executeStatus' => $executeStatus));

?>