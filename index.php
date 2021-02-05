
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
	<div class="header">
		<a href="mycart.php">My Cart</a>
		<a href="login.php">Login</a>
	</div>
	<div class="container">
<?php
require_once 'dbconnect.php';
$dbconnect=new dbconnect();

$result = $dbconnect->getproductData();
$size=count($result);
if ($size >= 1) {
  // output data of each row
  for($i=0; $i<$size; $i++) {?>

    
    <div class="product-item">
		<form method="post" action="cartaction.php?action=add&code=<?php echo $result[$i]["code"]; ?>">
		<div class="product-image"><img src="<?php echo $result[$i]["image"]; ?>"></div>
		<div class="product-tile-footer">
		<div class="product-title"><?php echo $result[$i]["name"]; ?></div>
		<div class="product-price"><?php echo "&#x20B9;".$result[$i]["price"]; ?></div>
		<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
		</div>
		</form>
	</div>
	<?php
  }
} else {
  echo "0 results";
}


?>
</div>
</body>
</html>