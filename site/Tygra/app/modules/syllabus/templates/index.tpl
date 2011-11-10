{include file="findInclude:common/templates/header.tpl"}
<ul class="results" id="syllabusList">
  {foreach $results as $site}
  From site: <strong><a href="{$site['siteHref']}">'{$site['siteTitle']}'</a></strong>
	  {foreach $site.syllabus as $item}
	  <li>
	      <a href="{$item['linkUrl']}" target='_new'>{$item['title'][0]}<small>({$item['topicId']}/{$item['category']})</small></a>
		  {if isset($item['description'])}
		  <small>{$item['description'][0]}</small>
		  {/if}
	  </li>
	  {/foreach}
  {/foreach}
  {if count($results) == 0}
    {block name="noResults"}
      <li>{$noResultsText|default:"No results found"}</li>
    {/block}
  {/if}
</ul>

{include file="findInclude:common/templates/footer.tpl"}