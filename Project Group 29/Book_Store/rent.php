<?php
// the shopping cart needs sessions, to start one
/*
		Array of session(
			cart => array (
				book_isbn (get from $_POST['book_isbn']) => number of books
			),
			items => 0,
			total_price => '0.00'
		)
	*/
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: index.php");
}
require_once "./functions/database_functions.php";
require_once "./functions/cart_functions.php";

// book_isbn got from form post method, change this place later.
if (isset($_POST['bookisbn'])) {
	$book_isbn = $_POST['bookisbn'];
}

if (isset($book_isbn)) {
	// new item selected
	if (!isset($_SESSION['rent'])) {
		// $_SESSION['rent'] is associative array that bookisbn => qty
		$_SESSION['rent'] = array();

		$_SESSION['total_rent_items'] = 0;
		$_SESSION['total_rent_price'] = '0.00';
	}

	if (!isset($_SESSION['rent'][$book_isbn])) {
		$_SESSION['rent'][$book_isbn] = 1;
	} elseif (isset($_POST['rent'])) {
		$_SESSION['rent'][$book_isbn]++;
		unset($_POST);
	}
}

// if save change button is clicked , change the qty of each bookisbn
if (isset($_POST['save_change'])) {
	foreach ($_SESSION['rent'] as $isbn => $qty) {
		if ($_POST[$isbn] == '0') {
			unset($_SESSION['rent']["$isbn"]);
		} else {
			$_SESSION['rent']["$isbn"] = $_POST["$isbn"];
		}
	}
}

// print out header here
$title = "Your rent cart";
require "./template/header.php";

if (isset($_SESSION['rent']) && (array_count_values($_SESSION['rent']))) {
	$_SESSION['total_rent_price'] = total_price($_SESSION['rent']);
	$_SESSION['total_rent_items'] = total_items($_SESSION['rent']);
?>
	<form action="rent.php" method="post">
		<table class="table">
			<tr>
				<th>Item</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>
			</tr>
			<?php
			foreach ($_SESSION['rent'] as $isbn => $qty) {
				$conn = db_connect();
				$book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
			?>
				<tr>
					<td><?php echo $book['book_title'] . " by " . $book['book_author']; ?></td>
					<td><?php echo "$" . $book['book_price']; ?></td>
					<td><input type="text" value="<?php echo $qty; ?>" size="2" name="<?php echo $isbn; ?>"></td>
					<td><?php echo "$" . $qty * $book['book_price']; ?></td>
				</tr>
			<?php } ?>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th><?php echo $_SESSION['total_rent_items']; ?></th>
				<th><?php echo "$" . $_SESSION['total_rent_price']; ?></th>
			</tr>
		</table>
		<input type="submit" class="btn btn-primary" name="save_change" value="Save Changes">
	</form>
	<br /><br />
	<a href="rentout.php" class="btn btn-primary">Go To Checkout</a>
	<a href="books.php" class="btn btn-primary">Continue Shopping</a>
<?php
} else {
	echo "<p class=\"text-warning\">Your cart is empty! Please make sure you add some books in it!</p>";
}
if (isset($conn)) {
	mysqli_close($conn);
}
require_once "./template/footer.php";
?>