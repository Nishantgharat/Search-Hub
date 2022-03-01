<?php
alert( "string");
$mysqli = new mysqli("localhost","mysql","your_password","search");
echo "connection done";
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// Perform query
if ($result = $mysqli -> query("SELECT * FROM Persons")) {
  echo "Returned rows are: " . $result -> num_rows;
  // Free result set
  $result -> free_result();
}

$mysqli -> close();
?>