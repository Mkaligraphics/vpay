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
	$result = $this->con->query ("select count(id) from $table where status = 'active' ") ;
	  	while ($rw = mysqli_fetch_array($result)){
		return $rw[0] > 0 || $rw[0] !== null ? $rw[0]:0;
	} }
 //end

 //Totalizer
function units_status($status){

    $status = $this->con->real_escape_string($status);

    $result = $this->con->query("
        SELECT COUNT(id) as total
        FROM property_units
        WHERE status = '$status' AND active = '1'
    ");

    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}


function expected_revenue($month = null){

    if(!$month){
        $month = date('Y-m');
    }

    $result = $this->con->query("
        SELECT SUM(ti.amount) as total
        FROM tenant_info ti
        WHERE ti.active = 1
    ");

    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}

function collected_revenue($month = null){

    if(!$month){
        $month = date('Y-m');
    }

    // create start & end of month
    $start = $month . "-01";
    $end   = date("Y-m-t", strtotime($start));

    $stmt = $this->con->prepare("
        SELECT SUM(amount) as total
        FROM payments
        WHERE payment_for BETWEEN ? AND ?
    ");

    $stmt->bind_param("ss", $start, $end);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'] ?? 0;
}


function pending_cash($month = null){

    $expected = $this->expected_revenue($month);
    $paid = $this->collected_revenue($month);

    return $expected - $paid;
}


}


?>
