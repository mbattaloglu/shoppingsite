<?php
include("config/dbconnector.php");
include('session.php');

$query = "SELECT * FROM products";
$result = mysqli_query($connection, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
        </div>
    </header>
    <section class="shop container">
        <h2 class="section-title">All Items</h2>
        <br>
        <div>
            <a href="additem.php">
                <h4 style="text-align: center;">Add Item</h4>
            </a>
        </div>
        <br>
        <table class="products-table">
            <thead>
                <tr>
                    <th>Gender</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td class="text"><?php echo htmlspecialchars($product["gender"] == 1 ? "Man" : "Woman") ?></td>
                        <td class="text"><?php echo ucfirst(htmlspecialchars($product["category"])) ?></td>
                        <td class="text"><?php echo ucfirst(htmlspecialchars($product["name"])) ?></td>
                        <td class="text"><?php echo htmlspecialchars($product["description"]) ?></td>
                        <td class="text price">$<?php echo htmlspecialchars($product["price"]) ?></td>
                        <td><a href="edititem.php?id=<?php echo $product["id"]?>">Edit</a></td>
                        <td><a href="deleteitem.php?id=<?php echo $product["id"]?>">Delete</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="shop-content">
            <div class="products">
            </div>
        </div>
    </section>
    <script src="js/Main.js"></script>
</body>

</html>