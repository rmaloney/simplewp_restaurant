<?php

/*********************************************************
* The Contextual Help
* Package: TRUEedit
* Author: Zachary Segal
* Author URI: http://www.illproductions.com/
**********************************************************/

$contextual_help = "
<p>
<strong>".__('Filters:')."</strong><br />
<span>
	".__('You may disable or enable any of the registered content filters with this plugin.')."<br /> 
	".__('Simple confirm that the checkbox is checked next to the filter you wish to disable.')."<br />
	".__('The two most commonly removed filter are described below.')."
</span>
<ol>
	<li>".__('<em>wpautop</em> will automatically replace hard returns with paragraph and break tags,
	handy for the blogger who does not know about HTML, but very frustrating for the blogger
	who does. Check this checkbox to remove this filter.')."</li>
	
	<li>".__('<em>wptexturize</em> will replace specific characters and character patterns with special
	characters. While not as frustrating and more predictable, this filter can also get in the
	way of entering formatted and syntactically correct HTML. Check the checkbox to remove this filter.')."
	</li>
</ol>

<p>
<strong>".__('Post Editor Style:')."</strong><br />
<span>
	".__('You may override the default styling of the post editor with these controls.')."
	".__('I especially like reducing the font size and setting the font family to a fixed width
	font such as Monaco.')."
</span>
<ol>
	<li>".__('<em>Font Family</em> will let you set the font face or family for the post editor. 
	I prefer fixed width font families for editing code such as Monaco or Courier New.
	Leave this as default if you do not wish to change the font family')."</li>
	
	<li>".__('<em>Font Size</em> will let you set the font size for the post editor.
	With a fixed width fonts it is easier to read so you may turn the font size down a bit.
	Again just leave this as default to not affect your editors font size.')."</li>
	
	<li>".__('<em>Height</em> will let you override the height of the post editor.
	This can make editing your code easier as it give you more room to work with.')."</li>
	
	<li>".__('<em>Font Color</em> will let you set the font color for the post editor.
	You will most likely want to choose a color that is of high contract to the background color.')."</li>
	
	<li>".__('<em>Background Color</em> will let you set the background color of the post editor.
	Again you will most likely want to choose a color that is of high contrast to the font color.')."</li>
	
	<li>".__('<em>Enable Full Screen</em> will make a full screen button in the post editor appear when checked.
	Clicking the full screen button will enlarge the editor to take up your entire browser\'s window.
	Remember to click the "back to normal view" button to switch your view back.')."</li>
</ol>
";