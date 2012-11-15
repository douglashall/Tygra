{include file="findInclude:common/templates/header.tpl"}
  <script type="text/javascript" src="http://isites.harvard.edu/jwplayer/jwplayer.js"></script>

{if $audio}
<style type="text/css">
#audio_container {
    padding-left: 10px;
    display: none;
}

#media_selector ul {
	margin-left: 0;
	padding-left: 0;
	display: inline;
	} 

#media_selector ul li {
	margin-left: 0;
	padding: 3px 15px;
	border-left: 1px solid #000;
	list-style: none;
	display: inline;
	}
	
		
#media_selector ul li.first {
	margin-left: 0;
	border-left: none;
	list-style: none;
	display: inline;
	}

</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	/* user clicked on the audio link*/
	$('#audiolink').click(function(){
		console.log("audiolink was clicked");
		
		if ( $('#videolink').hasClass('active')){
			$('#videolink').removeClass('active');
		}
		
		$('#video_container').hide();
		$('#audio_container').show();
		$(this).addClass('active');
		
		$('object').each(function(index){
			var id = $(this).attr('id');
			jwplayer(id).stop();
	  	});
	});
	
	/* user clicked on the video link*/
	$('#videolink').click(function(){
		console.log("videolink was clicked");
		
		if ( $('#audiolink').hasClass('active')){
			$('#audiolink').removeClass('active');
		}
		
		$('#audio_container').hide();
		$('#video_container').show();
		$(this).addClass('active');
		
		$('object').each(function(index){
			var id = $(this).attr('id');
			jwplayer(id).stop();
	  	});
	});	
});


</script>
{/if}

<h1 class="focal videoTitle">{$videoTitle}</h1>
<div id="media_selector">
<ul>
<li><a id="videolink" >Video</a></li>
<li><a id="audiolink" >Audio Only</a></li>
</ul>
</div>

<p class="nonfocal">
 <div id="video_container">
 {$embed}
 </div>
 
{if $audio}
 <div id="audio_container">
 {$audio}
 </div>
{/if}
</p>

{include file="findInclude:common/templates/footer.tpl"}