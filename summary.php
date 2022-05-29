<?php 
    include("session.php");

    
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
        </div>
    </header>
    <section class="shop container">
        <h2>Your Order Is Served</h2>
        <p>Thanks for using our site</p>
        <h4>Summary</h4>
        <div class="buy-item-container">
            <table class="shop-summary-table">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>                  

                </tr>
                <?php foreach($_SESSION["items"] as $item){?>
                    <tr>
                    <td>
                        <div class="buy-item-info">
                            
                            <img src=<?php echo htmlspecialchars($item["imagelink"])?> alt="">
                            <div>
                                <p><?php echo htmlspecialchars($item["name"])?></p>
                                <span>$<?php echo htmlspecialchars($item["uniqueprice"])?></span>
                                <br>
                            </div>
                        </div>
                    </td>
                    <td><?php echo htmlspecialchars($item["quantity"])?></td>
                    <td><?php echo htmlspecialchars($item["totalprice"])?></td>
                </tr>
                <?php }?>
                <?php $_SESSION["items"] = [];?>
            </table>
            
            <div class="summary-total-price">
                <table class="summary-total-price-table">
                    <tr>
                        <td class="table-title">Total:</td>
                        <td>$<?php echo htmlspecialchars($_SESSION["totalPrice"])?></td>
                        <?php $_SESSION["totalPrice"] = 0;?>
                    </tr>
                </table>
            </div>
        </div>
    </section>
    <script src="js/Main.js"></script>
    </div>
</body>

</html>