<?php
class CWM_Solution extends Object
{
	var $ID;
	var $UserId;
	var $Name;

	public function __construct($_id, $_userId, $_name) {
       $this->ID = $_id;
       $this->UserId = $_userId;
       $this->Name = $_name;
   	}

   	public static function get($_name, $tokenValue) {
   		$solution = null;
   		if(CWM_API::IsTokenValid($tokenValue)) {
	   		$userId = CWM_API::GetUserId($tokenValue);
	   		$row = DB::queryFirstRow("SELECT * FROM CWM_Solution WHERE UserId=%? AND Name=%?", $userId, $_name);
	   		if(!is_null($row)) {
	   			$solution = new CWM_Solution($row['Id'], $row['UserId'], $row['Name']);
	   		}
	   	}
	   	return $solution;
   	}

	public function create()
	{
		DB::insert('CWM_Solution', array(
		  'UserId' => $this->UserId,
		  'Name' => $this->Name
		));
		$this->ID = DB::insertId();
		return $this->ID;
	}

	public static function getList($tokenValue) {
		$list = array();
        #$userId = DB::queryOneField("Id", "SELECT * FROM CWM_ApiKeySession aks JOIN CWM_User as u ON aks.UserId = u.Id WHERE TokenValue=%?", $tokenValue);
		if(CWM_API::IsTokenValid($tokenValue)) {
			$userId = CWM_API::GetUserId($tokenValue);
			$results = DB::query("SELECT * FROM CWM_Solution WHERE UserId=%?", $userId);
        	foreach ($results as $row) {
	            array_push($list, new CWM_Solution($row['Id'], $row['UserId'], $row['Name']));
	        }
	    }
        return $list;
	}

	public function getId()
    {
        return DB::queryOneField("Id", "SELECT * FROM CWM_Solution WHERE UserId=%? AND Name=%?", $this->UserId, $this->Name);
    }

    /**
     * Adds a project to the solution
     * @param [int] $solutionId
     * @param [int] $projectId
     * @param [string] $tokenValue
     * @return [int] Returns -1 if invalid token, 1 if valid token and project was added to the solution, 0 if valid token, but project is already connected the solution
     */
    public static function addProject($solutionId, $projectId, $tokenValue) {
    	$result = -1;
   		if(CWM_API::IsTokenValid($tokenValue)) {
   			$row = DB::queryFirstRow("SELECT * FROM CWM_SolutionProject WHERE SolutionId=%? AND ProjectId=%?", $solutionId, $projectId);
   			$result = is_null($row) == true ? 1 : 0;
	   		if($result) {
	   			$result = DB::insert('CWM_SolutionProject', array(
				  'SolutionId' => $solutionId,
				  'ProjectId' => $projectId
				));
	   		}
	   	}
	   	return $result;
   	}
}
?>