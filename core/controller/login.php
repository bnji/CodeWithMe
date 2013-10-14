<?php
require_once '../dirHandler.php';
require_once $GLOBALS['dirLibs'].'/external/meekrodb.2.2.class.php';
require_once $GLOBALS['dirCore'].'/dbConfig.inc.php';
require_once $GLOBALS['dirCore'].'/config.inc.php';
require_once $GLOBALS['dirCore'].'/common.inc.php';
#echo $GLOBALS['dirRoot'];
$uid = "";
$email = $_POST['email'];
$emailHash = sha1($email);
$hash = $_POST['hash'];
$account = DB::queryFirstRow("SELECT * FROM CWM_User WHERE Email=%?", $email);
$isNewuser = true;
$isVerified = false;
$isEmailValid = verifyEmail($email);
if($isEmailValid) {
	// No user found
	if(is_null($account))
	{
		DB::insert('CWM_User', array(
			'Id' => 0, // auto increment
			'Email' => $email,
			'EmailHash' => $emailHash,
			'Password' => $hash,
			'Status' => 0
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
	}
	$expire = time()+$cookie_expire;
	#bool setcookie ( string $name [, string $value [, int $expire = 0 [, string $path [, string $domain [, bool $secure = false [, bool $httponly = false ]]]]]] )
	//setcookie("uid", sha1($uid), $expire, "/", $_SERVER['HTTP_HOST'], false, true);
	setcookie("uid", $uid, time()+3600, "/");
	setcookie("uidHash", sha1($uid), time()+3600, "/");
}
$resultData = array('uid' => $uid, 'email' => $email, 'isNew' => $isNewuser, 'isVerified' => $isVerified, 'isEmailValid' => $isEmailValid);
echo json_encode($resultData);
?>