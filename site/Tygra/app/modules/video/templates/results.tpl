<ul class="results">
  {$ellipsisCount=0}
  
  {if $previousURL}
    <li class="pagerlink">
      <a href="{$previousURL}">Previous {$maxPerPage} videos...</a>
    </li>
  {/if}
  
  {foreach $results as $item}
  
    {if !isset($item['separator'])}
      <li class="video{if !$item['img']} noimage{/if}">  
  		
        {include file="findInclude:modules/$moduleID/templates/listItem.tpl" ellipsisId=$ellipsisCount++ subTitleNewline=$subTitleNewline|default:true} 
       
      </li>
    {/if}
  {/foreach}
  
  {if count($results) == 0}
    {block name="noResults"}
      <li>{$noResultsText|default:"No results found"}</li>
    {/block}
  {/if}
  
  {if $nextURL}
    <li class="pagerlink">
      <a href="{$nextURL}">Next {$maxPerPage} videos...</a>
    </li>
  {/if}
</ul>
