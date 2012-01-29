<span class="boldtext">How do I add the thumbnails to my posts? </span>
<div class="indent">
  <p>Chameleon utilizes a script called TimThumb to automatically resize images. Whenever you make a new post you will need to add a custom field. Once you are on the edit/write page screen, click the "Screen Options" link on the top right of the screen and make sure "Custom Fields" is checked. Scroll down below the text editor and click on the &quot;custom fields&quot; link. In the &quot;Name&quot; section, input &quot;Thumbnail&quot; (this is case sensitive). In the &quot;Value&quot; area, input the url to your thumbnail image. Your image will automatically be resized and cropped. The image must be hosted on your domain. (this is to protect against bandwidth left) </p>
  <p><span class="style1">Important Note: You <u>must</u> CHMOD the &quot;cache&quot; folder located in the Chameleon directory to 777 for this script to work. You can CHMOD (change the permissions) of a file using your favorite FTP program. If you are confused try following <a href="http://www.siteground.com/tutorials/ftp/ftp_chmod.htm"><u>this tutorial</u></a><u>.</u> Of course instead of CHMODing the template folder (as in the tutorial) you would CHMOD the &quot;cache&quot; folder found within your theme's directory. </span></p>
</div>
<span class="boldtext">How do I add my title/logo? </span>
<div class="indent">
In this theme the title/logo is an image, which means you will need an image editor to add your own text. You can do this by opening the blank logo image located at Photoshop Files/logo_blank.png, or by opening the logo PSD file located at Photoshop Files/logo.psd. Replace the edited logo with the old logo by placing it in the following directory: theme/Chameleon/images, and naming the file "logo.png". If you need more room, or would like to edit the logo further, you can always do so by opening the original fully layered PSD file located at Photoshop Files/Chameleon.psd  </div>

<span class="boldtext"> How do I manage advertisements on my blog? </span>
<div class="indent">You can change the images used in each of the advertisements, as well as which URL each ad points to, through the custom option pages found in wp-admin. Once logged in to the wordpress admin panel, click &quot;Design&quot; and then &quot;Chameleon Theme Options&quot; to reveal the various theme options. You can also use the 125x125 advertisement widget by adding the ET: Advertisement widget to your sidebar, and filling in the required fields.  </div>

  <span class="boldtext"> How do I set up the featured slider on the homepage? </span>
  <div class="indent">
  <p>The featured slider can be set up using two different methods. You can either populate the tabs using Pages, or you can popular it using posts from a designated category. In the Appearances > Chameleon Theme Options page in wp-admin, under the General Settings > Featured Slider tab, you will see an option that says "Use Pages." If you select this option then pages will be used, if you don't then posts will be used. If you want to use Pages then you simply select "Use Pages," and then below the option select which pages you would like to display in the slider. If you don't use pages, then simply select the "Featured Category" from the dropdown menu and posts from that category will be added to the slider. </p>You can also choose between three different slider variations (Nivo, Cycle and Roundabout). YOu can switch between each slider type via the "Slider Type" setting located in the General Settings > Featured Slider tab of ePanel.</div>
  
  
  <span class="boldtext"> Setting Up The Media Bar On The Homepage</span> 
  <div class="indent"> 
  <p>Each item in the media bar on the homepage comes from a post. All of these posts are pulled from a single category that is defined within the ePanel theme options. The first thing you need to do is choose which category you would like to pull your posts from. To do this, navigate to the Appearances > Chameleon Theme Options page and click on the General Settings > Homepage tab. Look for the "Exclude categories from homepage media section" section and select, with a green checkmark, which categories you would like to display in the media bar.
</p> 
<p>Next you will need to add "media" to each of the posts within those categories. To add an image to the media bar, you simply need to add the Thumbnail custom field to each of the posts as outlined in the "Adding Thumbnails Images To Posts" tutorial above.</p>
<p>You can also add video to each of the posts in the media bar. To do this you will need to add a new custom field to the post with a Name of "et_videolink" and a Value of the URL to your video. You can only embed videos from video hosts such as youtube.com or vimeo.com. Once you have chosen a video, simply add the URL to the video in the "Value" field of the custom field. For example, if I wanted to add the following video to the post: http://vimeo.com/21294655 then all I would do is type "http://vimeo.com/21294655" into the Value field of the "et_videolink" custom field.</p>
</div> 
  
  <span class="boldtext"> How do I setup the three blurbs on the homepage, below the slider? </span>
  <div class="indent">
  <p>These blurbs are created using pages. Create three pages that you would like to use for these three blurbs, then go to the Appearances > Chameleon Theme Options page and click the General Settings > Homepage tab. Under the Service Page 1/2/3 dropdown menus, choose the three pages you would like to use. Wi tin the pages you can use a "more" tag to truncate the post preview.
</p>
<p>Next you will need to assign an Icon image to each blurb. This works just like Thumbnail images, except you use the custom field name "Icon" instead. So create a custom field for each page with the name of "Icon" and a value of the icon image you would like to use. Icons must not exceed 36x36 pixels to insure optimum display.</p>
</div>

  <span class="boldtext"> Customizing the fonts used in the theme </span>
  <div class="indent">
  <p>Chameleon makes it easy to change what fonts are used in the theme. You can change the Header and Body fonts independently from within the Appearances > Chameleon Theme Options page under the General Settings > General tab. Look for the "Header Font" and "Body Font" settings and select your desired font from the dropddow menu.
</p>
</div>

  <span class="boldtext"> Adjust the theme's background image and color</span>
  <div class="indent">
  <p>Chameleon comes with loads of background options. You can change the background color as well as choose from various overlay patterns to give your background a unique look. To adjust the background color of your theme, adjust the "Background Color" setting in ePanel located under the General Settings > General tab. When you click the field, a color wheel will pop up allowing you to choose any color.
</p>
<p>
Next you can choose a background texture via the "Background Texture" setting located in the General Settings > General Tab of ePanel. You can also upload your own background image via the "Background Image" option.</p>
</div>

  <span class="boldtext"> Using the Theme Customizer to easily experiment with font and color options</span>
  <div class="indent">
  <p>Chameleon comes with a nifty customization control panel that allows you to adjust the visual elements of your theme on the fly. This control panel makes it easier to choose great colorschemes, instead of having to adjust colors one-by-one in ePanel, and having to save/preview along the way. To enable the control panel, locate the "Show Control Panel" option in the General Settings > General Tab of ePanel. Once enabled, a settings box will appear on the left hand side of your screen when browser your website. Use the various settings to adjust your theme's colors until you have found a combination that pleases you. Then simply add the color values you have chosen into ePanel and turn off the control panel to finalize your setup.
</p>
</div>