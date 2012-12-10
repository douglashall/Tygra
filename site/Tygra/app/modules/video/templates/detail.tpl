{include file="findInclude:common/templates/header.tpl"}
  <script type="text/javascript" src="http://isites.harvard.edu/jwplayer/jwplayer.js"></script>

{if $audio}


<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>-->

<script type="text/javascript">
$(document).ready(function() {
	
	if( !$.trim( $('#video_container').html() ).length ){
		console.log("no video, just audio");
		$('#videolink').hide();
		$('#audiolink').addClass('active');
		$('#video_container').hide();
		$('#audio_container').show();
	}
	
	$('#videolink').addClass('active');
	
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
<!-- only show audio nav if there is an audio version -->
{if $audio}
<ul class="videoAudio">
<li><a id="videolink" >Video</a></li>
<li><a id="audiolink" >Audio Only</a></li>
</ul>
{/if}
</div>

<p class="nonfocal">
 <div id="video_container">
 {$video}
 </div>
 
{if $audio}
 <div id="audio_container">
 {$audio}
 </div>
{/if}
</p>

{include file="findInclude:common/templates/footer.tpl"}
