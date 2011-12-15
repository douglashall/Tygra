{extends file="findExtends:modules/people/templates/detail.tpl"}

{block name="detailsStart"}
<div class="focal">
  <table class="dl" cellpadding="0" cellspacing="0" border="0" style="margin: 0; padding: 0">
    <tbody>
{/block}
    
      {block name="detail"}
        <tr valign="top">
          <td align="right" class="label">{$item['label']}&nbsp;</td>
          <td class="value">
            {if isset($item['linkUrl'])}
              <a href="{$item['linkUrl']}" class="{$item['class']|default:''}">
            {/if}
                {$item['title'][0]}
            {if isset($item['lihkUrl'])}
              </a>
            {/if}
          </td>
        </tr>
      {/block}

{block name="detailsEnd"}
    </tbody>
  </table>
</div>
{/block}
