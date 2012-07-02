{include file="findInclude:common/templates/header.tpl"}

{if $results}
		{block name="detail"}
            <div>
                  <div class="label">Title</div>
                  <div class="value">{$results['title']}</div>
                  {if $results['subTitle']}
	                  <div class="label">Sub Title</div>
	                  <div class="value">{$results['subTitle']}</div>
                  {/if}
                  {if $results['description']}
	                  <div class="label">Description</div>
	                  <div class="value">{$results['description']}</div>
	              {/if}
	              {if $results['credits']}
                  	 <div class="label">Credits</div>
                  	<div class="value">{$results['credits']}</div>
                  {/if}
                  {if $results['termDisplayName']}
	                  <div class="label">Term </div>
	                  <div class="value">{$results['termDisplayName']}</div>
	               {/if}   
                   {if $results['instructorsDisplay']}
	                   <div class="label">Instructors </div>
	                   <div class="value">{$results['instructorsDisplay']}</div>
	               {/if}  
                   {if $results['meetingTime']}
	                   <div class="label">Meeting Time</div>
	                   <div class="value">{$results['meetingTime']}</div>
	                {/if}  
                   {if $results['department']}
	                   <div class="label">Department </div>
	                   <div class="value">{$results['department']}</div>
	                {/if}   
                   {if $results['schoolId']}
	                   <div class="label">School </div>
	                   <div class="value">{$results['schoolId']}</div>
	                {/if}  

			
			 
            </div>
          {/block}


	
{else}
	{include file="findInclude:common/templates/emptylist.tpl" emptyMessage="No Information found"}
{/if}


{include file="findInclude:common/templates/footer.tpl"}
