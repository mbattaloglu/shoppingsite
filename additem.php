
<?php
    include("config/dbconnector.php");
    include('session.php');

    $errors = array("name" =>  "", "description" => "", "imagelink" => "",  "price" =>  "", "gender" => "", "category" => "", "mysql" => "");

    $name = "";
    $description = "";
    $imagelink = "";
    $gender = "";
    $category = "";
    $price = "";

    if(isset($_POST["submit"])){
        if(empty($_POST["item-name"])){
            $errors["name"] = "Please enter a name";
        }
        else{
            $name = $_POST["item-name"];
        }
        if(empty($_POST["item-description"])){
            $errors["description"] = "Please enter a description";
        }
        else{
            $description = $_POST["item-description"];
        }
        if(empty($_POST["image-link"])){
            $errors["imagelink"] = "Please enter an imagelink";
        }
        else{
            $imagelink = $_POST["image-link"];
        }
        if(empty($_POST["genders"])){
            $errors["gender"] = "Please select a gender";
        }
        else{
            $gender = $_POST["genders"] == "Man" ? 1 : 0;
        }
        if(empty($_POST["categories"])){
            $errors["category"] = "Please select a category";
        }
        else{
            $category = $_POST["categories"];
        }
        if(empty($_POST["price"])){
            $errors["price"] = "Please enter a price";
        }
        else{
            $price = $_POST["price"];
        }

        
        if(!array_filter($errors)){
            $name = mysqli_real_escape_string($connection, $name);
            $description = mysqli_real_escape_string($connection, $description);
            $gender = mysqli_real_escape_string($connection, $gender);
            $category = mysqli_real_escape_string($connection, $category);
            $price = mysqli_real_escape_string($connection, $price);
            $imagelink = mysqli_real_escape_string($connection, $imagelink);
            
            $query = "INSERT INTO products(gender, category, name, description, price, imagelink) VALUES($gender, \"$category\", \"$name\", \"$description\", $price, \"$imagelink\")";

            //Check saving
            if(mysqli_query($connection, $query)){
                //Success
                header("Location: allitems.php");
            }
            else{
                $errors["mysql"] = "Query Error" . mysqli_error($connection);
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
 <script async src="https://imgbb.com/upload.js" data-palette="black" data-auto-insert="html-embed-medium"></script>
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
     </div>
 </header>
 <section class="shop container">
    <div class="signup-box">
        <form class="signup-form" method="POST">
            <h2 class="title">Add Item</h2>
            <div class="red-text"> <?php echo htmlspecialchars($errors["name"]); ?> </div>
            <div class="input-container">
                <input class="information center" name="item-name" type="text" placeholder="Item Name">
            </div>
            <div class="red-text"> <?php echo htmlspecialchars($errors["description"]); ?> </div>
            <div class="input-container">
                <input class="information center" name="item-description" type="text" placeholder="Item Description">
            </div>
            <div class="red-text"> <?php echo htmlspecialchars($errors["imagelink"]); ?> </div>
            <div class="input-container">
                <input class="information center" name="image-link" type="text" placeholder="Image Link" id="#imagelinkcopy">
            </div>
            <div class="red-text"> <?php echo htmlspecialchars($errors["price"]); ?> </div>
            <div class="input-container">
                <input class="information center" name="price" type="text" placeholder="Price">
            </div>
            <div class="red-text"> <?php echo htmlspecialchars($errors["category"]); ?> </div>
            <div class="input-container select">
                <select class="select-text" name="genders" required>
                    <option value="" disabled selected>Chose a Gender</option>
                    <option value="man">Man</option>
                    <option value="woman">Woman</option>
                </select>
            </div>
            <div class="red-text"> <?php echo htmlspecialchars($errors["gender"]); ?> </div>
            <div class="input-container select">
                <select class="select-text" name="categories" required>
                    <option value="" disabled selected>Chose a Category</option>
                    <option value="shirts">Shirt</option>
                    <option value="jeans">Jean</option>
                    <option value="shortsandjoggers">Short and Jogger</option>
                    <option value="dresses">Dress</option>
                    <option value="shoes">Shoe</option>
                    <option value="accessories">Accessory</option>
                </select>
            </div>
            <input class="btn-submit" name="submit" type="submit" value="Add Item">
            <div class="red-text"> <?php echo htmlspecialchars($errors["mysql"]); ?> </div>
        </form>
    </div>
 </section>
    
    <script src="js/Slider.js"></script>
    <script src="js/Main.js"></script>
 </div>
</body>
</html>