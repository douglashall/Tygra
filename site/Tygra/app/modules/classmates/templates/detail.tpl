{include file="findInclude:common/templates/header.tpl"}

<div class="peoplebuttons">
{include file="findInclude:common/templates/bookmark.tpl" name=$cookieName item=$bookmarkItem exdate=$expireDate}  
</div>

{block name="detailsStart"}
{/block}
    {block name="sectionStart"}
      <div class="nav section_thumbnail">
    {/block}
          {block name="detail"}
            <img src="{$photoUrl}" class="image" alt="{$item['title']}"{if $item['imgWidth']}
			        width="{$item['imgWidth']}"{/if}
			        {if $item['imgAlt']}alt="{$item['imgAlt']}"{/if} />
          {/block}
    {block name="sectionEnd"}
      </div>
    {/block}
    
    {block name="sectionStart"}
      <ul class="nav section_name">
    {/block}
          {block name="detail"}
            <li class="detail_name">
                  <div class="label">name</div>
                  <div class="value">{$item['firstName']} {$item['lastName']}</div>
            </li>
          {/block}
    {block name="sectionEnd"}
      </ul>
    {/block}
    
    {block name="sectionStart"}
      <ul class="nav section_email">
    {/block}
          {block name="detail"}
            <li class="detail_email">
              <a href="mailto:{$item['email']}" class="email">
                  <div class="label">email</div>
                  <div class="value">{$item['email']}</div>
              </a>
            </li>
          {/block}
    {block name="sectionEnd"}
      </ul>
    {/block}
{block name="detailsEnd"}
{/block}

{include file="findInclude:common/templates/footer.tpl"}

