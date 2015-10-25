<?php if($totalMovies[0]['ttlMovies'] > 0){ ?>
<nav id="page">
	<ul class="pagination" style=" margin: 0 auto; padding: 15px;">
		<?php
		/******  build the pagination links ******/
		// range of num links to show
		$range = 3;
		// if not on page 1, don't show back links
		if ($currentpage > 1) {
			// show << link to go back to page 1
			//echo " <a href='{$_SERVER['PHP_SELF']}?page=1'><<</a> ";
			// get previous page num
			$prevpage = $currentpage - 1;
			// show < link to go back to 1 page
			if(isset($_POST['btnSearch']))
			{
				echo "<li><a href='{$_SERVER['PHP_SELF']}?page=$prevpage&search=$search' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
			}else
			{
				if(isset($_GET['search']) && $_GET['search'] != "")
					echo "<li><a href='{$_SERVER['PHP_SELF']}?page=$prevpage&search=".$_GET['search']."' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
				else
					echo "<li><a href='{$_SERVER['PHP_SELF']}?page=$prevpage' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
			}
		}// end if

		// loop to show links to range of pages around current page
		for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
			// if it's a valid page number...
			if (($x > 0) && ($x <= $numPages)) {
				// if we're on current page...
				if ($x == $currentpage) {
					// 'highlight' it but don't make a link
					if(isset($_POST['btnSearch']))
					{
						echo "<li class='active'><a href='{$_SERVER['PHP_SELF']}?page=$x&search=$search'>$x</a></li> ";
					}else{
						if(isset($_GET['search']))
							echo "<li class='active'><a href='{$_SERVER['PHP_SELF']}?page=$x&search=".$_GET['search']."'>$x</a></li> ";
						else
							echo "<li class='active'><a href='{$_SERVER['PHP_SELF']}?page=$x'>$x</a></li> ";
					}
					// if not current page...
				} else {
					// make it a link
					if(isset($_POST['btnSearch'])){
						echo "<li><a href='{$_SERVER['PHP_SELF']}?page=$x&search=$search'>$x</a></li>";
					}else{
						if(isset($_GET['search']))
							echo "<li><a href='{$_SERVER['PHP_SELF']}?page=$x&search=".$_GET['search']."'>$x</a></li>";
						else
							echo "<li><a href='{$_SERVER['PHP_SELF']}?page=$x'>$x</a></li>";
					}
				} // end else
			} // end if
		}// end for

		// if not on last page, show forward and last page links
		if ($currentpage != $numPages) {
			// get next page
			$nextpage = $currentpage + 1;
			// echo forward link for next page
			if(isset($_POST['btnSearch'])){
				echo " <li><a href='{$_SERVER['PHP_SELF']}?page=$nextpage&search=$search' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
			}else{
				echo " <li><a href='{$_SERVER['PHP_SELF']}?page=$nextpage' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
			}
			// echo forward link for lastpage
			//echo " <a href='{$_SERVER['PHP_SELF']}?page=$numPages'>>></a> ";
		} // end if
		/****** end build pagination links ******/
		?>
	</ul>
</nav>
<?php } ?>