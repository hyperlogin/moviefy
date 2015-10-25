<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	include("class/clsDatabase.php");
	include("process/processvideo.php");
	
	$db = new Db();
	
	$recentAdd = $db->select("SELECT * FROM `mf_movies` WHERE ID='".$db->quote($_GET['m'])."'");
	
	$videoLink = new video();
	$video = $videoLink->GetPicsaVideo($recentAdd[0]['stream_links']);
	
?>
<html>
	<head>
		<title>Moviefy - <?php echo $recentAdd[0]['movie_title']; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="description" content="Moviefy - Streaming Movies for all needs" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css' />
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<!--<link href="http://vjs.zencdn.net/5.0.0/video-js.min.css" media="screen" rel="stylesheet">-->
		<link href="css/videojs.caption.min.css" media="screen" rel="stylesheet">
		
		<link href='css/bootstrap.min.css' rel='stylesheet'  type="text/css"/>
		<link href='css/bootstrap-theme.min.css' rel='stylesheet'  type="text/css"/>
		<link href='css/font-awesome.min.css' rel='stylesheet'  type="text/css"/>
		
        <link href="css/easy-autocomplete.css" rel="stylesheet" type="text/css"/>
		<link href="css/easy-autocomplete.themes.css" rel="stylesheet" type="text/css" />
        
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/vague.js"></script>
		
		<link type="text/css" rel="stylesheet" href="https://vjs.zencdn.net/4.12/video-js.css" />
        <link href="css/videojs-hd.css" rel="stylesheet" />
        <script src="js/videojs-hd.js" type="text/javascript"></script>
  		<script src="https://vjs.zencdn.net/4.12/video.js"></script>
		<script  src="js/youtube.js" type="text/javascript"></script>
  		
		<style>
			body {
				background-color:#262626;
			}
			
			#backdrop
			{
				background-color:black;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
				width:100%;
				height:100%;
				position:absolute;
				z-index:-1;
				top:0;
			}
			#content
			{
				width:50%;
				background-color:rgba(0,0,0,.7);
				border-radius: 5px;
				height:700px;
				position:absolute;
				left:23%;
				top:10%;
			}
			#content img
			{
				border-radius: 5px;
			    background: white;
			    padding: 5px;
			    margin:15px;
			}
			#moviePoster h2
			{
				color:white;
				font-family: 'Dancing Script', arial, serif;
				padding-left:15px;
				margin-top:-5px;
				font-size:20px;
				text-align:left;
			}
			
			#movieDetails
			{
				color:white;
				font-weight:bolder;
				position:relative;
				top:-35%;
				left:33%;
			}

			#movieLinks
			{
				padding:35px;
				width:70%;
				position:relative;
				top:-250px;
				left:40px;
				color:white;
			}
			
			.tab-content > div
			{
				background-color:rgba(0,0,0,.6);
				border-radius: 5px;
				width:100%;
				height:100%;
			}
			
			.tab-content > .tab-pane
			{
				height:300px;
			}
			
			.nav-tabs > li > a,
			.nav-tabs > li > a:hover,
			.nav-tabs > li > a:focus{
			    color: #929292;
			    background-color: rgba(0,0,0,.5);
			} 
			
			.nav-tabs > li.active > a,
			.nav-tabs > li.active > a:hover,
			.nav-tabs > li.active > a:focus{
			    color: #929292;
			    background-color: rgba(0,0,0,.7);
			} 
			
			#nostream
			{
				color:white;
				font-family: 'Dancing Script', arial, serif;
				font-size:25px;
				padding:20px;
			}
			
			.popover
			{
				max-width: 500px;
				width: auto;
			}
			
			
		</style>
		<script type="text/javascript">
				$(document).ready(function(){
					$("#backdrop").css("background-image" , "url(" + $("#backdrop").attr("backdrop") + ')');
					
					$('.nav-tabs a').click(function (e) {
					  e.preventDefault()
					  $(this).tab('show')
					})
					HDtoggle();
					$('[data-toggle="popover"]').popover({
						"placement":"right",
						"title":"Full Sypnosis",
					});
					
					var vague = $('#backdrop').Vague({
						intensity:      30,      // Blur Intensity
						forceSVGUrl:    false,   // Force absolute path to the SVG filter,
						// default animation options
						animationOptions: {
						  duration: 1000,
						  easing: 'linear' // here you can use also custom jQuery easing functions
						}
					});
					
					vague.blur();
				});
		</script>
	</head>
		<body>
			<div id="headerbar">
				<?php include("includes/navbar.php"); ?>
			</div>
			<div id="backdrop" backdrop ='<?php echo $recentAdd[0]['backdrop_image'];?>'></div>
			<div id="content">
				<div id="moviePoster">
					<img src="<?php echo $recentAdd[0]['poster_image']; ?>" alt="<?php echo $recentAdd[0]['movie_title']; ?>" width="200" height="250" />
					<h2><?php echo $recentAdd[0]['movie_title']; ?></h2>
				</div>
				<div id="movieDetails">
					<p>Release Year : <?php echo $recentAdd[0]['release_year']; ?></p>
					<p>Genre : <?php echo str_replace(","," / ",$recentAdd[0]['genre']); ?></p>
					<div class="ratingreview">
						<img src='images/rt-fresh.png' alt="rottomTomato" style="background-color:transparent;"/>&nbsp;<span style="padding-top:10px;"><?php echo $recentAdd[0]['critics']."% - Critics"; ?></span>
						<img src='images/rt-upright.png' alt="audience" style="background-color:transparent;"/>&nbsp;<span style="padding-top:10px;"><?php echo $recentAdd[0]['audience']."% - Audience"; ?></span>
						<img src='images/logo-imdb.svg' alt="imdb" style="background-color:transparent;"/>&nbsp;<span style="padding-top:10px;"><?php echo $recentAdd[0]['imdb_rating']." /10 "; ?>&nbsp;<i class="fa fa-star" style="color:green;"></i></span>
					</div>
					<h3>Synopsis</h3><p style="width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $recentAdd[0]['overview'];?></p><span style='color:white;'><button type="button" class="btn btn-info" data-container="body" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="<?php echo $recentAdd[0]['overview'];?>">
  View full sypnosis
