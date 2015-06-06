<?php

class CompileLib
{
	public function getFile($language) {
		return file_get_contents($GLOBALS['dirLibs'].'/internal/ide/code_templates/'.$language);
	}

	public function extractProject($language, $projectName) {
		$baseDir = $GLOBALS['dirLibs'].'/internal/ide';
		$langDir = $baseDir.'/code_output/'.$language;
		$file = $baseDir.'/code_templates/'.$language.'.zip';
		$destDir = $langDir.'/'.$projectName;
		$this->createDir($langDir);
		$mainFile = $baseDir.'/code_output/'.$language.'/'.$projectName.'/main_template_file';
		$result = $this->extractFile($file, $destDir);
		if($result == 1) {
			return file_get_contents($mainFile);
		}
	}

	public function extractFile($file, $destDir) {
		$zip = new ZipArchive;
		if ($zip->open($file) === TRUE) {
		    $zip->extractTo($destDir);
		    $zip->close();
		    return true;
		} else {
		    return false;
		}
	}

	private function createDir($dir)
	{
		if(!is_dir($dir) && !is_file($dir))
		{
			return mkdir($dir);
		}
		return false;
	}
}

?>