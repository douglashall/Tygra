{include file="findInclude:common/templates/header.tpl"}

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
		<a href="/course/?keyword={$course->getKeyword()}">{$course->getTitle()}</a>
	</li>
	{/foreach}
</ul>



{include file="findInclude:common/templates/footer.tpl"}