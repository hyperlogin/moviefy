<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	include("class/clsDatabase.php");
		
	$db = new Db();
	$search='';
	if(isset($_POST['btnSearch']) && $_POST['txtSearchMovies'] != ""){
		$search = $_POST['txtSearchMovies'];
		$totalMovies = $db->select("SELECT COUNT(*) as ttlMovies FROM mf_movies where movie_title LIKE '%$search%' order by added_date asc");
	}else if(isset($_GET['search']) && $_GET['search'] != '')
	{
			$totalMovies = $db->select("SELECT COUNT(*) as ttlMovies FROM mf_movies where movie_title LIKE '%".mysql_real_escape_string($_GET['search'])."%' order by added_date asc");
	}else{
			$totalMovies = $db->select("SELECT COUNT(*) as ttlMovies FROM mf_movies");
	}
	/*
	 * [ PAGINATION]
	 * 
	 */
		$noRowsPerPage = 20;
		$numPages = ceil($totalMovies[0]['ttlMovies'] / $noRowsPerPage);
		
		// get the current page or set a default
		if (isset($_GET['page']) && is_numeric($_GET['page'])) {
		   // cast var as int
		   $currentpage = (int) $_GET['page'];
		} else {
		   // default page num
		   $currentpage = 1;
		} // end if
		
		// if current page is greater than total pages...
		if ($currentpage > $numPages) {
		   // set current page to last page
		   $currentpage = $numPages;
		} // end if
		// if current page is less than first page...
		if ($currentpage < 1) {
		   // set current page to first page
		   $currentpage = 1;
		} // end if
				
		// the offset of the list, based on current page 
		$offset = ($currentpage - 1) * $noRowsPerPage;
		
		if(isset($_POST['btnSearch']))	
		{	
			$resultAllMovie = $db->select("SELECT * FROM mf_movies where movie_title LIKE '%$search%' ORDER BY added_date desc LIMIT $offset , $noRowsPerPage");
		}else{
			if(isset($_GET['search']))
				$resultAllMovie = $db->select("SELECT * FROM mf_movies where movie_title LIKE '%".mysql_real_escape_string($_GET['search'])."%' ORDER BY added_date desc asc LIMIT $offset , $noRowsPerPage");
			else 
				$resultAllMovie = $db->select("SELECT * FROM mf_movies ORDER BY added_date desc LIMIT $offset , $noRowsPerPage ");
		}
