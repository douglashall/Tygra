{include file="findInclude:common/templates/header.tpl"}

{if $showFederatedSearch}
{block name="federatedSearch"}
{include file="findInclude:common/templates/search.tpl" extraArgs=$extraArgs}
{/block}
{/if}
 
{if $displayType == 'springboard'}
  {include file="findInclude:common/templates/springboard.tpl" springboardItems=$modules springboardID="homegrid"}
{elseif $displayType == 'list'}
  {$primaryModules = array()}
  {$secondaryModules = array()}
  {$foundSeparator = false}
  {foreach $modules as $module}
    {if $module['separator']}
      {$foundSeparator = true}
    {elseif $foundSeparator}
      {$secondaryModules[] = $module}
    {else}
      {$primaryModules[] = $module}
    {/if}
  {/foreach}

  {include file="findInclude:common/templates/navlist.tpl" navlistItems=$primaryModules}
  {if $secondaryModules}
  {include file="findInclude:common/templates/navlist.tpl" navlistItems=$secondaryModules accessKeyLink=false}
  {/if}
{/if}

{include file="findInclude:common/templates/footer.tpl"}
