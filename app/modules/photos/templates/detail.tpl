{include file="findInclude:common/templates/header.tpl"}

<div class="photo">
    <h1 class="slugline">{$photoTitle}</h1>

  <div id="photosubhead">
		<div class="photobuttons">
      {include file="findInclude:common/templates/bookmark.tpl" name=$cookieName item=$bookmarkItem exdate=$expireDate}  
      {include file="findInclude:common/templates/share.tpl" shareURL=$photoURL shareRemark=$shareRemark shareEmailURL=$shareEmailURL}
      </div>
            
        <p class="byline">
          {block name="byline"}
              
            {if $photoAuthor}
              <span class="credit">by <span class="author">{$photoAuthor}</span><br /></span>
            {/if}
    
            <span class="postdate">{$photoDate}</span>
          {/block}
        </p>    
  </div><!--storysubhead-->

    <img src="{$photoURL}" id="photoDetail" />

	<div class="photodescription">

		{$photoDescription}
	</div>
</div>

{include file="findInclude:common/templates/footer.tpl"}