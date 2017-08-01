<?php
/**
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Piquant
 * @subpackage Functions
 * @version    0.1.0
 * @author     Spigot Design <http://spigotdesign.com/>
 * @copyright  Copyright (c) 2017
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Get the template directory and make sure it has a trailing slash. */
$piquant_dir = trailingslashit( get_template_directory() );

/* Load the Hybrid Core framework and launch it. */
require_once( $piquant_dir . 'hybrid-core/hybrid.php' );
new Hybrid();

add_action( 'after_setup_theme', 'piquant_theme_setup', 5 );

/**
 * The theme setup function.  This function sets up support for various WordPress and framework functionality.
 *
 * @since  1.0
 * @access public
 * @return void
 */
function piquant_theme_setup() {

	// Load stylesheets
	add_action( 'wp_enqueue_scripts', 'piquant_styles' );

	// Layout Support
	add_theme_support( 'theme-layouts', array( 'default' => '1c' ) );
	add_action( 'hybrid_register_layouts', 'piquant_register_layouts' );

	// Hybrid Core functions and extensions
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'get-the-image' );

	// WordPress theme support
	add_theme_support( 'automatic-feed-links' );

	// Remove WordPress stuff
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wp_generator');

	// Register custom menus.
	add_action( 'init', 'piquant_register_menus', 5 );

	// Register sidebars.
	add_action( 'widgets_init', 'piquant_register_sidebars', 5 );

	// Add custom styles and scripts.
	add_action( 'wp_enqueue_scripts', 'piquant_enqueue_scripts' );

	
	// Register custom image sizes. 
	// add_action( 'init', 'piquant_register_image_sizes', 5 );

	// Modifies the theme layout.
	// add_filter( 'theme_mod_theme_layout', 'piquant_mod_theme_layout', 15 );

	// Gravity Forms enable Label visiblity
	add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

	// Beaver Support
	// add_theme_support( 'fl-theme-builder-footers' );
	// add_action( 'wp', 'piquant_theme_footer_render' );


}

/**
 * Registers stylesheets for the frontend
 *
 */

function piquant_styles() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
}


/**
 * Registers custom theme layouts
 *
 */

function piquant_register_layouts() {

    hybrid_register_layout(
        '1c',
        array(
            'label'            => _x( '1 Column', 'theme layout', 'piquant' ),
            'is_global_layout' => true,
            'is_post_layout'   => true,
            'image'            => '%s/img/layouts/1c.svg', 
        )
    );

    hybrid_register_layout(
        '2c-l',
        array(
            'label'            => _x( '2 Columns: Sidebar / Content', 'theme layout', 'piquant' ),
            'is_global_layout' => true,
            'is_post_layout'   => true,
            'image'            => '%s/img/layouts/2c-l.svg', 
        )
    );

    
}

/**
 * Registers nav menu locations.
 *
 */

function piquant_register_menus() {
	register_nav_menu( 'primary',   _x( 'Primary',   'nav menu location', 'piquant' ) );
	register_nav_menu( 'secondary', _x( 'Secondary', 'nav menu location', 'piquant' ) );
	register_nav_menu( 'social',    _x( 'Social',    'nav menu location', 'piquant' ) );
}

/**
 * Registers sidebars.
 *
 */

function piquant_register_sidebars() {

	hybrid_register_sidebar(
		array(
			'id'          => 'primary',
			'name'        => _x( 'Primary', 'sidebar', 'piquant' ),
			'description' => __( 'The main sidebar. It is displayed on either the left or right side of the page based on the chosen layout.', 'piquant' )
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'subsidiary',
			'name'        => _x( 'Subsidiary', 'sidebar', 'piquant' ),
			'description' => __( 'A sidebar located in the footer of the site. Optimized for one, two, or three widgets (and multiples thereof).', 'piquant' )
		)
	);
}

/**
 * Enqueues scripts.
 *
 */

function piquant_enqueue_scripts() {

	// Header

	// Footer
	wp_enqueue_script( 'plugins', trailingslashit( get_template_directory_uri() ) . 'js/build/plugins.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'scripts', trailingslashit( get_template_directory_uri() ) . 'js/build/scripts.min.js', array( 'jquery' ), null, true );

	// Stylesheets
	wp_register_style( 'piquant-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600' );


}

/**
 * Registers custom image sizes for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function piquant_register_image_sizes() {

	/* Sets the 'post-thumbnail' size. */
	// set_post_thumbnail_size( 175, 131, true );

	/* Adds the 'piquant-full' image size. */
	// add_image_size( 'piquant-full', 1025, 500, false );
}


/**
 * Modifies the theme layout
 *
 * @since  1.0
 * @access public
 * @param  string  $layout
 * @return string
 */
function piquant_mod_theme_layout( $layout ) {

	if ( is_home() || is_singular('post') || is_404() ) {

        $layout = '2c-l';

    } elseif ( is_archive() && !is_archive('portfolio') ) {
        
        $layout = '2c-l';

    }

	return $layout;
}



function piquant_theme_footer_render() {

	
	// Get the footer ID.
	$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();
	
	// If we have a footer, remove the theme footer and hook in Theme Builder's.
	if ( ! empty( $footer_ids ) ) {
		remove_action( 'wp_footer', 'infusion_footer' );
		add_action( 'wp_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
	}
}