?>
<html>
	<head>
		<title>Moviefy</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="description" content="Moviefy - Streaming Movies for all needs" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css' />
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<!--<link href="http://vjs.zencdn.net/5.0.0/video-js.min.css" media="screen" rel="stylesheet">-->
		<link href="css/videojs.caption.min.css" media="screen" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet"  type="text/css"/>
		<link href='css/bootstrap.min.css' rel='stylesheet'  type="text/css"/>
		<link href='css/bootstrap-theme.min.css' rel='stylesheet'  type="text/css"/>
		<link href='css/font-awesome.min.css' rel='stylesheet'  type="text/css"/>
		<link href="css/easy-autocomplete.css" rel="stylesheet" type="text/css"/>
		<link href="css/easy-autocomplete.themes.css" rel="stylesheet" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
  		
		<style>
			body {
				
				background: ##229cff;
				background-image: url("images/zenbg-1.png"), url("images/zenbg-2.png");
				background-repeat: repeat-x, repeat;
			}
		
			
			#searchTerms
			{
				width:100%;
				height:300px;
				background-color:rgba(0,0,0,.3);
				position:relative;
				margin-top:-20px;
				
				
			}
			#frmSearch
			{
				width:800px;
				display:block;
				position:relative;
				margin:0 auto;
				left:90px;
				top:50px;
				color:white;
			}
			#frmSearch h2
			{
				color:white;
			}
			
			#txtResults
			{
				position:absolute;
				left:10%;
				top:400px;
				width:1340px;
			    padding: 10px;
			    margin:0 auto;
			}
			
			#total_movie
			{
				text-align:center;
				margin-left:-230px;
				color:white;
				font-weight:bold;
			}
			
			#page
			{
				width:400px;
				margin:0 auto;
			}
			
			figure {
			  display: block;
			  position: relative;
			  float: left;
			  overflow: hidden;
			  margin: 0 20px 20px 0;
			}
			
			figure img
			{
				border-radius: 5px;
			    background: white;
			    padding: 8px; 
				-webkit-box-shadow: 10px 7px 22px 0px rgba(92,92,92,0.5);
				-moz-box-shadow: 10px 7px 22px 0px rgba(92,92,92,0.5);
				box-shadow: 10px 7px 22px 0px rgba(92,92,92,0.5);
			}
			
			figcaption {
			  position: absolute;
			  background: black;
			  background: rgba(0,0,0,0.75);
			  color: white;
			  width:100%;
			  height:100%;
			  padding: 10px 20px;
			  opacity: 0;
			  -webkit-transition: all 0.6s ease;
			  -moz-transition:    all 0.6s ease;
			  -o-transition:      all 0.6s ease;
			}
			figure:hover figcaption {
			  opacity: 1;
			  -webkit-border-radius: 5px;
			  -moz-border-radius:    5px;
			  border-radius:         5px;
			}
			figure:before {
			  content: "?";
			  position: absolute;
			  font-weight: 800;
			  background: black;
			  background: rgba(255,255,255,0.75);
			  text-shadow: 0 0 5px white;
			  color: black;
			  width: 24px;
			  height: 24px;
			  -webkit-border-radius: 12px;
			  -moz-border-radius:    12px;
			  border-radius:         12px;
			  text-align: center;
			  font-size: 14px;
			  line-height: 24px;
			  -moz-transition: all 0.6s ease;
			  opacity: 0.75;
			}
			figure:hover:before {
			  opacity: 0;
			}
						
			.cap-left:before {  bottom: 10px; left: 10px; }
			.cap-left figcaption { bottom: 0; left: -30%; }
			.cap-left:hover figcaption { left: 0; }
			
			.cap-right:before { bottom: 10px; right: 10px; }
			.cap-right figcaption { bottom: 0; right: -30%; }
			.cap-right:hover figcaption { right: 0; }
			
			.cap-top:before { top: 10px; left: 10px; }
			.cap-top figcaption { left: 0; top: -30%; }
			.cap-top:hover figcaption { top: 0; }
			
			.cap-bot:before { bottom: 10px; left: 10px; }
			.cap-bot figcaption { left: 0; bottom: -30%;}
			.cap-bot:hover figcaption { bottom: 0; }
			
		</style>
		<script type="text/javascript">
				$(document).ready(function(){
					
				});
		</script>
	</head>
		<body>
			<div id="backdrop"></div>
			<div id="headerbar">
				<?php include("includes/navbar.php"); ?>
			</div>
			<div id="searchTerms">
				<form id="frmSearch" method="post" action="<?php $_SERVER['PHP_SELF'];?>">
					<div id="frmItems" class="container-fluid">
						<div class="row">
							<div class="col-md-6">
								<h2>Search Terms </h2>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6"><input type="text" id="txtSearchMovies" class="form-control" name="txtSearchMovies" /></div>
							<div class="col-md-1"><input type="submit" id="btnSearch" name="btnSearch" class="btn btn-success btn-lg" style="margin-top:-5px;" value="Search"></div>
						</div>
						<div class="row" style="padding-top:15px;">
							<div class="col-md-2">
								Genre:<br>
								<select class="form-control" id="selectGenre">
									<option value="all" selected="true">All</option>
									<option value="action">Action</option>
									<option value="adventure">Adventure</option>
									<option value="animation">Animation</option>
									<option value="bio">Biography</option>
									<option value="comedy">Comedy</option>
									<option value="crime">Crime</option>
									<option value="doc">Documentary</option>
									<option value="drama">Drama</option>
									<option value="family">Family</option>
									<option value="horror">Horror</option>
									<option value="music">Music</option>
									<option value="romance">Romance</option>
									<option value="scifi">Sci-Fi</option>
									<option value="triller">Triller</option>
									<option value="war">War</option>
								</select>
							</div>
							<div class="col-md-2">
								Rating:<br>
								<select class="form-control" id="selectRating">
									<option value="all" selected="true">All</option>
									<option value="9">9+</option>
									<option value="8">8+</option>
									<option value="7">7+</option>
									<option value="6">6+</option>
									<option value="5">5+</option>
									<option value="4">4+</option>
									<option value="3">3+</option>
									<option value="2">2+</option>
									<option value="1">1+</option>
								</select>
							</div>
							<div class="col-md-2">
								Order By:<br>
								<select class="form-control" id="selectOrder">
									<option value="asc" selected="true">Latest</option>
									<option value="desc">Oldest</option>
									<option value="year">Year</option>
									<option value="alpha">Alphabetical</option>
									<option value="rate">Rating</option>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<h3 id="total_movie"><?php if($totalMovies[0]['ttlMovies'] > 0){echo $totalMovies[0]['ttlMovies']."- Movies Found";}else{ echo "Aw.. no results found.";}?></h3>
			<div id="txtResults">
				<?php include("includes/paginationbrowsemovie.php"); ?>
				<div class="container-fluid" id="movieList">
				 <?php
						$max_items_per_row = 4;
									
						$count = 0;
						$newRow = true;
								
						for($i = 0; $i < sizeof($resultAllMovie); $i++)
						{
							if($count > ($max_items_per_row))
							{
								//Reset
								echo "</div>";
								$count = 0;
								$newRow = true;
								
							}
							if($newRow)
							{
								$newRow = false;
								echo "<div class='row'>";
								
							}
							
					?>
					
						<div class="col-md-2">
							<figure class="cap-bot" style="margin-left:50px;">
                            	<?php if($resultAllMovie[$i]['age_restrict'] == 1){ ?>
									<div class="ribbon-wrapper-red"><div class="ribbon-red">Warning</div></div>
                                <?php } ?>
                                <img src="<?php echo $resultAllMovie[$i]['poster_image'];?>" alt="<?php echo $resultAllMovie[$i]['movie_title']; ?>" height="250" width="180">
								<figcaption>
									<div class=".container-fluid">
											<div class="row">
												<div class="col-lg-12">
													<div id="content" style="margin:0 auto; text-align: center; font-size: 18px;">
														<p><i class="fa fa-star fa-2x" style="color:#7FFF00;"></i><br><?php echo $resultAllMovie[$i]['imdb_rating']; ?> / 10</p>
														<p>
															<?php
																$genre = explode(",", $resultAllMovie[$i]['genre']);
																$sizeCut = '';
																if(sizeof($genre) < 3)
																	$sizeCut = 1;
																else if(sizeof($genre) >= 3)
																	$sizeCut = 2;
																else 
																	$sizeCut = $sizeof($genre);
																if($sizeCut == 1) { echo "<br>";}
																for($j = 0 ; $j < $sizeCut; $j++)
																{
																	echo $genre[$j]."<br>";
																}
															?>
														</p>
														<span style="width:100%; display:block; font-size:16px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $resultAllMovie[$i]['movie_title']; ?></span>
														<p style="position:relative;"><br><a href='<?php echo "movie.php?m=".$resultAllMovie[$i]['id']; ?>' class="btn btn-success">View Movie</a></p>	
													</div>							
												</div>
											</div>
										</div>
								</figcaption>
							</figure>
						</div>
						<?php
							$count++;
							}
						?>
					</div>
					<?php include("includes/paginationbrowsemovie.php"); ?>
				</div>
		</body>
</html>