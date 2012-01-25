{include file="findInclude:common/templates/header.tpl" scalable=false}

{include file="findInclude:common/templates/search.tpl" emphasized=false}

<ul class="results">
	{foreach $searchResults as $result}
	<li>
		<a href="{$result['url']}">{$result['title']}</a>
	</li>
	{/foreach}
</ul>



{include file="findInclude:common/templates/footer.tpl"}
