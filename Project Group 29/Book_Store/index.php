<?php
session_start();
if (isset($_SESSION['username'])) {
	header("Location: home.php");
}
$title = "Book Store";
require_once "functions/database_functions.php";
$conn = db_connect();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM customer_login;";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("We have encountered an error: " . $conn->error);
    }
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['username'] == $username) {
            if ($row['password'] == $password) {
                session_start();
                $_SESSION['username'] = $username;
                // echo "Successfully saved the session" . '<br>';
                header("Location: home.php");
            }
        }
    }
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?></title>

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="./bootstrap/css/jumbotron.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/css/main.css">
</head>

<body>
    <div class="body">
        <div class="form-container">
            <form action="index.php" method="post">
                <h2 class="form__title">Login</h2>
                <input type="text" name="username" id="username" placeholder="Username" class="form__input">
                <input type="password" name="password" id="password" placeholder="password" class="form__input">
                <button class="form__button">Continue</button>



                <div class="form__link form__text"><a href="signup.php">Don't have an account?</a></div>
            </form>
        </div>
    </div>
</body>

</html>