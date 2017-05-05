<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="query.css">
</head>

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
	
$names = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s");
$var = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S");

$gender = $_POST["gender"];
$nummovies = $_POST["countmovies"];
$directed = $_POST["dir"];

// echo "Sex: " . $gender . "<br>";
// echo "nummovies: " . $nummovies . "<br>";
// echo "Directed: " . $directed . "<br>";

// echo $gender . "<br>";

if($gender == "None")
{
	$var[0] = "create table $names[0] as (select * from actor)";
	$result = $conn->query($var[0]);
	// if($result)
	// 	echo "Table names[0] created <br>";
	// else
	// 	echo "Fuck";
}
else
{
	$var[0] = "create table $names[0] as(select * from actor where actor_gender='$gender')";
	$result = $conn->query($var[0]);
}

if($nummovies != "")
{
	// echo $nummovies;
	$tt = "create table tmp as (select person_id from movie_cast group by person_id having count(person_id)='$nummovies')";
	$result = $conn->query($tt);
	// if($result)
	// 	echo "YO";
	$var[1] = "create table $names[1] as (select $names[0].person_id from tmp, $names[0] where tmp.person_id = $names[0].person_id)";
	$result = $conn->query($var[1]);
	// if($result)
	// 	echo "YO";
}
else
{
	$var[1] = "create table $names[1] as (select person_id from $names[0])";
	$result = $conn->query($var[1]);
}

if($directed == "on")
{
	$var[2] = "create table $names[2] as (select distinct movie_cast.person_id from movie_cast, direction, $names[1] where movie_cast.person_id = direction.person_id and direction.person_id = $names[1].person_id)";
	$result = $conn->query($var[2]);
}
else
{
	$var[2] = "create table $names[2] as (select * from $names[1])";
	$result = $conn->query($var[2]);
}

$fin = "select * from $names[2]";
$result = $conn->query($fin);

// if($result->num_rows > 0)
// {
// 	while($row = $result->fetch_assoc())
// 	{
// 		echo $row["person_id"] . " ";
// 	}
// }
// else
// {
// 	echo "0 result";
// }



?>



<body>

<div class="container">

	<div class="heading">
		<div class="logo">
			<img src="imdb.jpe" alt="Fjords" width=100% height=100% >
		</div>
		<h1 id="header2">IMDB </h1>

	</div>

	<div class="icon-bar">
	<a  href="home.html"><i>Home</i></a> 
	  <a href="insert.html"><i>Insert</i></a> 
	  <a class="active" href="query.html"><i>Query</i></a> 
	</div>
	<div class = "footer">
		<div class="left">
		<div class="li2">
 			<a href="query.html">Movies</a></li>
			<a href="actor_query.html">Actor</a>
			<a href="complex.html">Complex Query</a>
			</div>
		</div>
		<div class="content">

		<?php
		if($result->num_rows > 0)
		{
			while($row1 = $result->fetch_assoc())
			{
				$tmp = $row1["person_id"];
				$y = "select actor_name from actor where actor.person_id = '$tmp'";
				$res = $conn->query($y);

				echo "<h3>";
				if($res->num_rows > 0)
				{
					while($row1 = $res->fetch_assoc())
					{
						echo $row1["actor_name"] . "<br>";
					}
				}
				echo "</h3>";

				echo "<p style='font-size:0.8em'><b>Sex: </b>";
				$y = "select actor_gender from actor where person_id = '$tmp'";
				$res = $conn->query($y);
				if($res->num_rows > 0)
				{
					while($row1 = $res->fetch_assoc())
					{
						echo $row1["actor_gender"] . "<br>";
					}
				}

				echo "<b>Date Of Birth: </b>";
				$y = "select actor_dob from actor where person_id = '$tmp'";
				$res = $conn->query($y);
				if($res->num_rows > 0)
				{
					while($row1 = $res->fetch_assoc())
					{
						echo $row1["actor_dob"] . "<br>";
					}
				}

				echo "<b>Birth Place: </b>";
				$y = "select actor_birthplace from actor where person_id = '$tmp'";
				$res = $conn->query($y);
				if($res->num_rows > 0)
				{
					while($row1 = $res->fetch_assoc())
					{
						echo $row1["actor_birthplace"] . "<br>";
					}
				}


				echo "</p>";
			}


		}

		for($ct=0;$ct<6;$ct++)
		{
			$var[$ct] = "drop table $names[$ct]";
			$tmp = $conn->query($var[$ct]);
		}
		$x = "drop table tmp";
		$y = $conn->query($x);
		?>


		
		</div>
	</div>
</div>
</body>
</html>