</button></span>
				</div>
				<div id="movieLinks">
					<ul class="nav nav-tabs" role="tablist">
					  <li role="presentation" class="active" aria-controls="trailer" role="tab" data-toggle="tab"><a href="#trailer"><i class="fa fa-film"></i>&nbsp;Trailer</a></li>
					  <li role="presentation" aria-controls="html5" role="tab" data-toggle="tab"><a href="#html5"><i class="fa fa-video-camera"></i>&nbsp;Stream</a></li>
				      <li role="presentation" aria-controls="mirror" role="tab" data-toggle="tab"><a href="#mirror"><i class="fa fa-external-link"></i>&nbsp;Mirrors</a></li>
				   </ul>
					
					<!-- Tab panes -->
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="trailer"><iframe width="99%" height="99%" src="<?php echo $recentAdd[0]['trailer_link'];?>" frameborder="0" allowfullscreen></iframe></div>
				    <div role="tabpanel" class="tab-pane" id="html5">
				    	<?php 
				    		if($video != "" || $video != NULL){
				    	?>
						  <video id="moviestream" class="video-js vjs-default-skin vjs-big-play-centered" style="padding:15px;" width="99%" height="99%" controls preload="auto"  data-setup="{}" poster="<?php echo $recentAdd[0]['poster_image']; ?>" HD="<?php 
						  if($video['1080'] !== "")
						  { 
						  	echo $video['1080']; 
						  } else {
						    echo $video['720']; 
						  }?>" nonHD="<?php echo $video['SD'] ?>">
						  	<source src="<?php echo $video['SD']; ?>" type="video/mp4"></source>
						  		<p class="vjs-no-js">
							      To view this video please enable JavaScript, and consider upgrading to a web browser that
							      <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
							    </p>
						  </video>
						 <?php
							}else{
						 ?>
						 	<p id="nostream">No streams at the moment....</p>
						 <?php }?>
                         
					</div>
				    <div role="tabpanel" class="tab-pane" id="mirror"><embed src=""></embed></div>
				  </div>
				</div>
			</div>
		</body>
</html>