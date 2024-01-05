<?php
$title = "Book Store";
require_once "functions/database_functions.php";
$conn = db_connect();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $query = "SELECT `username` FROM customer_login;";
    $result = mysqli_query($conn,$query);
    if(!$result)
    {
        die("We have encountered an error: ". $conn->error);
    }
    while($row = mysqli_fetch_assoc($result))
    {
        if($row['username'] == $username)
        {
            die("You are already registered try logging in");
        }
    }
    // echo "Post hogaya vai";
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $query = "INSERT INTO `customers` VALUES('$username','$name','$address','$city',$zip_code,'$country')";
    $result = mysqli_query($conn,$query);
    if(!$result)
    {
        die("Please don't use enter key use your mouse");
    }
    $query = "INSERT INTO `customer_login` VALUES('$username','$password');";
    $result = mysqli_query($conn,$query);
    if(!$result)
    {
        die("Please don't use enter key use your mouse");
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
            <form action="signup.php" method="post">
                <h2 class="form__title">SignUp</h2>
                <div id="f1">
                    <input type="text" name="username" id="username" placeholder="Username" class="form__input">
                    <input type="password" name="password" id="password" placeholder="password" class="form__input">
                    <button id="linkF2" type="button" class="form__button">Continue</button>
                    
                </div>
                <div id="f2" class="form--hidden">
                    <input type="text" name="name" id="name" placeholder="Name" class="form__input">
                    <input type="text" name="address" id="address" placeholder="Address" class="form__input">
                    <input type="text" name="city" id="city" placeholder="City" class="form__input">
                    <input type="text" name="zip_code" id="zip_code" placeholder="Zip Code" class="form__input">
                    <input type="text" name="country" id="country" placeholder="Country" class="form__input">
                    
                    <button id="submit" class="form__button">Continue</button>
                    <button id="linkF1" type="button" class="form__button">Back</button>

                </div>
                <div class="form__link form__text"><a href="index.php">Already have an account? Login</a></div>
            </form>
        </div>
    </div>
    <script src="bootstrap/js/main.js"></script>
</body>

</html>