<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TETK_Theme_Demo_Builder_Plus extends TETK_Theme_Demo
{

    public static function import_files()
    {
        $server_url = 'https://demo.themeegg.com/themes/builder-plus';
        $demo_urls = array(
            array(
                'import_file_name' => 'Builder Plus Default',
                'import_file_url' => $server_url . '/wp-content/demo-content/default/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/default/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/default/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/default/screenshot.png',
                'demo_url' => $server_url . '/default',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            ), array(
                'import_file_name' => 'Builder Plus Education',
                'import_file_url' => $server_url . '/wp-content/demo-content/education/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/education/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/education/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/education/screenshot.png',
                'demo_url' => $server_url . '/study',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            ), array(
                'import_file_name' => 'Builder Plus Construction',
                'import_file_url' => $server_url . '/wp-content/demo-content/construction/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/construction/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/construction/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/construction/screenshot.png',
                'demo_url' => $server_url . '/construction',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            ), array(
                'import_file_name' => 'Builder Plus Restaurant',
                'import_file_url' => $server_url . '/wp-content/demo-content/restaurant/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/restaurant/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/restaurant/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/restaurant/screenshot.png',
                'demo_url' => $server_url . '/restaurant',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            )
        );

        return $demo_urls;
    }

    public static function after_import($selected_import)
    {


        $installed_demos = get_option('themeegg_themes', array());
        $import_file_name = isset($selected_import['import_file_name']) ? $selected_import['import_file_name'] : '';
        if (!empty($import_file_name)) {
            array_push($installed_demos, $import_file_name);
        }

        $installed_demos = array_unique($installed_demos);


        // SET Menus
        $new_theme_locations = get_registered_nav_menus();

        $nav_menus = array();

        foreach ($new_theme_locations as $location_key => $location) {

            $menu = get_term_by('name', $location, 'nav_menu');

            if (isset($menu->term_id)) {

                $nav_menus[$location_key] = $menu->term_id;
            }
        }
        if (count($nav_menus) > 0) {
            set_theme_mod('nav_menu_locations', $nav_menus);
        }

// Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title('Home Page');
        $blog_page_id = get_page_by_title('Blog Page');
        $blog_category_id = get_cat_ID('Blog');
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page_id->ID);
        update_option('page_for_posts', $blog_page_id->ID);
        update_option('themeegg_themes', $installed_demos);


        // Navigation
        $new_theme_locations = get_registered_nav_menus();

        foreach ($new_theme_locations as $location_key => $location) {

            $menu = get_term_by('name', $location, 'nav_menu');

            if (isset($menu->term_id)) {
                set_theme_mod('nav_menu_locations', array(
                        'primary' => $menu->term_id,
                    )
                );
            }
        }

        switch ($import_file_name) {

            case 'Builder Plus Default':


                break;

            default:

        }
    }
}

?>