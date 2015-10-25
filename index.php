<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	include("class/clsDatabase.php");
	
	$db = new Db();
	
	$recentAdd = $db->select("SELECT * FROM `mf_movies` order by updated_date desc LIMIT 4;");
?>
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
		<link href="css/easy-autocomplete.css" rel="stylesheet" type="text/css"/>
		<link href="css/easy-autocomplete.themes.css" rel="stylesheet" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<link type="text/css" rel="stylesheet" href="https://vjs.zencdn.net/4.12/video-js.css" />
  		<script src="https://vjs.zencdn.net/4.12/video.js"></script>
		<script  src="js/youtube.js"></script>
  		
		<style>
			body {
				background-color:black;
				background: url(images/bg.jpg) no-repeat center center fixed;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
			#content {

				color: white;
				font-size: 16px;
				width: 100%;
				height: 100%;
			}
			#contentHeader {
				margin: 0 auto;
			}
			#contentHeader h2 {
				margin: 0 auto;
				color: white;
				font-size: 40px;
				font-family: 'Dancing Script', arial, serif;
				text-transform: uppercase;
				text-align: center;
				text-shadow: 1px 1px 2px #000;
				font-weight: bold;
				margin-top:5%;
				margin-left:-50%;
			}
			#contentHeader p {
				display: block;
				margin: 0 auto;
				text-align: center;
			}
			
			#rencentAdded
			{
				margin-left:100px;
				padding-top:25px;
				
			}
			#recent_added
			{
				background-color:rgba(0,0,0,.5);
				border-radius:5px;
				
			}
			#recent_added td img
			{
				border-radius: 5px;
			    background: white;
			    padding: 8px; 
				-webkit-box-shadow: 10px 7px 22px 0px rgba(92,92,92,0.5);
				-moz-box-shadow: 10px 7px 22px 0px rgba(92,92,92,0.5);
				box-shadow: 10px 7px 22px 0px rgba(92,92,92,0.5);
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
						
			.btnBrowseMovie
			{
				position:absolute;
				left:80%;
			}
			
			#contentHeader h3
			{
				color:white;
				font-family: 'Dancing Script', arial, serif;
				margin-left:5%;
			}

			.footer {
				position:fixed;
				bottom: 0;
				height: 30px;
				width:100%;
			}
			
			#wrapper
			{
				height:100%;
				width:100%;
			}
			
			#recent_added > tbody > tr > td
			{
				padding:10px;
			}
			
			.footer > ul li
			{
				display:inline;
				font-size:16px;
				padding:10px;
				font-weight:bold;
			}
			.footer > ul li a
			{
				text-decoration:none;
				color:#585858 ;
			}
			.footer > ul li a:hover
			{
				text-decoration:none;
				color:white ;
			}
		</style>
		<body>
			<div id="headerbar">
				<?php include("includes/navbar.php"); ?>
			</div>
            <div id="wrapper">
                <div id="contentHeader">
                    <h2>Moviefy</h2>
                    <h3>Recently Added Movies</h3>
                </div>
                <div id="rencentAdded">
                    <table id="recent_added">
                        <tbody>
                            <tr>
                                <?php
                                for($i = 0; $i < sizeof($recentAdd); $i++)
                                    {
                                ?>
                                <td>
                                    <figure class="cap-bot">
                                    	<?php if($recentAdd[$i]['age_restrict'] == 1){ ?>
                                                <div class="ribbon-wrapper-red"><div class="ribbon-red">Warning</div></div>
                                        <?php } ?>
                                        <img src='<?php echo $recentAdd[$i]['poster_image'] ?>' width="200" height="250" / >
                                        <figcaption>
                                            <div class=".container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div id="content" style="margin:0 auto; text-align: center; font-size: 18px;">
                                                            <p><i class="fa fa-star fa-2x" style="color:#7FFF00;"></i><br><?php echo $recentAdd[$i]['imdb_rating']; ?> / 10</p>
                                                            <p>
                                                                <?php
                                                                    $genre = explode(",", $recentAdd[$i]['genre']);
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
                                                            <span style="width:100%; display:block; font-size:16px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $recentAdd[$i]['movie_title']; ?></span>
														<p style="position:relative;"><br><a href='<?php echo "movie.php?m=".$recentAdd[$i]['id']; ?>' class="btn btn-success">View Movie</a></p>		
                                                        </div>							
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </figcaption>
                                    </figure>
                                </td>
                                <?php
                                    }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="footer">
                    <ul style="list-style-type:none; position:relative; left:40%; margin-right:-50%;">
                    	<li><i class="fa fa-pencil-square-o"></i>&nbsp;<a href="#">Contact us</a></li>
                        <li><i class="fa fa-info-circle"></i>&nbsp;<a href="#">Moviefy - 2015</a></li>
                    </ul>
                </div>
             </div>		
		</body>
</html>