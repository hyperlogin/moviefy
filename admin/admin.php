<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	session_start();
	include("../class/clsDatabase.php");
	include("../includes/permissions.php");
			
	$db = new Db();
	
	$resultTotalMovies = $db->select("SELECT COUNT(*) as ttlMovies from mf_movies");
	 
?>
<html>
    <head>
        <title>Moviefy</title>
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
				$(".side-nav").find('li').eq(0).addClass("active");
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
	                            Dashboard <small>Statistics Overview</small>
	                        </h1>
	                        <ol class="breadcrumb">
	                            <li class="active">
	                                <i class="fa fa-dashboard"></i> Dashboard
	                            </li>
	                        </ol>
	                    </div>
	                </div>
	                <!-- /.row -->
	
	                <div class="row">
	                    <div class="col-lg-12">
	                        <div class="alert alert-info alert-dismissable">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-info-circle"></i>  <strong>Welcome to Moviefy Admin Dashboard</strong>
	                        </div>
	                    </div>
	                </div>
	                <!-- /.row -->
	
	                <div class="row">
	                    <div class="col-lg-3 col-md-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                <div class="row">
	                                    <div class="col-xs-3">
	                                        <i class="fa fa-film fa-5x"></i>
	                                    </div>
	                                    <div class="col-xs-9 text-right">
	                                        <div class="huge"><?php echo $resultTotalMovies[0]['ttlMovies']; ?></div>
	                                        <div>Movies in database</div>
	                                    </div>
	                                </div>
	                            </div>
	                            <a href="movies.php">
	                                <div class="panel-footer">
	                                    <span class="pull-left">View Movies</span>
	                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                                    <div class="clearfix"></div>
	                                </div>
	                            </a>
	                        </div>
	                    </div>
	                    <div class="col-lg-3 col-md-6">
	                        <div class="panel panel-green">
	                            <div class="panel-heading">
	                                <div class="row">
	                                    <div class="col-xs-3">
	                                        <i class="fa fa-television fa-5x"></i>
	                                    </div>
	                                    <div class="col-xs-9 text-right">
	                                        <div class="huge">-</div>
	                                        <div>TV Series</div>
	                                    </div>
	                                </div>
	                            </div>
	                            <a href="#">
	                                <div class="panel-footer">
	                                    <span class="pull-left">View TV Series</span>
	                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                                    <div class="clearfix"></div>
	                                </div>
	                            </a>
	                        </div>
	                    </div>
	                    <div class="col-lg-3 col-md-6">
	                        <div class="panel panel-yellow">
	                            <div class="panel-heading">
	                                <div class="row">
	                                    <div class="col-xs-3">
	                                        <i class="fa fa-users fa-5x"></i>
	                                    </div>
	                                    <div class="col-xs-9 text-right">
	                                        <div class="huge">-</div>
	                                        <div>Moderators</div>
	                                    </div>
	                                </div>
	                            </div>
	                            <a href="#">
	                                <div class="panel-footer">
	                                    <span class="pull-left">View Details</span>
	                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                                    <div class="clearfix"></div>
	                                </div>
	                            </a>
	                        </div>
	                    </div>
	                    <div class="col-lg-3 col-md-6">
	                        <div class="panel panel-red">
	                            <div class="panel-heading">
	                                <div class="row">
	                                    <div class="col-xs-3">
	                                        <i class="fa fa-support fa-5x"></i>
	                                    </div>
	                                    <div class="col-xs-9 text-right">
	                                        <div class="huge">-</div>
	                                        <div>Movie / Tv Series Requests</div>
	                                    </div>
	                                </div>
	                            </div>
	                            <a href="#">
	                                <div class="panel-footer">
	                                    <span class="pull-left">View Details</span>
	                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                                    <div class="clearfix"></div>
	                                </div>
	                            </a>
	                        </div>
	                    </div>
	                </div>
	                <!-- /.row -->
	
	                <div class="row">
	                    <div class="col-lg-4">
	                        <div class="panel panel-default">
	                            <div class="panel-heading">
	                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Recently Added Movie Panel</h3>
	                            </div>
	                            <div class="panel-body">
	                                <div class="list-group">
	                                    <a href="#" class="list-group-item">
	                                        <span class="badge">just now</span>
	                                        <i class="fa fa-fw fa-calendar"></i> Calendar updated
	                                    </a>
	                                    
	                                </div>
	                                <div class="text-right">
	                                    <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-4">
	                        <div class="panel panel-default">
	                            <div class="panel-heading">
	                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Recently Added Movie Panel</h3>
	                            </div>
	                            <div class="panel-body">
	                                <div class="list-group">
	                                    <a href="#" class="list-group-item">
	                                        <span class="badge">just now</span>
	                                        <i class="fa fa-fw fa-calendar"></i> Calendar updated
	                                    </a>
	                                    
	                                </div>
	                                <div class="text-right">
	                                    <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!-- /.row -->
	
	            </div>
	            <!-- /.container-fluid -->
			</div>
		</div>
    </body>
</html>