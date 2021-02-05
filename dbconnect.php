<?php
class dbconnect
{

private $dbConn;

private $ds;

function __construct()
{
		require_once "DataSource.php";
        $this->ds = new DataSource();
}
public function getproductData()
{
	$query="SELECT * FROM tblproduct ORDER BY id ASC";
    $productResult = $this->ds->select($query);
    return $productResult;
	
}
public function getproductDatabycode($code)
{
	$query="SELECT * FROM tblproduct WHERE code= ?";
    $paramType = "s";
    $paramArray = array($code);
    $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
   	return $memberResult;
	
}
public function getproductDatabyid($productid)
{
	$query="SELECT * FROM tblproduct WHERE id= ?";
    $paramType = "i";
    $paramArray = array($productid);
    $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
   	return $memberResult;
	
}
public function getMemberById($memberId)
    {
    	$query = "select * FROM registered_users WHERE id = ?";
        $paramType = "i";
        $paramArray = array($memberId);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
        return $memberResult;
    }
public function processLogin($username,$password){
		$passwordHash = md5($password);
        $query = "select * FROM registered_users WHERE user_name = ? AND password = ?";
        $paramType = "ss";
        $paramArray = array($username, $passwordHash);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        if(!empty($memberResult)) {
            $_SESSION["userId"] = $memberResult[0]["id"];
            return true;
        }
}
public function addtoCart($quantity,$userid,$productid)
{
	$query="INSERT INTO `customer_cart` (`customer_id`, `product_id`, `quantity`, `time`) VALUES
(?, ?, ? , ?);";
    $paramType = "iiis";
    $date=date("Y-m-d");
    $paramArray = array($userid,$productid,$quantity,$date);
    $Result = $this->ds->insert($query, $paramType, $paramArray);
        
   	return $Result;
	
}
public function getcartitem($userId)
{
	$query="SELECT * FROM customer_cart WHERE customer_id= ?";
    $paramType = "i";
    $paramArray = array($userId);
    $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
   	return $memberResult;
	
}
public function checkalreadyexist($userId,$productId)
{
	$query="SELECT * FROM customer_cart WHERE customer_id= ? AND product_id =?";
    $paramType = "ii";
    $paramArray = array($userId,$productId);
    $memberResult = $this->ds->select($query, $paramType, $paramArray);
    return $memberResult;
	
}
public function updateCart($oldqty,$newqty,$userId,$productId)
{
	if(empty($oldqty)){
		$totalqty=$newqty;
	}
	else{
		$totalqty=$oldqty+$newqty;
	}
	
	$query="Update customer_cart set quantity= ? WHERE customer_id= ? AND product_id =?";
    $paramType = "iii";
    $paramArray = array($totalqty,$userId,$productId);
    $memberResult = $this->ds->update($query, $paramType, $paramArray);
    return $memberResult;
	
}

public function removeItem($userId,$productId)
{
	$totalqty=$oldqty+$newqty;
	$query="DELETE FROM customer_cart WHERE customer_id=? AND product_id=?";
    $paramType = "ii";
    $paramArray = array($userId,$productId);
    $memberResult = $this->ds->delete($query, $paramType, $paramArray);
    return $memberResult;
	
}
}