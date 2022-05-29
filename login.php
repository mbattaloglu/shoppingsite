<?php
    include("config/dbconnector.php");
    session_start();

    $errors = array("email" => "", "password" => "", "usertype" => "", "wronginfo" => "");

    $email = "";
    $password = "";
    $usertype = "";

    if(isset($_POST["submit"])){
        //Check for usertype
        if(empty($_POST["usertype"])){
            $errors["usertype"] = "Please select a usertype";
        }
        else{
            $usertype = $_POST["usertype"] == "admin" ? "admins" : "users";
        }
        //check email
        if(empty($_POST["email"])){
            $errors["email"] = "Please enter your email.";
        }
        else{
            $email = mysqli_real_escape_string($connection, $_POST["email"]);
        }
        //check email
        if(empty($_POST["password"])){
            $errors["password"] = "Please enter your password.";
        }
        else{
            $password = mysqli_real_escape_string($connection, $_POST["password"]);
        }

        //Query
        $query = "SELECT * FROM $usertype WHERE email = \"$email\" and password = \"$password\"";
        //Execution
        $result = mysqli_query($connection, $query);
        //Fetch Result
        $user = mysqli_fetch_assoc($result);
        //Get row count
        $count = mysqli_num_rows($result);
        //If query is successfull, row count should be 1
        if($count == 1){
            $_SESSION["totalPrice"] = 0;
            $_SESSION["login_email"] = $email;
            $_SESSION["login_id"] = $user["id"];
            $_SESSION["login_name"] = $user["name"];
            $_SESSION["login_surname"] = $user["surname"];
            $_SESSION["login_type"] = $usertype;
            $_SESSION["logged_in"] = true;
            $items = array();

            $_SESSION["items"] = $items;

            header("Location: index.php");
        }
        else{
            $errors["wronginfo"] = "Wrong email or password";
        }

        //Release result
        mysqli_free_result($result);
        //Close connection
        mysqli_close($connection);
        
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Shopping</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <div class="nav container">
            <a href="index.php" class="logo">Shopping</a>
            <div class="main-categories">
                <div class="dropdown">
                    <p class="main-categories">Man</p>
                    <div class="dropdown-content">
                        <a href="manshirt.php">Shirts</a>
                        <a href="manjeans.php">Jeans</a>
                        <a href="manshortsandjoggers.php">Shorts and Joggers</a>
                        <a href="manshoes.php">Shoes</a>
                        <a href="manaccessories.php">Accessories</a>
                    </div>
                </div>
                <div class="dropdown">
                    <p class="main-categories">Woman</p>
                    <div class="dropdown-content">
                        <a href="womanshirts.php">Shirts</a>
                        <a href="womandresses.php">Dresses</a>
                        <a href="womanjeans.php">Jeans</a>
                        <a href="womanshoes.php">Shoes</a>
                        <a href="womanaccessories.php">Accessories</a>
                    </div>
                </div>
                
            </div>
            <a href="login.php">
                <i class='bx bx-user icon' id="login-icon"></i>
            </a>
        </div>
    </header>
    <section class="shop container">
        <div class="signup-box">
            <form class="signup-form" method="POST">
                <h2 class="title">Log In</h2>
                <div class="user-type">
                    <div>
                        <input type="radio" class="radio-button" name="usertype" value="admin" required>
                        <label for="admin">Admin</label>
                    </div>
                    <div>
                        <input type="radio" class="radio-button" name="usertype" value="user" required>
                        <label for="user">User</label>
                    </div>
                </div>
                <div class="red-text"> <?php echo htmlspecialchars($errors["usertype"]); ?> </div>
                <div class="input-container">
                    <input class="information center" name="email" type="email" placeholder="E-Mail">
                </div>
                <div class="red-text"> <?php echo htmlspecialchars($errors["email"]); ?> </div>
                <div class="input-container">
                    <input class="information center" name="password" type="password" placeholder="Password">
                </div>
                <div class="red-text"> <?php echo htmlspecialchars($errors["password"]); ?> </div>
                <a href="signup.php" id="sign-up">Don't have an account?</a>
                <br>
                <input class="btn-submit" name="submit" type="submit" value="Log In">
                <div class="red-text"> <?php echo htmlspecialchars($errors["wronginfo"]); ?> </div>
            </form>
        </div>
    </section>
        <script src="js/Main.js"></script>
    </div>
</body>
</html>