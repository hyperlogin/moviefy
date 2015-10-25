<?php
	if($_SESSION['user']['name'] == NULL || $_SESSION['user']['name'] == "")
	{
		header('Location: index.php');
		exit;
	}
?>