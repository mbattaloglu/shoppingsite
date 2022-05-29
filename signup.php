<?php
    include("config/dbconnector.php");

    $errors = array("name" => "", "surname" => "", "email" => "", "password" => "", "passwordAgain" => "", "gender" => "");
    $name = "";
    $surname = "";
    $email = "";
    $password = "";
    $passwordAgain = "";
    $gender = "";
    

    if(isset($_POST["submit"])){
        //Check Name
        if(empty($_POST["name"])){
            $errors["name"] = "Enter Your Name";
        }
        else{
            $name = $_POST["name"];

            if(!preg_match("/^[a-zA-Z\s]+$/", $name)){
                $errors["name"] = "Surname must be letters and spaces only";
            }
        }

        //Check Surname
        if(empty($_POST["surname"])){
            $errors["surname"] = "Enter Your Surname";
        }
        else{
            $surname = $_POST["surname"];

            if(!preg_match("/^[a-zA-Z\s]+$/", $surname)){
                $errors["surname"] = "Surname must be letters and spaces only";
            }
        }

        //Check Email
        if(empty($_POST["email"])){
            $errors["email"] = "An email is required.";
        }
        else{
            $email = $_POST["email"];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors["email"] = "Not a valid email";
            }
        }

        //Check Password
        if(!empty($_POST["password"]) && ($_POST["password"] == $_POST["passwordAgain"])) {
            $password = $_POST["password"];
            $passwordAgain = $_POST["passwordAgain"];
            if (strlen($_POST["password"]) < '8') {
                $errors["password"] = "Your Password Must Contain At Least 8 Characters!";
            }
            elseif(!preg_match("#[0-9]+#",$password)) {
                $errors["password"] = "Your Password Must Contain At Least 1 Number!";
            }
            elseif(!preg_match("#[A-Z]+#",$password)) {
                $errors["password"] = "Your Password Must Contain At Least 1 Capital Letter!";
            }
            elseif(!preg_match("#[a-z]+#",$password)) {
                $errors["password"] = "Your Password Must Contain At Least 1 Lowercase Letter!";
            }
        }
        elseif(!empty($_POST["password"])) {
            $errors["passwordAgain"] = "Please Check You've Entered Or Confirmed Your Password!";
        } else {
            $errors["password"] = "Please enter password   ";
        }
        
        if(empty($_POST["gender"])){
            $errors["gender"] = "Please select your gender";
        }
        else{
            $gender = $_POST["gender"] == "male" ? 1 : 0;
        }
        
        if(!array_filter($errors)){
            $name = mysqli_real_escape_string($connection, $name);
            $surname = mysqli_real_escape_string($connection, $surname);
            $email = mysqli_real_escape_string($connection, $email);
            $password = mysqli_real_escape_string($connection, $password);
            $gender = mysqli_real_escape_string($connection, $gender);

            $query = "INSERT INTO users(name, surname, email, password, gender) VALUES ('$name', '$surname', '$email', '$password', '$gender')";

            //Check saving
            if(mysqli_query($connection, $query)){
                //Success
                header("Location: login.php");
            }
            else{
                echo "Query Error" . mysqli_error($connection);
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
            <a href="login.php">
                <i class='bx bx-user icon' id="login-icon"></i>
            </a>
        </div>
    </header>
    <section class="shop container">
        <div class="signup-box">
            <form action="signup.php" class="signup-form" method="POST">
                <h2 class="title">Sign Up</h2>
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
                <div class="input-container">
                    <input class="information center" name="password" type="password" placeholder="Password" >
                    <div class="red-text"> <?php echo htmlspecialchars($errors["password"]); ?> </div>
                </div>
                <div class="input-container">
                    <input class="information center" name="passwordAgain" type="password" placeholder="Password Again" >
                    <div class="red-text"> <?php echo htmlspecialchars($errors["passwordAgain"]); ?> </div>
                </div>
                <div class="user-type">
                    <div>
                        <input type="radio" class="radio-button" name="gender" value="male">
                        <label for="male">Male</label>
                    </div>
                    <div>
                        <input type="radio" class="radio-button" name="gender" value="female">
                        <label for="female">Female</label>
                    </div>
                    <br>
                </div>
                <div class="red-text"> <?php echo htmlspecialchars($errors["gender"]); ?> </div>
                <input class="btn-submit" type="submit" name="submit" value="Sign Up">
            </form>
        </div>
    </section>
        <script src="js/Main.js"></script>
    </div>
</body>
</html>