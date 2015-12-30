/**
 * Toggle columns in Blog Settings section
 * @param {object} $ctrl --- jQuery object control
 * @param  {boolean} show --- true = show | false = hide
 * @return
 */
function ctrlToggle($ctrl, show)
{
	if(show)
	{
		$ctrl.show();
	}
	else
	{
		$ctrl.hide();
	}
}

/**
 * Change top menu location
 */
jQuery(document).on(
	'change',
	'#customize-control-nav_menu_locations-top select',
	function(){
		var val = jQuery(this).val();

		ctrlToggle(
			jQuery('#customize-control-disclimer_text'),
			val != 0
		);
		ctrlToggle(
			jQuery('#customize-control-search_box'),
			val != 0
		);
	}
);

/**
 * Change layout style
 */
jQuery(document).on(
	'change',
	'#customize-control-layout_style select',
	function(){
		var val = jQuery(this).val();

		ctrlToggle(
			jQuery('#customize-control-columns'),
			val == 'grid' || val == 'masonry'
		);
	}
);

/**
 * Change footer style
 */
jQuery(document).on(
	'change',
	'#customize-control-footer_style select',
	function(){
		var val = jQuery(this).val();

		ctrlToggle(jQuery('#customize-control-footer_logo'), val == 'centered');
		ctrlToggle(jQuery('#customize-control-footer_columns'), val == 'default' || val == 'centered');
	}
);

/**
 * Document ready
 */
jQuery(document).ready(
	function(){
		var footer_style = jQuery('#customize-control-footer_style select').val();
		var layout_style = jQuery('#customize-control-layout_style select').val();
		var top_menu     = jQuery('#customize-control-nav_menu_locations-top select').val();

		ctrlToggle(
			jQuery('#customize-control-footer_logo'), 
			footer_style == 'centered'
		);
		ctrlToggle(
			jQuery('#customize-control-footer_columns'), 
			footer_style == 'default' || footer_style == 'centered'
		);	
		ctrlToggle(
			jQuery('#customize-control-columns'),
			layout_style == 'grid' || layout_style == 'masonry'
		);
		ctrlToggle(
			jQuery('#customize-control-disclimer_text'),
			top_menu != 0
		);
		ctrlToggle(
			jQuery('#customize-control-search_box'),
			top_menu != 0
		);
	}
);