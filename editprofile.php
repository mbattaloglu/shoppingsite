<?php
include("config/dbconnector.php");
include('session.php');

if (isset($_POST["btn-buy"])) {
    header("Location: buy.php");
}

$errors = array("name" => "", "surname" => "", "email" => "", "password" => "", "passwordAgain" => "");

$id = $_SESSION["login_id"];
$loginType = $_SESSION['login_type'];
$userQuery = "SELECT * FROM  $loginType where id = $id";
$result = mysqli_query($connection, $userQuery);
$user = mysqli_fetch_assoc($result);

$name = $user["name"];
$surname = $user["surname"];
$email = $user["email"];

if (isset($_POST["submit"])) {
    if (empty($_POST["name"])) {
        $errors["name"] = "Enter Your Name";
    } else {
        $name = $_POST["name"];

        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors["name"] = "Name must be letters and spaces only";
        }
    }

    //Check Surname
    if (empty($_POST["surname"])) {
        $errors["surname"] = "Enter Your Surname";
    } else {
        $surname = $_POST["surname"];

        if (!preg_match("/^[a-zA-Z\s]+$/", $surname)) {
            $errors["surname"] = "Surname must be letters and spaces only";
        }
    }

    //Check Email
    if (empty($_POST["email"])) {
        $errors["email"] = "An email is required.";
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Not a valid email";
        }
    }


    $name = mysqli_real_escape_string($connection, $name);
    $surname = mysqli_real_escape_string($connection, $surname);
    $email = mysqli_real_escape_string($connection, $email);

    $query = "UPDATE $loginType SET name = \"$name\", surname = \"$surname\", email = \"$email\" where id = $id";

    //Check saving
    if (mysqli_query($connection, $query)) {
        //Success
        $_SESSION["login_email"] = $email;
        $_SESSION["login_name"] = $name;
        $_SESSION["login_surname"] = $surname;
        header("Location: index.php");
    } else {
        $errors["mysql"] = "Query Error" . mysqli_error($connection);
    }
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
            <?php if ($_SESSION["logged_in"]) : ?>
                <i class='bx bx-user icon' id="profile-icon"></i>
                <div class="login">
                    <h2 class="title">Welcome</h2>
                    <h5 style="text-align:center;"><?php echo $_SESSION["login_name"] . " " . $_SESSION["login_surname"]; ?></h5>
                    <?php if ($_SESSION["login_type"] == "admins") : ?>
                        <a href="allitems.php">Show All Items</a>
                    <?php endif; ?>
                    <br>
                    <a href="editprofile.php">Edit Profile</a>
                    <br>
                    <a href="logout.php">Log Out</a>
                    <i class='bx bx-x close' id="close-login"></i>
                </div>
            <?php else : ?>
                <a href="login.php">
                    <i class='bx bx-user icon' id="login-icon"></i>
                </a>
            <?php endif; ?>
            <i class='bx bx-shopping-bag icon' id="cart-icon"></i>
            <div class="cart">
                <h2 class="cart-title">Your Cart</h2>
                <div class="cart-content">
                    <form method="post">
                        <div class="cart-box">
                            <?php foreach ($_SESSION["items"] as $item) { ?>
                                <img src=<?php echo htmlspecialchars($item["imagelink"]) ?> alt="" class="cart-img">
                                <div class="detail-box">
                                    <input type="hidden" name="cart_hidden_id" value="<?php echo htmlspecialchars($item["id"]) ?>">
                                    <div class="cart-product-title"><?php echo htmlspecialchars($item["name"]) ?></div>
                                    <div class="cart-price">Quantity:<?php echo htmlspecialchars($item["quantity"]) ?></div>
                                    <div class="cart-price">$<?php echo htmlspecialchars($item["totalprice"]) ?></div>
                                </div>
                                <input type="submit" value="🗑" name="btn-remove" class="btn-remove">
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <div class="total">
                    <div class="total-title">Total:</div>
                    <div class="total-price">$<?php echo htmlspecialchars($_SESSION["totalPrice"]) ?></div>
                </div>
                <form method="post">
                    <input type="submit" value="Buy" name="btn-buy" class="btn-buy">
                </form>
            </div>
        </div>
        <i class='bx bx-x close' id="close-cart"></i>
        <form method="post">
            <input type="submit" value="Buy" name="btn-buy" class="btn-buy">
        </form>
        </div>
        </div>
    </header>
    <section class="shop container">
        <div class="signup-box">
            <form class="signup-form" method="POST">
                <h2 class="title">Edit Profile</h2>
                <div class="input-container">
                    <input class="information center" name="name" type="text" placeholder="Name" value="<?php echo $name; ?>">
                    <div class="red-text"> <?php echo htmlspecialchars($errors["name"]); ?> </div>
                </div>
                <div class="input-container">
                    <input class="information center" name="surname" type="text" placeholder="Surname" value="<?php echo $surname; ?>">
                    <div class="red-text"> <?php echo htmlspecialchars($errors["surname"]); ?> </div>
                </div>
                <div class="input-container">
                    <input class="information center" name="email" type="email" placeholder="E-Mail" value="<?php echo $email; ?>">
                    <div class="red-text"> <?php echo htmlspecialchars($errors["email"]); ?> </div>
                </div>
                <input class="btn-submit" type="submit" name="submit" value="Update Profile">
            </form>
        </div>
    </section>

    <script src="js/Slider.js"></script>
    <script src="js/Main.js"></script>
    </div>
</body>

</html>