<?php

class CompileLib
{
	public function GetFile($language) {
		$filename = $GLOBALS['dirLibs'].'/internal/ide/code_templates/'.$language;
		#$handle = fopen($filename, "rb");
		#$data = fread($handle, filesize($filename));
		#fclose($handle);
		#return htmlentities($data);
		return file_get_contents($filename);
	}

	public function ExtractProject($language, $projectName) {
		$baseDir = $GLOBALS['dirLibs'].'/internal/ide';
		$file = $baseDir.'/code_templates/'.$language.'.zip';
		$destDir = $baseDir.'/code_output/'.$language.'/'.$projectName;
		$mainFile = $baseDir.'/code_output/'.$language.'/'.$projectName.'/main_template_file';
		$result = $this->ExtractFile($file, $destDir);
		if($result == 1) {
			return file_get_contents($mainFile);
		}
	}

	public function ExtractFile($file, $destDir) {
		$zip = new ZipArchive;
		if ($zip->open($file) === TRUE) {
		    $zip->extractTo($destDir);
		    $zip->close();
		    return true;
		} else {
		    return false;
		}
	}
}

?>