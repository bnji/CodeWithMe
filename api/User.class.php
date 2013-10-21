<?php
class CWM_User extends Object
{
	var $ID;
	var $Email;
	var $EmailHash;
	var $Password;
	var $Status;
	var $IsFirstTime;

	public function __construct($_id, $_email, $_emailHash, $_password, $_status, $_isFirstTime) {
		$this->ID = $_id;
		$this->Email = $_email;
		$this->EmailHash = $_emailHash;
		$this->Password = $_password;
		$this->Status = $_status;
		$this->IsFirstTime = $_isFirstTime;
	}

	public static function getFromToken($tokenValue) {
		$user = null;
   		if(CWM_API::IsTokenValid($tokenValue)) {
	   		$row = DB::queryFirstRow("SELECT * FROM CWM_User as u JOIN CWM_ApiKeySession as aks ON u.Id = aks.UserId WHERE aks.TokenValue=%?", $tokenValue);
	   		if(!is_null($row)) {
	   			$status = $row['Status'] == '1' ? true : false;
	   			$isFirstTime = $row['IsFirstTime'] == '1' ? true : false;
	   			$user = new CWM_User($row['UserId'], $row['Email'], "", "", $status, $isFirstTime);
	   		}
	   	}
	   	return $user;
	}
}
?>