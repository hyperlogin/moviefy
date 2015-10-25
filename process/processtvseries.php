<?php
include ("../class/clsDatabase.php");

$db = new Db();

if ($_GET['action'] == "add" || $_GET['action'] == "update") {
	if ($_GET['action'] == "add" && $_GET['mode'] == "cover") {
		//Data Array for Cover Page ( TV SERIES )
	$tvcoverpage = array('series_title' => $_POST['seriesTitle'], 'original_title' => $_POST['originalTitle'], 'series_desc' => $_POST['seriesoverview'], 'genre' => $_POST['genre'], 'total_season' => $_POST['totalSeason'], 'total_episodes' => $_POST['totalEps'], 'airing_date' => $_POST['air_date'], 'rating' => $_POST['rating'], 'poster_image' => $_POST['imgPoster'], 'backdrop_image' => $_POST['imgBackDrop'], 'series_library' => $_POST['library'],"series_code" => $_POST['seriesCode'] , "added_date" => $_POST['posted_date']);
		$query = addCover($tvcoverpage);
		$res = $db -> insertGetLastID($query);
		if ($res > 0) {
			echo "1";
		} else {
			echo "-1";
		}
	}else if($_GET['action'] == "add" && $_GET['mode'] == "episode")
	{
		//Data Array for TV Episodes
	$tvepisodes = array('season' => $_POST['season'], 'episode' => $_POST['episode'], 'series_id' => $_POST['id'], 'title' => $_POST['episodeTitle'], 'backdrop_image' => $_POST['imgBackDrop'], 'overview' => $_POST['overview'], 'poster_image' => $_POST['imgPoster'], 'episode_date' => $_POST['epDate'], 'last_updated' => $_POST['lastUpdate'], 'stream_link' => $_POST['stream']);
		$query = addEpisodes($tvepisodes);
		$res = $db -> insertGetLastID($query);
		if ($res > 0) {
			echo "1";
		} else {
			echo "-1";
		}
	}else if ($_GET['action'] == "update" && $_GET['mode'] == "cover") {
		$query = updateMovie($movie);
		$query .= " WHERE id='" . $_POST['id'] . "';";

		$res = $db -> getaffectedRows($query);

		if ($res > 0) {
			echo "1";
		} else {
			echo "-1";
		}
	}else if($_GET['action'] == "update" && $_GET['mode'] == "episode")
	{
		
	}

} else if ($_GET['action'] == "view") {
	$query = "SELECT * FROM mf_series where id='" . escapeString($_POST['id']) . "'";

	$res = $db -> query($query);
	$result = array();
	$epRes = array();
	
	while ($row = mysqli_fetch_array($res)) {
		$result[] = array('seriesTitle' => $row['series_title'], 'genre' => $row['genre'], 'overview' => $row['series_desc'], 'totalSeason' => $row['total_season'], 'totalEp' => $row['total_episodes'], 'air_date' => $row['airing_date'], 'rating' => $row['rating'], 'poster' => $row['poster_image'], 'backdrop' => $row['backdrop_image'], 'library' => $row['series_library'], 'id' => $row['id'], 'sCode' => $row['series_code'], 'addDate' => $row['added_date'],"update_date" => $row['updated_date']);
	}
	
	//Selecting Episodes
	$query = "SELECT * FROM mf_episodes where series_id='".escapeString($_POST['id'])."'";
	
	$res = $db->query($query);
	while($row = mysqli_fetch_array($res))
	{
		$epRes[] = array('id' => $row['uid'], 'season' => $row['season'], 'episode' => $row['episode'], 'title' => $row['title'], 'backdrop' => $row['backdrop_image'], 'ep_overview' => $row['overview'], 'epDate' => $row['episode_date'], 'lastUpdate' => $row['last_updated'], 'stream' => $row['stream_link']);
	}
	
	$result['episodes'] = $epRes;
	
	echo json_encode($result);
} else if ($_GET['action'] == "remove") {
	$query = "DELETE FROM mf_series where id='" . escapeString($_POST['id'] . "'");
	$deleteEpisode = "DELETE FROM mf_episodes where series_id='" . escapeString($_POST['id'])."'";
	
	$res = $db -> getaffectedRows($query);
	$deleteRes = $db->getaffectedRows($deleteEpisode);
	if (($res > 0 && $deleteRes > 0)) {
		echo "1";
	} else {
		echo "-1";
	}
}

//Function to escape mysql Strings

function escapeString($data) {
	global $db;
	return $db -> quote($data);
}

//Function to pass in a arry to convert into Insert Statements

function addCover($mData) {
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

	return $query = "INSERT INTO mf_series ($cols) VALUES ($fields);";
}

function addEpisodes($mData)
{
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

	return $query = "INSERT INTO mf_episodes ($cols) VALUES ($fields);";
}

function updateCover($mData) {
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

function updateEpisode($mData,$season,$episode)
{
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

	return $query = "UPDATE mf_movies SET $fields WHERE season='$season' AND episode='$episode'";
}

?>