{include file="findInclude:common/templates/header.tpl"}

<div class="focal">{$LOGIN_SIGNED_IN_MESSAGE}</div>

{include file="findInclude:common/templates/navlist.tpl" navlistItems=$users subTitleNewline=true navlistID="loggedInUsers"}

{include file="findInclude:common/templates/footer.tpl"}
