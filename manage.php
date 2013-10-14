<?php
require_once './core/dirHandler.php';
require_once $GLOBALS['dirRoot'].'/libs/external/meekrodb.2.2.class.php';
require_once './core/dbConfig.inc.php';
require_once './core/auth.inc.php';
if(!isUserLoggedIn())
{
	redirect('./');
}
require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>
<script type="text/javascript" src="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/scripts/shBrushCSharp.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/styles/shCore.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/styles/shThemeDefault.css" />
<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/spike-engine/js/spike-sdk.js.src.js" type="application/javascript" ></script>
<link rel="stylesheet" href="<?php echo $GLOBALS['urlLibs']; ?>/external/spike-engine/css/styles2.css" type="text/css" />

<!--
<style>
#projects-content {
  position: absolute;
  top: 0;
  /* just used to show how to include the margin in the effect */
  margin-top: 20px;
  border-top: 1px solid purple;
  padding-top: 19px;
}

#projects-content.fixed {
  position: fixed;
  top: 0;
}
</style>-->


<?php require_once $GLOBALS['dirCore'].'/view/standard/navbarSignedIn.inc.php'; ?>

<div id="mainContent" class="container-fluid">

	<div class="row-fluid">

		<div id="projects-content" class="span2">
			<ul id="projects2" class="nav nav-list"></ul>
		</div>

		<div class="span7">
			<div id="shares"></div>
			<pre id="data" class="brush: csharp"></pre>

		</div>

		<div class="span3">
			<div id="form">
				<form class="form" onsubmit="sendMessage();return false;" method="get">
					<!--<div class="input-append">-->
					<input id="msgText" class="input-block-level" type="text" placeholder="Say something (hit [ENTER] to send message)...">
						<!--<input type="submit" class="btn btn-primary" value="Send" />
					</div>-->
				</form>
			</div>
			<div id="wrapper">
				<div class="bubble-container" ></div>
			</div>
		</div>

	</div>
</div>

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script>
var autoUpdateActive = true;
var selectedSolution = "<?php echo $_GET['s']; ?>";
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


	if(autoUpdateActive) {
		// Load file data
		setInterval(function(){
			LoadFile(selectedSolution, selectedProject, selectedFile);
		 }, 2000);

		/*setInterval(function(){
			LoadProjectFiles(GetSolutionName(), GetProjectName());
		}, 10000);*/
	}



});

/***
	HTML5 Server code below
	*/
	function sendMessage() {
		server.sendMyChatMessage($("#msgText").val());
		$("#msgText").val("");
	}

	function addBubble(avatar, text) {

    // Get the bytes of the image and convert it to a BASE64 encoded string and then
    // we use data URI to add dynamically the image data
    var avatarUri = "data:image/png;base64," + avatar.toBase64();

    var bubble = $('<div class="bubble-container"><span class="bubble"><img class="bubble-avatar" src="' + avatarUri + '" /><div class="bubble-text"><p>' + text + '</p></div><span class="bubble-quote" /></span></div>');
    $("#msgText").val("");

    $(".bubble-container:last")
    .after(bubble);

    if (bubbles >= maxBubbles) {
    	var first = $(".bubble-container:first")
    	.remove();
    	bubbles--;
    }

    bubbles++;
    $('.bubble-container').show(250, function showNext() {
    	if (!($(this).is(":visible"))) {
    		bubbles++;
    	}

    	$(this).next(".bubble-container")
    	.show(250, showNext);

    	$("#wrapper").scrollTop(9999999);
    });
}

// On page loaded and ready
$(window).load(function () {


    // First we need to create a server channel on the given URI, in a form http://IP:PORT
    // For your local test you might try http://127.0.0.1:8002 (or a different IP address/port)
    server = new ServerChannel('http://'+serverAddress+":"+serverPort);

    // When the browser is connected to the server, we show that we are connected to the user
    // and provide a transport name (websockets, flashsockets etc.).
    server.onConnect(function () {
        // Once connected, we need to join the chat
        server.joinMyChat();

    });



    // Here we hook the room messages inform event so we know when
    // the server sends us the messages. We need to show them properly in the text area.
    server.myChatMessagesInform = function (p) {
    	addBubble(p.avatar, p.message);
    };

});
</script>