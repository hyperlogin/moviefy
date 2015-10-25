<?php
	include("../class/clsDatabase.php");
	include("../includes/permissions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Moviefy</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Moviefy - Streaming Movies for all needs" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css' />
		<link href='../css/bootstrap.min.css' rel='stylesheet'  type="text/css"/>
		<link href='../css/bootstrap-theme.min.css' rel='stylesheet'  type="text/css"/>
		<link href='sb-admin.css' rel='stylesheet'  type="text/css"/>
		<link href='../css/font-awesome.min.css' rel='stylesheet'  type="text/css"/>
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<style>
			body
			{
				background-color:white;
			}

		</style>
		<script type="text/javascript">
			$(window).load(function(){
				//Movie Page
				$(".side-nav").find('li').eq(3).addClass("active");
			});
		</script>
    <body>
		<div id="wrapper">
			<?php include("includes/inc_navBar.php"); ?>
			
			<div id="page-wrapper">
				<div class="container-fluid">
	
	                <!-- Page Heading -->
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h1 class="page-header">
	                            Manage Mods<small>Moderators Overview</small> &nbsp; <button id='btnAddMovie' class="btn btn-danger">Add Movies</button>
	                        </h1>
	                        <ol class="breadcrumb">
	                            <li class="active">
	                                <i class="fa fa-dashboard"></i> Moderators
	                            </li>
	                        </ol>
	                    </div>
	                </div>
	            </div>
	            <!-- /.container-fluid -->
			</div>
		</div>
    </body>
</html>