{include file="findInclude:common/templates/header.tpl"}

{foreach $sections as $section}
	<div class="nonfocal">
	  <h2>{$section['label']}</h2>
	</div>

	{include file="findInclude:common/templates/navlist.tpl" navlistItems=$section['items']}
{/foreach}

{include file="findInclude:common/templates/footer.tpl"}