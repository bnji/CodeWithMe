<?php
require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';

$isPhpShortOpenTagOn = ini_get('short_open_tag');
if($isPhpShortOpenTagOn == 0) {
	print_r("You need to turn on short_open_tag in your php configuration!"); return;
}
?>

<div class="container">
	<h1>
		Setup CodeWithMe
	</h1>
	<form id="createdb" role="form">
	  <div class="form-group">
	    <label for="dbPrefix">Database Table Prefix</label>
	    <input type="user" class="form-control" id="dbPrefix" placeholder="Prefix" value="CWM_">
	  </div>
	  <div class="form-group">
	    <label for="dbUser">Database User</label>
	    <input type="user" class="form-control" id="dbUser" placeholder="Username" value="root">
	  </div>
	  <div class="form-group">
	    <label for="dbPassword">Database Password</label>
	    <input type="password" class="form-control" id="dbPassword" placeholder="Password" value="">
	  </div>
	  <div class="form-group">
	    <label for="dbName">Database Name</label>
	    <input type="user" class="form-control" id="dbName" placeholder="Database name" value="">
	  </div>
	  <div class="form-group">
	    <label for="dbHost">Database Host (defaults to localhost if omitted)</label>
	    <input type="user" class="form-control" id="dbHost" placeholder="Database host" value="">
	  </div>
	  <div class="form-group">
	    <label for="dbPort">Database Port (defaults to 3306 if omitted)</label>
	    <input type="user" class="form-control" id="dbPort" placeholder="Database port" value="3306">
	  </div>
	  <div class="form-group">
	    <label for="dbEncoding">Database Encoding (defaults to latin1 if omitted)</label>
	    <input type="user" class="form-control" id="dbEncoding" placeholder="Database encoding" value="utf8">
	  </div>
	  <button type="submit" class="btn btn-default">Create</button> <label id="status"></label>
	  <textarea id="sqlTemp" cols="200" rows="20"></textarea>
	</form>
</div>

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script>
$(function() {
	$('#createdb').submit(function(e){
		dbPrefix = $("#"+e.currentTarget.dbPrefix.id).val();
		dbUser = $("#"+e.currentTarget.dbUser.id).val();
		dbPassword = $("#"+e.currentTarget.dbPassword.id).val();
		dbName = $("#"+e.currentTarget.dbName.id).val();
		dbHost = $("#"+e.currentTarget.dbHost.id).val();
		dbPort = $("#"+e.currentTarget.dbPort.id).val();
		dbEncoding = $("#"+e.currentTarget.dbEncoding.id).val();

		$.post("<? echo $GLOBALS['urlCore']; ?>/controller/setupDatabase.php", {
			'dbPrefix' : dbPrefix,
			'dbUser' : dbUser,
			'dbPassword' : dbPassword,
			'dbName' : dbName,
			'dbHost' : dbHost,
			'dbPort' : dbPort,
			'dbEncoding' : dbEncoding
		}).done(function(data){
			$('#sqlTemp').val(data);
		});
		e.preventDefault();
	});
});
</script>