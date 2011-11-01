{include file="findInclude:common/templates/header.tpl"}

{block name="bookmarks"}
  {if $hasBookmarks}
    {include file="findInclude:common/templates/navlist.tpl" navlistItems=$bookmarkLink secondary=true}
  {/if}
{/block}

{block name="videos"}
{include file="findInclude:modules/$moduleID/templates/results.tpl" results=$videos resultsID="videoList" titleTruncate=40}
{/block}
{include file="findInclude:common/templates/footer.tpl"}