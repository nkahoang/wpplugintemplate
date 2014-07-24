<?php

// This class is mainly for Admin option page as well as for getting saved options from Database

class WMEAdmin {
    const OPTION_SAMPLE_TEXT = "WME_SAMPLE_TEXT";
	const OPTION_SAMPLE_PHONE = "WME_SAMPLE_PHONE";
	const OPTION_SAMPLE_PAGE = "WME_SAMPLE_PAGE";
	const OPTION_SAMPLE_POST = "WME_SAMPLE_POST";
	const OPTION_SAMPLE_COLOR = "WME_SAMPLE_COLOR";
	const OPTION_SAMPLE_DATETIME = "WME_SAMPLE_DATETIME";

    const ENUM_LINK_TYPE_NONE = "none";
    const ENUM_LINK_TYPE_PAGE = "page";
    const ENUM_LINK_TYPE_POST = "post";
    const ENUM_LINK_TYPE_URL = "url";

    /**
     * Called when the plugin is activate
     */
    static function activate() {
        // Plugin activate
    }

    /**
     * Called when teh plugin is deactivated
     */
    static function deactivate() {
        // Plugin deactivate
    }

    /**
     * Called to add WME Page into the admin menu
     */
    static function admin_menu() {
        add_options_page("WME Custom", "WME", "manage_options", "WME-custom", array("WMEAdmin", "option_page"));
    }

	protected static function _get_all_published_posts() {
		$posts = array();
		$args = array(
			'orderby'          => 'post_title',
			'order'            => 'ASC',
			'post_status'      => 'publish',
			'post_type'        => 'post',
			'suppress_filters' => true );

		$published_posts = get_posts( $args );
		foreach ($published_posts as $post) {
			/* @var $post WP_Post */

			$posts[] = array(
				"id" => $post->ID,
				"title" => $post->post_title,
				"name" => $post->post_name
			);
		}
		return $posts;
	}

	protected static function _get_all_published_pages() {
		// getting all pages

		$pages_args = array(
			'sort_order' => 'ASC',
			'sort_column' => 'post_title',
			'post_type' => 'page',
			'post_status' => 'publish'
		);

		$published_pages = get_pages($pages_args);
		$pages = array();

		foreach ($published_pages as $page) {
			$pages[] = array(
				"id" => $page->ID,
				"title" => $page->post_title,
				"name" => $page->post_name
			);
		}

		return $pages;
	}
    /**
     * Rendering the option page
     */
    static function option_page() {
        $model = array();
	    $model["Posts"] = self::_get_all_published_posts();
	    $model["Pages"] = self::_get_all_published_pages();

	    $options = array();
	    $options["SampleText"] = get_option(self::OPTION_SAMPLE_TEXT, "Sample Text");
	    $options["SamplePhone"] = get_option(self::OPTION_SAMPLE_PHONE, "(03) 9999-9999");
	    $options["SamplePage"] = get_option(self::OPTION_SAMPLE_PAGE, 0);
	    $options["SamplePost"] = get_option(self::OPTION_SAMPLE_POST, 0);
	    $options["SampleColor"] = get_option(self::OPTION_SAMPLE_COLOR, "#000");
	    $options["SampleDateTime"] = get_option(self::OPTION_SAMPLE_DATETIME, "2014-01-01 00:00:00");

	    $model["Options"] = $options;
        include WME__PLUGIN_DIR . "/pages/admin-options.php";
    }

	static function get_option($option_name) {
		if (!isset(self::$_cached[$option_name])) {
			self::$_cached[$option_name] = get_option($option_name);
		}
		return self::$_cached[$option_name];
	}

    /**
     * Option page ajax save
     */
    static function option_save_ajax_callback() {
	    $result = array(
		    'success' => true
	    );

	    try {
		    $options = $_POST["options"];

		    update_option( self::OPTION_SAMPLE_TEXT, $options["SampleText"] );
		    update_option( self::OPTION_SAMPLE_PHONE, $options["SamplePhone"] );
		    update_option( self::OPTION_SAMPLE_PAGE, intval($options["SamplePage"]) );
		    update_option( self::OPTION_SAMPLE_POST, intval($options["SamplePost"]) );
		    update_option( self::OPTION_SAMPLE_COLOR, $options["SampleColor"] );
		    update_option( self::OPTION_SAMPLE_DATETIME, $options["SampleDateTime"] );
	    }
		catch(\Exception $e) {
			$result["success"] = false;
			$result["message"] = $e->getMessage();
		}

        header('Content-type: application/json', true);
        echo json_encode($result);
        die(); // this is required to return a proper result
    }

    /**
     * Enqueuing javascripts and hooks for admin option page
     * @param $hook
     */
    static function admin_enqueue_assets($hook) {
        if( 'settings_page_WME-custom' != $hook ) return;

	    // SCRIPTS
	    // Kendo UIS
        wp_enqueue_script( 'kendo_ui', WME__PLUGIN_URL . 'js/kendo.ui.core.min.js', array('jquery'), "2014.1.416" );
	    // Admin javascript
        wp_enqueue_script( 'WME_main', WME__PLUGIN_URL . 'js/admin_option.js', array('kendo_ui'), WME__ASSET_VERSION );
	    // Helper object for ajax call
        wp_localize_script( 'WME_main', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );

	    // STYLESHEETS
	    // Bootstrap
        wp_enqueue_style( 'bootstrap' , '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', array(), "3.2.0");
	    // Font awesome
        wp_enqueue_style( 'font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array('bootstrap'), "4.1.0");
	    // Kendo UIS
        wp_enqueue_style( 'kendo_ui_core', WME__PLUGIN_URL . 'styles/kendo.common.core.min.css', array(), "2014.1.416" );
        wp_enqueue_style( 'kendo_ui_flat', WME__PLUGIN_URL . 'styles/kendo.flat.min.css', array(), "2014.1.416" );

	    // Admin Option
        wp_enqueue_style( 'WME_main', WME__PLUGIN_URL . 'styles/admin_option.css', array(), WME__ASSET_VERSION );
    }

    static $_cached = array();
}