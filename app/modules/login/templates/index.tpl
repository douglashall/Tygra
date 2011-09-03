{include file="findInclude:common/templates/header.tpl"}

{if $message}
<p class="nonfocal error">{$message|escape}</p>
{/if}

<p class="nonfocal">{if $moduleStrings.LOGIN_INDEX_MESSAGE}{$moduleStrings.LOGIN_INDEX_MESSAGE}
{else}
To access {$strings.SITE_NAME}, please sign in{if $multipleAuthorities}
{if $authenticationAuthorities.direct && $authenticationAuthorities.indirect}
.
{elseif $authenticationAuthorities.direct}
 using your account with one of these services.
{else}
 using your account with one of these external services.{/if}
{else}
.
{/if}
{/if}
</p>

{include file="findInclude:modules/login/templates/loginForm.tpl"}

{include file="findInclude:common/templates/footer.tpl"}
