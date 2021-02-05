<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
	<div id="shopping-cart">
<div class="txt-heading">Shopping Cart</div>

<a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>
<?php
session_start();
$total_quantity = 0;
$total_price = 0;
$items="";
if(! empty($_SESSION["userId"])){
	
	require_once 'dbconnect.php';
	$dbconnect=new dbconnect();

	$result=$dbconnect->getcartitem($_SESSION["userId"]);
	$size=count($result);
	for($i=0; $i<$size; $i++){
		$productdata=$dbconnect->getproductDatabyid($result[$i]["product_id"]);
		$itemArray = array($productdata[0]["code"]=>array('name'=>$productdata[0]["name"], 'code'=>$productdata[0]["code"], 'quantity'=>$result[$i]["quantity"], 'price'=>$productdata[0]["price"], 'image'=>$productdata[0]["image"]));
		if(empty($items)){
			$items=$itemArray;
		}
		else{
			$items=array_merge($items,$itemArray);
		}
	}
	
}
else{
	if(isset($_SESSION["cart_item"])){
    	$items=$_SESSION["cart_item"];
	}
}
	
if(! empty($items)){
?>
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
<th style="text-align:center;" width="5%">Update</th>
</tr>	
<?php	
require_once 'dbconnect.php';
	
$dbconnect=new dbconnect();
    foreach ($items as $item){
    	$result=$dbconnect->getproductDatabycode($item["code"]);
    	if(empty($result)){
    		$k=$item["code"];
    		unset($_SESSION["cart_item"][$k]);
    		if(empty($_SESSION["cart_item"]))
				unset($_SESSION["cart_item"]);
    		?>
    		<tr>
				<td style="text-align:left;" colspan="4">Product does not exist.</td>
			</tr>
			<?php
    	}
    	else{
    	if($item["price"] != $result[0]["price"]){
    		$item["price"]=$result[0]["price"];
    		$k=$item["code"];
    		$_SESSION["cart_item"][$k]["price"] = $result[0]["price"];
    	}
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
				<td><?php echo $item["code"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "&#x20B9; ".$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "&#x20B9; ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="cartaction.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction">Remove</a></td>
				<td style="text-align:center;"><form method="post" action="cartaction.php?action=update&code=<?php echo $item["code"]; ?>"><input type="text" name="quantity" value="<?php echo $item["quantity"]; ?>" size="2"><input type="submit" value="Update" class="btnAddAction" /></form></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
	}
		?>
		<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "&#x20B9; ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>
<button type="button" onclick="document.location='checkout.php'" target="checkout.php">Proceed to checkout</button>
<?php
	}
		



		
  
if(empty($items)){
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
</div>

</body>
</html>