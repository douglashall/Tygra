{include file="findInclude:common/templates/header.tpl"}
  <script type="text/javascript" src="http://isites.harvard.edu/jwplayer/jwplayer.js"></script>

<h1 class="focal videoTitle">{$videoTitle}</h1>
<p class="nonfocal">

<!-- {foreach $mediaurls as $url}
<a href="{$url}">
<img class="videoThumbnail" src="http://isites.harvard.edu/remote/video//js/videotool/resources/images/no-thumbnail.gif">
</a>
{/foreach}
 -->
 
 embed: {$embed}

</p>
<p class="focal">
{$videoDescription}
</p>

{include file="findInclude:common/templates/footer.tpl"}