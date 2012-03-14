<div class="springboard"{if $springboardID} id="{$springboardID}"{/if}>
  {foreach $springboardItems as $item}
    {if $item['separator']}
      {block name="separator"}
        <p class="separator">&nbsp;</p>
      {/block}
    {else}
      <div {if $item['class']} class="{$item['class']}"{/if}>
        {if $item['url']}
          <a href="{$item['url']}">
        {/if}
            <img src="{$item['img']}" alt="{$item['title']}" />
            <br/>{$item['title']}
            {if isset($item['subTitle'])}
              <br/><span class="fineprint">{$item['subTitle']}</span>
            {/if}
            {block name="badge"}
              {if isset($item['badge'])}
                <span class="badge">{$item['badge']}</span>
              {/if}
            {/block}
            {block name="secured"}
              {if isset($item['secured'])}
          		<span class="secured"></span>
              {/if}
            {/block}
        {if $item['url']}
          </a>
        {/if}
      </div>
    {/if}
  {/foreach}
  {if isset($keyword)}
  <div class="module">
  <a href="http://isites.harvard.edu/{$keyword}"><img alt="Lecture Video" src="/modules/home/images/coursesite.png"><br>
  Course home</a>
  </div>
  {/if}
   <div class="module">
  <a href="https://huit.uservoice.com/forums/150465-mobile-interface"><img alt="Lecture Video" src="/modules/home/images/coursesite.png"><br>
  Feedback</a>
  </div>
</div>
