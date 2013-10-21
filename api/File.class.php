<?php
class CWM_File extends Object
{
    var $ID;
    var $ProjectId;
    var $Name;
    var $Data;
    var $UserId;
    var $SolutionName;
    var $ProjectName;
    var $ShareId;

    public function __construct($_id, $_projectId, $_name, $_data, $_userId, $_solutionName, $_projectName, $_shareId) {
    	$this->ID = $_id;
    	$this->ProjectId = $_projectId;
    	$this->Name = $_name;
    	$this->Data = $_data;
    	$this->UserId = $_userId;
    	$this->SolutionName = $_solutionName;
    	$this->ProjectName = $_projectName;
        $this->ShareId = $_shareId;
    }

    /**
     * Inserts information about a file into the DB and assigns the new ID to the object.
     * @return [type]
     */
    public function create() {
    	DB::insert('CWM_File', array(
    		'ProjectId' => $this->ProjectId,
		  	'Name' => $this->Name,
		  	'Data' => $this->Data,
		  	'UserId' => $this->UserId,
		  	'SolutionName' => $this->SolutionName,
		  	'ProjectName' => $this->ProjectName,
            'ShareId' => null
		));
		// Update the file info with the new file ID
		$this->ID = DB::insertId();
    }

    /**
     * Returns a list of file belonging to the given project
     * @param  [int] $projectId
     * @param  [string] $tokenValue
     * @return [array] List of files
     */
    public static function getList($projectId, $tokenValue) {
        $list = array();
        if(CWM_API::IsTokenValid($tokenValue)) {
            $userId = CWM_API::GetUserId($tokenValue);
            $results = DB::query("SELECT * FROM CWM_File WHERE ProjectId=%?", $projectId);
            foreach ($results as $row) {
                array_push($list, new CWM_File($row['Id'], $row['ProjectId'], $row['Name'], $row['Data'], $row['UserId'], $row['SolutionName'], $row['ProjectName']));
            }
        }
        return $list;
    }

    /**
     * Get a file
     * @param  [type] $tokenValue [description]
     * @param  [type] $fileId     [description]
     * @return [type]             [description]
     */
    public static function get($fileId, $tokenValue)
    {
        $file = null;
        if(CWM_API::IsTokenValid($tokenValue)) {
            //$userId = CWM_API::GetUserId($tokenValue);
            $row = DB::queryOneRow("SELECT * FROM CWM_File WHERE Id=%?", $fileId);
            if(!is_null($row)) {
                $file = new CWM_File($row['Id'], $row['ProjectId'], $row['Name'], $row['Data'], $row['UserId'], $row['SolutionName'], $row['ProjectName'], $row['ShareId']);
            }
        }
        return $file;
    }

    public static function getByProjectIdFileName($projectId, $fileName, $tokenValue)
    {
        $file = null;
        if(CWM_API::IsTokenValid($tokenValue)) {
            //$userId = CWM_API::GetUserId($tokenValue);
            $row = DB::queryOneRow("SELECT * FROM CWM_File WHERE ProjectId=%? AND Name=%?", $projectId, $fileName);
            if(!is_null($row)) {
                $file = new CWM_File($row['Id'], $row['ProjectId'], $row['Name'], $row['Data'], $row['UserId'], $row['SolutionName'], $row['ProjectName'], $row['ShareId']);
            }
        }
        return $file;
    }

    /**
     * Deletes a file
     * @param  [int] $fileId
     * @param  [string] $tokenValue
     * @return [int] -1 if invalid token, 1 if valid token and file was removed, 0, if valid token, but file doesn't exist
     */
    public static function delete($fileId, $tokenValue) {
        $result = -1;
        if(CWM_API::IsTokenValid($tokenValue)) {
            DB::delete('CWM_File', "Id=%?", $fileId);
            $result = DB::affectedRows();
        }
        return $result;
    }

    /**
     * Updates a file
     * @param  [int] $fileId File ID
     * @param  [int] $name File name
     * @param  [int] $data File data
     * @param  [string] $tokenValue
     * @return [int] -1 if invalid token, 1 if valid token and file was updated, 0, if valid token, but file content was same (no update performed)
     */
    public static function update($id, $name, $data, $tokenValue) {
        $result = -1;
        if(CWM_API::IsTokenValid($tokenValue)) {
            DB::update('CWM_File', array(
                'Name' => $name,
                'Data' => $data
            ), "Id=%?", $id);
            $result = DB::affectedRows();
        }
        return $result;
    }
}
?>