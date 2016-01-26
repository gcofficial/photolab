<?php

class UpgradeToPro{

	/**
	 * Class constructor UpgradeToPro 
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this , 'addWelcomePage' ));
	}

	/**
	 * Add theme page
	 */
	public function addWelcomePage()
	{
		add_theme_page( 
			__('About Photolab', 'photolab'), 
			__('About Photolab', 'photolab'), 
			'edit_theme_options', 
			'about_photolab', 
			array($this, 'render') 
		);
	}

	/**
	 * Render theme page
	 */
	public function render(){
		echo Tools::renderView('about_photolab');
	}
}

$upgrade_to_pro = new UpgradeToPro;