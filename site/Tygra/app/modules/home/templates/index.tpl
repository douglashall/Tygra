{capture name="banner" assign="banner"}

  <h1 id="homelogo"{if isset($topItem)} class="roomfornew"{/if}>
    <img src="/modules/{$moduleID}/images/logo-home{$imageExt}" width="{$banner_width|default:265}" height="{$banner_height|default:45}" alt="{$strings.SITE_NAME|escape}" />
  </h1>
{/capture}

{include file="findInclude:common/templates/header.tpl" customHeader=$banner scalable=false}

{if $terms}
	{if $showFederatedSearch}
	{block name="federatedSearch"}
	{include file="findInclude:common/templates/search.tpl"}
	{/block}
	{/if}

	<div class="homegrid" style="height:100px">
		{include file="findInclude:common/templates/springboard.tpl" springboardItems=$modules springboardID="homegrid"}
	</div>

	{foreach $terms as $term}
		<div class="nonfocal">
			 <h2>{$term['label']}</h2>
		</div>
		
		{include file="findInclude:common/templates/navlist.tpl" navlistItems=$term['items'] titleTruncate=40}
	{/foreach}
{else}
	{include file="findInclude:common/templates/emptylist.tpl" emptyMessage="No courses found"}
{/if}

{include file="findInclude:common/templates/footer.tpl"}
