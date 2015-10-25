var counter = 0;
var totalEps = 0;
var moviefy = {

  options : {
		  api_key : "43271e66afe59efbf69a9a86cc5bd466",
		  base_uri : "",
		  tmdb : theMovieDb,
		  image_size : "w500",
		  image_sizeOri : "original",
		  image_uri : "https://image.tmdb.org/t/p/",
		  youtube_uri : "https://www.youtube.com/embed/",
		  defaultPoster : "images/poster.jpg",
		  defaultBackdrop : "images/backdrop.jpg",
  },
  init : function()
  {
	  this.options.tmdb.common.api_key = this.options.api_key;
  },
   getImage : function(src)
  {
	  return this.options.tmdb.common.getImage({size : this.options.image_size, file : src});
  },
  
  getImageOriginal : function(src)
  {
	  return this.options.tmdb.common.getImage({size : this.options.image_sizeOri, file : src});
  },
  
  getGenre : function(ids)
  {
	  var arryGenres;
	  
	  this.options.tmdb.genres.getList({},function success(data)
	  {
		  //alert(data);
		  var gData = JSON.parse(data);
		  var gData_res = gData.genres[0];
		  var strbuilder = "";
		  
		  arryGenres= $.map(gData.genres,function(el) { return el;});
		  
		  for(var i = 0; i < ids.length; i ++)
		  {
			  for(var j = 0; j < arryGenres.length; j++)
			  {
				  if(arryGenres[j].id == ids[i])
				  {
					  strbuilder += arryGenres[j].name + ",";
				  }
			  }
		  }
		  
		  //Clean up the strBuilder
		  strbuilder = strbuilder.substr(0,strbuilder.length - 1);
		  $("#txtGenre").val(strbuilder);
		  
	  },function error(){});
  },
				  
  findTrailer : function(movieID)
  {
	  //Find Trailer for Movie
	  var trailer = this.options.tmdb.movies.getTrailers({"id" : movieID},
	  function success(data){
			  var mData = JSON.parse(data);
			  var mData_res = mData.youtube[0];
			  $("#txtTrailerLnk").val(this.moviefy.options.youtube_uri + mData_res.source);
	  },function error(){});
  },
  searchMovie : function (imdbCode)
  {
	  var MovieID;
	  var result = this.options.tmdb.find.getById({"id" : imdbCode, "external_source" : "imdb_id"},
	  function searchSuccess(data){
		  var mData = JSON.parse(data);
		  var mDataRes = mData.movie_results[0];
		  //Push Data into text Fields
		  $("#txtMovieTitle").val(mDataRes.original_title);
		  $("#taMovieoverview").val(mDataRes.overview);
		  $("#txtYear").val(moment(mDataRes.release_date).format("YYYY"));
		  $("#imgPoster").attr("src",this.moviefy.getImage(mDataRes.poster_path));
		  $("#imgBackDrop").attr("src",this.moviefy.getImageOriginal(mDataRes.backdrop_path));
		  $("#txtRating").val(mDataRes.vote_average);
		  
		  //Assign Movie ID
		  //MovieID = mDataRes.id;
		  this.moviefy.findTrailer(mDataRes.id);
		  this.moviefy.getGenre(mDataRes.genre_ids);
		  $(".loader").addClass("hidden");
	  },function error(){});
  },
  
  getTVGenres : function(aryGenre) {
	  var genre = "" ;
	  for(var i=0; i< aryGenre.length; i++)
	  {
		  genre += aryGenre[i].name + ",";
	  }
	  return genre.substr(0,genre.length-1);
  },
  searchTV : function(tvCode,container)
  {
	  var result = this.options.tmdb.tv.getById({"id" : tvCode },
		function success(data){
			//console.log(data);
			var mData = JSON.parse(data);
			$("#txtSeriesTitle").val(mData.name);
			$("#imgPoster").attr("src",this.moviefy.getImage(mData.poster_path));
			$("#imgBackDrop").attr("src",this.moviefy.getImageOriginal(mData.backdrop_path));
			$("#taSeriesoverview").val(mData.overview);
			$("#txtGenre").val(this.moviefy.getTVGenres(mData.genres));
			$("#txtairdate").val(mData.first_air_date);
			$("#txtRating").val(mData.vote_average);
			$("#txtttlSeason").val(mData.number_of_seasons);
			$("#txtttlEpisode").val(mData.number_of_episodes);
			$("#seriesCode").val(tvCode);
			//Populate Season Tabs
			for(var noSeasons = 1; noSeasons <= mData.number_of_seasons; noSeasons++)
			{
				if(noSeasons <= 1){
					$(container + " .seasons ul").append("<li class='active'><a href='#season" + noSeasons + "' data-toggle='tab'>Season " + noSeasons + "</a></li>");
					$(container + " .seasons").find(".tab-content").append("<div class='tab-pane active' id='season"+noSeasons+"'><img id='seasonPoster' src='' height=200 width=150 style='position:relative;margin:auto; padding-bottom:10px;' /><table class='table-bordered' style='clear:both; padding:15px;'><tbody><tr><td>Season air date</td><td><span class='seasonairdate'></span></td></tr><tr><td>Episodes</td><td><span class='totalepisodes'></span></td></tr><tr><td>Season Overview</td><span id='seasonOverview'></span><td></td> </tr></tbody></table></div>");
				}
				else{
					$(container + " .seasons ul").append("<li><a href='#season" + noSeasons + "' data-toggle='tab'>Season " + noSeasons + "</a></li>");
					$(container + " .seasons").find(".tab-content").append("<div class='tab-pane' id='season"+noSeasons+"'><img id='seasonPoster' src='' height=200 width=150 style='position:relative;margin:auto; padding-bottom:10px;' /><table class='table-bordered' style='clear:both; padding:15px;'><tbody><tr><td>Season air date</td><td><span class='seasonairdate'></span></td></tr><tr><td>Episodes</td><td><span class='totalepisodes'></span></td></tr><tr><td>Season Overview</td><td><span class='seasonOverview'></span></td> </tr></tbody></table></div>");
				}
				this.moviefy.getSeasons(tvCode,noSeasons,container);
			}
			//Scrollbar
			$('.seasons').scrollbar();
			$(".loader").addClass("hidden");
						
		},function error(){});
  },
  getSeasons : function(tvCode,seasonNumber,container)
  {
	  console.log(container);
	   var result = this.options.tmdb.tvSeasons.getById({"id" : tvCode ,"season_number" : seasonNumber},
		function success(data){
			//Populate Seasons
			var mData = JSON.parse(data);
			//Inject Data For Season information
			var noofEps = mData.episodes.length;
			var seasonContainer = $(container + " .seasons").find(".tab-content #season"+seasonNumber);
			seasonContainer.find("#seasonPoster").attr("src",this.moviefy.getImage(mData.poster_path));
			seasonContainer.append('<div class="panel-group" style="margin-top:20px;" id="acdSeason_'+seasonNumber+'" role="tablist" aria-multiselectable="true"></div>');
			
			seasonContainer.find(".seasonairdate").html(mData.air_date);
			seasonContainer.find(".totalepisodes").html(mData.episodes.length);
			seasonContainer.find(".seasonOverview").html(mData.overview);
			//Inject Episodes
			var acdContainer = $(container + " .seasons").find(".tab-content #season"+seasonNumber+" #acdSeason_"+seasonNumber);
			for(var episodes = 0; episodes < noofEps; episodes++)
			{
				acdContainer.append('<div class="panel panel-default"><div class="panel-heading" role="tab" ep="'+ episodes +'" id="s'+seasonNumber+'_ep'+(episodes + 1)+'"><h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#acdSeason_'+ seasonNumber +'" href="#s'+seasonNumber+'_ep_'+ (episodes + 1) +'" aria-expanded="false" aria-controls="s'+seasonNumber+'_ep_'+ (episodes + 1) +'"><div id="episodeTitle">Episode '+ (episodes + 1) +' - ' + mData.episodes[episodes].name + '</div></a></h4></div><div id="s'+seasonNumber+'_ep_'+(episodes + 1)+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ep_'+(episodes + 1)+'"><div class="panel-body"><table class="table"><tbody><tr><td>Overview</td><td><div id="episodeOverview">'+ mData.episodes[episodes].overview +'</div></td></tr><tr><td>Episode Backdrop</td><td><img src="'+ this.moviefy.getImageOriginal(mData.episodes[episodes].still_path) +'" id="episode_backdrop" height=150 width=300 /></td></tr><tr><td>Episode Code</td><td><input type="text" id="episodeCode" class="form-control" name="episodeCode" placeholder="Episode Code"/></td></tr></tbody></table></div></div></div>');
			}
			acdContainer.append('<button class="btn btn-success btnAddSeason" season="' + seasonNumber +'" style="position:absolute; right:0; margin:20px;">Add Season</button>');
			//Handlers
			//Add Season Button Handler
			$(container + ' #season'+seasonNumber+' .btnAddSeason').click(function(){
				var container = "#acdSeason_" + $(this).attr("season");
				moviefy.TVSeriesHandlerEpisode(container);
			});

		},function error(){});
  },
  addTVCoverHandler : function()
  {
	  //Submit to Database
	  $(".btnAddCover").click(function() {
		  $(".processing-info").removeClass("hidden").fadeIn(100);
		  $(".coverbutton").fadeOut(100);
		  var DateTime = moment(moment()).format("MM-DD-YYYY HH:mm:ss");
		  $.ajax({
			  url : "../process/processtvseries.php?action=add&mode=cover",
			  method : "POST",
			  data : {
				  seriesTitle : $("#txtSeriesTitle").val(),
				  originalTitle : "",
				  genre : $("#txtGenre").val(),
				  seriesoverview : $("#taSeriesoverview").val(),
				  runtime:$("txtRunTime").val(),
				  totalSeason : $("#txtttlSeason").val(),
				  totalEps : $("#txtttlEpisode").val(),
				  air_date : $("#txtairdate").val(),
				  posted_date : DateTime,
				  imgPoster : $("#imgPoster").attr("src"),
				  imgBackDrop : $("#imgBackDrop").attr("src"),
				  rating : $("#txtRating").val(),
				  seriesCode : $("#txtIMDBCode").val(),
				  library : $("#txtlibrary").val(),
			  }

		  }).complete(function(msg) {
			  if (msg.responseText > 0) {
				  //$(".movie_table > tbody:last-child").append('');//Table
				  $(".btnAddCover").removeClass("btn-primary").addClass("btn-success").attr("disabled","disabled").text("Cover Added Successful");					
				  $(".coverbutton").fadeIn(100);
				  $(".processing-info").fadeOut(100);	
				  $('#rootWizardAdd').bootstrapWizard("next",100);
			  }
		  });					
	  });
  },
  TVSeriesHanderEdit : function()
  {
	  //Add events to the Edit Button
	  $("a[id=editSeries]").click(function() {
		  $(".btnUpdateButton").attr("mID", $(this).attr("mID"));
		  //Retrieve Data
		  $.ajax({
			  url : "../process/processtvseries.php?action=view",
			  method : "POST",
			  data : {
				  id : $(this).attr("sID")
			  }
		  }).complete(function(msg) {
			  var mData = JSON.parse(msg.responseText);
			  var mData = mData[0];
			  //GENERATE DATA
			  var container = $("#editcover");
			  container.find("#txtSeriesTitle").val(mData.seriesTitle);
			  container.find("#txtGenre").val(mData.genre);
			  container.find("#taSeriesoverview").val(mData.overview);
			  container.find("#txtRunTime").val("");//TODO
			  container.find("#txtttlSeason").val(mData.totalSeason);
			  container.find("#txtttlEpisode").val(mData.totalEp);
			  container.find("#txtairdate").val(mData.air_date);
			  container.find("#imgPoster").attr('src',mData.poster);
			  container.find("#imgBackDrop").attr('src',mData.backdrop);
			  container.find("#txtRating").val(mData.rating);
			  container.find("#txtlibrary").val(mData.library);
			  container.append("<input type='hidden' id='seriesCode' name='seriesCode' value='" + mData.sCode + "' />");
			  $("#updateTVModal").modal();
		  });

	  });
  },
  TVSeriesHandlerEpisode : function(container)
  {
	totalEps = $(container).find(".panel").length;
	var season = $(container).attr("id");
	moviefy.addEpisode(season.replace("acdSeason_",""));
	$(container + " .btnAddSeason").attr("disabled","disabled");
  },
  addEpisode : function(season)
  {
	 var panel = '#s'+season+'_ep' + (counter+1);
	 var panelContent = '#s'+season+'_ep_' + (counter+1);
	 var DateTime = moment(moment()).format("MM-DD-YYYY HH:mm:ss");
	 
	 $.ajax({
		  url : "../process/processtvseries.php?action=add&mode=episode",
		  async : true,
		  method : "POST",
		  data : {
			  season : season,
			  episode : counter,
			  id : $("#seriesCode").val(),
			  episodeTitle : $(panel + " #episodeTitle").text(),
			  overview : $(panelContent + " #episodeOverview").text(),
			  epDate : $("#season" + season + " .seasonairdate").text(),
			  imgPoster : $("#season"+season+ " #seasonPoster").attr("src"),
			  imgBackDrop : $(panelContent + " #episode_backdrop").attr("src"),
			  lastUpdate : DateTime,
			  stream : $(panelContent + " #episodeCode").val(),
		  }
	  }).complete(function(msg)
	  {
		  if(msg.responseText == 1)
		  {
			  $("#season" + season+ " .btnAddSeason").text("Processing " + counter + " / " + totalEps);
		  }
		  counter++;
		  if(counter < totalEps)
			 moviefy.addEpisode(season);
		  else
		  	$("#season" + season+ " .btnAddSeason").text("Season Added");
	  });
  },
  
  clearTVData : function()
  {
	  $("#txtSeriesTitle").val("");
	  $("#imgPoster").attr("src","../" + this.options.defaultPoster);
	  $("#imgBackDrop").attr("src","../" + this.options.defaultBackdrop);
	  $("#taSeriesoverview").val("");
	  $("#txtGenre").val("");
	  $("#txtairdate").val("");
	  $("#txtRating").val("");
	  $("#txtttlSeason").val("");
	  $("#txtttlEpisode").val("");
	  //Clearing Season Column
	  $(".seasons").find("ul").empty();
	  $(".seasons").find(".tab-content").empty();
	  $(".btnAddCover").removeClass("btn-success").addClass("btn-primary").removeAttr("disabled").text("Add Cover Page");
  },
  clearMovieData : function()
  {
	  //Clear Movie Data
	  $("#txtMovieTitle").val("");
	  $("#taMovieoverview").val("");
	  $("#txtYear").val("");;
	  $("#imgPoster").attr("src","../" + this.options.defaultPoster);
	  $("#imgBackDrop").attr("src","../" + this.options.defaultBackdrop);
	  $("#txtTrailerLnk").val("");
	  $("#txtGenre").val("");
	  $("#txtRating").val("");
	  $("#txtIMDBCode").val("");
  },
};


