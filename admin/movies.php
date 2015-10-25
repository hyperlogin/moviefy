<?php
	session_start();
	include('../class/clsDatabase.php');
	include("../includes/permissions.php");
		
	$db = new Db();
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Moviefy</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Moviefy - Streaming Movies for all needs" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css' />
		<link href="../css/bootstrap-table.css" rel="stylesheet" type="text/css" />
		<link href='../css/bootstrap.min.css' rel='stylesheet'  type="text/css"/>
		<link href='../css/bootstrap-theme.min.css' rel='stylesheet'  type="text/css"/>
		<link href='sb-admin.css' rel='stylesheet'  type="text/css"/>
		<link href='../css/font-awesome.min.css' rel='stylesheet'  type="text/css"/>
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="../js/themoviedb.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/moment.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		<script type="text/javascript" src="../js/ext/bootstrap-table-toolbar.js"></script>
        <script type="text/javascript" src="../js/moviefy.js"></script>
		<style>
			body
			{
				background-color:white;
			}
			
			.fontDancing
			{
				font-family: 'Dancing Script', arial, serif;
			}
			
			@media screen and (min-width: 768px) {
				#addMovieModal .modal-dialog  {width:900px;}
				#updateMovieModal .modal-dialog  {width:900px;}
			}
			
			.star-five {
			   display: block;
			   color: green;
			   width: 0px;
			   height: 0px;
			   border-right:  100px solid transparent;
			   border-bottom: 70px  solid green;
			   border-left:   100px solid transparent;
			   -moz-transform:    rotate(35deg) scale(.1);
			   -webkit-transform: rotate(35deg) scale(.1);
			   -ms-transform:     rotate(35deg) scale(.1);
			   -o-transform:      rotate(35deg) scale(.1);
			}
			.star-five:before {
			   border-bottom: 80px solid green;
			   border-left: 30px solid transparent;
			   border-right: 30px solid transparent;
			   position: absolute;
			   height: 10px;
			   width: 0;
			   top: -45px;
			   left: -65px;
			   display: block;
			   content: '';
			   -webkit-transform: rotate(-35deg);
			   -moz-transform:    rotate(-35deg);
			   -ms-transform:     rotate(-35deg);
			   -o-transform:      rotate(-35deg);
			
			}
			.star-five:after {
			   position: absolute;
			   display: block;
			   color: green;
			   top: 3px;
			   left: -105px;
			   width: 0px;
			   height: 0px;
			   border-right: 100px solid transparent;
			   border-bottom: 70px solid green;
			   border-left: 100px solid transparent;
			   -webkit-transform: rotate(-70deg);
			   -moz-transform:    rotate(-70deg);
			   -ms-transform:     rotate(-70deg);
			   -o-transform:      rotate(-70deg);
			   content: '';
			     
			}
			
						
			a {text-decoration: none; color:#333333;}
			a:hover { text-decoration : none; color:#666666;}
		</style>
		<script type="text/javascript">
			$(window).load(function(){
				//Movie Page
				$(".side-nav").find('li').eq(1).addClass("active");
				
				//Add event to Add movie button
				$("#btnAddMovie").click(function(){
					$("#addMovieModal").modal({backdrop:true,});
				});
				
				//Add events to the IMDB Button
				$("#fillDataIMDB").click(function(){
					$(".loader").removeClass("hidden");
					moviefy.init();
					moviefy.searchMovie($("#txtIMDBCode").val());
				});
				//Populate Table
				$("#movie_table").bootstrapTable({
						pagination:true,
						pageSize: 5,
						pageList : [5,10,25,50],
						search: true,
						onPageChange : function(number,size) {
							$("#movie_table > tbody tr").each(function(){
								$(this).find("td:eq(7)").text(moment().to($(this).find("td:eq(7)").text()));
							});
							
							//Add events to the Edit Button
							$("a[id=editMovie]").click(function(){
								$(".btnUpdateButton").attr("mID",$(this).attr("mID"));
								//Retrieve Data
								$.ajax({
									url: "../process/processmovie.php?action=view",
									method:"POST",
									data : {id:$(this).attr("mID")}
								}).complete(function(msg){
									console.log(msg.responseText);
									var mData = JSON.parse(msg.responseText);
									var mData = mData[0];
									$("#txtEdMovieTitle").val(mData.movieTitle);
									$("#txtEdGenre").val(mData.genre);
									$("#taEdMovieoverview").val(mData.overview);
									$("#txtEdYear").val(mData.release_year);
									$("#imgEdPoster").attr("src",mData.imgPoster);
									$("#imgEdBackDrop").attr("src",mData.imgBackDrop);
									$("#txtEdTrailerLnk").val(mData.trailer);
									$("#txtEdRating").val(mData.imdbRate);
									$("#txtEdCritics").val(mData.critics);
									$("#txtEdAudience").val(mData.audience);
									$("#txtEdIMDBCode").val(mData.imdbID);
									$("#txtEdStreamLinks").val(mData.stream);
									if(mData.ageRestrict == 1) { $("#updateMovieModal #chkAgeRestrict").attr("checked",true); }else{ $("#updateMovieModal #chkAgeRestrict").attr("checked",false); }
									$("#updateMovieModal").modal();	
								});
								
							});
							
							//Add Event to the remove button
							$("a[id=removeMovie]").click(function(){
								$(".btnRemoveMovie").attr("mID",$(this).attr("mID"));
								$("#removeMovieModal").modal();
							});
						}
				});
				
				//Update Time stamp
				$("#movie_table > tbody tr").each(function(){
					$(this).find("td:eq(7)").text(moment().to($(this).find("td:eq(7)").text()));
				});
				
				//Add events to the Edit Button
				$("a[id=editMovie]").click(function(){
					$(".btnUpdateButton").attr("mID",$(this).attr("mID"));
					//Retrieve Data
					$.ajax({
						url: "../process/processmovie.php?action=view",
						method:"POST",
						data : {id:$(this).attr("mID")}
					}).complete(function(msg){
						var mData = JSON.parse(msg.responseText);
						var mData = mData[0];
						$("#txtEdMovieTitle").val(mData.movieTitle);
						$("#txtEdGenre").val(mData.genre);
						$("#taEdMovieoverview").val(mData.overview);
						$("#txtEdYear").val(mData.release_year);
						$("#imgEdPoster").attr("src",mData.imgPoster);
						$("#imgEdBackDrop").attr("src",mData.imgBackDrop);
						$("#txtEdTrailerLnk").val(mData.trailer);
						$("#txtEdRating").val(mData.imdbRate);
						$("#txtEdCritics").val(mData.critics);
						$("#txtEdAudience").val(mData.audience);
						$("#txtEdIMDBCode").val(mData.imdbID);
						$("#txtEdStreamLinks").val(mData.stream);
						if(mData.ageRestrict == 1) { $("#updateMovieModal #chkAgeRestrict").attr("checked",true); }else{ $("#updateMovieModal #chkAgeRestrict").attr("checked",false); }
						$("#updateMovieModal").modal();	
					});
					
				});
				
				//Add Event to the remove button
				$("a[id=removeMovie]").click(function(){
					$(".btnRemoveMovie").attr("mID",$(this).attr("mID"));
					$("#removeMovieModal").modal();
				});
				
				$(".btnRemoveMovie").click(function()
				{
					var _mid = $(".btnRemoveMovie").attr("mID");
					$.ajax({
							url : "../process/processmovie.php?action=delete",
							method: "POST",
							data : { mid : _mid },
							
					}).complete(function(msg){
						if(msg.responseText == 200)
						{
							alert("Remove Success");
						}
					});
				});
				
				$(".btnCancelRemove").click(function(){ $(".btnRemoveMovie").removeAttr("mID"); });
				
				//Update to Database
				$(".btnUpdateButton").click(function(){
					var DateTime = moment(moment()).format("MM-DD-YYYY HH:mm:ss");
					$.ajax({
						url:"../process/processmovie.php?action=update",
						method:"POST",
						data : {
								movieTitle : $("#txtEdMovieTitle").val(), 
								genre : $("#txtEdGenre").val(), 
								movieoverview : $("#taEdMovieoverview").val(), 
								year : $("#txtEdYear").val(),
								posted_date : DateTime,
								updated_date : DateTime, 
								imgPoster : $("#imgEdPoster").attr("src"), 
								imgBackDrop : $("#imgEdBackDrop").attr("src"), 
								trailerLnk : $("#txtEdTrailerLnk").val(), 
								rating : $("#txtEdRating").val(), 
								critics : $("#txtEdCritics").val(), 
								audience : $("#txtEdAudience").val(),
								imdbcode : $("#txtEdIMDBCode").val(), 
								streamLinks : $("#txtEdStreamLinks").val(),
								id: $(".btnUpdateButton").attr("mID"),
								ageRestrict : $('input[name="chkAgeRestrict"]:checked').length} 
								
					}).complete(function(msg)
					{	
						console.log(msg.responseText);			
						$("#updateMovieModal").modal('hide');
						$("#addMovieSuccessModal").modal('show');
					});
				});
				
				//Submit to Database
				$(".btnSubmitMovie").click(function(){
					var DateTime = moment(moment()).format("MM-DD-YYYY HH:mm:ss");
					$.ajax({
						url:"../process/processmovie.php?action=add",
						method:"POST",
						data : {
								movieTitle : $("#txtMovieTitle").val(), 
								genre : $("#txtGenre").val(), 
								movieoverview : $("#taMovieoverview").val(), 
								year : $("#txtYear").val(),
								posted_date : DateTime,
								updated_date : DateTime, 
								imgPoster : $("#imgPoster").attr("src"), 
								imgBackDrop : $("#imgBackDrop").attr("src"), 
								trailerLnk : $("#txtTrailerLnk").val(), 
								rating : $("#txtRating").val(), 
								critics : $("#txtCritics").val(), 
								audience : $("#txtAudience").val(),
								imdbcode : $("#txtIMDBCode").val(), 
								streamLinks : $("#txtStreamLinks").val(),
								ageRestrict : $('input[name="chkAgeRestrict"]:checked').length} 
								
					}).complete(function(msg)
					{
						if(msg.responseText > 0)
						{
							$(".movie_table > tbody:last-child").append(
								"<tr>" +
								'<input type="hidden" id="mID" value="' + msg + '" />'+
								'<td class="col-md-1"><img src="'+ $("#imgPoster").attr("src") + '" alt="' + $("#txtMovieTitle").val() + '" width="50" height="75" /></td>'+
								'<td class="col-md-1">' + $("#txtMovieTitle").val() + '</td>'+
							  	'<td class="col-md-2"><p style="width:350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' + $("#taMovieoverview").val() + '</p></td>'+
							  	'<td class="col-md-1">' + $("#txtCritics").val() + '%</td>'+
							  	'<td class="col-md-1">' + $("#txtAudience").val() + '%</td>'+
							  	'<td class="col-md-1">' + $("#txtRating").val() + '</td>' +	
							  	'<td class="col-md-2">' + DateTime +'</td>' +	
							  	'<td class="col-md-1"><i class="fa fa-cog fa-2x" style="color:#19A3D1;"></i>&nbsp;<i class="fa fa-trash fa-2x" style="color:red;"></i></td>');	
							
							$("#addMovieModal").modal('hide');
							$("#addMovieSuccessModal").modal('show');
							moviefy.clearMovieData();
						}
					});
				});
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
	                            Movies <small>Shows Overview</small> &nbsp; <button id='btnAddMovie' class="btn btn-danger">Add Movies</button>
	                        </h1>
	                        <ol class="breadcrumb">
	                            <li class="active">
	                                <i class="fa fa-dashboard"></i> Movies
	                            </li>
	                        </ol>
	                    </div>
	                </div>
	                <!-- /.row -->

					<div class="row">
						<div class="col-lg-12">
							<table id="movie_table">
							  <thead>
							  		<tr>
							  			<th class="col-md-1">Poster</th>
							  			<th class="col-md-1" data-sortable="true">Title</th>
							  			<th class="col-md-2">Overview</th>
							  			<th class="col-md-1" data-sortable="true">Release Year</th>
							  			<th class="col-md-1" data-sortable="true"><img src="../images/rt-fresh.png" height="20" width="20" alt='critics'/> Critics</th>
							  			<th class="col-md-1" data-sortable="true"><img src="../images/rt-upright.png" height="20" width="20" alt='critics'/> Audience</th>
							  			<th class="col-md-1" data-sortable="true"><i class="fa fa-star" style="color:green;"></i> Ratings</th>
							  			<th class="col-md-2" data-sortable="true">Added Date</th>
							  			<th class="col-md-1"></th>
							  		</tr>
							  		<!-- MAX 5 Movies can be displayed -->
							  </thead>
							  <tbody>
							  	<?php
							  		$queryAllMovie = $db->select("SELECT * from mf_movies");
									for($i = 0; $i < sizeof($queryAllMovie); $i++)
									{
							  	?>
							  	<tr id="<?php echo $queryAllMovie[$i]['id']; ?>">
							  		<input type="hidden" id="mID" value="<?php echo $queryAllMovie[$i]['id']; ?>" />
							  		<input type="hidden" id="mgenre" value="<?php echo $queryAllMovie[$i]['genre']; ?>" />
							  		<input type="hidden" id="mtrailer" value="<?php echo $queryAllMovie[$i]['trailer_link'];?>" />
							  		<input type="hidden" id="mstream" value="<?php echo $queryAllMovie[$i]['stream_links'];?>" />
							  		<td class="col-md-1"><img src="<?php echo $queryAllMovie[$i]['poster_image'] ?>" alt="<?php echo $queryAllMovie[$i]['movie_title'] ?>" width="50" height="75" /></td>
							  		<td class="col-md-1"><?php echo $queryAllMovie[$i]['movie_title'] ?></td>
							  		<td class="col-md-2"><p style="width:350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $queryAllMovie[$i]['overview']; ?></p></td>
							  		<td class="col-md-1"><?php echo $queryAllMovie[$i]['release_year'];?></td>
							  		<td class="col-md-1"><?php echo $queryAllMovie[$i]['critics']; ?>%</td>
							  		<td class="col-md-1"><?php echo $queryAllMovie[$i]['audience']; ?>%</td>
							  		<td class="col-md-1"><?php echo $queryAllMovie[$i]['imdb_rating']; ?></td>
							  		<td class="col-md-2"><?php echo $queryAllMovie[$i]['updated_date']; ?></td>
							  		<td class="col-md-1"><a href='#' id="editMovie" mID='<?php echo $queryAllMovie[$i]['id'];?>'><i class="fa fa-cog fa-2x" style="color:#19A3D1;"></i></a>&nbsp;<a href="#" id="removeMovie" mID='<?php echo $queryAllMovie[$i]['id'];?>'><i class="fa fa-trash fa-2x" style="color:red;"></i></a></td>
							  	</tr>
							  	<?php
									}
							  	?>
							  </tbody>
							</table>
						</div>
					</div>
					<!-- /.row -->
	            </div>
	            <!-- /.container-fluid -->
			</div>
		</div>
		<!-- Modal Success Boxx -->
		<div class="modal fade" id="addMovieSuccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title"><h2 class="fontDancing">Movie Added</h2></h4>
		      </div>
		      <div class="modal-body">
		        <p>Movie has been added to the database</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- Modal Remove Boxx -->
		<div class="modal fade" id="removeMovieModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title"><h2 class="fontDancing">Remove Movie?</h2></h4>
		      </div>
		      <div class="modal-body">
		        <p>Confirm remove movie?</p>
		      </div>
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-default btnCancelRemove" data-dismiss="modal">Cancel</button>
		        <button type="button" class="btn btn-danger btnRemoveMovie" >Yes Please</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- Add Movie Modal Boxx -->
		<div class="modal fade" id="addMovieModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="addMovieModalTitle"><h2 class="fontDancing" stlye="text-align:center;">Add Movie</h2></h4>
		      </div>
		      <div class="modal-body">
		        	<div class="container-fluid">
		        		<div class="row">
		        			<div class="col-lg-2"><p style="padding-top:5px;">IMDB Code : </p></div>
		        			<div class="col-lg-2"><input type="text" class="form-control" id="txtIMDBCode" name="txtIMDBCode" placeholder="IMDB Code" /></div>
		        			<div class="col-lg-1 loader hidden"><img src='../images/loader.gif' width="15" height="15" alt="loader" /></div>
		        			<div class="col-lg-1"><button type="button" id="fillDataIMDB" class="btn btn-warning">Fill Data From IMDB</button></div>
		        			
		        		</div>
		        		<div class="row">
		        			<div class="col-lg-12" style="padding:5px 0 5px 0">
		        				<div class="alert alert-info alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  <i class="fa fa-exclamation-triangle"></i> <strong>Info</strong> Fill in the IMDB Code and press fill in data
								</div>
		        			</div>
		        		</div>
		        		<div class="row">
		        			<div class="col-lg-12">
		        				<table class='table table-bordered'>
		        					<tbody>
		        						<tr>
		        							<td>Movie Title : </td>
		        							<td><input type="text" class="form-control" id="txtMovieTitle" name="txtMovieTitle" placeholder="Movie Title" /></td>
		        						</tr>
		        						<tr>
		        							<td>Genre : </td>
		        							<td><input type="text" class="form-control" id="txtGenre" name="txtGenre" placeholder="Genre" /></td>
		        						</tr>
		        						<tr>
		        							<td>Movie Overview :</td>
		        							<td><textarea id="taMovieoverview" name="taMovieoverview" style="resize:none;width:100%;"></textarea></td>
		        						</tr>
		        						<tr>
		        							<td>Release Year :</td>
		        							<td><input type="text" class="form-control" id="txtYear" name="txtYear" placeholder="Released Year" /></td>
		        						</tr>
		        						<tr>
		        							<td>Poster Preview : </td>
		        							<td><img src="../images/poster.jpg" width="150" height="200" id="imgPoster" name="imgPoster" />
		        								<img src="../images/backdrop.jpg" width="250" height="200" id="imgBackDrop" name="imgBackDrop" />
		        							</td>
		        						</tr>
		        						<tr>
		        							<td>Trailer Link : </td>
		        							<td><input type="text" class="form-control" id="txtTrailerLnk" name="txtTrailerLnk" placeholder="Trailer Link" /></td>
		        						</tr>
		        						<tr>
		        							<td>Rating :</td><td><input type="text" style="width:150px;" class="form-control" id="txtRating" name="txtRating" placeholder="Rating" /></td>
		        						</tr>
		        						<tr>
		        							<td>Critics :</td><td><input type="text" style="width:150px;" class="form-control" id="txtCritics" name="txtCritics" placeholder="Critics" /></td>
		        						</tr>
		        						<tr>
		        							<td>Audience :</td><td><input type="text" style="width:150px;" class="form-control" id="txtAudience" name="txtAudience" placeholder="Audience" /></td>
		        						</tr>
		        					</tbody>
		        				</table>
		        			</div>
		        		</div>
		        		<div class="row">
		        			<div class="col-lg-12" style="padding:5px 0 5px 0">
		        				<div class="alert alert-info alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  <i class="fa fa-exclamation-triangle"></i> <strong>Info</strong> Use Commas , for multiple stream links
								</div>
		        			</div>
		        			<div class="col-lg-12">
		        				<div class="col-md-2"><p style="padding-top:5px">Stream Links : </p></div>
		        				<div class="col-md-4"><input type="text" class="form-control" id="txtStreamLinks" name="txtStreamLinks" placeholder="Stream Links" /></div>
		        			</div>
                            <div class="col-lg-12">
                            	<div class="col-md-2">
                                	<p>Age Restrict :&nbsp;</p>
                                </div>
                                <div class="col-md-4">
                                	<input type='checkbox' id='chkAgeRestrict' name='chkAgeRestrict' />
                                </div>
                            </div>
		        		</div>
		        	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button"  class="btn btn-primary btnSubmitMovie">Add Movie</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="moviefy.clearMovieData();">Cancel</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- Edit Movie Details -->
		<div class="modal fade" id="updateMovieModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="addMovieModalTitle"><h2 class="fontDancing" stlye="text-align:center;">Edit Movie Details</h2></h4>
		      </div>
		      <div class="modal-body">
		        	<div class="container-fluid">
		        		<div class="row">
		        			<div class="col-lg-2"><p style="padding-top:5px;">IMDB Code : </p></div>
		        			<div class="col-lg-2"><input type="text" class="form-control" id="txtEdIMDBCode" name="txtEdIMDBCode" placeholder="IMDB Code" /></div>
		        			<div class="col-lg-1 loader hidden"><img src='../images/loader.gif' width="15" height="15" alt="loader" /></div>
		        			<div class="col-lg-1"><button type="button" disabled id="fillDataIMDB" class="btn btn-warning">Fill Data From IMDB</button></div>
		        			
		        		</div>
		        		<div class="row">
		        			<div class="col-lg-12" style="padding:5px 0 5px 0">
		        				<div class="alert alert-info alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  <i class="fa fa-exclamation-triangle"></i> <strong>Info</strong> Fill in the IMDB Code and press fill in data
								</div>
		        			</div>
		        		</div>
		        		<div class="row">
		        			<div class="col-lg-12">
		        				<table class='table table-bordered'>
		        					<tbody>
		        						<tr>
		        							<td>Movie Title : </td>
		        							<td><input type="text" class="form-control" id="txtEdMovieTitle" name="txtEdMovieTitle" placeholder="Movie Title" /></td>
		        						</tr>
		        						<tr>
		        							<td>Genre : </td>
		        							<td><input type="text" class="form-control" id="txtEdGenre" name="txtEdGenre" placeholder="Genre" /></td>
		        						</tr>
		        						<tr>
		        							<td>Movie Overview :</td>
		        							<td><textarea id="taEdMovieoverview" name="taEdMovieoverview" style="resize:none;width:100%;"></textarea></td>
		        						</tr>
		        						<tr>
		        							<td>Release Year :</td>
		        							<td><input type="text" class="form-control" id="txtEdYear" name="txtEdYear" placeholder="Released Year" /></td>
		        						</tr>
		        						<tr>
		        							<td>Poster Preview : </td>
		        							<td><img src="../images/testPoster.jpg" width="150" height="200" id="imgEdPoster" name="imgEdPoster" />
		        								<img src="../images/testPoster.jpg" width="250" height="200" id="imgEdBackDrop" name="imgEdBackDrop" />
		        							</td>
		        						</tr>
		        						<tr>
		        							<td>Trailer Link : </td>
		        							<td><input type="text" class="form-control" id="txtEdTrailerLnk" name="txtEdTrailerLnk" placeholder="Trailer Link" /></td>
		        						</tr>
		        						<tr>
		        							<td>Rating :</td><td><input type="text" style="width:150px;" class="form-control" id="txtEdRating" name="txtEdRating" placeholder="Rating" /></td>
		        						</tr>
		        						<tr>
		        							<td>Critics :</td><td><input type="text" style="width:150px;" class="form-control" id="txtEdCritics" name="txtEdCritics" placeholder="Critics" /></td>
		        						</tr>
		        						<tr>
		        							<td>Audience :</td><td><input type="text" style="width:150px;" class="form-control" id="txtEdAudience" name="txtEdAudience" placeholder="Audience" /></td>
		        						</tr>
		        					</tbody>
		        				</table>
		        			</div>
		        		</div>
		        		<div class="row">
		        			<div class="col-lg-12" style="padding:5px 0 5px 0">
		        				<div class="alert alert-info alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  <i class="fa fa-exclamation-triangle"></i> <strong>Info</strong> Use Commas , for multiple stream links
								</div>
		        			</div>
		        			<div class="col-lg-12">
		        				<div class="col-md-2"><p style="padding-top:5px">Stream Links : </p></div>
		        				<div class="col-md-4"><input type="text" class="form-control" id="txtEdStreamLinks" name="txtEdStreamLinks" placeholder="Stream Links" /></div>
		        			</div>
                            <div class="col-lg-12">
                            	<div class="col-md-2">
                                	<p>Age Restrict :&nbsp;</p>
                                </div>
                                <div class="col-md-4">
                                	<input type='checkbox' id='chkAgeRestrict' name='chkAgeRestrict' />
                                </div>
                            </div>
		        		</div>
		        	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button"  class="btn btn-primary btnUpdateButton">Update</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		      </div>
		    </div>
		  </div>
		</div>
    </body>
</html>