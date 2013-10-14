<?
    /**
     *	Change this
     **/
    $dirCoreBase = "/core";
    $dirLibsBase = $dirAssetsBase."/libs";

    /*
    DON'T change stuff below unless you know what you're doing
    */

    #GLOBAL $baseUrl;
    GlOBAL $dirRoot, $dirCore, $dirLibs;
    GLOBAL $urlRoot, $urlCore, $urlLibs;

    $urlRoot = "";
    $pathinfoArray = explode('/', pathinfo(__DIR__)['dirname']);
    for($i = 0; $i < count($pathinfoArray); $i++) {
        if(strpos($_SERVER['REQUEST_URI'], $pathinfoArray[$i])) {
            $urlRoot .= '/'.$pathinfoArray[$i];
        }
    }
    $dirRoot = $_SERVER['DOCUMENT_ROOT'].$urlRoot;

    #$dirRoot = $basePath;
    $dirRoot = str_replace($dirCoreBase, "", $dirRoot);
    $dirCore = $dirRoot.$dirCoreBase;
    $dirLibs = $dirRoot.$dirLibsBase;

    #$urlRoot = $baseUrl;
    $urlCore = $urlRoot.$dirCoreBase;
    $urlLibs = $urlRoot.$dirLibsBase;

    function replaceSlash($string) {
        return substr($string, 0, strlen($string) - 0);
    }
?>