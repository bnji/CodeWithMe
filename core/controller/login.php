<?php
session_start();
require_once '../dirHandler.php';
$f3=require($GLOBALS['dirLibs'].'/external/fatfree/lib/base.php');
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
require_once $GLOBALS['dirCore'].'/config.inc.php';
require_once $GLOBALS['dirCore'].'/common.inc.php';
#echo $GLOBALS['dirRoot'];
$uid = "";
$email = $_POST['email'];
$rememberMe = $_POST['rememberMe'] == 1;
$emailHash = sha1($email);
$hash = $_POST['hash'];
$account = DB::queryFirstRow("SELECT * FROM CWM_User WHERE Email=%?", $email);
$isNewuser = true;
$isVerified = false;
$isEmailValid = verifyEmail($email);
$isFirstTime = 1;
if($isEmailValid) {
	// No user found
	if(is_null($account))
	{
		DB::insert('CWM_User', array(
			'Id' => 0, // auto increment
			'Email' => $email,
			'EmailHash' => $emailHash,
			'Password' => $hash,
			'Status' => 0,
			'IsFirstTime' => $isFirstTime
		));
		$uid = DB::insertId();

		$subject = "Welcome to CodeWithMe";
		$message = "
		<html>
		<head>
		  <title>Welcome to CodeWithMe</title>
		</head>
		<body>
		  Thank you for signing up on CodeWithMe!
		  <br />
		  Please <a href='" . $activationUrl . $emailHash . "'>activate your account</a>
		</body>
		</html>
		";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . '\r\n';
		sendEmail($email, $subject, $message, $headers);
	}
	else {
		$account = DB::queryFirstRow("SELECT * FROM CWM_User WHERE Email=%? AND Password=%?", $email, $hash);
		$uid = $account['Id'];
		$isVerified = intval($account['Status']);
		$isNewuser = false;
		$isFirstTime = $account['IsFirstTime'];
	}
	$uidHash = sha1($uid);

	$expire = time()+$cookie_expire;
	#bool setcookie ( string $name [, string $value [, int $expire = 0 [, string $path [, string $domain [, bool $secure = false [, bool $httponly = false ]]]]]] )
	//setcookie("uid", sha1($uid), $expire, "/", $_SERVER['HTTP_HOST'], false, true);
	if($rememberMe) {
		$cookieTime = time()+3600;
		setcookie("uid", $uid, $cookieTime, "/");
		setcookie("uidHash", $uidHash, $cookieTime, "/");
	}
	else {
		$_SESSION["uid"] = $uid;
		$_SESSION["uidHash"] = $uidHash;
  		$_SESSION["timeout"] = time();
	}
	#$f3->sync('SESSION');
	#$f3->sync('COOKIE');
}
$resultData = array('uid' => $uid, 'uidHash' => $uidHash, 'email' => $email, 'isNew' => $isNewuser, 'isVerified' => $isVerified, 'isEmailValid' => $isEmailValid, 'isFirstTime' => $isFirstTime);
echo json_encode($resultData);
?>