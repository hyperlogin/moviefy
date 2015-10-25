<div id="headerbar">
			<nav class="navbar navbar-inverse navbar-fixed-top">
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a class="navbar-brand" href="#">Moviefy</a>
				    </div>
				
				   	<ul class="nav navbar-right top-nav">
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user">&nbsp;&nbsp;</i><?php echo $_SESSION['user']['name']; ?> <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href="#"><i class="fa fa-cog">&nbsp;&nbsp;</i>Settings</a></li>
				            <li role="separator" class="divider"></li>
				            <li><a href="logout.php"><i class="fa fa-power-off">&nbsp;&nbsp;</i>Logout</a></li>		            
				          </ul>
				        </li>
				     </ul>
				  
				  <div class="collapse navbar-collapse navbar-ex1-collapse">
	                <ul class="nav navbar-nav side-nav">
	                    <li>
	                        <a href="admin.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
	                    </li>
	                    <li>
	                        <a href="movies.php"><i class="fa fa-fw fa-film"></i> Movies</a>
	                    </li>
	                    <li>
	                        <a href="tvseries.php"><i class="fa fa-fw fa fa-television"></i> TV-Series</a>
	                    </li>
	                    <li>
	                        <a href="users.php"><i class="fa fa-fw fa-users"></i> Manage Moderators</a>
	                    </li>
	                    <li>
	                    	<a href="webmaintain.php"><i class="fa fa-fw fa-wrench"></i> Web Maintainance</a>
	                    </li>
	                </ul>
	            </div>
	            <!-- /.navbar-collapse -->
			</nav>
</div>