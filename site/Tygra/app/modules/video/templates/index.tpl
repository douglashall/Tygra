{include file="findInclude:common/templates/header.tpl"}
<ul class="results">

 {foreach $results as $item}
      <li class="video{if !$item['img']} noimage{/if}">  
{block name="itemLink"}
  {if $item['url']}
    <a href="{$item['url']}" class="{$item['class']|default:''}"{if $linkTarget || $item['linkTarget']} target="{if $item['linkTarget']}{$item['linkTarget']}{else}{$linkTarget}{/if}"{/if}>
  {/if}
	    <div class="ellipsis" id="ellipsis_{$ellipsisId}">
	          <div class="title">{$item['keyword']}</div>
	    </div>
  {if $item['url']}
    </a>
  {/if}
{/block}
      </li>

{/foreach}
</ul>

{include file="findInclude:common/templates/footer.tpl"}



