<?php
function getUserId() {
	$userId = -1;
	if($_SESSION && isset($_SESSION["uid"])) {
		$userId = $_SESSION["uid"];
	}
	if($_COOKIE && isset($_COOKIE["uid"])) {
		$userId = $_COOKIE["uid"];
	}
	return $userId;
}

function getUserIdHash() {
	$uidHash = -1;
	if($_SESSION && isset($_SESSION["uidHash"])) {
		$uidHash = $_SESSION["uidHash"];
	}
	if($_COOKIE && isset($_COOKIE["uidHash"])) {
		$uidHash = $_COOKIE["uidHash"];
	}
	return $uidHash;
}

function isUserLoggedIn() {
	$userId = getUserId();
	if($userId != -1) {
		$account = DB::queryFirstRow("SELECT Id, Status FROM CWM_User WHERE Id=%?", $userId);
		$uidHashFromServer = sha1($account['Id']);
		$uidHash = getUserIdHash();

		return (isset($uidHash) &&
				$uidHashFromServer == $uidHash &&
				!is_null($account) &&
				$account['Status'] == 1
				);
	}
	return false;
}

function checkSession() {
	if(is_null($_COOKIE['uid']) || $_SESSION['timeout'] + 1 * 60 < time()) {
		redirect($GLOBALS['urlRoot']."/logout");
	}
}

function redirect($redirectUrl) {
	header("Location: " . $redirectUrl);
}

function authenticateUser($redirectUrl) {
	checkSession();
	if(!isUserLoggedIn())
	{
		redirect($redirectUrl);
	}
}
?>