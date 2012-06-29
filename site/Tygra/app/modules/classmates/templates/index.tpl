{include file="findInclude:common/templates/header.tpl"}

{if $hasSearchbox}
	{block name="searchbox"}
		{include file="findInclude:common/templates/search.tpl" resultCount=$resultCount tip=$searchTip}
	{/block}
{/if}

{if $hasBookmarks}
	{include file="findInclude:common/templates/navlist.tpl" navlistItems=$bookmarkLink secondary=true}
{/if}

{if $sections}
	{foreach $sections as $section}
		<div class="nonfocal">
		  <h2>{$section['label']}</h2>
		</div>
	
		{include file="findInclude:common/templates/navlist.tpl" navlistItems=$section['items']}
	{/foreach}
{else}
	{include file="findInclude:common/templates/emptylist.tpl" emptyMessage="No updates found"}
{/if}


{include file="findInclude:common/templates/footer.tpl"}
