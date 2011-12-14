{extends file="findExtends:modules/people/templates/detail.tpl"}

{block name="detail"}
  <li class="detail_{$key}{if !$item['label']} nolabel{/if}">
    {if $item['linkUrl']}
      <a href="{$item['linkUrl']}" class="{$item['class']|default:''}">
    {/if}
        <div class="value">{$item['title'][0]}</div>
    {if $item['linkUrl']}
      </a>
    {/if}
  </li>
{/block}
