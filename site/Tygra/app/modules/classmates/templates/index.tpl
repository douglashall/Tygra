{include file="findInclude:common/templates/header.tpl"}
{if $hasSearchbox}
	{block name="searchbox"}
		{include file="findInclude:common/templates/search.tpl" resultCount=$resultCount tip=$searchTip}
	{/block}
{/if}
{if $hasBookmarks}
	{include file="findInclude:common/templates/navlist.tpl" navlistItems=$bookmarkLink secondary=true}
{/if}

{include file="findInclude:common/templates/results.tpl" results=$courses resultsID="coursesList" titleTruncate=40}

{include file="findInclude:common/templates/footer.tpl"}
