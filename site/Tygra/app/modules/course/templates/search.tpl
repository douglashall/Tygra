{include file="findInclude:common/templates/header.tpl" scalable=false}

{include file="findInclude:common/templates/search.tpl" emphasized=false}

<ul class="results">
	{foreach $searchResults as $result}
	<li>
		<a href="{$result['url']}">{$result['title']}</a>
	</li>
	{/foreach}
	{if !is_array($searchResults) || $searchResults[0] == null}
    <li>Sorry, there were no results for your query.</li>
	{/if}
</ul>



{include file="findInclude:common/templates/footer.tpl"}
