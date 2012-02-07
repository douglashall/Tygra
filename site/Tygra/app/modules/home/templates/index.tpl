{include file="findInclude:common/templates/header.tpl"}

{if $courseItems}
	{if $showFederatedSearch}
	{block name="federatedSearch"}
	{include file="findInclude:common/templates/search.tpl"}
	{/block}
	{/if}

	<div class="homegrid" style="height:100px">
		{include file="findInclude:common/templates/springboard.tpl" springboardItems=$modules springboardID="homegrid"}
	</div>

	{include file="findInclude:common/templates/navlist.tpl" navlistItems=$courseItems}
{else}
	{include file="findInclude:common/templates/emptylist.tpl" emptyMessage="No courses found"}
{/if}

{include file="findInclude:common/templates/footer.tpl"}
