/**
 * Customizer Communicator
 */
( function ( exports, $ ) {
	"use strict";

	var api = wp.customize, OldPreviewer;

	/**
	 * Toggle columns in Blog Settings section
	 * @param {string} name --- control name
	 * @param  {boolean} show --- true = show | false = hide
	 * @return
	 */
	function ctrlToggle(name, show)
	{
		if(show)
		{
			api.control( name ).activate();
		}
		else
		{
			api.control( name ).deactivate();
		}
	}

	api(
		'bs[layout_style]',
		function(value){
			value.bind(
				function(to){
					ctrlToggle('columns', to == 'grid' || to == 'masonry');
				}
			)
		}
	);

	api(
		'fs[footer_style]',
		function(value){
			value.bind(
				function(to){
					ctrlToggle('footer_logo', to == 'centered');
				}
			)
		}
	);

	api(
		'fs[footer_style]',
		function(value){
			value.bind(
				function(to){
					ctrlToggle('footer_columns', to == 'default' || to == 'centered');
				}
			)
		}
	);

	// Custom Customizer Previewer class (attached to the Customize API)
	api.myCustomizerPreviewer = {
		// Init
		init: function () {
			var self = this; // Store a reference to "this" in case callback functions need to reference it

			// Listen to the "my-custom-event" event has been triggered from the Previewer
			this.preview.bind( 
				'my-custom-event', 
				function( data ) {
					ctrlToggle('columns', api.instance( 'bs[layout_style]' ).get() == 'grid' || api.instance( 'bs[layout_style]' ).get() == 'masonry');
					ctrlToggle('footer_logo', api.instance( 'fs[footer_style]' ).get() == 'centered');
					ctrlToggle('footer_columns', api.instance( 'fs[footer_style]' ).get() == 'default' || api.instance( 'fs[footer_style]' ).get() == 'centered' );
			} );
		}
	};

	/**
	 * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0)
	 *
	 * @see https://github.com/WordPress/WordPress/blob/5cab03ab29e6172a8473eb601203c9d3d8802f17/wp-admin/js/customize-controls.js#L1013
	 */
	OldPreviewer = api.Previewer;
	api.Previewer = OldPreviewer.extend( {
		initialize: function( params, options ) {
			// Store a reference to the Previewer
			api.myCustomizerPreviewer.preview = this;

			// Call the old Previewer's initialize function
			OldPreviewer.prototype.initialize.call( this, params, options );
		}
	} );

	// Document Ready
	$( function() {
		// Initialize our Previewer
		api.myCustomizerPreviewer.init();
	} );

	wp.customize.Previewer.bind('active', function(){ console.log('yeah i"m active'); })
} )( wp, jQuery ); 