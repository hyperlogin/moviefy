<script src="js/jquery.easy-autocomplete.min.js" type="text/javascript"></script>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><i class="fa fa-home"></i>&nbsp;Moviefy</a>
		</div>

		<ul class="nav navbar-nav">
			<li>
				<a href="browse-movies.php"><i class="fa fa-film"></i>&nbsp;Browse Movies</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-television"></i>&nbsp;Browse TV-Series</a>
			</li>
		</ul>
		<script>
		$(document).ready(function(){
			var options = {
				url: function(phrase) {
					return "includes/moviedata.php";
				},
			
				getValue: "title",
			
				list: {
					match: {
						enabled: true
					},
					maxNumberOfElements: 4,
					showAnimation: {
						type: "slide",
						time: 300
					},
					hideAnimation: {
						type: "slide",
						time: 300
					}
				},
				template : {
					type: "custom",
					method: function(value, item) {
						
						var genre = item.genre.split(',');
						
						
						return "<div><a href='movie.php?m="+item.id+"'><p style='width:190px; float:left; color:#333333; '><font style='font-weight:bold'>" + value + "</font><br><strong>Release</strong> - " + item.year +"<br><strong>Genre</strong> - " + genre[0] + " " + ((genre.length > 1) ? genre[1] : "")+"</p><img src='" + item.icon + "'  width=75 height=100 style='clear:both;padding:5px;' /></div></a>";
					}
				},
				theme: "round"
			};
			
			$(".input-livesearch").easyAutocomplete(options);
		});
		</script>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<form class="navbar-form navbar-right" role="search">
			<div class="form-group">
				<input type="text" class="form-control input-livesearch" placeholder="Search">
			</div>
		</form>
	</div><!-- /.container-fluid -->
</nav>