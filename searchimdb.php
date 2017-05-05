<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="home.css">
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
	

$input = $_POST["var"];

$flag = 0;

$x = "select movie_id from movies where title = '$input'";
$result = $conn->query($x);

if(!$result)
	echo "Fucked";

if($result->num_rows == 0)
{
	$flag = 1;
	$x = "select person_id from actor where actor_name = '$input'";
	$result = $conn->query($x);

	if($result->num_rows == 0)
		$flag = 2;
}

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
	<a class="active" href="home.html"><i>Home</i></a> 
	  <a href="insert.html"><i>Insert</i></a> 
	  <a href="query.html"><i>Query</i></a> 
	</div>

 		<div class="footer">

 		<?php


 		if($flag == 2)
 		{
 			echo "No Result of the query<br>Try Again.";
 		}
 		else if($flag == 1)
 		{
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
		}
		else
		{


					if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	
    	$tmp = $row["movie_id"];
    	$y = "select title from movies where movie_id = '$tmp'";
    	$res = $conn->query($y);

    	if($res->num_rows > 0)
    	{
    		while($row1 = $res->fetch_assoc())
        		{
    			echo "<h3>" . $row1["title"] . "</h3>";
    		}
    	}
    	else
    		echo "Fuck";

		echo "<p style='font-size:0.8em'><b>Genre: </b>";
    	$y = "select distinct genre.genre from movies, genre where movies.movie_id = genre.movie_id and movies.movie_id = '$tmp'";
    	$res = $conn->query($y);
    	if($res->num_rows > 0)
    	{
    		$row1 = $res->fetch_assoc();
    		echo $row1["genre"];
    		while($row1 = $res->fetch_assoc())
    		{
    			echo ", " . $row1["genre"];
    		}
    		echo "<br>";
    	}
    	else
    		echo "Fuck";

    	echo "<b>Actors:</b> ";
    	$y = "select distinct actor.actor_name from movies, movie_cast, actor where movies.movie_id = movie_cast.movie_id and movie_cast.person_id = actor.person_id and movies.movie_id = '$tmp'";
    	$res = $conn->query($y);
    	if($res->num_rows > 0)
    	{
    		$row1 = $res->fetch_assoc();
    		echo $row1["actor_name"];
    		while($row1 = $res->fetch_assoc())
    		{
    			echo ", " . $row1["actor_name"];
    		}
    		echo "<br>";
    	}
    	else
    		echo "Fuck";

    	echo "<b>Director: </b>";
    	$y = "select distinct director.dir_name from movies, direction, director where movies.movie_id = direction.movie_id and direction.person_id = director.person_id and movies.movie_id = '$tmp'";
    	$res = $conn->query($y);
    	if($res->num_rows > 0)
    	{
    		$row1 = $res->fetch_assoc();
    		echo $row1["dir_name"];
    		while($row1 = $res->fetch_assoc())
    		{
    			echo ", " . $row1["dir_name"];
    		}
    		echo "<br>";
    	}
    	else
    		echo "Fuck";	

    	echo "<b>Release-Date: </b>";
    	$y = "select distinct release_date from movies where movie_id = '$tmp'";
		$res = $conn->query($y);
    	if($res->num_rows > 0)
    	{
    		$row1 = $res->fetch_assoc();
    		echo $row1["release_date"];
    		while($row1 = $res->fetch_assoc())
    		{
    			echo ", " . $row1["release_date"];
    		}
    		echo "<br>";
    	}
    	else
    		echo "Fuck";	

    	echo "<b>Rating: </b>";
    	$y = "select rating from movies where movie_id = '$tmp'";
		$res = $conn->query($y);
    	if($res->num_rows > 0)
    	{
    		$row1 = $res->fetch_assoc();
    		echo $row1["rating"];
    		while($row1 = $res->fetch_assoc())
    		{
    			echo ", " . $row1["rating"];
    		}
    		echo "<br>";
    	}
    	else
    		echo "Fuck";

    	echo "<b>Duration:</b> ";
    	$y = "select duration from movies where movie_id = '$tmp'";
		$res = $conn->query($y);
    	if($res->num_rows > 0)
    	{
    		$row1 = $res->fetch_assoc();
    		$dur = $row1["duration"];
    		$hr = floor($dur/60);
    		$min = $dur % 60;
    		echo $hr . "hours " . $min . "min";
    		echo "<br>";
    	}
    	else
    		echo "Fuck";


    	echo "</p>";

    }
} else {
    echo "0 results";
}




		}



 		?>

 		</div>
	</div>

</div>
</body>
</html>
