{extends file="findExtends:common/templates/header.tpl"}

{block name="breadcrumbs"}
  {if !$isModuleHome}
    {foreach $breadcrumbs as $breadcrumb}	
    	{if $breadcrumb@first && ($breadcrumb['p'] == 'index' && $breadcrumb['m'] == 'home')}
    		{* Skip the home/index breadcrumb because the $homeLink is already displayed *}
    		{continue}
    	{/if}
    	
      {if $breadcrumb@first || ($breadcrumb['p'] == 'index')}
        {$crumbClass = 'module'}
      {elseif count($breadcrumbs) == 1}
        {$crumbClass = 'crumb1'}
      {elseif count($breadcrumbs) == 2}
        {if !$breadcrumb@last}
          {$crumbClass = 'crumb2a'}
        {else}
          {assign var=crumbClass value='crumb2b'}
        {/if}
      {elseif count($breadcrumbs) > 2}
        {if $breadcrumb@last}
          {$crumbClass = 'crumb3c'}
        {elseif $breadcrumb@index == ($breadcrumb@total-2)}
          {assign var=crumbClass value='crumb3b'}
        {else}
          {assign var=crumbClass value='crumb3a'}
        {/if}
        
      {/if}
      {if $moduleID != 'home' || !$breadcrumb@first}
        <a href="{$breadcrumb['url']|sanitize_url}" {if isset($crumbClass)}class="{$crumbClass}{/if}">
          {if $breadcrumb['p'] == 'index'}
            <img src="/common/images/title-{$navImageID|default:$breadcrumb['m']}.png" width="{$module_nav_image_width|default:28}" height="{$module_nav_image_height|default:28}" alt="" />
          {else}
            <span>{$breadcrumb['title']|sanitize_html:'inline'}</span>
          {/if}
        </a>
      {/if}
    {/foreach}
  {/if}
{/block}
