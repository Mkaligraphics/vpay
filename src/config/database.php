<?php
date_default_timezone_set('Africa/Nairobi');
class dbase{
public $con;
	public function __construct(){$this->con = new mysqli('localhost','root','','vpay');
		if (!$this->con){
			die('We could not connect to database') ;
		}
	}

}

?>
