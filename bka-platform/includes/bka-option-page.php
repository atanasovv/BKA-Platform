<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

if (is_admin()) {
    add_action('after_setup_theme', 'bka_loadcarbon_fields');
}


add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
    Container::make( 'theme_options', __( 'Theme Options' ) )
        ->add_fields( array(
            Field::make( 'checkbox', 'bks_enable_login', __('Enable login') ),
        ) );
}

function bka_loadcarbon_fields()
{
    \Carbon_Fields\Carbon_Fields::boot();
}