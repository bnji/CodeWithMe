<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="./">CodeWithMe</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li class="dropdown">
						<a id="my-solutions" href="#" class="dropdown-toggle" data-toggle="dropdown">My Solutions <b class="caret"></b></a>
						<ul id="solutionsTop" class="dropdown-menu">

						</ul>
					</li>
				</ul>

				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">File <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a id="shareSolutionFile" href="#">Share (public, but unlisted)</a></li>
						</ul>
					</li>
				</ul>

				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a id="shared-with-me" href="#">Solutions shared with me</a></li>
							<li><a id="shared-by-me" href="#">Solutions shared by me</a></li>
							<li class="divider"></li>
							<li><a id="settings" href="#">Settings</a></li>
							<li><a id="sign-out" href="#">Sign out</a></li>
                  <!--<li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>-->
		              </ul>
		          </li>
		      </ul>

		      <div class="nav-collapse collapse">
		      	<p class="navbar-text pull-right">
		      		Logged in as <a href="#" class="navbar-link"><span id="emailIdTop" href="#"></span></a>
		      	</p>
		      </div>
  			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
<script>
$(function() {
	// Load user's solutions
	LoadUserSolutions();

	$('#emailIdTop').html(storage.get('email'));

	$('#sign-out').click(function(e) {
		$.get('core/controller/logout.php', function(e) {
			CWMCommon.SignOut("index.php");
		});
	});

	$('#shareSolutionFile').click(function() {
		$.get('core/controller/shareSolutionFile.php', {'solutionName' : selectedSolution, 'projectName': selectedProject, 'fileName': selectedFile} ).done(function(data) {
			window.location = 'viewSolutionFile.php?id=' + data;
		});
	});

	$('#shared-by-me').click(function() {
		window.location = 'myshares.php';
	});

	$('#settings').click(function() {
		window.location = 'settings.php';
	});
});
</script>