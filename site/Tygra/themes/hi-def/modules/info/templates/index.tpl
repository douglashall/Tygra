{extends file="findExtends:modules/info/templates/index.tpl"}

{block name="pageTitle"}Harvard Mobile Courses{/block}

{block name='description'}m.courses.harvard.edu is a university-wide mobile initiative to aggregate and deliver useful,
		usable, mobile-appropriate course content.{/block}

{block name="header"}
  	<div id="utility_nav">
    </div><!--/utility_nav-->
    
    <div id="logo">
    	<img src="/modules/home/images/logo-home.png" alt="Harvard Mobile Courses" border="0" />
    </div>
    
    <!--h1>m.courses.harvard.edu</h1-->
    <p>
        is a university-wide mobile initiative to aggregate and deliver useful,
		usable, mobile-appropriate course content.
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
          <a id="feedback" href="https://icommons.uservoice.com/forums/155804-m-courses-feedback">
            <strong>Feedback</strong>
            <br />
            Want to recommend a feature? Your ideas and usage will 
            help inform future development. 
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
Keep up-to-date on site activity with this personalized list of the latest site content.
            </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/modules/home/images/syllabus.png" alt="Syllabus" />
            </td>
            <td>
            <h2>Syllabus</h2>
            <p>
View course outlines as posted by your teaching staff.
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
Get to know your fellow classmates -- contact information is available to help foster collaboration.
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
Miss a lecture or want to review? If media services has made a video of your class available, you'll find it here.
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
Available across all of your courses or within a single course, use this feature to quickly find what you're after.
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
