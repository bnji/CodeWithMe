<?php
abstract class Object
{
    public function GetAsJson() {
		header('content-type: application/json; charset=utf-8');
		return json_encode($this);
    }
}
?>