<?php
require_once 'core/common.inc.php';
require_once $GLOBALS['dirCore'].'/auth.inc.php';

class CWM_API {

	public static function getUserId($tokenValue) {
		$result = DB::queryOneField('UserId', 'SELECT * FROM CWM_ApiKeySession as aks JOIN CWM_UserApiKey as uak ON aks.ApiKeyId = uak.ApiKeyId WHERE TokenValue=%?', $tokenValue);
		if(!$result) {
			return -1;
		}
		return $result;
	}

	public static function generate($_asJson = true) {
		$result = array();
		$publicKey = sha1(mt_rand_str(40));
		$privateKey = sha1(mt_rand_str(40));
		#if(CWM_API::IsTokenValid($tokenValue)) {
		if(isUserLoggedIn()) {
			$result = array('public' => $publicKey, 'private' => $privateKey);
		}
		if($_asJson) {
			$result = CWM_API::getAsJson($result);
		}
		return $result;
	}

	public static function authorize($data, $publicApiKey, $hash)
	{
    	$newToken = "";
		$row = DB::queryFirstRow("SELECT * FROM CWM_ApiKey as ak JOIN CWM_UserApiKey uak ON ak.Id = uak.ApiKeyId WHERE PublicKey=%s", $publicApiKey);
		if(!is_null($row) && strlen(trim($publicApiKey)) > 0) {
			$userId = $row['UserId'];
			$privateApiKey = $row['PrivateKey'];
			$apiKeyIndex = $row['Id'];
	    	$hashCheck = sha1($data . $privateApiKey . $publicApiKey);
	    	$result = $hashCheck == $hash;
	    	if($result) {
				$oldToken = DB::queryOneField('TokenValue', 'SELECT * FROM CWM_ApiKeySession WHERE UserId=%?', $userId);
				if(!CWM_API::isTokenValid($oldToken))
				{
					$newToken = sha1($userId . $privateApiKey . $hashCheck . CWM_API::getDateTime(time()));
					DB::insertUpdate('CWM_ApiKeySession', array(
					  'ApiKeyId' => $apiKeyIndex,
					  'LastAccess' => CWM_API::getDateTime(time()),
					  'UserId' => $userId,
					  'TokenValue' => $newToken
					  ));
				}
				else {
					$newToken = $oldToken;
				}
	    	}
	    }
    	return $newToken;
	}

	public static function deAuthorize($tokenValue) {
		return CWM_API::resetToken("P1D", $tokenValue);
	}

	public static function isTokenValid($newTokenValue) {
		$datetimeValid = "P1D"; // valid for 1 day
		$result = false;
		$lastAccess = CWM_API::getDateTime(strtotime(DB::queryOneField('LastAccess', 'SELECT * FROM CWM_ApiKeySession WHERE TokenValue=%?', $newTokenValue)));
		$lastAccess = new DateTime($lastAccess);
		$lastAccess->add(new DateInterval($datetimeValid));
		$result = new DateTime(CWM_API::getDateTime(time())) < $lastAccess;
		// if not valid, update the date to be in the past
		if(!$result) {
			CWM_API::resetToken($datetimeValid, $newTokenValue);
		}
		return $result;
	}

	private static function resetToken($datetimeValid, $tokenValue) {
		$dateInPast = new DateTime(CWM_API::getDateTime(time()));
		$dateInPast->sub(new DateInterval($datetimeValid));
		return DB::update('CWM_ApiKeySession', array('LastAccess' => $dateInPast, 'TokenValue' => ''), "TokenValue=%?", $tokenValue);
	}

	private static function getDateTime($time) {
		return date("Y-m-d H:i:s", $time);
	}

    public static function getAsJson($data)
    {
        header('content-type: application/json; charset=utf-8');
        return json_encode($data);
    }
}
?>