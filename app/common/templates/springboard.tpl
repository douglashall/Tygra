<div class="springboard"{if $springboardID} id="{$springboardID}"{/if}>
  {foreach $springboardItems as $item}
    {if $item['separator']}
      {block name="separator"}
        <p class="separator">&nbsp;</p>
      {/block}
    {else}
    {if $item['title'] == "Logout"}
       <div class="module">
  <a href="https://icommons.uservoice.com/forums/155804-m-courses-feedback"><img alt="m.courses Feedback" class="Feedback" src="/modules/home/images/spacer.gif"><br>
  Feedback</a>
  </div>
    {/if}
      <div {if $item['class']} class="{$item['class']}"{/if}>
        {if $item['url']}
          <a href="{$item['url']}">
        {/if}
            <img src="/modules/home/images/spacer.gif" alt="{$item['title']}" class="{$item['title']|replace:' ':''}" /><!-- old src {$item['img']}-->
            <script>
				for ( var i = 0 ; i < 6; i++)
				{
					//get the img tag for icon
					var x=document.getElementsByTagName('img')[i];
					//remove (n)
					x = x.className.replace(/\(.*?\)/g, '');
					//replace class name with out (n)
					document.getElementsByTagName('img')[i].setAttribute("class", x);
				}
			</script>
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
  <a href="http://isites.harvard.edu/{$keyword}"><img alt="Course Site" class="CourseSite" src="/modules/home/images/spacer.gif"><br>
  Full Course Site</a>
  </div>
     <div class="module">
  <a href="https://icommons.uservoice.com/forums/155804-m-courses-feedback"><img alt="m.courses Feedback" class="Feedback" src="/modules/home/images/spacer.gif"><br>
  Feedback</a>
  </div>
  {/if}

</div>
