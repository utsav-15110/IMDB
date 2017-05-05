<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="query.css">
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

			$s1 = $_POST["submit1"];
			$s2 = $_POST["submit2"];
			$s3 = $_POST["submit3"];
			$s4 = $_POST["submit4"];



			if($s1 == "Submit")
			{

				$x = $_POST["q1"];
				$sql = "select person_id, count(person_id) from movie_cast group by person_id order by count(person_id) desc";
				$result = $conn->query($sql);


				$ct=0;

				if($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
					{
						$pid = $row["person_id"];
						
						$y = "select actor_name from actor where person_id='$pid'";
						$res = $conn->query($y);
						$row1 = $res->fetch_assoc();
						echo $row1["actor_name"] . ": <b>" . $row["count(person_id)"] . "</b> movies<br>";
						$ct++;
						if($ct == $x)
							break;
					}
				}
			}
			else if($s2 == "Submit")
			{

				$x  = $_POST["q21"];
				$sql = "create table tmp as (select movies.rating, actor.actor_name from movies, actor, movie_cast where movie_cast.movie_id = movies.movie_id and actor.person_id=movie_cast.person_id)";
				$result =$conn->query($sql);
				if(!$result)
					echo "Failed";

				$sql = "select actor_name, avg(rating) from tmp where actor_name='$x' group by actor_name";
				$result = $conn->query($sql);
				if(!$result)
					echo "Failed";

				if($result->num_rows > 0)
				{
					$ans = $result->fetch_assoc();
					echo "Average Rating: <b>" . round($ans["avg(rating)"],2) . "</b><br>";
				}

			}
			else if($s4 == "Submit")
			{
				$g1 = $_POST["q41"];
				$g2 = $_POST["q42"];

				$sql = "select movie_id from genre where genre='Thriller' and movie_id in (select movie_id from genre where genre='Horror')";
				$result = $conn->query($sql);
				if(!$result)
					echo "Failed";

				if($result->num_rows > 0)
				{
					while($ans = $result->fetch_assoc())
					{
						$id = $ans["movie_id"];
						$tmp1 = "select title from movies where movie_id = '$id'";
						$tmp2 = $conn->query($tmp1);
						$toprint = $tmp2->fetch_assoc();
						echo $toprint["title"] . "<br>";
					}
				}


			}

			$sql = "drop table tmp";
			$res = $conn->query($sql);

			?>










			</div>
		</div>
	</div>
</body>
</html>
