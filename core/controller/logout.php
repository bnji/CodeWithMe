<?php
session_start();
require_once '../../core/dirHandler.php';
setcookie("uid", "", time() - 3600, "/");
setcookie("uidHash", "", time() - 3600, "/");

session_destroy();
?>
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="../../libs/external/jQuery-Storage/jquery.storageapi.min.js"></script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha1.js"></script>
<script src="../../libs/internal/common.js"></script>
<script>
$(function() {
	CWMCommon.SignOut('<?php echo $GLOBALS[urlRoot]; ?>');
});
</script>