<?php
/**
 * Trusted Theme Customizer
 *
 * @package Trusted
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function trusted_customize_register( $wp_customize ) {

	$wp_customize->get_section('static_front_page')->priority = 2;
	$wp_customize->get_section('title_tagline')->priority = 4;
	$wp_customize->get_section('header_image')->priority = 5;
	$wp_customize->get_section('colors')->priority = 7;
	$wp_customize->get_section('background_image')->priority = 8;
	$wp_customize->get_setting('custom_logo')->transport = 'refresh';
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
	$wp_customize->get_control('header_textcolor')->label = esc_html__( 'Site Title Color', 'trusted' );

	$wp_customize->add_setting(
		'tel_no',
		array(
			'default'			=> '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'tel_no',
		array(
			'settings'		=> 'tel_no',
			'section'		=> 'title_tagline',
			'type'			=> 'text',
			'label'			=> esc_html__( 'Phone Number', 'trusted' ),
		)
	);

	$wp_customize->add_setting(
		'site_title_uppercase',
		array(
			'default'			=> 0,
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'site_title_uppercase',
			array(
				'settings'		=> 'site_title_uppercase',
				'section'		=> 'title_tagline',
				'label'			=> esc_html__( 'Site Title UPPERCASE', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting(
		'header_layout',
		array(
			'default' => 'behind',
			'sanitize_callback' => 'trusted_sanitize_radio_select'
		)
	);
	$wp_customize->add_control(
		new Trusted_Image_Radio_Control(
		$wp_customize,
		'header_layout',
		array(
			'type' => 'radio',
			'label' => esc_html__( 'Header Image Layout', 'trusted' ),
			'description' => esc_html__( 'Select behind or below the logo/menu area.', 'trusted' ),
			'section' => 'header_image',
			'settings' => 'header_layout',
			'choices' => array(
				'behind' => get_template_directory_uri() . '/images/container-outside-behind.png',
				'below' => get_template_directory_uri() . '/images/container-outside.png',
				)
			)
		)
	);

	$wp_customize->add_setting(
		'header_height_home',
		array(
			'default'			=> '580',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'header_height_home',
			array(
				'settings'		=> 'header_height_home',
				'section'		=> 'header_image',
				'label'			=> esc_html__( 'Minimum Height (Homepage)', 'trusted' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => 100,
                'max'   => 1200,
                'step'  => 10,
            ),
			)
	);

	$wp_customize->add_setting(
		'header_height_site',
		array(
			'default'			=> '300',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'header_height_site',
			array(
				'settings'		=> 'header_height_site',
				'section'		=> 'header_image',
				'label'			=> esc_html__( 'Minimum Height (Other Pages)', 'trusted' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => 100,
                'max'   => 1200,
                'step'  => 10,
            ),
			)
	);

	$wp_customize->add_setting(
		'header_image_x_pos',
		array(
			'default'			=> '65',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'header_image_x_pos',
			array(
				'settings'		=> 'header_image_x_pos',
				'section'		=> 'header_image',
				'label'			=> esc_html__( 'Horizontal Offset (%)', 'trusted' ),
				'description'   => esc_html__( 'Used to make the main focus of your image appear on smaller screens or where the image is wider than the visible screen. The default setting is 65%.', 'trusted' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => 0,
                'max'   => 100,
                'step'  => 1,
            ),
			)
	);

	$wp_customize->add_setting(
		'head_color_header',
		array(
			'default'			=> '',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Trusted_Customize_Heading(
			$wp_customize,
			'head_color_header',
			array(
				'settings'		=> 'head_color_header',
				'section'		=> 'header_image',
				'label'			=> esc_html__( 'Background Color', 'trusted' ),
				'description'	=> esc_html__( 'Only takes effect if not using an image or an image with some transparency.', 'trusted' ),
			)
		)
	);

	$wp_customize->add_setting(
		'head_bg_color',
		array(
			'default'			=> '#ced2d7',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control(
			$wp_customize,
			'head_bg_color',
			array( 
				'label'      => esc_html__( 'Color', 'trusted' ),
				'settings'   => 'head_bg_color',
				'section'    => 'header_image',
			)
		)
	);

	$wp_customize->add_setting(
		'head_transparent',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'head_transparent',
			array(
				'settings'		=> 'head_transparent',
				'section'		=> 'header_image',
				'label'			=> esc_html__( 'No Color (Transparent Background)', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	//Theme Options
	$wp_customize->add_section(
		'theme_options_sec',
		array(
			'title'			=> esc_html__( 'Theme Options', 'trusted' ),
			'priority'		=> 6,
		)
	);

	$wp_customize->add_setting(
		'animate_on',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'animate_on',
			array(
				'settings'		=> 'animate_on',
				'section'		=> 'theme_options_sec',
				'label'			=> esc_html__( 'Enable Reveal Animations', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting(
		'menu_center',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'menu_center',
			array(
				'settings'		=> 'menu_center',
				'section'		=> 'theme_options_sec',
				'label'			=> esc_html__( 'Primary Menu Centered', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting(
		'menu_uppercase',
		array(
			'default'			=> 0,
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'menu_uppercase',
			array(
				'settings'		=> 'menu_uppercase',
				'section'		=> 'theme_options_sec',
				'label'			=> esc_html__( 'Primary Menu UPPERCASE', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting(
		'menu_search',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'menu_search',
			array(
				'settings'		=> 'menu_search',
				'section'		=> 'theme_options_sec',
				'label'			=> esc_html__( 'Show Search Icon In Menu', 'trusted' ),
				'description'	=> esc_html__( 'Search icon will only display if you have set your own menu as Primary Menu in Appearance >> Menus', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting(
		'headings_underline',
		array(
			'default'			=> 0,
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'headings_underline',
			array(
				'settings'		=> 'headings_underline',
				'section'		=> 'theme_options_sec',
				'label'			=> esc_html__( 'Disable Headings Underline', 'trusted' ),
				'description'	=> esc_html__( 'H1, H2, H3, H4, H5, H6 headings in post/page content', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting( 'page_title_align', array(
		'default'           => 'left',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'page_title_align', array(
		'label'   => esc_html__( 'Page Title Alignment', 'trusted' ),
		'type'    => 'select',
		'section' => 'theme_options_sec',
		'choices' => array(
			'left' => esc_html__( 'Left', 'trusted' ),
			'center' => esc_html__( 'Center', 'trusted' ),
			'right' => esc_html__( 'Right', 'trusted' ),
		),
	) );

	$wp_customize->add_setting(
		'page_title_icon',
		array(
			'default'			=> 'fa fa-check',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Trusted_Icon_Choices(
		$wp_customize,
		'page_title_icon',
		array(
			'settings'		=> 'page_title_icon',
			'section'		=> 'theme_options_sec',
			'type'			=> 'select',
			'label'			=> esc_html__( 'Page Title Icon', 'trusted' ),
			'description'	=> 'pagetitleicon' //not for display, no translation as using only for unique element name
		)
		)
	);

	$wp_customize->add_setting(
		'blog_title_icon',
		array(
			'default'			=> 'fa fa-newspaper-o',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Trusted_Icon_Choices(
		$wp_customize,
		'blog_title_icon',
		array(
			'settings'		=> 'blog_title_icon',
			'section'		=> 'theme_options_sec',
			'type'			=> 'select',
			'label'			=> esc_html__( 'Blog Title Icon', 'trusted' ),
			'description'	=> 'blogtitleicon' //not for display, no translation as using only for unique element name
		)
		)
	);

	$wp_customize->add_setting(
		'shop_title_icon',
		array(
			'default'			=> 'fa fa-shopping-cart',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Trusted_Icon_Choices(
		$wp_customize,
		'shop_title_icon',
		array(
			'settings'		=> 'shop_title_icon',
			'section'		=> 'theme_options_sec',
			'type'			=> 'select',
			'label'			=> esc_html__( 'Shop Title Icon', 'trusted' ),
			'description'	=> 'shoptitleicon', //not for display, no translation as using only for unique element name
			'active_callback'	=> 'trusted_woo_callback'
		)
		)
	);
	$wp_customize->get_control( 'shop_title_icon' )->active_callback = 'trusted_woo_callback';

	$wp_customize->add_setting( 'sidebar_position', array(
		'default'           => 'right',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'sidebar_position', array(
		'label'   => esc_html__( 'Sidebar Position', 'trusted' ),
		'type'    => 'select',
		'section' => 'theme_options_sec',
		'choices' => array(
			'left' => esc_html__( 'Left', 'trusted' ),
			'right' => esc_html__( 'Right', 'trusted' ),
		),
	) );

	$wp_customize->add_setting(
		'sticky_footer',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'sticky_footer',
			array(
				'settings'		=> 'sticky_footer',
				'section'		=> 'theme_options_sec',
				'label'			=> esc_html__( 'Enable Sticky Footer', 'trusted' ),
				'description'	=> esc_html__( 'Position the footer at the bottom of the screen on pages with little content', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	//COLORS
	$wp_customize->add_setting( 'header_light', array(
		'default'           => 'dark',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'header_light', array(
		'label'   => esc_html__( 'Header Style', 'trusted' ),
		'type'    => 'select',
		'section' => 'colors',
		'choices' => array(
			'dark' => esc_html__( 'Dark', 'trusted' ),
			'light' => esc_html__( 'Light', 'trusted' ),
		),
	) );

	$wp_customize->add_setting(
		'hi_color',
		array(
			'default'			=> '#00bc96',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control(
			$wp_customize,
			'hi_color',
			array( 
				'label'      => esc_html__( 'Primary Color', 'trusted' ),
				'settings'   => 'hi_color',
				'section'    => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'sec_color',
		array(
			'default'			=> '#4f5e70',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control(
			$wp_customize,
			'sec_color',
			array( 
				'label'      => esc_html__( 'Secondary Color', 'trusted' ),
				'settings'   => 'sec_color',
				'section'    => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'body_text_color',
		array(
			'default'			=> '#323b44',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control(
			$wp_customize,
			'body_text_color',
			array( 
				'label'      => esc_html__( 'Text Color', 'trusted' ),
				'settings'   => 'body_text_color',
				'section'    => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'heading_color',
		array(
			'default'			=> '#323b45',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control(
			$wp_customize,
			'heading_color',
			array( 
				'label'      => esc_html__( 'Headings Color', 'trusted' ),
				'settings'   => 'heading_color',
				'section'    => 'colors',
			)
		)
	);

	//TYPOGRAPHY
	$wp_customize->add_section('typography', array(
	     'title'    => esc_html__( 'Typography' , 'trusted' ),
	     'priority'		=> 17,
	) );

	// Setting - Font - Header
	$wp_customize->add_setting( 'font_header', array(
		'default'           => 'Ubuntu:300,300italic,regular,italic,500,500italic,700,700italic',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_header', array(
		'label'   => esc_html__( 'Header', 'trusted' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => trusted_google_fonts_array(),
	) );

	// Setting - Font - Navigation
	$wp_customize->add_setting( 'font_nav', array(
		'default'           => 'Hind:300,regular,500,600,700',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_nav', array(
		'label'   => esc_html__( 'Navigation', 'trusted' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => trusted_google_fonts_array(),
	) );

	// Setting - Font - Page Title
	$wp_customize->add_setting( 'font_page_title', array(
		'default'           => 'Ubuntu:300,300italic,regular,italic,500,500italic,700,700italic',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_page_title', array(
		'label'   => esc_html__( 'Page Title', 'trusted' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => trusted_google_fonts_array(),
	) );

	// Setting - Font - Content
	$wp_customize->add_setting( 'font_content', array(
		'default'           => 'Open Sans:300,300italic,regular,italic,600,600italic,700,700italic,800,800italic',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_content', array(
		'label'   => esc_html__( 'Content', 'trusted' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => trusted_google_fonts_array(),
	) );

	// Setting - Font - Headings
	$wp_customize->add_setting( 'font_headings', array(
		'default'           => 'Montserrat:regular,700',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_headings', array(
		'label'   => esc_html__( 'Headings', 'trusted' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => trusted_google_fonts_array(),
	) );

	// Setting - Font - Footer
	$wp_customize->add_setting( 'font_footer', array(
		'default'           => 'Hind:300,regular,500,600,700',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_footer', array(
		'label'   => esc_html__( 'Footer', 'trusted' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => trusted_google_fonts_array(),
	) );

	/*============HOME SETTINGS PANEL============*/
	$wp_customize->add_panel(
		'home_settings_panel',
		array(
			'title' 			=> esc_html__( 'Static Homepage Options', 'trusted' ),
			'priority'          => 3,
		)
	);


	/*============RE-ORDER HOMEPAGE SECTIONS============*/
	$wp_customize->add_section(
		'reorder_sec',
		array(
			'title'			=> esc_html__( 'Activate and Sort Homepage Sections', 'trusted' ),
			'panel'         => 'home_settings_panel'
		)
	);

	$wp_customize->add_setting(
		'home_order[tabs]',
		array(
			'default'			=> '',
			'sanitize_callback' => 'trusted_sanitize_home_sections',
			'transport'         => 'refresh',
			'capability'        => 'manage_options',
		)
	);

	$home_order_choices = array();
	$home_order_tabs = trusted_home_order_sections();
	foreach( $home_order_tabs as $key => $val ){
		$home_order_choices[$key] = $val['label'];
	}
	$wp_customize->add_control(
		new Trusted_Sortable_Checkboxes(
			$wp_customize,
			'home_order',
			array(
				'section'     => 'reorder_sec',
				'settings'    => 'home_order[tabs]',
				'label'       => esc_html__( 'Homepage Sections', 'trusted' ),
				'description' => esc_html__( 'Check the box to display. Sortable: drag and drop into your preferred order.', 'trusted' ),
				'choices'     => $home_order_choices,
			)
		)
	);


	/*============FEATURED SECTION============*/
	//FEATURED ICONS, TITLES & TEXT
	$wp_customize->add_section(
		'featured_page_sec',
		array(
			'title'			=> esc_html__( 'Featured Services', 'trusted' ),
			'description'	=> esc_html__( 'By default this displays the 3 most recent posts. To override this, select a page for the first feature.', 'trusted' ),
			'panel'         => 'home_settings_panel'
		)
	);

	$wp_customize->add_setting(
		'enable_featured_link',
		array(
			'default'			=> 1,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'enable_featured_link',
			array(
				'settings'		=> 'enable_featured_link',
				'section'		=> 'featured_page_sec',
				'label'			=> esc_html__( 'Enable \'Read More\' Buttons', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	//FEATURES (MAX 3)
	for( $i = 1; $i < 4; $i++ ){

	$wp_customize->add_setting(
		'featured_header'.$i,
		array(
			'default'			=> '',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Trusted_Customize_Heading(
			$wp_customize,
			'featured_header'.$i,
			array(
				'settings'		=> 'featured_header'.$i,
				'section'		=> 'featured_page_sec',
				'label'			=> esc_html__( 'Feature ', 'trusted' ).$i
			)
		)
	);

	$wp_customize->add_setting(
		'featured_page_icon'.$i,
		array(
			'default'			=> trusted_featured_icon_defaults($i),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Trusted_Icon_Choices(
		$wp_customize,
		'featured_page_icon'.$i,
		array(
			'settings'		=> 'featured_page_icon'.$i,
			'section'		=> 'featured_page_sec',
			'type'			=> 'select',
			'label'			=> esc_html__( 'Icon', 'trusted' ),
			'description'	=> 'featuredpageicon'.$i //not for display, no translation as using only for unique element name
		)
		)
	);

	$wp_customize->add_setting(
		'featured_page_link'.$i,
		array(
			'default'			=> '',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'featured_page_link'.$i,
		array(
			'settings'		=> 'featured_page_link'.$i,
			'section'		=> 'featured_page_sec',
			'type'			=> 'dropdown-pages',
			'label'			=> esc_html__( 'Select Page', 'trusted' ),
			'description'	=> esc_html__( 'Displays title and excerpt of selected page. You can add an optional hand-crafted excerpt in the page editor (make sure []excerpt is checked in Screen Options).', 'trusted' )
		)
	);
	}


	//ABOUT SECTION
	$wp_customize->add_section(
		'about_sec',
		array(
			'title'			=> esc_html__( 'About Section', 'trusted' ),
			'description'	=> esc_html__( 'Displays title, excerpt and featured image of selected page.', 'trusted' ),
			'panel'         => 'home_settings_panel'
		)
	);

	$wp_customize->add_setting(
		'enable_about_link',
		array(
			'default'			=> 1,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'enable_about_link',
			array(
				'settings'		=> 'enable_about_link',
				'section'		=> 'about_sec',
				'label'			=> esc_html__( 'Enable \'Read More\' Button', 'trusted' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting(
		'about_page_link',
		array(
			'default'			=> '',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'about_page_link',
		array(
			'settings'		=> 'about_page_link',
			'section'		=> 'about_sec',
			'type'			=> 'dropdown-pages',
			'label'			=> esc_html__( 'Select Page', 'trusted' )
		)
	);

	$wp_customize->add_setting( 'about_layout', array(
		'default'           => '',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'trusted_sanitize_choices',
	) );
	$wp_customize->add_control( 'about_layout', array(
		'label'   => esc_html__( 'Featured Image Position', 'trusted' ),
		'type'    => 'select',
		'section' => 'about_sec',
		'choices' => array(
			'style2' => esc_html__( 'Image Left', 'trusted' ),
			'' => esc_html__( 'Image Right', 'trusted' ),
			'style3' => esc_html__( 'Stacked', 'trusted' ),
			'style4' => esc_html__( 'Stacked (Centered)', 'trusted' ),
		),
	) );


	/*============SHOP TABS SECTION============*/
	$wp_customize->add_section(
		'woo_home_section',
		array(
			'title'			=> esc_html__( 'Shop Tabs', 'trusted' ),
			'panel'         => 'home_settings_panel',
			'active_callback'	=> 'trusted_woo_callback'
		)
	);
	$wp_customize->get_section( 'woo_home_section' )->active_callback = 'trusted_woo_callback';

	$wp_customize->add_setting(
		'woo_home[tabs]',
		array(
			'default'           => trusted_woo_home_tabs_default(),
			'sanitize_callback' => 'trusted_sanitize_woo_tabs',
			'transport'         => 'refresh',
			'capability'        => 'manage_options',
		)
	);

	$woo_home_choices = array();
	$woo_home_tabs = trusted_woo_home_tabs();
	foreach( $woo_home_tabs as $key => $val ){
		$woo_home_choices[$key] = $val['label'];
	}
	$wp_customize->add_control(
		new Trusted_Sortable_Checkboxes(
			$wp_customize,
			'woo_home',
			array(
				'section'     => 'woo_home_section',
				'settings'    => 'woo_home[tabs]',
				'label'       => esc_html__( 'Home Page Shop Tabs', 'trusted' ),
				'description'	=> esc_html__( 'Check the box to display. Sortable: drag and drop into your preferred order.', 'trusted' ),
				'choices'     => $woo_home_choices,
			)
		)
	);

	$wp_customize->add_setting(
		'tab_featured_order',
		array(
			'default'			=> '',
			'sanitize_callback' => 'trusted_sanitize_choices'
		)
	);
	$wp_customize->add_control(
		'tab_featured_order',
		array(
			'settings'		=> 'tab_featured_order',
			'section'		=> 'woo_home_section',
			'label'			=> esc_html__( 'Featured: Order', 'trusted' ),
			'type'       	=> 'select',
			'choices' => array(
				'' => esc_html__( 'Default', 'trusted' ),
				'titleaz' => esc_html__( 'Title: A to Z', 'trusted' ),
				'titleza' => esc_html__( 'Title: Z to A', 'trusted' ),
				'datenew' => esc_html__( 'Date: New to Old', 'trusted' ),
				'dateold' => esc_html__( 'Date: Old to New', 'trusted' ),
				'pricehigh' => esc_html__( 'Price: High to Low', 'trusted' ),
				'pricelow' => esc_html__( 'Price: Low to High', 'trusted' ),
				'popular' => esc_html__( 'Top Selling', 'trusted' ),
				'rating' => esc_html__( 'Top Rated', 'trusted' ),
				'random' => esc_html__( 'Random', 'trusted' ),
            ),
		)
	);

	$wp_customize->add_setting(
		'tab_sale_order',
		array(
			'default'			=> '',
			'sanitize_callback' => 'trusted_sanitize_choices'
		)
	);
	$wp_customize->add_control(
		'tab_sale_order',
		array(
			'settings'		=> 'tab_sale_order',
			'section'		=> 'woo_home_section',
			'label'			=> esc_html__( 'Sale: Order', 'trusted' ),
			'type'       	=> 'select',
			'choices' => array(
				'' => esc_html__( 'Default', 'trusted' ),
				'titleaz' => esc_html__( 'Title: A to Z', 'trusted' ),
				'titleza' => esc_html__( 'Title: Z to A', 'trusted' ),
				'datenew' => esc_html__( 'Date: New to Old', 'trusted' ),
				'dateold' => esc_html__( 'Date: Old to New', 'trusted' ),
				'pricehigh' => esc_html__( 'Price: High to Low', 'trusted' ),
				'pricelow' => esc_html__( 'Price: Low to High', 'trusted' ),
				'popular' => esc_html__( 'Top Selling', 'trusted' ),
				'rating' => esc_html__( 'Top Rated', 'trusted' ),
				'random' => esc_html__( 'Random', 'trusted' ),
            ),
		)
	);

	$wp_customize->add_setting(
		'tab_custom_page',
		array(
			'default'			=> '0',
			'sanitize_callback' => 'trusted_sanitize_choices'
		)
	);
	$wp_customize->add_control(
		'tab_custom_page',
		array(
			'settings'		=> 'tab_custom_page',
			'section'		=> 'woo_home_section',
			'label'			=> esc_html__( 'Custom', 'trusted' ),
			'description'	=> esc_html__( 'Select a Private Page. Create your custom content in a new page and set the page "visibility" to "private" and it will be available to select here.', 'trusted' ),
			'type'       	=> 'select',
			'choices' => trusted_choices_reusable_content(),
		)
	);


	/*============RECENT POSTS SECTION============*/
	$wp_customize->add_section(
		'recent_posts_sec',
		array(
			'title'			=> esc_html__( 'Recent Posts Section', 'trusted' ),
			'description'	=> esc_html__( 'Displays your most recent posts.', 'trusted' ),
			'panel'         => 'home_settings_panel'
		)
	);

	$wp_customize->add_setting(
		'recent_posts_title',
		array(
			'default'			=> esc_html__( 'From Our Blog', 'trusted' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'trusted_sanitize_text'
		)
	);
	$wp_customize->add_control(
		'recent_posts_title',
		array(
			'settings'		=> 'recent_posts_title',
			'section'		=> 'recent_posts_sec',
			'type'			=> 'text',
			'label'			=> esc_html__( 'Title', 'trusted' ),
		)
	);


	/*============CTA SECTION============*/
	$wp_customize->add_section(
		'cta_sec',
		array(
			'title'			=> esc_html__( 'Call-to-action Panel', 'trusted' ),
			'description'	=> esc_html__( 'Displays phone number and optional button link to selected page.', 'trusted' ),
			'panel'         => 'home_settings_panel'
		)
	);

	$wp_customize->add_setting(
		'cta_button_link',
		array(
			'default'			=> '',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'cta_button_link',
		array(
			'settings'		=> 'cta_button_link',
			'section'		=> 'cta_sec',
			'type'			=> 'dropdown-pages',
			'label'			=> esc_html__( 'Select Page For Button Link', 'trusted' )
		)
	);

	$wp_customize->add_setting(
		'cta_img',
		array(
			'default'			=> '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	$wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'cta_img',
           array(
               'label'      => esc_html__( 'Background Image', 'trusted' ),
               'section'    => 'cta_sec',
               'settings'   => 'cta_img',
           )
       )
   );


	// Section - Go Pro
	$wp_customize->add_section( 'go_pro_sec' , array(
		'title'      => esc_html__( 'Go Pro', 'trusted' ),
		'priority'   => 1,
		'description' => esc_html__( 'Upgrade to Trusted Pro for even more cool features and customization options.', 'trusted' ),
	) );
	$wp_customize->add_control(
		new Trusted_Customize_Extra_Control(
			$wp_customize,
			'go_pro',
			array(
				'section'   => 'go_pro_sec',
				'type'      => 'pro-link',
				'label'		=> esc_html__( 'Go Pro', 'trusted' ),
				'url'		=> 'https://uxlthemes.com/theme/trusted-pro/',
				'priority'	=> 10
			)
		)
	);

}
add_action('customize_register', 'trusted_customize_register');


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function trusted_customize_preview_js() {
	wp_enqueue_script('trusted_customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), TRUSTED_VERSION, true );
}
add_action('customize_preview_init', 'trusted_customize_preview_js');


function trusted_customizer_script() {
	wp_enqueue_script('trusted-customizer-script', get_template_directory_uri() .'/functions/js/customizer-scripts.js', array("jquery","jquery-ui-draggable"),'', true  );
	wp_enqueue_script('trusted-sortable-checkbox', get_template_directory_uri() . '/functions/js/trusted-sortable-checkbox.js', array( 'jquery', 'jquery-ui-sortable', 'customize-controls' ) );
	wp_enqueue_style('font-awesome', get_template_directory_uri() .'/css/font-awesome.css');
	wp_enqueue_style('trusted-customizer-style', get_template_directory_uri() .'/functions/css/customizer-style.css', '', TRUSTED_VERSION);	
}
add_action('customize_controls_enqueue_scripts', 'trusted_customizer_script');


if( class_exists('WP_Customize_Control') ):	

class Trusted_Customize_Extra_Control extends WP_Customize_Control {
	public $settings = 'blogname';
	public $description = '';
	public $url = '';
	public $group = '';

	public function render_content() {
		switch ( $this->type ) {
			default:

			case 'extra':
				echo '<p style="margin-top:40px;">' . sprintf(
							'<a href="%1$s" target="_blank">%2$s</a>',
							esc_url( $this->url ),
							esc_html__( 'More options available', 'trusted' )
						) . '</p>';
				echo '<p class="description" style="margin-top:5px;">' . $this->description . '</p>';
				break;

			case 'docs':
				echo sprintf(
							'<a href="%1$s" class="button-primary" target="_blank">%2$s</a>',
							esc_url( $this->url ),
							esc_html__( 'Documentation', 'trusted' )
						);
				break;

			case 'pro-link':
				echo sprintf(
							'<a href="%1$s" class="button-primary" target="_blank">%2$s</a>',
							esc_url( $this->url ),
							esc_html__( 'Go Pro', 'trusted' )
						);
				break;
					
			case 'line' :
				echo '<hr />';
				break;
		}
	}
}


class Trusted_Icon_Choices extends WP_Customize_Control{
	public $type = 'icon';

	public function render_content(){
		$func_append = $this->description;
		?>
            <label>
                <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
                </span>

                <div class="selected-icon">
                	<i class="<?php echo esc_attr($this->value()); ?>"></i>
                	<span><i class="fa fa-angle-down"></i></span>
                </div>

                <ul id="icon-box<?php echo esc_html( $func_append ); ?>" class="icon-list">
				<form class="icon-search-input" action="#">
					<input id="input<?php echo esc_html( $func_append ); ?>" class="" type="text" placeholder="<?php esc_attr_e( 'Search...', 'trusted' ); ?>">
				</form>
                	<?php
                	$fontawesome_array = trusted_fontawesome_array();
                	foreach ($fontawesome_array as $fontawesome_array_single) {
							$icon_class = $this->value() == $fontawesome_array_single ? 'icon-active' : '';
								if ($fontawesome_array_single == 'not-a-real-icon') {
									$zero_icon = 'NONE';
									$b_class = ' class="visible"';
								} else {
									$zero_icon = $fontawesome_array_single;
									$b_class = '';
								}
							echo '<li class='.esc_html($icon_class).'><i class="fa fa-'.esc_html($fontawesome_array_single).'"></i><b'.$b_class.'>'.esc_html($zero_icon).'</b></li>';
						}
                	?>
                </ul>
                <input type="hidden" value="<?php $this->value(); ?>" <?php $this->link(); ?> />

<script>
(function ($) {
	$(function () {
		trustedListFilter($("#icon-box<?php echo esc_html( $func_append ); ?>"), $("#input<?php echo esc_html( $func_append ); ?>"));
	});
}(jQuery));
</script>

            </label>
		<?php
	}
}


class Trusted_Image_Radio_Control extends WP_Customize_Control {

	public function render_content() {

		if ( empty( $this->choices ) )
			return;

		$name = '_customize-radio-' . $this->id;

		?>
		<style>
			#trusted-img-container-<?php echo $this->id; ?> .trusted-radio-img-img {
			border: 2px solid #f6f6f6;
			cursor: pointer;
			width: 21%;
			margin: 0 1% 0 1%;
			float: left;
			}
			#trusted-img-container-<?php echo $this->id; ?> .trusted-radio-img-selected {
			border: 2px solid #0073aa;
			}
			input[type=checkbox]:before {
			content: '';
			margin: -3px 0 0 -4px;
			}
		</style>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<ul class="controls" id='trusted-img-container-<?php echo $this->id; ?>'>
		<?php
		foreach ( $this->choices as $value => $label ) :
			$class = ($this->value() == $value)?'trusted-radio-img-selected trusted-radio-img-img':'trusted-radio-img-img';
			?>
			<li style="display: inline;">
				<label>
					<input <?php $this->link(); ?>style='display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
				</label>
			</li>
			<?php
			endforeach;
		?>
		</ul>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.controls#trusted-img-container-<?php echo $this->id; ?> li img').click(function(){
					$('.controls#trusted-img-container-<?php echo $this->id; ?> li').each(function(){
						$(this).find('img').removeClass ('trusted-radio-img-selected') ;
				});
				$(this).addClass ('trusted-radio-img-selected') ;
				});
			});
		</script>
	<?php
	}
}


class Trusted_Customize_Heading extends WP_Customize_Control {
    public function render_content() {
    	?>

        <?php if ( !empty( $this->label ) ) : ?>
            <h3 class="trusted-accordion-section-title"><?php echo esc_html( $this->label ); ?></h3>
        <?php endif; ?>
        <?php if ( !empty( $this->description ) ) : ?>
            <p class="trusted-accordion-section-paragraph"><?php echo esc_html( $this->description ); ?></p>
        <?php endif; ?>
    <?php }
}


/**
 * Sortable multi check boxes custom control.
 * @since 0.1.0
 * @author David Chandra Purnama <david@genbu.me>
 * @copyright Copyright (c) 2015, Genbu Media
 * @license https://www.gnu.org/licenses/gpl-2.0.html
 */
class Trusted_Sortable_Checkboxes extends WP_Customize_Control {
	/**
	 * Control Type
	 */
	public $type = 'trusted-multicheck-sortable';
	/**
	 * Enqueue Scripts
	 */
	public function enqueue() {
		wp_enqueue_style( 'trusted-customize' );
		wp_enqueue_script( 'trusted-customize' );
	}
	/**
	 * Render Settings
	 */
	public function render_content() {
		/* if no choices, bail. */
		if ( empty( $this->choices ) ){
			return;
		} ?>

		<?php if ( !empty( $this->label ) ){ ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php } // add label if needed. ?>

		<?php if ( !empty( $this->description ) ){ ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php } // add desc if needed. ?>

		<?php
		/* Data */
		$values = explode( ',', $this->value() );
		$choices = $this->choices;
		/* If values exist, use it. */
		$options = array();
		if( $values ){
			/* get individual item */
			foreach( $values as $value ){
				/* separate item with option */
				$value = explode( ':', $value );
				/* build the array. remove options not listed on choices. */
				if ( array_key_exists( $value[0], $choices ) ){
					$options[$value[0]] = $value[1] ? '1' : '0'; 
				}
			}
		}
		/* if there's new options (not saved yet), add it in the end. */
		foreach( $choices as $key => $val ){
			/* if not exist, add it in the end. */
			if ( ! array_key_exists( $key, $options ) ){
				$options[$key] = '0'; // use zero to deactivate as default for new items.
			}
		}
		?>

		<ul class="trusted-multicheck-sortable-list">

			<?php foreach ( $options as $key => $value ){ ?>

				<li>
					<label>
						<input name="<?php echo esc_attr( $key ); ?>" class="trusted-multicheck-sortable-item" type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( $value ); ?> /> 
						<?php echo esc_html( $choices[$key] ); ?>
					</label>
					<i class="dashicons dashicons-menu trusted-multicheck-sortable-handle"></i>
				</li>

			<?php } // end choices. ?>

				<li class="trusted-hideme">
					<input type="hidden" class="trusted-multicheck-sortable" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
				</li>

		</ul>


	<?php
	}
}

endif;


//SANITIZATION FUNCTIONS

function trusted_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function trusted_sanitize_choices( $input, $setting ) {
    global $wp_customize;
 
    $control = $wp_customize->get_control( $setting->id );
 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function trusted_sanitize_radio_select( $input, $setting ) {
	// Ensuring that the input is a slug.
	$input = sanitize_key( $input );
	// Get the list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	// If the input is a valid key, return it, else, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function trusted_sanitize_woo_tabs( $input ){

	/* Var */
	$output = array();

	/* Get valid tabs */
	$valid_tabs = trusted_woo_home_tabs();

	/* Make array */
	$tabs = explode( ',', $input );

	/* Bail. */
	if( ! $tabs ){
		return null;
	}

	/* Loop and verify */
	foreach( $tabs as $tab ){

		/* Separate tab and status */
		$tab = explode( ':', $tab );

		if( isset( $tab[0] ) && isset( $tab[1] ) ){
			if( array_key_exists( $tab[0], $valid_tabs ) ){
				$status = $tab[1] ? '1' : '0';
				$output[] = trim( $tab[0] . ':' . $status );
			}
		}

	}

	return trim( esc_attr( implode( ',', $output ) ) );
}

function trusted_sanitize_home_sections( $input ){

	/* Var */
	$output = array();

	/* Get valid tabs */
	$valid_tabs = trusted_home_order_sections();

	/* Make array */
	$tabs = explode( ',', $input );

	/* Bail. */
	if( ! $tabs ){
		return null;
	}

	/* Loop and verify */
	foreach( $tabs as $tab ){

		/* Separate tab and status */
		$tab = explode( ':', $tab );

		if( isset( $tab[0] ) && isset( $tab[1] ) ){
			if( array_key_exists( $tab[0], $valid_tabs ) ){
				$status = $tab[1] ? '1' : '0';
				$output[] = trim( $tab[0] . ':' . $status );
			}
		}

	}

	return trim( esc_attr( implode( ',', $output ) ) );
}

// is WooCommerce active callback
function trusted_woo_callback( $control ) {
	if ( class_exists( 'WooCommerce' ) ) {
		return true;
	} else {
		return false;
	}
}

function trusted_get_private_pages() {
	$pages = array();

	$private_pages = get_pages( array( 'post_status' => 'private' ) );

	if ( ! empty( $private_pages ) ) {
		foreach ( $private_pages as $page ) {
			if ( $page->post_title == '' ) {
				$pages[ $page->ID ] = $page->post_name;
			} else {
				$pages[ $page->ID ] = $page->post_title;
			}
		}
	}

	return $pages;
}

function trusted_choices_reusable_content() {
	$choices = array(
		0 => esc_html__( '&mdash; Select &mdash;', 'trusted' ),
	);

	$pages = trusted_get_private_pages();
	if ( ! empty( $pages ) ) {
		foreach ( $pages as $page => $name ) {
			$pages[ $page ] = $name;
		}
	}

	$choices = $choices + $pages;

	return $choices;
}
