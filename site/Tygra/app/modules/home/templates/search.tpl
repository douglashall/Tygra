{include file="findInclude:common/templates/header.tpl" scalable=false}

{include file="findInclude:common/templates/search.tpl" emphasized=false}

<ul class="results">
	{foreach $searchResultArray as $title => $url}
	<li>
		<a href="{$url}">{$title}</a>
	</li>
	{/foreach}
</ul>



{include file="findInclude:common/templates/footer.tpl"}
