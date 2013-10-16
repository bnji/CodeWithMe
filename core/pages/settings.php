<?php
if(!isUserLoggedIn())
{
  redirect('logout');
}
require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>

<?php require_once $GLOBALS['dirCore'].'/view/standard/navbarSignedIn.inc.php'; ?>

<div class="container">
<h1>Settings</h1>

</div>

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script>
$(function(){


});
</script>