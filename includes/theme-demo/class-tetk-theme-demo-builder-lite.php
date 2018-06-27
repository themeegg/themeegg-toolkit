<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TETK_Theme_Demo_Builder_Lite extends TETK_Theme_Demo
{

    public static function import_files()
    {
        $server_url = 'https://demo.themeegg.com/themes/builder-lite';
        $demo_urls = array(
            array(
                'import_file_name' => 'Builder Lite Default',
                'import_file_url' => $server_url . '/wp-content/demo-content/default/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/default/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/default/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/default/screenshot.png',
                'demo_url' => $server_url . '/default',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            ), array(
                'import_file_name' => 'Builder Lite Business',
                'import_file_url' => $server_url . '/wp-content/demo-content/business/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/business/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/business/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/business/screenshot.png',
                'demo_url' => $server_url . '/business',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            ), array(
                'import_file_name' => 'Builder Lite Consulting',
                'import_file_url' => $server_url . '/wp-content/demo-content/consulting/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/consulting/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/consulting/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/consulting/screenshot.png',
                'demo_url' => $server_url . '/consulting',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            ), array(
                'import_file_name' => 'Builder Lite Charity',
                'import_file_url' => $server_url . '/wp-content/demo-content/charity/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/charity/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/charity/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/charity/screenshot.png',
                'demo_url' => $server_url . '/charity',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            ), array(
                'import_file_name' => 'Builder Lite Product Demo',
                'import_file_url' => $server_url . '/wp-content/demo-content/product/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/product/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/product/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/product/screenshot.png',
                'demo_url' => $server_url . '/product',
                //'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
            ), array(
                'import_file_name' => 'Builder Lite Artist',
                'import_file_url' => $server_url . '/wp-content/demo-content/artist/content.xml',
                'import_widget_file_url' => $server_url . '/wp-content/demo-content/artist/widgets.wie',
                'import_customizer_file_url' => $server_url . '/wp-content/demo-content/artist/customizer.dat',
                'import_preview_image_url' => $server_url . '/wp-content/demo-content/artist/screenshot.png',
                'demo_url' => $server_url . '/artist',
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
        $front_page_id = get_page_by_title('Home Page Default');
        $blog_page_id = get_page_by_title('Blog Page');
        $blog_category_id = get_cat_ID('Trend');
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page_id->ID);
        update_option('page_for_posts', $blog_page_id->ID);
        update_option('themeegg_themes', $installed_demos);
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

            case 'Builder Lite Default':

                break;

            default:

        }
    }
}

?>