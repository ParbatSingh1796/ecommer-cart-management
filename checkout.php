<?php
	session_start();
	if(isset($_SESSION["cart-item"])){
		header("location:index.php?sessiontimeout=true");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
	<link rel="stylesheet" href="web/css/checkout-styles.css">
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
	<div class="container" style="margin-top: 20px;margin-bottom: 20px;">
<div class="row">
  <div class="col-50">
    <div class="container">
      <form action="payment.php" method="post">

        <div class="row">
          <div class="col-100">
            <h3>Shipping Address</h3>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label><br>
            <input type="text" id="fname" name="firstname" placeholder="Mohit Sharma" required="required"><br>
            <label for="email"><i class="fa fa-envelope" ></i> Email</label><br>
            <input type="text" id="email" name="email" placeholder="mohit@example.com" required="required"><br>
            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label><br>
            <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" required="required"><br>
            <label for="city"><i class="fa fa-institution"></i> City</label><br>
            <input type="text" id="city" name="city" placeholder="Jodhpur" required="required"><br>
            <label for="state">State</label><br>
            <input type="text" id="state" name="state" placeholder="Rajasthan" required="required"><br>
            <label for="zip">Zip</label><br>
            <input type="text" id="zip" name="zip" placeholder="342303" required="required"><br>
              
            
          </div>

          

        </div>
        
        <input type="submit" value="Continue to checkout" class="btn">
      </form>
    </div>
  </div>

  <div class="col-50">
    <div class="container">
      <h4>Cart
        
      </h4>
      <table border="1">
      	<tr>
      		<th style="text-align: left;">Product Name</th>
      		<th style="text-align: right;">Quantity</th>
      		<th style="text-align: right;">Unit Price</th>
      		<th style="text-align: right">Price</th>
      	</tr>
      	<?php
      	require_once 'dbconnect.php';
    	$dbconnect=new dbconnect();	
      	$total_quantity=0;
      	$total_price=0;	
    foreach ($_SESSION["cart_item"] as $item){
    	//check if price changed or product exist or not
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
				<td style="text-align:left;"><?php echo $item["name"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td style="text-align:right;"><?php echo "&#x20B9; ".$item["price"]; ?></td>
				<td style="text-align:right;"><?php echo "&#x20B9; ". number_format($item_price,2); ?></td>
			</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
	}
		?>

		<tr>
		<td align="right">Total:</td>
		<td align="right"><?php echo $total_quantity; ?></td>

		<td align="right" colspan="2"><strong><?php echo "&#x20B9; ".number_format($total_price, 2); ?></strong></td>
		
	</tr>
      </table>
      
      
    </div>
  </div>
</div>
</div>
</body>
</html>