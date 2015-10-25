<?php
session_start();
include ('../class/clsDatabase.php');
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
		<link href='../css/bootstrap.vertical-tabs.min.css' rel='stylesheet'  type="text/css"/>
        <link href='../css/bootstrap-theme.min.css' rel='stylesheet'  type="text/css"/>
        <link href='../css/jquery-scroll-bar.css' rel='stylesheet'  type="text/css"/>
		<link href='sb-admin.css' rel='stylesheet'  type="text/css"/>
		<link href='../css/font-awesome.min.css' rel='stylesheet'  type="text/css"/>
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="../js/themoviedb.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/moment.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		<script type="text/javascript" src="../js/ext/bootstrap-table-toolbar.js"></script>
		<script type="text/javascript" src="../js/moviefy.js"></script>
		<script type="text/javascript" src="../js/jquery.bootstrap.wizard.min.js"></script>
        <script type="text/javascript" src="../js/jquery.scrollbar.min.js"></script>
		<style>
body {
	background-color: white;
}
.fontDancing {
	font-family: 'Dancing Script', arial, serif;
}
table tr > td
{
	padding:5px;
}
@media screen and (min-width: 768px) {
#addTVModal .modal-dialog {
	width: 900px;
}
#updateTVModal .modal-dialog {
	width: 900px;
}
}
.star-five {
	display: block;
	color: green;
	width: 0px;
	height: 0px;
	border-right: 100px solid transparent;
	border-bottom: 70px solid green;
	border-left: 100px solid transparent;
	-moz-transform: rotate(35deg) scale(.1);
	-webkit-transform: rotate(35deg) scale(.1);
	-ms-transform: rotate(35deg) scale(.1);
	-o-transform: rotate(35deg) scale(.1);
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
	-moz-transform: rotate(-35deg);
	-ms-transform: rotate(-35deg);
	-o-transform: rotate(-35deg);
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
	-moz-transform: rotate(-70deg);
	-ms-transform: rotate(-70deg);
	-o-transform: rotate(-70deg);
	content: '';
}
a {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: none;
	color: #666666;
}
</style>
		<script type="text/javascript">
			$(window).load(function() {
				//Movie Page
				$(".side-nav").find('li').eq(2).addClass("active");

				//Add event to Add movie button
				$("#btnAddMovie").click(function() {
					$("#addTVModal").modal({
						backdrop : true,
					});
				});

				//Add events to the IMDB Button
				$("#addTVModal #fillDataIMDB").click(function() {
					$(".loader").removeClass("hidden");
					moviefy.init();
					moviefy.clearTVData();
					moviefy.searchTV($("#txtIMDBCode").val(),"#addTVModal");
					//Handler Add Button
					moviefy.addTVCoverHandler();
				});
				//Populate Table
				$("#tv_table").bootstrapTable({
					pagination : true,
					pageSize : 5,
					pageList : [5, 10, 25, 50],
					search : true,
					onPageChange : function(number, size) {
						$("#tv_table > tbody tr").each(function() {
							$(this).find("td:eq(7)").text(moment().to($(this).find("td:eq(7)").text()));
						});

						//Add Handler
						moviefy.TVSeriesHanderEdit();
					}
				});

				//Update Time stamp
				$("#tv_table > tbody tr").each(function() {
					$(this).find("td:eq(7)").text(moment().to($(this).find("td:eq(7)").text()));
				});

				moviefy.TVSeriesHanderEdit();

				//Add Event to the remove button
				$("a[id=removeMovie]").click(function() {
					$(".btnRemoveMovie").attr("mID", $(this).attr("mID"));
					$("#removeMovieModal").modal();
				});

				$(".btnCancelRemove").click(function() {
					$(".btnRemoveMovie").removeAttr("mID");
				});

				//Update to Database
				$(".btnUpdateButton").click(function() {
					var DateTime = moment(moment()).format("MM-DD-YYYY HH:mm:ss");
					$.ajax({
						url : "../process/processmovie.php?action=update",
						method : "POST",
						data : {
							movieTitle : $("#txtEdMovieTitle").val(),
							genre : $("#txtEdGenre").val(),
							movieoverview : $("#taEdMovieoverview").val(),
							year : $("#txtEdYear").val(),
							posted_date : DateTime,
							imgPoster : $("#imgEdPoster").attr("src"),
							imgBackDrop : $("#imgEdBackDrop").attr("src"),
							trailerLnk : $("#txtEdTrailerLnk").val(),
							rating : $("#txtEdRating").val(),
							critics : $("#txtEdCritics").val(),
							audience : $("#txtEdAudience").val(),
							seriesCode : $("#txtEdIMDBCode").val(),
							streamLinks : $("#txtEdStreamLinks").val(),
							id : $(".btnUpdateButton").attr("mID")
						}

					}).complete(function(msg) {
						$("#updateTVModal").modal('hide');
						$("#addMovieSuccessModal").modal('show');
					});
				});
				
				//Pine Step wizard
				$('#rootWizardAdd').bootstrapWizard();
				$('#rootwizardUpdate').bootstrapWizard();
			});

		</script>
		<body>
