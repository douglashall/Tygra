{include file="findInclude:common/templates/header.tpl"}

{if $courses}
	{if $showFederatedSearch}
	{block name="federatedSearch"}
	{include file="findInclude:common/templates/search.tpl"}
	{/block}
	{/if}

	<div class="homegrid" style="height:100px">
		{include file="findInclude:common/templates/springboard.tpl" springboardItems=$modules springboardID="homegrid"}
	</div>

	<ul class="results">
		{foreach $courses as $course}
		<li>
			<a href="{$course['url']}">{$course['title']}</a>
		</li>
		{/foreach}
	</ul>
{else}
	<div style="margin: 1em">
		<p>No courses found</p>
	</div>
{/if}

{include file="findInclude:common/templates/footer.tpl"}
