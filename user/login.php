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


  // Sanitize.
  $email = mysqli_real_escape_string($con, $request->email);
  $password = mysqli_real_escape_string($con, $request->password);
   /* $confirmed = mysqli_real_escape_string($con, $request->confirmed);
  $isAdmin = mysqli_real_escape_string($con, $request->isAdmin);  */
  $expiresIn =  "3600";



  // Create.
  $sql = "SELECT * FROM users where email='$email' and password='$password'";

  

  if($result = mysqli_query($con,$sql))
  {
    $rows = array();
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    if($rows == null){
        http_response_code(400);
        echo json_encode($rows);
        echo('No valid data entered');
    }else{
        $policy = [
            'email' => $rows[0]['email'],
            'idToken' => random_str(20),
            'expiresIn' => $expiresIn,
            'confirmed' => $rows[0]['confirmed'],
            'isAdmin' => $rows[0]['isAdmin'],
            'localId'    => $rows[0]['id']
          ];
          echo json_encode($policy);
    }
    
  }
  else
  {
    http_response_code(404);
  }
}