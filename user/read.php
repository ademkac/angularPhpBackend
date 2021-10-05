<?php
/**
 * Returns the list of policies.
 */
require '../database.php';

$policies = [];
$sql = "SELECT id, brand_id, description, imagePath, name, price FROM phones";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $policies[$i]['id']    = $row['id'];
    $policies[$i]['brand_id'] = $row['brand_id'];
    $policies[$i]['description'] = $row['description'];
    $policies[$i]['imagePath'] = $row['imagePath'];
    $policies[$i]['name'] = $row['name'];
    $policies[$i]['price'] = $row['price'];
    $i++;
  }

  echo json_encode($policies);
}
else
{
  http_response_code(404);
}