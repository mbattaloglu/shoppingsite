<?php
   include('config/dbconnector.php');
   session_start();
   
   if($_SESSION["logged_in"]){
      $user_check = $_SESSION['login_email'];
      $usertype = $_SESSION["login_type"];
   
      $ses_sql = mysqli_query($connection,"SELECT email FROM $usertype WHERE email = \"$user_check\" ");
      
      $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
      
      $login_session = $row['email'];
      
      if(!isset($_SESSION['login_email'])){
         header("Location: login.php");
         die();
      }
   }

   else{
      $_SESSION["logged_in"] = false;
   }
   
?>