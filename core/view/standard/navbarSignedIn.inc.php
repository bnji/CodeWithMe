<div class="navbar navbar-inverse navbar-fixed-top onco-nav-large">
  <!--<div class="container">-->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<a class="navbar-brand" href="./">CodeWithMe</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="dropdown">
        	<a id="my-solutions" href="#" class="dropdown-toggle" data-toggle="dropdown">My Solutions <b class="caret"></b></a>

			<ul id="solutionsTop" class="dropdown-menu">

			</ul>
		</li>
      </ul>

      <ul class="nav navbar-nav">
        <li class="dropdown">
        	<a id="friends-solutions" href="#" class="dropdown-toggle" data-toggle="dropdown">Friends Solutions <b class="caret"></b></a>
			<ul id="friendSolutionsTop" class="dropdown-menu">

			</ul>
		</li>
      </ul>

      <ul class="nav navbar-nav">
        <li class="dropdown">
			<a id="menu-file" href="#" class="dropdown-toggle" data-toggle="dropdown">File <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a id="share-file" href="#">Share (public, but unlisted)</a></li>
				<li><a id="view-shared-files" href="#">View shares</a></li>
			</ul>
		</li>
      </ul>

      <ul class="nav navbar-nav">
        <li class="dropdown">
			<a id="menu-account" href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a id="solutions-shared-with-me" href="#">Solutions shared with me</a></li>
				<li><a id="solutions-shared-by-me" href="#">Solutions shared by me</a></li>
				<li class="divider"></li>
				<li><a id="settings" href="#">Settings</a></li>
				<li><a id="sign-out" href="#">Sign out</a></li>
          	</ul>
      	</li>
      </ul>

      <p class="navbar-text pull-right">
  		Signed in as <a href="#" class="navbar-link"><span id="emailIdTop" href="#"></span></a>
	  </p>
    </div><!--/.nav-collapse -->
  <!--</div><!--/.container -->
</div>

<!-- small menu -->
<div class="navbar-wrapper">
	<div class="container">
		<div class="navbar navbar-inverse navbar-fixed-top onco-nav onco-nav-small">
			<div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
				<a class="navbar-brand" href="./">CodeWithMe</a>
		    </div>
		    <div class="collapse navbar-collapse">
		      <ul class="nav navbar-nav">
		        <li class="dropdown">
					<a id="menu-file" href="#" class="dropdown-toggle" data-toggle="dropdown">File <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a id="share-file" href="#">Share (public, but unlisted)</a></li>
						<li><a id="view-shared-files" href="#">View shares</a></li>
					</ul>
				</li>
		      </ul>
		  </div>
	  </div>
  </div>
</div>

<style>
.onco-nav-large {

}

.onco-nav-small {
  display: none;
  visibility: hidden;
  margin-top: -50px;
}
</style>

<script>
$(function() {
	// Load user's solutions
	LoadUserSolutions();

	// Load friends solutions
	LoadFriendsSolutions();

	$('#emailIdTop').html(storage.get('email'));

	$('#sign-out').click(function(e) {
		$.get('core/controller/logout.php', function(e) {
			CWMCommon.SignOut("<?php echo $GLOBALS['urlRoot']; ?>");
		});
	});

	$('#share-file').click(function() {
		$.get('core/controller/shareFile.php', {'uid': storage.get('uid'), 'solutionName' : selectedSolution, 'projectName': selectedProject, 'fileName': selectedFile} ).done(function(data) {
			window.location = "<?php echo $GLOBALS['urlRoot']; ?>/share/file/" + data;
		});
	});

	$('#view-shared-files').click(function() {
		window.location = "<?php echo $GLOBALS['urlRoot']; ?>/shares";
	});

	$('#solutions-shared-with-me').click(function() {
		window.location = "<?php echo $GLOBALS['urlRoot']; ?>/friendSolutionShares";
	});

	$('#solutions-shared-by-me').click(function() {
		window.location = "<?php echo $GLOBALS['urlRoot']; ?>/mySolutionShares";
	});

	$('#settings').click(function() {
		window.location = "<?php echo $GLOBALS['urlRoot']; ?>/settings";
	});



	$(window).scroll(function() {
		var posY = $(window).scrollTop();
		if (posY > 0) {
			$("#projects2, #chat-content, #chat-status").animate({marginTop: posY},0);
		}
		else {
			$("#projects2, #chat-content, #chat-status").animate({marginTop:"0px"},0);
		}
		if (posY > 100) {
			//console.log($(window).scrollTop());
			$('.onco-nav-small').css({"display":"block", "visibility":"visible"}).animate({marginTop:"0px"},500);
			$('.onco-nav-large').css({"display":"none", "visibility":"hidden"});
		}
		else {
			$(".onco-nav-small").stop(true,true).animate({marginTop:"-50px"},10);
			$('.onco-nav-large').css({"display":"block", "visibility":"visible"});
		}
	});
});
</script>