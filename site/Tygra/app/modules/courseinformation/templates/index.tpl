{include file="findInclude:common/templates/header.tpl"}

{if $results}
		
            
            <!-- what is this block for? (start)-->
            <div class="nonfocal">
                <h3>
                    {if $results['title']}
                    {$results['title']}
                    {/if} 
                    {if $results['subTitle']}
                        : {$results['subTitle']}
                    {/if}	
                </h3>              
            </div>   
            <!-- what is this block for? (end)-->
            
							  
            {if $results['schoolId']}
                <div class="nonfocal">
                	<h3>{$results['schoolId']}: {$results['registrarCode']}</h3>
                </div>				      
            {/if}
                  
	         <ul class="nav">     
	              {if $results['termDisplayName']}
	                  <!--<div class="label">Term </div>-->
	                  <li>{$results['termDisplayName']}</li>
	                  
	               {/if} 
	               
          
	            
	              {if $results['credits']}
                  	 <!--<div class="label">Credits</div>-->
                  	<li >{$results['credits']}</li>
                  	
                  {/if}
  					
                   {if $results['instructorsDisplay']}
	                  
	                   <li>{$results['instructorsDisplay']}</li>
	                   
	               {/if} 
	              
                   {if $results['meetingTime']}
	                   <li>Meeting Time: {$results['meetingTime']}</li>
	                   
	                {/if}
	                
	                {if $results['location']}
	                   <!--<div class="label">Location</div>-->
	                   <li>{$results['location']}</li>
	     
	                {/if} 
	                
	                {if $results['examGroup']}
	                   <!--<div class="value">examGroup</div>-->
	                   <li>Exam Group: {$results['examGroup']}</li>
	        
	                {/if}   
                   

			        {if $results['description']}
	                  <li>{$results['description']}</li>
	       
	                {/if}
	                
	                
			        {if $results['prereq']}
	                  <li>Prerequisite: {$results['prereq']}</li>
	          
	                {/if}
			 
            </ul>
        


	
{else}
	{include file="findInclude:common/templates/emptylist.tpl" emptyMessage="No Information found"}
{/if}


{include file="findInclude:common/templates/footer.tpl"}
