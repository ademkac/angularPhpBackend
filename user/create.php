<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

function random_str(
  int $length = 64,
  string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
  if ($length < 1) {
      throw new \RangeException("Length must be a positive integer");
  }
  $pieces = [];
  $max = mb_strlen($keyspace, '8bit') - 1;
  for ($i = 0; $i < $length; ++$i) {
      $pieces []= $keyspace[random_int(0, $max)];
  }
  return implode('', $pieces);
}

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  $sql1 = "SELECT * FROM users";
  $result = mysqli_query($con, $sql1);

  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    if($request->email == $row['email']){
      http_response_code(400);
      echo('Email already exists');
    } else{

      // Sanitize.
 $email = mysqli_real_escape_string($con, $request->email);
 $password = mysqli_real_escape_string($con, $request->password);
 $confirmed = mysqli_real_escape_string($con, 0);
 $isAdmin = mysqli_real_escape_string($con, 0);
 $expiresIn =  "3600";


 // Create.
 $sql = "INSERT INTO `users`(`id`,`email`,`password`,`confirmed`,`isAdmin`) VALUES (null,'{$email}','{$password}','{$confirmed}','{$isAdmin}')";
 if(mysqli_query($con,$sql))
 {
   http_response_code(201);
   $policy = [
     'email' => $email,
     'idToken' => random_str(20),
     'expiresIn' => $expiresIn,
     'confirmed' => $confirmed,
     'isAdmin' => $isAdmin,
     'localId'    => mysqli_insert_id($con)
   ];
   echo json_encode($policy);
 }
 else
 {
   http_response_code(400);
 }

    }
  }

 /*  $to = $email;
  $subject = 'Signup | Verification';
  $message = '
  Please click this link to activate your account:
  http://127.0.0.1:80/angularphp/backend/user/verify.php?email='.$email.'
  ';
  $headers = 'From:noreply@prodajatelefona.com';
  mail($to, $subject, $message, $headers); */ //Send our emaii

};

