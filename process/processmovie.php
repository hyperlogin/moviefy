<?php
session_start();
if($_SESSION['user']['name'] == NULL || $_SESSION['user']['name'] == "")
{
	header('HTTP/1.0 403 Forbidden');
	exit;
}

include ("../class/clsDatabase.php");

$db = new Db();

if ($_GET['action'] == "add" || $_GET['action'] == "update") {
	$movie = array('movie_title' => $_POST['movieTitle'], 'genre' => $_POST['genre'], 'overview' => $_POST['movieoverview'], 'release_year' => $_POST['year'], 'poster_image' => $_POST['imgPoster'], 'backdrop_image' => $_POST['imgBackDrop'], 'trailer_link' => $_POST['trailerLnk'], 'imdb_rating' => $_POST['rating'], 'critics' => $_POST['critics'], 'audience' => $_POST['audience'], 'imdb_id' => $_POST['imdbcode'], 'stream_links' => $_POST['streamLinks'], "age_restrict" => $_POST['ageRestrict']);
	

	if ($_GET['action'] == "add") {
		$movie['added_date'] = $_POST['posted_date'];
		$query = addMovie($movie);
		//echo $query;
		$res = $db -> insertGetLastID($query);
		if ($res > 0) {
			echo $res;
		} else {
			echo "-1";
		}
	} else if ($_GET['action'] == "update") {
		$movie['updated_date'] = $_POST['updated_date'];
		$query = updateMovie($movie);
		$query .= " WHERE id='" . $_POST['id'] . "';";
		//echo $query;
		
		$res = $db -> getaffectedRows($query);

		if ($res > 0) {
			echo "1";
		} else {
			echo "-1";
		}
	}
} else if ($_GET['action'] == "view") {
	$query = "SELECT * FROM mf_movies where id='" . escapeString($_POST['id']) . "'";

	$res = $db -> query($query);
	$result = array();

	while ($row = mysqli_fetch_array($res)) {
		$result[] = array('movieTitle' => $row['movie_title'], 'genre' => $row['genre'], 'overview' => $row['overview'], 'release_year' => $row['release_year'], 'posted_date' => $row['updated_date'], 'imgPoster' => $row['poster_image'], 'imgBackDrop' => $row['backdrop_image'], 'trailer' => $row['trailer_link'], 'imdbRate' => $row['imdb_rating'], 'critics' => $row['critics'], 'audience' => $row['audience'], 'imdbID' => $row['imdb_id'], 'stream' => $row['stream_links'], "ageRestrict" => $row['age_restrict']);
	}
	echo json_encode($result);
} else if ($_GET['action'] == "remove") {
	$query = "DELETE FROM mf_movies where id='" . escapeString($_POST['id'] . "'");

	$res = $db -> getaffectedRows($query);

	if ($res > 0) {
		echo "1";
	} else {
		echo "-1";
	}
} else if($_GET['action'] == "delete")
{
	$query = "DELETE FROM mf_movies where id='".$_POST['mid']."'";
	
	$res = $db->getaffectedRows($query);
	
	if($res > 0)
	{
		echo "200";
	}
}

//Function to escape mysql Strings

function escapeString($data) {
	global $db;
	return $db -> quote($data);
}

//Function to pass in a arry to convert into Insert Statements

function addMovie($mData) {
	global $db;
	$count = 0;
	$fields = '';
	$cols = '';
	foreach ($mData as $col => $val) {
		if ($count++ != 0) {
			$fields .= ', ';
			$cols .= ', ';
		}
		$col = $db -> quote($col);
		$val = $db -> quote($val);
		$cols .= "$col";
		$fields .= "'$val'";
	}

	return $query = "INSERT INTO mf_movies ($cols) VALUES ($fields);";
}

function updateMovie($mData) {
	global $db;
	$count = 0;
	$fields = '';
	foreach ($mData as $col => $val) {
		if ($count++ != 0) {
			$fields .= ', ';
		}
		$col = $db -> quote($col);
		$val = $db -> quote($val);
		$fields .= "$col=" . "'$val'";
	}

	return $query = "UPDATE mf_movies SET $fields";
}
?>