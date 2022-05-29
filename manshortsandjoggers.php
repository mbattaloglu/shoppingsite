<?php 
    include("config/dbconnector.php");
    include('session.php');

    $query = "SELECT * FROM products where category = \"shortsandjoggers\" and gender = 1";
    $result = mysqli_query($connection, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $isItemFound = false;
    if(isset($_POST["add-cart"])){
        $tempId = $_POST["hidden_id"];
        for($i=0; $i<count($_SESSION["items"]); $i++){
            if($_SESSION["items"][$i]["id"] == $tempId){
                $_SESSION["items"][$i]["quantity"] += 1;
                $_SESSION["items"][$i]["totalprice"] = $_POST["hidden_price"] * $_SESSION["items"][$i]["quantity"];
                $itemIndex = $i;
                $isItemFound = true;
                $_SESSION["totalPrice"] +=  $_SESSION["items"][$i]["totalprice"];
                break;
            }
        }
        if(!$isItemFound){
            $_SESSION["items"][] = array("name" => $_POST["hidden_name"], "uniqueprice" => $_POST["hidden_price"], "totalprice" => $_POST["hidden_price"], "imagelink" => $_POST["hidden_imagelink"], "id" => $_POST["hidden_id"], "quantity" => "1");
            $_SESSION["totalPrice"] +=  $_POST["hidden_price"];
        }
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

    if(isset($_POST["btn-buy"])){
        header("Location: buy.php");
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping</title>
    <link rel="stylesheet" href="css/productstyle.css">
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
                        <a href="manshortsandjoggers.php" id="dropdown-content-active-category">Shorts and Joggers</a>
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
                    <?php foreach($_SESSION["items"] as $item) {?>
                        <div class="cart-box">
                                <img src=<?php echo htmlspecialchars($item["imagelink"]) ?> alt="" class="cart-img">
                                <div class="detail-box">
                                    <input type="hidden" name="cart_hidden_id" value="<?php echo htmlspecialchars($item["id"])?>">
                                    <div class="cart-product-title"><?php echo htmlspecialchars($item["name"]) ?></div>
                                    <div class="cart-price">Quantity:<?php echo htmlspecialchars($item["quantity"]) ?></div>
                                    <div class="cart-price">$<?php echo htmlspecialchars($item["totalprice"]) ?></div>
                                </div>
                                <input type="submit" value="🗑" name="btn-remove" class="btn-remove">
                            </div>
                        <?php }?>
                    </form>
                </div>
                <div class="total">
                    <div class="total-title">Total:</div>
                    <div class="total-price">$<?php echo htmlspecialchars($_SESSION["totalPrice"]) ?></div>
                </div>
                <i class='bx bx-x close' id="close-cart"></i>
                <form method="post">
                        <input type="submit" value="Buy" name="btn-buy" class="btn-buy">
                </form>
            </div>
        </div>
    </header>
    <section class="shop container">
        <h2 class="section-title">Shorts and Joggers</h2>
        <div class="shop-content">
            <?php foreach($products as $product) {?>
                <form method="post">
                    <div class="product-box">
                        <img src= <?php echo htmlspecialchars($product["imagelink"]) ?> alt="" class="product-img">
                        <h2 class="product-title"><?php echo htmlspecialchars($product["name"])?></h2>
                        <p><?php echo htmlspecialchars($product["description"])?></p>
                        <span class="price">$<?php echo htmlspecialchars($product["price"])?></span>
                        <input type="hidden" name="hidden_name" value="<?php echo htmlspecialchars($product["name"]) ?>">
                        <input type="hidden" name="hidden_price" value="<?php echo htmlspecialchars($product["price"]) ?>">
                        <input type="hidden" name="hidden_imagelink" value="<?php echo htmlspecialchars($product["imagelink"]) ?>">
                        <input type="hidden" name="hidden_id" value="<?php echo htmlspecialchars($product["id"]) ?>">
                        <input class="add-cart btn-submit" type="submit" name="add-cart" value="Add Cart">
                    </div>
                </form>
            <?php }?>
        </div>
    </section>
    <script src="js/Main.js"></script>
    </div>
</body>

</html>