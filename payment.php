<?php
	session_start();
	
	if(isset($_SESSION["cart-item"])){
		header("location:index.php?sessiontimeout=true");
	}	
	$total_quantity=0;
	$total_price=0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add payment method</title>
	<title></title>
	<link rel="stylesheet" href="web/css/payment-styles.css">
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
	<div class="continer" style="margin-right: 20px;margin-left: 20px;margin-top: 20px;margin-bottom: 20px;">
		<div class="row">
  			<div class="col-50">
    			<div class="container">
      				<form action="placeorder.php" onsubmit="return checkRegistration()">

				        <div class="row">
					        <div class="col-50">
					            <h3>Billing Address</h3>
					            <label for="fname"><i class="fa fa-user"></i> Full Name</label><br>
					            <input type="text" id="fname" name="firstname" placeholder="John M. Doe" required="required"><br>
					            <label for="email"><i class="fa fa-envelope"></i> Email</label><br>
					            <input type="text" id="email" name="email" placeholder="john@example.com" required="required"><br>
					            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label><br>
					            <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" required="required"><br>
					            <label for="city"><i class="fa fa-institution"></i> City</label><br>
					            <input type="text" id="city" name="city" placeholder="New York" required="required"><br>

					            <div class="row">
					              <div class="col-50">
					                <label for="state">State</label><br>
					                <input type="text" id="state" name="state" placeholder="NY" required="required"><br>
					              </div>
					              <div class="col-50">
					                <label for="zip">Zip</label><br>
					                <input type="text" id="zip" name="zip" placeholder="10001" required="required">
					              </div>
					            </div>
					        </div>

					        <div class="col-50">
					            <h3>Payment Method</h3>
					            <input type="radio" id="cod" name="payment-method" value="1" onclick="handlecod();" checked="checked">
								<label for="cod">Cash on delivery</label><br>
								<input type="radio" id="card" name="payment-method" value="0" onclick="handlecards();">
								<label for="card" >Credit/Debit card</label><br>
								

					            <div id="payment-card" style="display: none;">
						            <label for="fname">Accepted Cards</label>
						            <div class="icon-container">
						              <i class="fa fa-cc-visa" style="color:navy;"></i>
						              <i class="fa fa-cc-amex" style="color:blue;"></i>
						              <i class="fa fa-cc-mastercard" style="color:red;"></i>
						              <i class="fa fa-cc-discover" style="color:orange;"></i>
						            </div>
						            <label for="cname">Name on Card</label><br>
						            <input type="text" id="cname" name="cardname" placeholder="John More Doe"><br>
						            <label for="ccnum">Credit/Debit card number</label><br>
						            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444"><br>
						            <label for="expmonth">Exp Month</label><br>
						            <input type="text" id="expmonth" name="expmonth" placeholder="September" ><br>

						            <div class="row">
						              <div class="col-50">
						                <label for="expyear">Exp Year</label><br>
						                <input type="text" id="expyear" name="expyear" placeholder="2018" ><br>
						              </div>
						              <div class="col-50">
						                <label for="cvv">CVV</label><br>
						                <input type="text" id="cvv" name="cvv" placeholder="352" >
						              </div>
						            </div>
					        	</div>
      						</div>
        				</div>
				        <label>
				        <input type="checkbox" id="sameasshipping" onclick="setBillingaddress()" name="sameadr"> Billing address same as shipping address
				        </label>
        				<input type="submit" value="Continue to checkout" class="btn">
      				</form>
    			</div>
  			</div>

		  <div class="col-50s">
		    <div class="container">
		      <h4>Cart</h4>
		      <table border="1">
		      	<tr>
		      		<th style="text-align: left;">Product Name</th>
		      		<th style="text-align: right;">Quantity</th>
		      		<th style="text-align: right;">Unit Price</th>
		      		<th style="text-align: right">Price</th>
		      	</tr>
		      	<?php
		      		
			    foreach ($_SESSION["cart_item"] as $item){
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
<script type="text/javascript">
	function checkRegistration(){
		var radio= document.getElementById("card");
        if(radio.checked == true){
        	var cardname  =document.getElementById("cname").value;
        	var cardnumber=document.getElementById("ccnum").value;
        	var expmonth  =document.getElementById("expmonth").value;
        	var expyear   =document.getElementById("expyear").value;
        	var cvv       =document.getElementById("cvv").value;
        	if(cardname == "" || cardnumber == "" || expmonth == "" || expyear == "" || cvv == ""){
        		alert('Please fill payment details');
            	return false;
        	}
        	else{
        		return false;
        	}
        	
        	
            
        }
        return true;
    }
	function handlecod(){
		document.getElementById('payment-card').style.display = 'none';
	}
	function handlecards(){
		document.getElementById('payment-card').style.display = 'block';
	}
	function setBillingaddress(){
		var checkBox = document.getElementById("sameasshipping");
		if(checkBox.checked == true){
			document.getElementById('fname').value = "<?php echo $_POST["firstname"] ?>";
			document.getElementById('email').value = "<?php echo $_POST["email"] ?>";
			document.getElementById('adr').value = "<?php echo $_POST["address"] ?>";
			document.getElementById('city').value = "<?php echo $_POST["city"] ?>";
			document.getElementById('state').value = "<?php echo $_POST["state"] ?>";
			document.getElementById('zip').value = "<?php echo $_POST["zip"] ?>";
		}
		else{
			document.getElementById('fname').value = '';
			document.getElementById('email').value = '';
			document.getElementById('adr').value = '';
			document.getElementById('city').value = '';
			document.getElementById('state').value = '';
			document.getElementById('zip').value = '';
		}
		
	}
</script>