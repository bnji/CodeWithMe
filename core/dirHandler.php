<?
    // Define here which global path (url & dir) variables, you prefer...
    $urlList = array(
        "/core",
        "/libs",
        "/assets"
    );

    $pathinfo = pathinfo(__DIR__);
    $urlRoot = $pathinfo['dirname'];
    $urlRoot = str_replace("\\", "/", $urlRoot); // windows fix
    $urlRoot = substr($urlRoot, strrpos($urlRoot, '/'), strlen($urlRoot)); //fix for str_replace, as it is different on windows (wamp) and osx (mamp)!!!
    $dirRoot = $_SERVER['DOCUMENT_ROOT'].$urlRoot;

    // Creates e.g. dirCore and urlCore variables, which would become
    // dirCore = "/path/to/your/htdocs/CodeWithMe/core"
    // urlCore = "/CodeWithMe/core"
    foreach ($urlList as $key => $value) {
        $key = str_replace("/", "", $value);
        $key = ucfirst($key);
        ${"dir$key"} = $dirRoot.$value;
        ${"url$key"} = $urlRoot.$value;
    }
?>