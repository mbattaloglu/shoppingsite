<?php
    //Connection to Database
    $connection = mysqli_connect("localhost", "mustafa", "123456", "shopping_site");

    if(!$connection){
        echo "Connection Error" . mysqli_connect_error($connection);
    }
?>