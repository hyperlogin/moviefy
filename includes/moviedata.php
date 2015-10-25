<?php
	include("../class/clsDatabase.php");
	
	$db = new Db();
	
	$query = "SELECT id,release_year,movie_title,poster_image,genre FROM mf_movies";
	
	$res = $db->query($query);
	
	$movieData = array();
	
	while($row = mysqli_fetch_array($res))
	{
		$data = array("id" => $row['id'], "title" => $row['movie_title'], "year" => $row['release_year'], "genre" => $row['genre'], "icon" => $row['poster_image'], "website-link" => "movie.php?m=".$row['id']);
		array_push($movieData,$data);		
	}
	echo json_encode($movieData);
?>