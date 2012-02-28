{extends file="findExtends:modules/info/templates/index.tpl"}

{block name="pageTitle"}Harvard Mobile Courses{/block}

{block name='description'}m.courses.harvard.edu is a university-wide mobile initiative to aggregate and deliver useful,
		usable, mobile-appropriate course content to university communities, locally and
		worldwide.{/block}

{block name="header"}
	<!--
  	<div id="utility_nav">
    	<a href="http://modolabs.com" target="_blank">Universitas.edu</a>
        &nbsp;|&nbsp;
        <a href="http://modolabs.com/" target="_blank">Contact</a>
        &nbsp;|&nbsp;
        Share &nbsp; <a href="http://facebook.com/universitas" title="Facebook" target="_blank"><img src="/modules/info/images/facebook.png" alt="facebook"></a>  
		&nbsp;
		<a href="http://twitter.com/universitas" title="Twitter" target="_blank"><img src="/modules/info/images/twitter.png" alt="twitter"></a>
    </div><!--/utility_nav-->
    -->
    <div id="logo">
    	<img src="/modules/home/images/logo-home.png" alt="Harvard Mobile Courses" border="0" />
    </div>
    
    <!--h1>m.courses.harvard.edu</h1-->
    <p>
        is a university-wide mobile initiative to aggregate and deliver useful,
		usable, mobile-appropriate course content to university communities, locally and
		worldwide.
    </p>
{/block}
    
{block name="content"}
  	<div class="leftcol">
    	<h2>Mobile Web Application</h2>
        <p>
            You can reach the mobile web application by going to <a href="/">m.courses.harvard.edu</a> on your
            web browser on any internet-enabled mobile device. The mobile web
            application includes all the features listed at right.
        </p>
        <p>
          <a id="preview" href="/home/" target="HarvardCoursesMobile">Click here to preview the site on your desktop or laptop.</a>
        </p>
        
        <div class="clr"></div>
        
    	<h2>What's next?</h2>
        <p>
            We recognize that this is just the starting point for providing a better
            mobile experience for students, faculty and staff. We will continue to roll
            out new features in the future.
        </p>
        
        <p>
          <a id="feedback" href="https://huit.uservoice.com/forums/150465-mobile-interface">
            <strong>Feedback</strong>
            <br />
            Want to recommend a feature? Your ideas and usage will 
            help inform future development. 
            <a href="https://huit.uservoice.com/forums/150465-mobile-interface">Click here to give us feedback</a>!
          </a>
        </p>
        
    </div><!--/leftcol-->
    
    <div class="rightcol">
    	<h2>Features</h2>
        
    	<table cellpadding="0" cellspacing="0" id="features">
          <tr>
            <td>
              <img src="/modules/home/images/updates.png" alt="Updates" />
            </td>
            <td>
            <h2>Updates</h2>
            <p>
            Search by first and last name for phone numbers, email addresses, and office location for Universitas students, faculty and staff. Note that contact details vary and are informed by individual privacy settings.
            </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/modules/home/images/syllabus.png" alt="Syllabus" />
            </td>
            <td>
            <h2>Classmates</h2>
            <p>
            Search by first and last name for phone numbers, email addresses, and office location for Universitas students, faculty and staff. Note that contact details vary and are informed by individual privacy settings.
            </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/modules/home/images/classmates.png" alt="Classmates" />
            </td>
            <td>
            <h2>Classmates</h2>
            <p>
            Search by first and last name for phone numbers, email addresses, and office location for Universitas students, faculty and staff. Note that contact details vary and are informed by individual privacy settings.
            </p>
            </td>
          </tr>

          <tr>
            <td>
              <img src="/modules/home/images/video.png" alt="Lecture Video" />
            </td>
            <td>
            <h2>Lecture Video</h2>
            <p>
            View YouTube videos posted by Universitas including special events, athletics and student organizations. 
            </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/modules/home/images/info.png" alt="Search" />
            </td>
            <td>
            <h2>Search</h2>
            <p>
            Search offers a quick and powerful way to search across content from most or all of the features above. Search results will be presented grouped by type, and recent search queries will be saved and auto-suggested for even faster and easier access.
            </p>
            </td>
          </tr>
          
        </table>
    </div><!--/rightcol-->

	<div class="clr"></div>
{/block}
    
{block name="footer"}
  <span class="copyright">&copy; 2012 The President and Fellows of Harvard College</span>
{/block}

{block name="footerJavascript"}
{/block}
