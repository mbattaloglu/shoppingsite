<?php
    include("config/dbconnector.php");

    $id = $_GET["id"];
    $query = "DELETE FROM products where id = $id";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);

    header("location: allitems.php");

?>