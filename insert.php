<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="insert.css">
</head>


<body>

<div class="container">
	<div class="heading">
		<div class="logo">
			<img src="imdb.jpe" alt="Fjords" width=100% height=100% >
		</div>
		<h1 id="header2">IMDB </h1>

	</div>

	<div class="icon-bar">
		<a href="home.html"><i>Home</i></a> 
		<a class="active" href="insert.html"><i>Insert</i></a> 
		<a href="query.html"><i>Query</i></a> 
	</div>  

	<div class="footer">
			
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

$title = $_POST["title"];
if($title == "")
	$title = "default";
$rating = $_POST["rating"];
if($rating == "")
	$rating = "default";

$rdate = $_POST["rdate"];
if($rdate == "")
	$rdate = "default";
$duration = $_POST["duration"];
if($duration == "")
	$duration = "default";
$director = $_POST["director"];
if($director == "")
	$director = "default";
$actor = $_POST["actor"];
if($actor == "")
	$actor = "default";
$actress = $_POST["actress"];
if($actress == "")
	$actress = "default";



$x = "select * from movies";
$res = $conn->query($x);
$mid = $res->num_rows + 1;

// echo $actor;

$sql1 = "select person_id from actor where actor_name='$actor' and actor_gender='Male'";
$result = $conn->query($sql1);

if($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$pid = $row["person_id"];
		// echo $mid . " " . $pid . "<br>";
		$sql1 = "insert into movie_cast values('$mid', '$pid')";
		$res = $conn->query($sql1);
	}
}

// echo "HERE";

$sql1 = "select person_id from actor where actor_name='$actress' and actor_gender='Female'";
$result = $conn->query($sql1);

if($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$pid = $row["person_id"];
		// echo $mid . " " . $pid . "<br>";
		$sql1 = "insert into movie_cast values('$mid', '$pid')";
		$res = $conn->query($sql1);
	}
}

$sql1 = "select person_id from director where dir_name='$director'";
$result = $conn->query($sql1);
if(!$result)
	echo "Err";

if($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$pid = $row["person_id"];
		// echo $mid . " " . $pid . "<br>";
		$sql1 = "insert into direction values('$mid', '$pid')";
		$res = $conn->query($sql1);
	}
}
	// echo "No Result<br>";

// echo $mid;

$sql = "insert into movies values('$mid', '$title', '$rating', '$rdate', '$duration')";
$result = $conn->query($sql);

echo "<h3>Inserted....</h3>";

?>

	</div>
</div>
</body>
</html>