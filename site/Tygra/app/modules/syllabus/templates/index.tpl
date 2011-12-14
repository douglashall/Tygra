{include file="findInclude:common/templates/header.tpl"}

<ul class="results" id="syllabusList">
  {foreach $results as $item}
	{if $item['syllabus'] && count($item['syllabus']) > 0}
	    {if !isset($item['separator'])}
	      <li{if $item['img']} class="icon"{/if}>
	        {capture name="listItemLabel" assign="listItemLabel"}
			  {if isset($item['siteTitle'])}
			    {if $boldLabels}
			      <strong>
			    {/if}
			      {$item['siteTitle']}{if $labelColon|default:false}: {/if}
			    {if $boldLabels}
			      </strong>
			    {/if}
			  {/if}
			{/capture}
			{block name="itemLink"}
			  {if count($item['syllabus']) == 1}
			    <a href="{$item['syllabus'][0]['linkUrl']}" class="{$item['class']|default:''}"{if $linkTarget || $item['linkTarget']} target="{if $item['linkTarget']}{$item['linkTarget']}{else}{$linkTarget}{/if}"{/if}>
			  {else}
			    <a href="detail?keyword={$item['keyword']}" class="{$item['class']|default:''}"{if $linkTarget || $item['linkTarget']} target="{if $item['linkTarget']}{$item['linkTarget']}{else}{$linkTarget}{/if}"{/if}>
			  {/if}
			    {if $item['img']}
			      <img src="{$item['img']}" alt="{$item['title']}"{if $item['imgWidth']}
			        width="{$item['imgWidth']}"{/if}{if $item['imgHeight']}
			        height="{$item['imgHeight']}"{/if}{if $item['imgAlt']}
			        alt="{$item['imgAlt']}"{/if} />
			    {/if}
			    {$listItemLabel}
			    {if count($item['syllabus']) == 1}
				    {if $item['syllabus'][0]['description']}
				      {if $subTitleNewline|default:true}<div{else}&nbsp;<span{/if} class="smallprint">
				        {$item['syllabus'][0]['description']}
				      {if $subTitleNewline|default:true}</div>{else}</span>{/if}
				    {/if}
				{else}
				    ({count($item['syllabus'])})
				{/if}
			    {if $item['badge']}
			      <span class="badge">{$item['badge']}</span>
			    {/if}
			    </a>
			{/block}
	      </li>
      {/if}
    {/if}
  {/foreach}
  {if count($results) == 0}
    {block name="noResults"}
      <li>{$noResultsText|default:"No results found"}</li>
    {/block}
  {/if}
</ul>

{include file="findInclude:common/templates/footer.tpl"}