{include file="findInclude:common/templates/header.tpl"}

<div class="focal"> 
  {foreach $moduleStrings.SITE_ABOUT_HTML as $paragraph}
    <p>{$paragraph}</p>
  {/foreach}
  <p>
    You're using the version optimized for {$devicePhrase}.
  </p>
  <p>
    We value your feedback! Please email your questions and suggestions 
    to <a href="mailto:{$strings.FEEDBACK_EMAIL}">{$strings.FEEDBACK_EMAIL}</a>.
  </p> 
</div> 

<div class="nonfocal legend"> 
  <p><strong>* Important note:</strong> {$strings.SITE_NAME} is a free service. Extra data charges may apply when using any website on your mobile device depending on your service plan.</p> 
</div> 
{include file="findInclude:common/templates/footer.tpl"}
