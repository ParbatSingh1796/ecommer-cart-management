<?php
// Start the session
session_start();
require_once 'dbconnect.php';
$dbconnect=new dbconnect();
switch($_GET["action"]){	
case "add":
	if(! empty($_SESSION["userId"])){
		$productresult = $dbconnect->getproductDatabycode($_GET["code"]);
		$isexist=$dbconnect->checkalreadyexist($_SESSION["userId"],$productresult[0]["id"]);
		
		if(empty($isexist)){
			$result = $dbconnect->addtoCart($_POST["quantity"],$_SESSION["userId"],$productresult[0]["id"]);
			
		}
		else{
			
			$result = $dbconnect->updateCart($isexist[0]["quantity"],$_POST["quantity"],$_SESSION["userId"],$productresult[0]["id"]);
			
		}
		

	}
	else{
	if(!empty($_POST["quantity"])) {
		
		$result = $dbconnect->getproductDatabycode($_GET["code"]);
		//$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
		
		
		$itemArray = array($result[0]["code"]=>array('name'=>$result[0]["name"], 'code'=>$result[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$result[0]["price"], 'image'=>$result[0]["image"]));
		//echo $row["name"];
		if(!empty($_SESSION["cart_item"])) {
			if(in_array($result["code"],array_keys($_SESSION["cart_item"]))) {
				foreach($_SESSION["cart_item"] as $k => $v) {
						if($result["code"] == $k) {
							if(empty($_SESSION["cart_item"][$k]["quantity"])) {
								$_SESSION["cart_item"][$k]["quantity"] = 0;
							}
							$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
						}
				}
			} else {
				$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
			}
		} else {
			
			$_SESSION["cart_item"] = $itemArray;
		}
	}
}
	header("location:mycart.php?add=success");
	break;
case "remove":
	if(! empty($_SESSION["userId"])){
		$productremoveresult = $dbconnect->getproductDatabycode($_GET["code"]);
		$finalresult = $dbconnect->removeItem($_SESSION["userId"],$productremoveresult[0]["id"]);
	}
	else{
	if(!empty($_SESSION["cart_item"])) {
		foreach($_SESSION["cart_item"] as $k => $v) {
			if($_GET["code"] == $k)
				unset($_SESSION["cart_item"][$k]);				
			if(empty($_SESSION["cart_item"]))
				unset($_SESSION["cart_item"]);
		}
	}
}
	header("location:mycart.php?remove=success");
	break;
case "update":
	if($_POST["quantity"] == 0){
		header("location:mycart.php?update=error");
		break;
	}
	if(! empty($_SESSION["userId"])){
		$oldqty="";
		$productupdateresult = $dbconnect->getproductDatabycode($_GET["code"]);
		$result = $dbconnect->updateCart($oldqty,$_POST["quantity"],$_SESSION["userId"],$productupdateresult[0]["id"]);
	}
	else{
	if(!empty($_SESSION["cart_item"])) {
		if(in_array($_GET["code"],array_keys($_SESSION["cart_item"]))) {
			foreach($_SESSION["cart_item"] as $k => $v) {
				if($_GET["code"] == $k) {
					if(empty($_SESSION["cart_item"][$k]["quantity"])) {
						$_SESSION["cart_item"][$k]["quantity"] = 0;
					}
					$_SESSION["cart_item"][$k]["quantity"]=$_POST["quantity"];
				}
			}
		}
	}
}
	header("location:mycart.php?update=success");
    break;
case "empty":
	unset($_SESSION["cart_item"]);
	header("location:index.php");
    break;	
}

?>