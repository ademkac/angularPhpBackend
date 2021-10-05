<?php

if(isset($_GET['email']) && !empty($_GET['email'])){
    $em = mysql_escape_string($_GET['email']);

    $sql1 = "SELECT * FROM users WHERE email='".$em."' AND confirmed='0'";
    $search = mysql_query($con, $sql1);
    $match = mysql_num_rows($search);

    if($match > 0){
      $sql2 = "UPDATE users SET confirmed='1' WHERE email='".$em"' AND confirmed='0'";
      mysql_query($con, $sql2);
      echo('Your account has been activated, you can now login');
    }else{
      echo('The url is either invalid or you already have activated your account.');
    }
}else{
  echo('Invalid approach, please use the link that has been send to your email.');
}