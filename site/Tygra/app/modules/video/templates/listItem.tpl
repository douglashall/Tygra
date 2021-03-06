{if isset($item['label'])}
  {if $boldLabels}
    <strong>
  {/if}
    {$item['label']}{if $labelColon|default:true}:&nbsp;{/if}
  {if $boldLabels}
    </strong>
  {/if}
{/if}
{block name="itemLink"}
  {if $item['url']}
    <a href="{$item['url']}" class="{$item['class']|default:''}"{if $linkTarget || $item['linkTarget']} target="{if $item['linkTarget']}{$item['linkTarget']}{else}{$linkTarget}{/if}"{/if}>
  {/if}
    {if $item['img']}
      <img src="{$item['img']}" class="thumbnail" alt="{$item['title']}" />
    {/if}
	    <div class="ellipsis" id="ellipsis_{$ellipsisId}">
	          <div class="title">{$item['title']}
	          	<div class="moddate">Last modified: {$item['modDate']}</div>
	          </div>
	          
	    </div>
    {if $item['badge']}
      <span class="badge">{$item['badge']}</span>
    {/if}
  {if $item['url']}
    </a>
  {/if}
{/block}
