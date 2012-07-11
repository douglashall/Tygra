{include file="findInclude:common/templates/header.tpl"}

{if $results}
		
            <div>
            	<strong>
            	 <div>
	            	  {if $results['title']}
	                 	{$results['title']}
	                  {/if} 
	                  {if $results['subTitle']}
	                  		: {$results['subTitle']}
	                  {/if}	
	                  <br/>
				  <div/>
				 </strong>
				  
				  {if $results['schoolId']}
				       <div>{$results['schoolId']}: {$results['registrarCode']}</div>
				      
	              {/if}  
	              
	              {if $results['termDisplayName']}
	                  <!--<div class="label">Term </div>-->
	                  <div >{$results['termDisplayName']}</div>
	                  
	               {/if} 
	               
          
	            
	              {if $results['credits']}
                  	 <!--<div class="label">Credits</div>-->
                  	<div >{$results['credits']}</div>
                  	
                  {/if}
  					
                   {if $results['instructorsDisplay']}
	                  
	                   <div>{$results['instructorsDisplay']}</div>
	                   
	               {/if} 
	              
                   {if $results['meetingTime']}
	                   <div>Meeting Time: {$results['meetingTime']}</div>
	                   
	                {/if}
	                
	                {if $results['location']}
	                   <!--<div class="label">Location</div>-->
	                   <div>{$results['location']}</div>
	     
	                {/if} 
	                
	                {if $results['examGroup']}
	                   <!--<div class="value">examGroup</div>-->
	                   <div>Exam Group: {$results['examGroup']}</div>
	        
	                {/if}   
                   

			        {if $results['description']}
	                  <div>{$results['description']}</div>
	       
	                {/if}
	                
	                
			        {if $results['prereq']}
	                  <div>Prerequisite: {$results['prereq']}</div>
	          
	                {/if}
			 
            </div>
        


	
{else}
	{include file="findInclude:common/templates/emptylist.tpl" emptyMessage="No Information found"}
{/if}


{include file="findInclude:common/templates/footer.tpl"}
