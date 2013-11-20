<?
    $dirCoreBase = "/core";
    $dirLibsBase = "/libs";
    $dirAssetsBase = "/assets";

    GlOBAL $dirRoot, $dirCore, $dirLibs, $dirAssets;
    GLOBAL $urlRoot, $urlCore, $urlLibs, $urlAssets;

    $pathinfo = pathinfo(__DIR__);
    $urlRoot = $pathinfo['basename'];

    /*$pathinfoArray = explode('/', pathinfo(__DIR__)['dirname']);
    foreach ($pathinfoArray as $pathInfo) {
        if($pathInfo) {
            if(strpos($_SERVER['REQUEST_URI'], $pathInfo)) {
                $urlRoot .= '/'.$pathInfo;
            }
        }
    }*/

    #$dirRoot = str_replace($dirCoreBase, "", $_SERVER['DOCUMENT_ROOT'].$urlRoot);

    $dirRoot = $_SERVER['DOCUMENT_ROOT'];

    $urlRoot = $pathinfo['dirname'];
    $urlRoot = str_replace($dirRoot, "", $urlRoot);

    $dirRoot = $dirRoot.$urlRoot;
    #"var_dump(pathinfo(__DIR__));
    #$dirRoot = str_replace($dirCoreBase, "", pathinfo(__DIR__)['dirname']);//$_SERVER['DOCUMENT_ROOT'].$urlRoot);


    $dirCore = $dirRoot.$dirCoreBase;
    $dirLibs = $dirRoot.$dirLibsBase;
    $dirAssets = $dirRoot.$dirAssetsBase;

    $urlCore = $urlRoot.$dirCoreBase;
    $urlLibs = $urlRoot.$dirLibsBase;
    $urlAssets = $urlRoot.$dirAssetsBase;

?>