<?php
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location: index.php");
	}

	$_SESSION['err'] = 1;
	foreach($_POST as $key => $value){
		if(trim($value) == ''){
			$_SESSION['err'] = 0;
		}
		break;
	}

	if($_SESSION['err'] == 0){
		header("Location: purchase.php");
	} else {
		unset($_SESSION['err']);
	}

	require_once "./functions/database_functions.php";
	// print out header here
	$title = "Purchase Process";
	require "./template/header.php";
	// connect database
	$conn = db_connect();
	extract($_SESSION['ship']);

	// validate post section
	$card_number = $_POST['card_number'];
	$card_PID = $_POST['card_PID'];
	$card_expire = strtotime($_POST['card_expire']);
	$card_owner = $_POST['card_owner'];

	// find customer
	$customerid = $_SESSION['username'];
	
	$date = date("Y-m-d H:i:s");
	insertIntoOrder($conn, $customerid, $_SESSION['total_price']);

	// take orderid from order to insert order items
	$orderid = getOrderId($conn, $customerid);
	// echo $orderid . '<br>';

	foreach($_SESSION['cart'] as $isbn => $qty){
		$bookprice = getbookprice($isbn);
		$query = "INSERT INTO `order_items` VALUES($orderid,'$isbn',$qty);";
		// echo $query . '<br>';
		$result = mysqli_query($conn,$query);
		if(!$result)
		{
			echo "Error inserting data into order_items: ". $conn->error;
		}
	}

	unset($_SESSION['cart']);
	unset($_SESSION['total_price']);
	unset($_SESSION['total_items'])
?>
	<p class="lead text-success">Your order has been processed sucessfully. Please check your email to get your order confirmation and shipping detail!. 
	Your cart has been empty.</p>

<?php
	if(isset($conn)){
		mysqli_close($conn);
	}
	require_once "./template/footer.php";
?>