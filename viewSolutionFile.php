<?php
require_once './core/dirHandler.php';
require_once $GLOBALS['dirRoot'].'/libs/external/meekrodb.2.2.class.php';
require_once './core/dbConfig.inc.php';
/*require_once './core/auth.inc.php';
if(!isUserLoggedIn())
{
	redirect('./');
}*/
require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>
<script type="text/javascript" src="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/scripts/shBrushCSharp.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/styles/shCore.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/styles/shThemeDefault.css" />
<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/spike-engine/js/spike-sdk.js.src.js" type="application/javascript" ></script>
<link rel="stylesheet" href="<?php echo $GLOBALS['urlLibs']; ?>/external/spike-engine/css/styles2.css" type="text/css" />

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="./">CodeWithMe</a>
    </div>
  </div>
</div>

<div id="mainContent" class="container-fluid">

 <div class="row-fluid">

  <div class="span12">

    <pre id="data" class="brush: csharp"></pre>

  </div>

</div>
</div>

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script>
	// Document ready
$(function() {
	var solutionName = "";
	var projectName = "";
	var fileName = "";

	// Load user's solutions
	$.get('core/controller/getSolutionDataFromShare.php', {'url': "<?php echo $_GET['id']; ?>"}).done(function(data) {
		var jsonData = JSON.parse(data);
		solutionName = jsonData['solutionName'];
		projectName = jsonData['projectName'];
		fileName = jsonData['fileName'];
		LoadFile(solutionName, projectName, fileName);
	});

	// Enable syntax highligther
	SyntaxHighlighter.all();

	function LoadFile(solutionName, projectName, fileName) {
		$.get('core/controller/readfile.php', { 'solution': solutionName, 'project': projectName, 'title': fileName }).done(function(data) {
		$('#data').html("<pre class='brush: csharp;'>" + data + "</pre>");
		SyntaxHighlighter.highlight();
		});
	}

});
</script>