<div id="wrapper">
          <?php
			include ("includes/inc_navBar.php");
 ?>
          <div id="page-wrapper">
    <div class="container-fluid"> 
              
              <!-- Page Heading -->
              <div class="row">
        <div class="col-lg-12">
                  <h1 class="page-header"> TV-Series <small>Shows Overview</small> &nbsp;
            <button id='btnAddMovie' class="btn btn-danger">Add Series</button>
          </h1>
                  <ol class="breadcrumb">
            <li class="active"> <i class="fa fa-dashboard"></i> TV-Series </li>
          </ol>
                </div>
      </div>
              <!-- /.row -->
              
              <div class="row">
        <div class="col-lg-12">
                  <table id="tv_table">
            <thead>
                      <tr>
                <th class="col-md-1">Poster</th>
                <th class="col-md-1" data-sortable="true">Series Title</th>
                <th class="col-md-2">Overview</th>
                <th class="col-md-1" data-sortable="true">Air date</th>
                <th class="col-md-1" data-sortable="true"><i class="fa fa-star" style="color:green;"></i>&nbsp;Rating</th>
                <th class="col-md-1" data-sortable="true"><i class="fa fa-television"></i>&nbsp;Total Season</th>
                <th class="col-md-1" data-sortable="true"><i class="fa fa-television"></i>&nbsp;Total Episodes</th>
                <th class="col-md-2" data-sortable="true">Added Date</th>
                <th class="col-md-1"></th>
              </tr>
                      <!-- MAX 5 Movies can be displayed -->
                    </thead>
            <tbody>
                      <?php
							  		$queryAllMovie = $db->select("SELECT * from mf_series");
									for($i = 0; $i < sizeof($queryAllMovie); $i++)
									{
							  	?>
                      <tr id="<?php echo $queryAllMovie[$i]['id']; ?>">
                <input type="hidden" id="mID" value="<?php echo $queryAllMovie[$i]['id']; ?>" />
                <input type="hidden" id="mgenre" value="<?php echo $queryAllMovie[$i]['genre']; ?>" />
                <!--<input type="hidden" id="mtrailer" value="" />-->
                <td class="col-md-1"><img src="<?php echo $queryAllMovie[$i]['poster_image'] ?>" alt="<?php echo $queryAllMovie[$i]['series_title'] ?>" width="50" height="75" /></td>
                <td class="col-md-1"><?php echo $queryAllMovie[$i]['series_title'] ?></td>
                <td class="col-md-2"><p style="width:350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $queryAllMovie[$i]['series_desc']; ?></p></td>
                <td class="col-md-1"><?php echo $queryAllMovie[$i]['airing_date']; ?></td>
                <td class="col-md-1"><?php echo $queryAllMovie[$i]['rating']; ?></td>
                <td class="col-md-1"><?php echo $queryAllMovie[$i]['total_season']; ?></td>
                <td class="col-md-1"><?php echo $queryAllMovie[$i]['total_episodes']; ?></td>
                <td class="col-md-2"><?php echo $queryAllMovie[$i]['added_date']; ?></td>
                <td class="col-md-1"><a href='#' id="editSeries" sID='<?php echo $queryAllMovie[$i]['id']; ?>'><i class="fa fa-cog fa-2x" style="color:#19A3D1;"></i></a>&nbsp;<a href="#" id="removeSeries" sID='<?php echo $queryAllMovie[$i]['id']; ?>'><i class="fa fa-trash fa-2x" style="color:red;"></i></a></td>
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
        <h4 class="modal-title">
                  <h2 class="fontDancing">TV-series Added</h2>
                </h4>
      </div>
              <div class="modal-body">
        <p>TV-serie has been added to the database</p>
      </div>
              <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
            </div>
    <!-- /.modal-content --> 
  </div>
          <!-- /.modal-dialog --> 
        </div>
<!-- /.modal --> 
<!-- Modal Remove Boxx -->
<div class="modal fade" id="removeMovieModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog">
    <div class="modal-content">
              <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
                  <h2 class="fontDancing">Remove Movie?</h2>
                </h4>
      </div>
              <div class="modal-body">
        <p>Confirm remove movie?</p>
      </div>
              <div class="modal-footer">
        <button type="button" class="btn btn-default btnCancelRemove" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger btnRemoveMovie" >Yes Please</button>
      </div>
            </div>
    <!-- /.modal-content --> 
  </div>
          <!-- /.modal-dialog --> 
        </div>
<!-- /.modal --> 
<!-- Add Movie Modal Boxx -->
<div class="modal fade" id="addTVModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
    <div class="modal-content">
              <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addMovieModalTitle">
                  <h2 class="fontDancing" stlye="text-align:center;">Add TV Series</h2>
                </h4>
      </div>
              <div class="modal-body">
                  <div id="rootWizardAdd">
                    <div class="navbar">
                      <div class="navbar-inner">
                        <div class="container">
                    <ul>
                        <li><a href="#addcover" data-toggle="tab">Cover Page</a></li>
                        <li><a href="#addep" data-toggle="tab">Seasons &amp; Episodes</a></li>
                        <li><a href="#addfinalize" data-toggle="tab">Finalize</a></li>
                    </ul>
                     </div>
                      </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane" id="addcover">
                          <div class="container-fluid">
                                  <div class="row">
                            <div class="col-lg-2">
                                      <p style="padding-top:5px;">IMDB Code : </p>
                                    </div>
                            <div class="col-lg-2">
                                      <input type="text" class="form-control" id="txtIMDBCode" name="txtIMDBCode" placeholder="IMDB Code" />
                                      <input type="hidden" id="seriesCode" name="seriesCode" />
                                    </div>
                            <div class="col-lg-1 loader hidden"><img src='../images/loader.gif' width="15" height="15" alt="loader" /></div>
                            <div class="col-lg-1">
                                      <button type="button" id="fillDataIMDB" class="btn btn-warning">Fill Data From TMDB</button>
                                    </div>
                          </div>
                                  <div class="row">
                            <div class="col-lg-12" style="padding:5px 0 5px 0">
                                      <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <i class="fa fa-exclamation-triangle"></i> <strong>Info</strong> Fill in the <a href="https://www.themoviedb.org/tv?language=en"><strong>TMDB</strong></a> Code and press fill in data </div>
                                    </div>
                          </div>
                                  <div class="row">
                            <div class="col-lg-12">
                                      <table class='table table-bordered'>
                                <tbody>
                                          <tr>
                                    <td>Series Title : </td>
                                    <td><input type="text" class="form-control" id="txtSeriesTitle" name="txtSeriesTitle" placeholder="Series Title" /></td>
                                  </tr>
                                          <tr>
                                    <td>Series Genre : </td>
                                    <td><input type="text" class="form-control" id="txtGenre" name="txtGenre" placeholder="Genre" /></td>
                                  </tr>
                                          <tr>
                                    <td>Series Overview :</td>
                                    <td><textarea id="taSeriesoverview" name="taSeriesoverview" style="resize:none;width:100%;"></textarea></td>
                                  </tr>
                                          <tr>
                                    <td>Air Date :</td>
                                    <td><input type="text" class="form-control" id="txtairdate" name="txtairdate" placeholder="Air Date" /></td>
                                  </tr>
                                          <tr>
                                    <td>Poster Preview : </td>
                                    <td><img src="../images/poster.jpg" width="150" height="200" id="imgPoster" name="imgPoster" /> <img src="../images/backdrop.jpg" width="250" height="200" id="imgBackDrop" name="imgBackDrop" /></td>
                                  </tr>
                                          <tr>
                                    <td>Rating :</td>
                                    <td><input type="text" style="width:150px;" class="form-control" id="txtRating" name="txtRating" placeholder="Rating" /></td>
                                    <tr>
                                        <td>Total Seasons : </td><td><input type="text" class="form-control" style="width:150px;" id="txtttlSeason" name="txtttlSeason" placeholder="Total Seasons" /></td>
                                    </tr>
                                    <tr>
                                        <td>Total Episodes : </td><td><input type="text" class="form-control" style="width:150px;" id="txtttlEpisode" name="txtttlEpisode" placeholder="Total Episodes" /></td>
                                    </tr>
                                    <tr>
                                        <td>Library : </td><td><input type="text" class="form-control" style="width:150px;" id="txtlibrary" name="txtlibrary" placeholder="Library" /></td>
                                    </tr>
                                        </tbody>
                              </table>
                                    </div>
                          </div>
                            <div class="row pull-right">
                                <div class="col-lg-30 processing-info hidden">
                                     <img src='../images/loader.gif' width="15" height="15" alt="loader" />&nbsp; Processing Data
                                </div>
                                <div class="col-lg-5 coverbutton">
                                    <button type="button"  class="btn btn-primary btnAddCover">Add Cover Page</button>
                                </div>
                            </div>
                                </div>
                        </div>
                        <div class="tab-pane" id="addep">
                            <div class="seasons" style="height:500px; max-height:500px; width:100%;">
                              <div class="col-xs-3"> <!-- required for floating -->
                                  <!-- Nav tabs -->
                                  <ul class="nav nav-tabs tabs-left" style="height:auto; max-height:500px; width:100%;">
                                    
                                  </ul>
                              </div>
                              
                              <div class="col-xs-9">
                                  <!-- Tab panes -->
                                  <div class="tab-content" style="height:500px; max-height:500px; width:100%;">
                                        
                                  </div>
                                  
                              </div>
                              
                          </div>  
                        </div>
                        <div class="tab-pane" id="addfinalize">
                            3
                        </div>
                        <ul class="pager wizard">
                            
                        </ul>
                    </div>	
                </div>
        
      </div>
              <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="moviefy.clearTVData();">I'm Done</button>
      </div>
            </div>
  </div>
        </div>
<!-- Edit Movie Details -->
<div class="modal fade" id="updateTVModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
    <div class="modal-content">
              <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addMovieModalTitle">
                  <h2 class="fontDancing" stlye="text-align:center;">Edit Movie Details</h2>
                </h4>
      </div>
              <div class="modal-body">
        <div id="rootwizardUpdate">
                <div class="navbar">
                  <div class="navbar-inner">
                    <div class="container">
                <ul>
                    <li><a href="#editcover" data-toggle="tab">Cover Page</a></li>
                    <li><a href="#editep" data-toggle="tab">Seasons &amp; Episodes</a></li>
                    <li><a href="#editfinalize" data-toggle="tab">Finalize</a></li>
                </ul>
                 </div>
                  </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane" id="editcover">
                      <div class="container-fluid">
                             <div class="row">
                             	<div class="col-lg-12" style="padding:5px 0 5px 0">
                                      <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <i class="fa fa-exclamation-triangle"></i> <strong>Info</strong> Here you can edit the cover page / seasons &amp; episodes </div>
                                    </div>
                             </div>
                              <div class="row">
                        <div class="col-lg-12">
                                  <table class='table table-bordered'>
                            <tbody>
                                      <tr>
                                <td>Series Title : </td>
                                <td><input type="text" class="form-control" id="txtSeriesTitle" name="txtSeriesTitle" placeholder="Series Title" /></td>
                              </tr>
                                      <tr>
                                <td>Series Genre : </td>
                                <td><input type="text" class="form-control" id="txtGenre" name="txtGenre" placeholder="Genre" /></td>
                              </tr>
                                      <tr>
                                <td>Series Overview :</td>
                                <td><textarea id="taSeriesoverview" name="taSeriesoverview" style="resize:none;width:100%;"></textarea></td>
                              </tr>
                                      <tr>
                                <td>Air Date :</td>
                                <td><input type="text" class="form-control" id="txtairdate" name="txtairdate" placeholder="Air Date" /></td>
                              </tr>
                                      <tr>
                                <td>Poster Preview : </td>
                                <td><img src="../images/poster.jpg" width="150" height="200" id="imgPoster" name="imgPoster" /> <img src="../images/backdrop.jpg" width="250" height="200" id="imgBackDrop" name="imgBackDrop" /></td>
                              </tr>
                                      <tr>
                                <td>Rating :</td>
                                <td><input type="text" style="width:150px;" class="form-control" id="txtRating" name="txtRating" placeholder="Rating" /></td>
                                <tr>
                                    <td>Total Seasons : </td><td><input type="text" class="form-control" style="width:150px;" id="txtttlSeason" name="txtttlSeason" placeholder="Total Seasons" /></td>
                                </tr>
                                <tr>
                                    <td>Total Episodes : </td><td><input type="text" class="form-control" style="width:150px;" id="txtttlEpisode" name="txtttlEpisode" placeholder="Total Episodes" /></td>
                                </tr>
                                <tr>
                                    <td>Library : </td><td><input type="text" class="form-control" style="width:150px;" id="txtlibrary" name="txtlibrary" placeholder="Library" /></td>
                                </tr>
                                    </tbody>
                          </table>
                                </div>
                      </div>
                        <div class="row pull-right">
                            <div class="col-lg-30 processing-info hidden">
                                 <img src='../images/loader.gif' width="15" height="15" alt="loader" />&nbsp; Processing Data
                            </div>
                            <div class="col-lg-5 coverbutton">
                                <button type="button"  class="btn btn-primary btnUpdateCover">Update Cover Page</button>
                            </div>
                        </div>
                            </div>
                    </div>
                    <div class="tab-pane" id="editep">
                        <div class="seasons" style="height:500px; max-height:500px; width:100%;">
                          <div class="col-xs-3"> <!-- required for floating -->
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs tabs-left" style="height:auto; max-height:500px; width:100%;">
                                
                              </ul>
                          </div>
                          
                          <div class="col-xs-9">
                              <!-- Tab panes -->
                              <div class="tab-content" style="height:500px; max-height:500px; width:100%;">
                                    
                              </div>
                              
                          </div>
                          
                      </div>  
                    </div>
                    <div class="tab-pane" id="editfinalize">
                        3
                    </div>
                    <ul class="pager wizard">
                        
                    </ul>
                </div>	
            </div>
      </div>
              <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">I'm Done</button>
      </div>
            </div>
  </div>
        </div>
</body>
</html>