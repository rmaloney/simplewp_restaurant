<?php
/*********************************************************
* Admin Setting's Panel Template Code
* Package: TRUEedit
* Author: Zachary Segal
* Author URI: http://www.illproductions.com/
**********************************************************/
?>
<div class="wrap">
	
	<?php screen_icon(); ?>
	<h2><?php _e('TRUEedit Settings', 'trueedit'); ?></h2>
	
	<?php if ($message): ?>
		<div id="message" class="updated"><?php echo $message; ?></div>
	<?php endif ?>

	<?php if ($error): ?>
		<div id="message" class="error"><?php echo $error; ?></div>
	<?php endif ?>
	
	<form method="post" action="" style="max-width:800px;">
		
		<fieldset style="float:left; width:48%;">
			<p><strong><?php _e('The Content Filters:', 'trueedit'); ?></strong></p>
			
		<?php foreach ($content_filters as $name): ?>
			<p>
				<label for="<?php echo $name ?>">
					<?php $checked = (isset($options['filters']) && is_array($options['filters']) && in_array($name, $options['filters']))? 'checked="checked"' : ''; ?>
					<?php $attr    = 'title="'.__('Learn more about this WordPress filter').'" target="_trueedit"'; ?>
					<?php $label   = $name; ?>
					<?php if (in_array($name, $built_in_filter_functions)): ?>
						<?php $label   = "<a href='http://codex.wordpress.org/Function_Reference/$name' $attr>$name</a>"; ?>
					<?php endif ?>
					
					<input type="checkbox" id="<?php echo $name ?>" name="disable-filters[]" value="<?php echo $name ?>" <?php echo $checked; ?> />
					<span><?php printf(__('Disable the %s filter.', 'trueedit'), $label); ?></span>
				</label>				
			</p>
		<?php endforeach ?>
		</fieldset>
		
		<fieldset style="float:left;">
		
			<p><strong><?php _e('Post Editor Styles:', 'trueedit'); ?></strong></p>
			
			<p>
				<label for="font-family"><?php _e('Font Family', 'trueedit'); ?></label>
				<select id="font-family" name="font-family">
					<option value=""><?php _e('- default', 'trueedit'); ?></option>
					
					<?php $fonts = array('Monaco', 'Courier New', 'Arial', 'Helvetica', 'Times', 'Trebuchet MS') ?>
					<?php foreach ($fonts as $font): ?>
						<?php $selected = ($options['font-family'] == $font)? 'selected="selected"' : '' ?>
						<option value="<?php echo $font ?>" <?php echo $selected ?> ><?php echo $font ?></option>
					<?php endforeach ?>
					
				</select>
			</p>
			
			<p>
				<label for="font-size"><?php _e('Font Size', 'trueedit'); ?></label>
				<select id="font-size" name="font-size">
					<option value=""><?php _e('- default', 'trueedit'); ?></option>
					<?php $sizes = array('7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '15pt', '18pt', '22pt', '26pt', '34pt') ?>
					<?php foreach ($sizes as $size): ?>
						<?php $selected = ($options['font-size'] == $size)? 'selected="selected"' : '' ?>
						<option value="<?php echo $size ?>" <?php echo $selected ?> ><?php echo $size ?></option>
					<?php endforeach ?>
				</select>
			</p>
			
			<p>
				<label for="editor-height"><?php _e('Height', 'trueedit'); ?></label>
				<select id="editor-height" name="editor-height">
					<option value=""><?php _e('- default', 'trueedit'); ?></option>
					<?php $heights = array('5em', '10em', '15em', '20em', '25em', '30em', '40em', '45em', '50em', '60em', '70em') ?>
					<?php foreach ($heights as $height): ?>
						<?php $selected = ($options['editor-height'] == $height)? 'selected="selected"' : '' ?>
						<option value="<?php echo $height ?>" <?php echo $selected ?> ><?php echo $height ?></option>
					<?php endforeach ?>
				</select>
			</p>
			
			<p>
				<label for="font-color"><?php _e('Font Color', 'trueedit'); ?></label>
				<input type="text" id="font-color" name="font-color" value="<?php echo $options['font-color'] ?>" maxlength="7" />
			</p>
			
			<p>
				<label for="background-color"><?php _e('Background Color', 'trueedit'); ?></label>
				<input type="text" id="background-color" name="background-color" value="<?php echo $options['background-color'] ?>" maxlength="7" />
			</p>
				
			<p>
				<label for="show-fullscreen">
					<?php $checked = ($options['editor-fullscreen'])? 'checked="checked"' : ''; ?>
					<span><?php _e('Enable Full Screen', 'trueedit'); ?></span>
					<input type="checkbox" id="show-fullscreen" name="show-fullscreen" value="1" <?php echo $checked; ?> />
				</label>
			</p>

		</fieldset>
		
		<p style="clear:both;">&nbsp;</p>
		
		<p>
			<?php wp_nonce_field( 'trueedit_save', '_trueedit_save_nonce', false, true ) ?>
			<input type="submit" class="button-primary" name="save" value="<?php _e('Save Settings', 'trueedit'); ?>" />
		</p>
		
	</form>
</div><!-- END div#wrap-->