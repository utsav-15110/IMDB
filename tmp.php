<?php
$servername = "localhost";
$username = "root";
$password = "checkersdada";
$dbname = "my_imdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(is_resource($g_link)  &&  get_resource_type($g_link)=='mysql link'){
   echo 'MYSQL';
}else{
    if(is_object($g_link)  && get_class($g_link)=='mysqli'){
        echo 'MYSQLI';
    }
    echo "NONE";
}
// $conn->close();
?>
