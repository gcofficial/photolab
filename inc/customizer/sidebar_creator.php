<?php
if( class_exists( 'WP_Customize_Control' ) ):
class SidebarCreator extends WP_Customize_Control {

    /**
     * Add scripts and styles
     */
    public function enqueue()
    {
        wp_enqueue_script( 
            'sidebar-creator', 
            get_template_directory_uri().'/js/sidebar-creator.js', 
            array('jquery', 'underscore') 
        );
        wp_enqueue_style( 
            'sidebar-creator', 
            get_template_directory_uri().'/css/sidebar-creator.css' 
        );
    }

    /**
     * Render content
     */
    public function render_content() 
    {
        echo Tools::renderView(
            'customizer_sidebar_creator_input',
            array(
                'id'    => 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id ),
                'class' => 'customize-control customize-control-' . $this->type,
                'label' => esc_html( $this->label ),
                'value' => $this->value(),
                'link'  => $this->get_link()
            )
        );
    }
}
endif;