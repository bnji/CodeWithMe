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

<?php require_once $GLOBALS['dirCore'].'/view/standard/navbarSignedIn.inc.php'; ?>

<h1>Settings</h1>



<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script>
$(function(){


});
</script>