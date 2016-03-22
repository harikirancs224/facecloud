<?php echo get_header("script");	?>
<div  class="clr"></div>
<!--<div class="container">
	<div class="search_page">
		<form action="<?php //bloginfo("siteurl"); ?>/search/" method="get">
			<fieldset>
				 <div class=" col-md-4 location">
					 <p>what location you are looking for?</p>
					 <div class="supertitle">
						<input type="search" name="location" onclick="ajaxloader('locationgrab','searchenginecol');" id="locatorin" list="clist" class="locationinput" placeholder="location"/>
					 </div>
				 </div>
				<!-- <div class="col-md-3 gender">
					  <p>Gender:</p>
					  <label for="male">
						<input <?php //if(isset($_GET['gender'])&&$_GET['gender']=="male") echo 'checked';?> type="radio" value="male" name="gender" id="male" checked > <span style="float:left;">Male</span>
					  </label>

					  <label for="female">
						<input <?php //if(isset($_GET['gender'])&&$_GET['gender']=="female") echo 'checked';?> type="radio" value="female"  name="gender" id="female"> <span>Female</span>
					  </label>
				  </div>  
				  <div class="col-md-3 property">
					  <p>Category Type</p>
					  <input type="hidden" value="" name="q"/>
					  <select name="category" class="">
						<option value="">All</option>
						<?php 
						//$cd="";if(isset($_GET["category"])) $cd=$_GET["category"];
							// c_options_list(CATID,0,$cd);
							//echo get_options('0','category','','active')
						?>
					  </select>
				  </div>
				  <div class="col-md-2 search_go">
					<input type="submit" value="Search"/>
				  </div>
				   <div class="col-md-10"  id="searchenginecol">
					
					</div>
			</fieldset>
		</form>
	</div>
</div>-->
	

<div class="container">
	<div class="row">
		<div class="breadcum">
			<?php echo breadcrumbs(); ?>
		</div>
	</div>
</div>
<div class="clr"></div>
 
<script>
var is2search=0;
function opensearchheader(v)
{
	if(v!="")
	{
		$("#infront").slideUp();
		$("#insearch").slideDown();
		//$("#inner_search").html($("#searchengine").html());
		$("#reg_search").slideUp();
		is2search++;
		$("#searchterm1").val(v);
		$("#searchterm1").focus();
	}
}
$("#searchterm").focus();

function jssearch(q)
{
	if(q !="") $(".frntico").css("display","none"); else $(".frntico").css("display","block");
	//$.getJSON("http://en.wikipedia.org/w/api.php?callback=?",
	$.getJSON("loader.php?jsn",
	{
	  srsearch: q,
	  action: "query",
	  listfrom: "0",
	  listto: "15",
	  list: "search",
	  format: "json"
	},
	function(data) {
	  $("#results").empty(); $("#results").append("Results for <b>" + q + "</b><div class='clr'></div>");
	  $("#featuredresults").empty(); $("#featuredresults").append("<b>Featured Ads</b>");
	  
	  $.each(data.ads, function(i,item){
		var d="";
		if(item.thumb!="null") d='<img src="'+item.thumb+'" class="r-thumb"/>';
		$("#results").append('<li class="g"><div class="rc"><a href="' + item.link + '"><h3 class="r">' + item.title + '<span class="r-module '+ item.g +'">'+item.g+'</span></h3></a><a class="r-link" href="' + item.link + '">' + item.link + '</a><p>'+ d + item.snippet.substr(0, 300)  + '</p></div></li>');
	  });
	  $.each(data.featuredads, function(i,item){
		$("#featuredresults").append('<li><img src="<?php bloginfo('root_template_directory'); ?>/images/adindex.jpg"/></li><li class="g" style="display:none"><div class="rc"><a href="' + item.link + '"><h3 class="r">' + item.title + '</h3></a><a class="r-link" href="' + item.link + '">' + item.link + '</a><p>'+ item.snippet.substr(0, 100) + '..</p></div></li>');
	  });
	});
}
$(function(){
	var q = $("#locatorin").val();
	var lc=getCookie("location");
	if(lc==null) lc="nulld";
	var dlc="<?php echo do_shortcode("[LOCATOR get=city]"); ?>";
	if(lc!="nulld" && lc!=dlc)
	{
		$("#locatorin").val(lc);
		//alert(lc);
	}
	else{
		$("#locatorin").val(dlc);
		//alert("elsepart");
	}
});
$("#locatorin").change(function(e){
	var q = $("#locatorin").val();
	var lc=getCookie("location");
	var dlc="<?php echo do_shortcode("[LOCATOR get=city]"); ?>";
	
	if(q!=""&&lc!=""&&lc!=q)
	{
		//alert("cookie Called");
		setCookie("location",q);
		
	}
  }); 
</script>