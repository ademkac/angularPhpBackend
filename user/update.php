<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);


  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->id);
  $brand_id = mysqli_real_escape_string($con, trim($request->brand_id));
  $description = mysqli_real_escape_string($con, trim($request->description));
  $imagePath = mysqli_real_escape_string($con, trim($request->imagePath));
  $name = mysqli_real_escape_string($con, trim($request->name));
  $price = mysqli_real_escape_string($con, trim($request->price));

  

  // Update.
  $sql = "UPDATE `phones` SET `brand_id`='$brand_id',`description`='$description',`imagePath`='$imagePath',`name`='$name',`price`='$price' WHERE `id` = '{$id}' LIMIT 1";

  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}