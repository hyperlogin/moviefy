<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Moviefy</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="description" content="Moviefy - Streaming Movies for all needs" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css' />
		<!--<link href="http://vjs.zencdn.net/5.0.0/video-js.min.css" media="screen" rel="stylesheet">-->
		<link href="css/videojs.caption.min.css" media="screen" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet"  type="text/css"/>
		<link href='css/bootstrap.min.css' rel='stylesheet'  type="text/css"/>
		<link href='css/bootstrap-theme.min.css' rel='stylesheet'  type="text/css"/>
		<link href='css/font-awesome.min.css' rel='stylesheet'  type="text/css"/>
		
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
  		
		<style>
			body {
				background-color:#262626;
				background:url(images/bg_adm.png) no-repeat center center fixed;
			}
			
			#info
			{
				width:800px;
				height:600px;
				background-color:rgba(0,0,0,.5);
				color:white;
				border-radius: 5px;
				display:block;
				margin:0 auto;
				left:50%;
				margin-top:100px;
			}
			
			#info h1
			{
				padding:15px;
				color: white;
				font-size: 100px;
				font-family: 'Dancing Script', arial, serif;
			}
			#info p
			{
				padding:15px;
				color: white;
				font-size: 35px;
				font-family: 'Dancing Script', arial, serif;
			}
			#info img
			{
				margin:0 auto;
				display:block;
				
			}
			
			
		</style>
	</head>
		<body>
			<div id="header">
				<?php include("includes/navbar.php") ?>
			</div>
			<div id="info">
				<h1>404 Error</h1>
				<p>Sorry the page you are looking for cannot be found.</p>
				<img src='images/404j.gif' alt="404 Error Page Sad Face" height="200" width="200" />
			</div>
		</body>
</html>