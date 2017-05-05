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


// echo "wderfdsf";
// echo $_POST["durend"];

$start = $_POST["durstart"];
$end = $_POST["durend"];

$rat = floatval($_POST["rating"]);
$gen = $_POST["genr"];

// if($rat == 9.3)
// 	echo $rat . "<br>";

$rel_date_start = $_POST["rel_start"];
$rel_date_end = $_POST["rel_end"];

if($rel_date_start == "")
	$rel_date_start = "0000:00:00";
if($rel_date_end == "")
	$rel_date_end = "0000:00:00";

$date1 = date_create($rel_date_start);
$date2 = date_create($rel_date_end);

// echo $gen . "<br>";

$x=0;

$names = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s");
$var = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S");


$actor = $_POST["actor"];
// echo $actor;

// $tmp1 = "select * from movies where release_date > '$rel_date_start'";
// $result = $conn->query

if($start != "")
{
	$var[0] = "create table $names[0] as (select * from movies where duration >= $start and duration <= $end)";
	$result = $conn->query($var[0]);
}
else
{
	$var[0] = "create table $names[0] as (select * from movies)";
	$result = $conn->query($var[0]);
}

$x1 = $rat - 0.05;
$x2 = $rat + 0.05;



// echo $rat;

if($rat != "")
{
	$var[1] = "create table $names[1] as (select * from $names[0] where $names[0].rating >= $x1 and $names[0].rating <= $x2)";
	$result = $conn->query($var[1]);
}
else
{
	$var[1] = "create table $names[1] as (select * from $names[0])";
	$result = $conn->query($var[1]);
}

if($gen != "")
{
	// echo "HERE";
	$var[2] = "create table $names[2] as (select $names[1].release_date, $names[1].movie_id, $names[1].rating, $names[1].title, genre.genre, $names[1].duration from $names[1],genre where $names[1].movie_id = genre.movie_id and genre.genre = '$gen')";
	$result = $conn->query($var[2]);
	// if($result)
	// 	echo "Success<br>";
	// else
	// 	echo "Failed<br>";
}
else
{
	$var[2] = "create table $names[2] as (select * from $names[1])";
	$result = $conn->query($var[2]);
}

if($actor != "")
{
	// echo "into";
	$var[3] = "create table $names[3] as (select actor.actor_name , $names[2].movie_id, $names[2].release_date, $names[2].rating, $names[2].duration from $names[2], movie_cast, actor where $names[2].movie_id = movie_cast.movie_id and movie_cast.person_id = actor.person_id and actor.actor_name = '$actor')";
	$result = $conn->query($var[3]);
}
else
{
	$var[3] = "create table $names[3] as (select $names[2].movie_id, $names[2].title, $names[2].release_date, $names[2].rating, $names[2].duration from $names[2])";
	$result = $conn->query($var[3]);
	// if($result)
	// 	echo "3: suc";
	// else
	// 	echo "3: fail";
}

$director = $_POST["director"];


// echo $director;
if($director != "")
{
	$var[4] = "create table $names[4] as (select director.dir_name , $names[3].movie_id, $names[3].release_date from $names[3], direction, director where $names[3].movie_id = direction.movie_id and direction.person_id = director.person_id and director.dir_name = '$director')";
	$result = $conn->query($var[4]);
	// if($result)
	// 	echo "suc";
	// else
	// 	echo "fail";
}
else
{
	$var[4] = "create table $names[4] as (select * from $names[3])";
	$result = $conn->query($var[4]);
}

if($rel_date_start != "0000:00:00" && $rel_date_end != "0000:00:00")
{
	// echo $rel_date_start;
	$var[5] = "create table $names[5] as (select movie_id, release_date, rating, title, duration from $names[4] where release_date > '$rel_date_start' and release_date < '$rel_date_end')";
	$result = $conn->query($var[5]);
	// if($result)
	// 	echo "sucsuc<br>";
	// else
	// 	echo "<br>failfail<br>";
}
else
{
	// echo "yo";
	$var[5] = "create table $names[5] as (select distinct movie_id from $names[4])";
	$result = $conn->query($var[5]);
}

$sortbyrating = $_POST["sortbyrating"];
$sortbymovie = $_POST["sortbymovie"];

if($sortbyrating == "on")
{
    $final = "select distinct $names[5].movie_id from $names[5],movies where $names[5].movie_id = movies.movie_id order by rating asc";
}
else if($sortbymovie == "on")
{
    $final = "select distinct $names[5].movie_id from $names[5],movies where $names[5].movie_id = movies.movie_id order by title asc";

}
else
{
    $final = "select distinct movie_id from $names[5]";
}

$result = $conn->query($final);
// if(!$result)
//     echo "gone";

// if($result)
// 	echo "var3 Success<br>"
// else
// 	echo "var3 Failed<br>";



// $del = "drop table fin";
// $tmp = $conn->query($del);

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
 			<a href="query.html">Movies</a>
			<a href="actor_query.html">Actor</a>
			<a href="complex.html">Complex Query</a>
			</div>
		</div>
		<div class="content">




		<?php
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
    	// else
    	// 	echo "Fuck";
        // echo $tmp;
        $y = "select distinct genre.genre from movies, genre where movies.movie_id = genre.movie_id and movies.movie_id = '$tmp'";
        $res = $conn->query($y);
        echo "<p style='font-size:0.8em'>";
        if($res->num_rows > 0)
        {
    		echo "<p style='font-size:0.8em'><b>Genre: </b>";
    		$row1 = $res->fetch_assoc();
    		echo $row1["genre"];
    		while($row1 = $res->fetch_assoc())
    		{
    			echo ", " . $row1["genre"];
    		}
        }
    		echo "<br>";
    	// else
    	// 	echo "Fuck";

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
        }
    		echo "<br>";
    	// else
    	// 	echo "Fuck";

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
        }
    		echo "<br>";
    	// else
    	// 	echo "Fuck";	

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
        }
    		echo "<br>";
    	// else
    	// 	echo "Fuck";	

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
        }
    		echo "<br>";
    	// else
    	// 	echo "Fuck";

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
        }
    		echo "<br>";
    	// else
    	// 	echo "Fuck";


    	echo "</p>";

    }
} else {
    echo "0 results";
}

		for($ct=0;$ct<6;$ct++)
		{
			$var[$ct] = "drop table $names[$ct]";
			$tmp = $conn->query($var[$ct]);
		}

        $conn->close();
	?>



		</div>
	</div>
</div>
</body>
</html>