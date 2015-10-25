<?php
    session_start();
	session_destroy();
	ob_flush();
	header("Location: index.php");
	exit;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>