<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Moviefy</title>
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Moviefy - Streaming Movies for all needs" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css' />
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link href='../css/bootstrap.min.css' rel='stylesheet'  type="text/css"/>
		<link href='../css/bootstrap-theme.min.css' rel='stylesheet'  type="text/css"/>
        <link href='../css/main.css' rel='stylesheet' type="text/css" />
		<link href='sb-admin.css' rel='stylesheet'  type="text/css"/>
		<link href='../css/font-awesome.min.css' rel='stylesheet'  type="text/css"/>
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<style>		
			#content-contain
			{
				position:relative;
				top:50%;
			}
			
			#frmLoginPanel
			{
				display:block;
				margin:0 auto;
				position:relative;
				top:150px;
				width:400px;
				padding-top:-50px;
				height:350px;
				border-radius:5px;
				background-color:white;
				-webkit-box-shadow: 6px 10px 5px 0px rgba(184,184,184,0.59);
				-moz-box-shadow: 6px 10px 5px 0px rgba(184,184,184,0.59);
				box-shadow: 6px 10px 5px 0px rgba(184,184,184,0.59);
			}
			
			.container-fluid > div
			{
				padding:15px;
			}

		</style>
    <body>
    	<div id="content-contain">
        <?php
			include("../class/clsDatabase.php");
			$db = new Db();
			
			if(isset($_POST['btnLogin']))
			{
				$user = $db->quote($_POST['txtUser']);
				$pass = sha1($_POST['txtPass']);
				
				$checkQuery = $db->selectReturnRows("SELECT * FROM mf_accounts where username='$user' AND password='$pass'");
				if($checkQuery > 0)
				{
					//Registering Sessions
					session_start();
					$dataQuery = $db->select("SELECT * FROM mf_accounts where username='$user' AND password='$pass'");
					$userInfo = array();
					$userInfo['name'] = $user;
					$userInfo['flag'] = $dataQuery[0]['flag'];
					$_SESSION['user'] = $userInfo;
					header("Location: admin.php");
					exit;
				}else
				{
					
				}
			}
		?>
    		<div id="frmLoginPanel">
    			<form id="frmLogin" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>">
	    			<div class="container-fluid">
	    				<div class="row">
	    					<div class="col-lg-12">
	    						<labe><strong>Username</strong></labe>
	    					</div>
	    				</div>
	    				<div class="row">
	    					<div class="col-lg-12">
	    						<input type="text" class="form-control" placeholder="Username" id="txtUser" name="txtUser" />
	    					</div>
	    				</div>
	    				<div class="row">
	    					<div class="col-lg-12">
	    						<labe><strong>Password</strong></labe>
	    					</div>
	    				</div>
	    				<div class="row">
	    					<div class="col-lg-12">
	    						<input type="password" class="form-control" placeholder="Password" id="txtPass" name="txtPass" />
	    					</div>
	    				</div>
	    				<div class="row">
	    					<div class="col-lg-12">
	    						<input type="submit" id="btnLogin" name="btnLogin" class="btn-lg btn-info btn-block center-block" value="Login">
	    					</div>
	    				</div>
	    			</div>
	    		</form>
	    		
    		</div>
    		
    	</div>
    </body>
</html>