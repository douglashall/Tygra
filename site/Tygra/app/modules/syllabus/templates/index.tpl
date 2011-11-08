{include file="findInclude:common/templates/header.tpl"}
<ul class="results" id="syllabusList">
  {foreach $results as $site}
  <b>From site: '{$site['siteTitle']}'</b>
	  {foreach $site.syllabus as $item}
	    {if !isset($item['separator'])}
	      <li{if $item['img']} class="icon"{/if}>
	        {capture name="listItemLabel" assign="listItemLabel"}
			  {if isset($item['title'])}
			    {if $boldLabels}
			      <strong>
			    {/if}
			      {$item['title'][0]}{if $labelColon|default:false}: {/if}
			    {if $boldLabels}
			      </strong>
			    {/if}
			  {/if}
			{/capture}
			{block name="itemLink"}
			  {if $item['linkUrl']}
			    <a href="{$item['linkUrl'][0]}" class="{$item['class']|default:''}"{if $linkTarget || $item['linkUrl'][0]} target="{if $item['linkUrl']}{$item['linkUrl'][0]}{else}{$linkTarget}{/if}"{/if}>
			  {/if}
			    {if $item['img']}
			      <img src="{$item['img']}" alt="{$item['title']}"{if $item['imgWidth']}
			        width="{$item['imgWidth']}"{/if}{if $item['imgHeight']}
			        height="{$item['imgHeight']}"{/if}{if $item['imgAlt']}
			        alt="{$item['imgAlt']}"{/if} />
			    {/if}
			    {$listItemLabel}
			    {if $item['title']}
			      {if $subTitleNewline|default:true}<div{else}&nbsp;<span{/if} class="smallprint">
			        {$item['title'][0]}
			      {if $subTitleNewline|default:true}</div>{else}</span>{/if}
			    {/if}
			    {if $item['description']}
			      <span class="badge">{$item['description'][0]}</span>
			    {/if}
			  {if $item['linkUrl']}
			    </a>
			  {/if}
			{/block}
	      </li>
	    {/if}
	  {/foreach}
  
  {/foreach}
  {if count($results) == 0}
    {block name="noResults"}
      <li>{$noResultsText|default:"No results found"}</li>
    {/block}
  {/if}
</ul>

{include file="findInclude:common/templates/footer.tpl"}