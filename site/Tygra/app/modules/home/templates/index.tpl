{include file="findInclude:common/templates/header.tpl"}

{if $showFederatedSearch}
{block name="federatedSearch"}
{include file="findInclude:common/templates/search.tpl"}
{/block}
{/if}

<div class="homegrid" style="height:100px">
	{include file="findInclude:common/templates/springboard.tpl" springboardItems=$modules springboardID="homegrid"}
</div>
{if $courses}
	<ul class="results">
		{foreach $courses as $course}
		<li>
			<a href="/course/?keyword={$course->getKeyword()}">{$course->getTitle()}</a>
		</li>
		{/foreach}
	</ul>
{else}
	<ul class="results">
		<li>You are not enrolled in any courses</li>
	</ul>
{/if}



{include file="findInclude:common/templates/footer.tpl"}