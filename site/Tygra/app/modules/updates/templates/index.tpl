{include file="findInclude:common/templates/header.tpl"}

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