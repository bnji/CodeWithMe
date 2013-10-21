<?php
if(!isUserLoggedIn())
{
  redirect('logout');
}
require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>
<script type="text/javascript" src="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/scripts/shBrushCSharp.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/styles/shCore.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/styles/shThemeDefault.css" />
<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/spike-engine/js/spike-sdk.js.src.js" type="application/javascript" ></script>
<link rel="stylesheet" href="<?php echo $GLOBALS['urlLibs']; ?>/external/spike-engine/css/styles2.css" type="text/css" />


<?php require_once $GLOBALS['dirCore'].'/view/standard/navbarSignedIn.inc.php'; ?>

<!--<div id="mainContent" class="container">-->
	<div class="row">
		<div id="projects-content" class="col-md-2">
      <div class="panel-group" id="accordion">
      </div>
	  </div>
		<div class="col-md-7">
			<label class="checkbox">
        <input id="useAutoUpdate" type="checkbox" checked> Use auto update?
      </label>
      <pre id="data" class="brush: csharp"></pre>
		</div>
		<div class="col-md-3">
      <div id="chat-status"></div>
      <div style="display:none;" id="chat-content">
  			<div class="input-group">
          <span class="input-group-addon">Say:</span>
          <input id="msgText" type="text" class="form-control" placeholder="(hit [ENTER] to send)">
        </div>
  			<div id="wrapper">
  				<div class="bubble-container" ></div>
  			</div>
      </div>
		</div>
	</div>
<!--</div><!--/.container -->

<!--template start-->
<div id="project-content-template" style="display:none;" class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><span id="projectName"></span></h3>
  </div>
  <div class="panel-body">
    <ul id="projects2" class="nav nav-list"></ul>
  </div>
</div>

<div id="project-panel-template" style="display:none;" class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">
      <a id="projectName" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#">

      </a>
    </h3>
  </div>
  <!--<div class="panel-body"> </div>-->
  <div class="panel-collapse collapse in">
    <ul id="projectFiles" class="list-group"></ul>
  </div>
</div>
<!--//template end-->

<script src="<?php echo $GLOBALS['urlLibs']; ?>/internal/chatServer.js" type="text/javascript" ></script>

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script>
var selectedSolution = "";
var selectedProject = "";
var selectedFile = "";
var bubbles = 1;
var maxBubbles = 200;
var server;
var serverAddress = "10.211.55.5";
var serverPort = 8002;

/*var top = $('#projects-content').offset().top - parseFloat($('#projects-content').css('marginTop').replace(/auto/,0));

$(window).scroll(function () {
    // what the y position of the scroll is
    var y = $(this).scrollTop();

    // whether that's below the form
    if (y >= top) {
      // if so, ad the fixed class
      $('#projects-content').addClass('fixed');
  } else {
      // otherwise remove it
      $('#projects-content').removeClass('fixed');
  }
});*/


// Document ready
$(function() {

	// Perform authentication
	/*if(CWMCommon.GetIsLoggedIn(function() {
		$('#mainContent').show();
	}, function() {
		CWMCommon.SignOut("./");
	}));*/


	// Enable syntax highligther
	SyntaxHighlighter.all();

	// On dropdown change
	$('#projects').change(function(e) {
		LoadProjectFiles(GetSolutionName(), GetProjectName());
		/*$( "select option:selected" ).each(function() {
	    	LoadProjectFiles($( this ).text());
	    });*/
    });


	// On dropdown change
	$('#Files').change(function(e) {
		$( "select option:selected" ).each(function() {
			LoadFile(GetSolutionName(), GetProjectName(), $( this ).text());
		});
	});

	/*$('#my-solutions').click(function() {
		$('#shares').slideUp('slow', function() {
    		$('#data, #projects-content').slideDown('slow', function() {

    		});
    	});
	});

    $('#shared-by-me').click(function(e) {
    	$('#projects-content').toggle({'direction':'left'});

		$('#data').slideUp('slow', function() {
    		$.get('myshares.php', function(data) {
    			//alert(data);
    			$('#shares').html(data).slideDown('slow', function() {

	    		});
    		});
    	});
    });*/


	setInterval(function(){
    if($("#useAutoUpdate:checked").length == 1) {
		 LoadFile(selectedSolution, selectedProject, selectedFile);
    }
	 }, 2000);

  // First we need to create a server channel on the given URI, in a form http://IP:PORT
  // For your local test you might try http://127.0.0.1:8002 (or a different IP address/port)
  server = new ServerChannel('http://'+serverAddress+":"+serverPort);

  $("#chat-status").html("Chat server is offline...");
  // When the browser is connected to the server, we show that we are connected to the user
  // and provide a transport name (websockets, flashsockets etc.).
  server.onConnect(function () {
    $("#chat-status").hide();
    $("#chat-content").show();
      // Once connected, we need to join the chat
      server.joinMyChat();
  });
  server.onDisconnect(function() {
    $("#chat-status").html("Chat server is offline...").show();
    $("#chat-content").hide();
  });
  // Here we hook the room messages inform event so we know when
  // the server sends us the messages. We need to show them properly in the text area.
  server.myChatMessagesInform = function (p) {
  	addBubble(p.avatar, p.message);
  };

});
</script>