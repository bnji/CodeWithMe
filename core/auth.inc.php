<?php
function isUserLoggedIn() {
	$account = DB::queryFirstRow("SELECT Id, Status FROM CWM_User WHERE Id=%?", $_COOKIE['uid']);
	$uidHashFromServer = sha1($account['Id']);
	$uidHashCookie = $_COOKIE['uidHash'];

	return (isset($uidHashCookie) &&
			$uidHashFromServer == $uidHashCookie &&
			!is_null($account) &&
			$account['Status'] == 1
			);
}

function redirect($redirectUrl) {
	header("Location: " . $redirectUrl);
}

function authenticate($redirectUrl) {
	if(isUserLoggedIn())
	{
		#redirect($redirectUrl);
	}
	else {
		redirect('./');
	}
}
?>