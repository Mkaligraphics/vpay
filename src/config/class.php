<?php



class modules extends dbase

{
	
//Keeep the user logged in;
function loggedin(){
if (isset($_SESSION['id']) && !empty($_SESSION['id'])){
	return true ;
		} else {
			return false ;
		}
}

	//getting users fields
function getfield($fields){
	$result = $this->con->query ("SELECT $fields FROM users  WHERE users.id = '".$_SESSION['id']."' ") ;
	   $counts =  $result ->num_rows;
	   if ($counts > 0){
	   	while ($rw = mysqli_fetch_assoc($result)){
	  return $rw[$fields];
	   	}
   }
}

//Totalizer
 function totals($table){
	$result = $this->con->query ("select count(id) from $table where active = '1' ") ;
	  	while ($rw = mysqli_fetch_array($result)){
	   	return $rw[0] > 0 || $rw[0] !== null ? $rw[0]:0;	 
	} }
 //end

}


?>