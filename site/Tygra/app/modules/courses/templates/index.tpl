{capture name="banner" assign="banner"}

  <h1 id="homelogo"{if isset($topItem)} class="roomfornew"{/if}>
    <img src="/modules/{$moduleID}/images/logo-home{$imageExt}" width="{$banner_width|default:265}" height="{$banner_height|default:45}" alt="{$strings.SITE_NAME|escape}" />
  </h1>
{/capture}

{include file="findInclude:common/templates/header.tpl"}

{if $showFederatedSearch}
{block name="federatedSearch"}
{include file="findInclude:common/templates/search.tpl"}
{/block}
{/if}

<div class="homegrid">
	{include file="findInclude:common/templates/springboard.tpl" springboardItems=$modules springboardID="homegrid"}
</div>
<ul class="results">
	{foreach $courses as $course}
	<li>
		<a href="/home/?keyword={$course->getKeyword()}">{$course->getTitle()}</a>
	</li>
	{/foreach}
</ul>


<!--
<ul class="results" id="activityList">
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
		  {if $item['url']}
		    <a href="{$item['url']}" class="{$item['class']|default:''}"{if $linkTarget || $item['linkTarget']} target="{if $item['linkTarget']}{$item['linkTarget']}{else}{$linkTarget}{/if}"{/if}>
		  {/if}
		    {if $item['img']}
		      <img src="{$item['img']}" alt="{$item['title']}"{if $item['imgWidth']}
		        width="{$item['imgWidth']}"{/if}{if $item['imgHeight']}
		        height="{$item['imgHeight']}"{/if}{if $item['imgAlt']}
		        alt="{$item['imgAlt']}"{/if} />
		    {/if}
		    {$listItemLabel}
		    {if $titleTruncate}
		      {$item['title']|truncate:$titleTruncate}
		    {else}
		      {$item['title']}
		    {/if}
		    {if $item['subtitle']}
		      {if $subTitleNewline|default:true}<div{else}&nbsp;<span{/if} class="smallprint">
		        {$item['subtitle']}
		      {if $subTitleNewline|default:true}</div>{else}</span>{/if}
		    {/if}
		    {if $item['badge']}
		      <span class="badge">{$item['badge']}</span>
		    {/if}
		  {if $item['url']}
		    </a>
		  {/if}
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
-->


{include file="findInclude:common/templates/footer.tpl"}