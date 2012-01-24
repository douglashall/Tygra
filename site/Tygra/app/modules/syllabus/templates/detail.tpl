{include file="findInclude:common/templates/header.tpl"}

<ul class="results" id="syllabusList">
  {foreach $results as $item}
      {if !isset($item['separator'])}
	      <li{if $item['img']} class="icon"{/if}>
	        {capture name="listItemLabel" assign="listItemLabel"}
			  {if isset($item['title'])}
			    {if $boldLabels}
			      <strong>
			    {/if}
			      {$item['title']}{if $labelColon|default:false}: {/if}
			    {if $boldLabels}
			      </strong>
			    {/if}
			  {/if}
			{/capture}
			{block name="itemLink"}
			    <a href="{$item['url']}" class="{$item['class']|default:''}"{if $linkTarget || $item['linkTarget']} target="{if $item['linkTarget']}{$item['linkTarget']}{else}{$linkTarget}{/if}"{/if}>
			    {if $item['img']}
			      <img src="{$item['img']}" alt="{$item['title'][0]}"{if $item['imgWidth']}
			        width="{$item['imgWidth']}"{/if}{if $item['imgHeight']}
			        height="{$item['imgHeight']}"{/if}{if $item['imgAlt']}
			        alt="{$item['imgAlt']}"{/if} />
			    {/if}
			    {$listItemLabel}
				    {if $item['subtitle']}
				      {if $subTitleNewline|default:true}<div{else}&nbsp;<span{/if} class="smallprint">
				        {$item['subtitle']}
				      {if $subTitleNewline|default:true}</div>{else}</span>{/if}
				    {/if}
			    {if $item['badge']}
			      <span class="badge">{$item['badge']}</span>
			    {/if}
			    </a>
			{/block}
	      </li>
      {/if}
  {/foreach}
  {if count($results) == 0}
    {block name="noResults"}
      <li>{$noResultsText|default:"No results found"}</li>
    {/block}
  {/if}
</ul>

{include file="findInclude:common/templates/footer.tpl"}

