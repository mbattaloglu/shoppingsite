<?php
    include('session.php');

    if(isset($_POST["btn-buy"])){
        header("Location: buy.php");
    }

    if(isset($_POST["btn-remove"])){
        $tempId = $_POST["cart_hidden_id"];
        for($i=0; $i<count($_SESSION["items"]); $i++){
            if($_SESSION["items"][$i]["id"] == $tempId){
                $_SESSION["totalPrice"] -= $_SESSION["items"][$i]["totalprice"];
                unset($_SESSION["items"][$i]);
                $_SESSION["items"] = array_values($_SESSION["items"]);
                break;
            }
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
                    <h4 style="text-align:center;"><?php echo $_SESSION["login_name"] . " " . $_SESSION["login_surname"]; ?></h4>
                    <?php if ($_SESSION["login_type"] == "admins") : ?>
                        <a class="navigator" href="allitems.php">Show All Items</a>
                    <?php endif; ?>
                    <br>
                    <a class="navigator" href="editprofile.php">Edit Profile</a>
                    <br>
                    <a class="navigator" href="logout.php">Log Out</a>
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
                            <?php foreach($_SESSION["items"] as $item) {?>
                                <img src=<?php echo htmlspecialchars($item["imagelink"]) ?> alt="" class="cart-img">
                                <div class="detail-box">
                                    <input type="hidden" name="cart_hidden_id" value="<?php echo htmlspecialchars($item["id"])?>">
                                    <div class="cart-product-title"><?php echo htmlspecialchars($item["name"]) ?></div>
                                    <div class="cart-price">Quantity:<?php echo htmlspecialchars($item["quantity"]) ?></div>
                                    <div class="cart-price">$<?php echo htmlspecialchars($item["totalprice"]) ?></div>
                                </div>
                                <input type="submit" value="🗑" name="btn-remove" class="btn-remove">
                                <?php }?>
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
                <i class='bx bx-x close' id="close-cart"></i>
            </div>
        </div>
    </header>
    <section class="shop container">
        <div class="slideshow-container">
            <div class="image-container fade">
                <img src="img/woman/slider/slider5.jpg" alt="">
            </div>
            <div class="image-container fade">
                <img src="img/man/slider/slider1.jpg" alt="">
            </div>
            <div class="image-container fade">
                <img src="img/woman/slider/slider1.jpg" alt="">
            </div>
            <div class="image-container fade">
                <img src="img/man/slider/slider2.jpg" alt="">
            </div>
            <div class="image-container fade">
                <img src="img/woman/slider/slider2.jpg" alt="">
            </div>
            <div class="image-container fade">
                <img src="img/man/slider/slider3.jpg" alt="">
            </div>
            <div class="image-container fade">
                <img src="img/woman/slider/slider3.jpg" alt="">
            </div>
            <div class="image-container fade">
                <img src="img/man/slider/slider4.jpg" alt="">
            </div>
            <div class="image-container fade">
                <img src="img/woman/slider/slider4.jpg" alt="">
            </div>
            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>
            <br>
        </div>
    </section>
    <script src="js/Slider.js"></script>
    <script src="js/Main.js"></script>
    </div>
</body>

</html>