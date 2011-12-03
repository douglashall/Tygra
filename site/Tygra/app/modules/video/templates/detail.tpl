{include file="findInclude:common/templates/header.tpl"}

<h1 class="focal videoTitle">{$videoTitle}</h1>


<p class="nonfocal">
<a href="http://isites.harvard.edu/icb/ajax/playListFromCollection.do?keyword={$keyword}&topicId=icb.topic{$topicid}&entry={$entryid}">
<img class="videoThumbnail" src="{$videoThumbnail}">
</a>
</p>
<p class="focal">{$videoDescription}</p>

{include file="findInclude:common/templates/footer.tpl"}