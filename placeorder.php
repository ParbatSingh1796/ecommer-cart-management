<?php
	session_start();
	if(isset($_SESSION["cart-item"])){
		header("location:index.php?sessiontimeout=true");
	}
	else{
		$total_quantity=0;
		$total_price=0;
		foreach ($_SESSION["cart_item"] as $item){
			        $item_price = $item["quantity"]*$item["price"];
					echo $item["name"];
					echo $item["code"]; 
					echo $item["quantity"]; 
					echo $item["price"]; 
					echo number_format($item_price,2);
					echo "<br>";
					$total_quantity += $item["quantity"];
					$total_price += ($item["price"]*$item["quantity"]);
				}
			echo "<br>";
			echo $total_quantity;
			echo $total_price;
	}
?>