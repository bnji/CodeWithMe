<?
    $dirCoreBase = "/core";
    $dirLibsBase = "/libs";

    GlOBAL $dirRoot, $dirCore, $dirLibs;
    GLOBAL $urlRoot, $urlCore, $urlLibs;

    $pathinfoArray = explode('/', pathinfo(__DIR__)['dirname']);
    foreach ($pathinfoArray as $pathInfo) {
        if($pathInfo) {
            if(strpos($_SERVER['REQUEST_URI'], $pathInfo)) {
                $urlRoot .= '/'.$pathInfo;
            }
        }
    }
    $dirRoot = str_replace($dirCoreBase, "", $_SERVER['DOCUMENT_ROOT'].$urlRoot);

    $dirCore = $dirRoot.$dirCoreBase;
    $dirLibs = $dirRoot.$dirLibsBase;

    $urlCore = $urlRoot.$dirCoreBase;
    $urlLibs = $urlRoot.$dirLibsBase;

    $tempProjectDir = "/CodeWithMe";
    $tempDirBase = "/Users/beha/Documents/Mamp Sites".$tempProjectDir;

    assert($urlRoot ==  $tempProjectDir);
    assert($urlCore ==  $tempProjectDir."/core");
    assert($urlLibs ==  $tempProjectDir."/libs");

    assert($dirRoot ==  $tempDirBase);
    assert($dirCore ==  $tempDirBase."/core");
    assert($dirLibs ==  $tempDirBase."/libs");
?>