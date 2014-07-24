<?php
/**
 * This class is mainly for Page Template management as well as appending custom assets into the site
 * User: nkahoang
 * Date: 8/07/2014
 * Time: 8:38 PM
 */

class WMEPageTemplater {
	public static $page_templates = array(
		'../page_templates/custom-template.php'     => 'Custom template'
	);

	/**
	 * Enqueuing assets for the site
	 * @param $hook
	 */
	static function site_enqueue_assets($hook) {
		wp_enqueue_script( 'wme_custom', WME__PLUGIN_URL . 'js/main.js', array('jquery'), WME__ASSET_VERSION );
		wp_enqueue_style( 'wme_custom', WME__PLUGIN_URL . 'styles/main.css', array(), WME__ASSET_VERSION );
	}

    /**
     * A Unique Identifier
     */
    protected $plugin_slug;

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * The array of templates that this plugin tracks.
     */
    protected $templates;


    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {

        if( null == self::$instance ) {
            self::$instance = new WMEPageTemplater();
        }

        return self::$instance;

    }

    /**
     * Initializes the plugin by setting filters and administration functions.
     */
    private function __construct() {

        $this->templates = array();


        // Add a filter to the attributes metabox to inject template into the cache.
        add_filter(
            'page_attributes_dropdown_pages_args',
            array( $this, 'register_project_templates' )
        );


        // Add a filter to the save post to inject out template into the page cache
        add_filter(
            'wp_insert_post_data',
            array( $this, 'register_project_templates' )
        );


        // Add a filter to the template include to determine if the page has our
        // template assigned and return it's path
        add_filter(
            'template_include',
            array( $this, 'view_project_template')
        );


        // Add your templates to this array.
        $this->templates = self::$page_templates;

    }


    /**
     * Adds our template to the pages cache in order to trick WordPress
     * into thinking the template file exists where it doesn't really exist.
     *
     */

    public function register_project_templates( $atts ) {

        // Create the key used for the themes cache
        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

        // Retrieve the cache list.
        // If it doesn't exist, or it's empty prepare an array
        $templates = wp_get_theme()->get_page_templates();
        if ( empty( $templates ) ) {
            $templates = array();
        }

        // New cache, therefore remove the old one
        wp_cache_delete( $cache_key , 'themes');

        // Now add our template to the list of templates by merging our templates
        // with the existing templates array from the cache.
        $templates = array_merge( $templates, $this->templates );

        // Add the modified cache to allow WordPress to pick it up for listing
        // available templates
        wp_cache_add( $cache_key, $templates, 'themes', 1800 );

        return $atts;

    }

    /**
     * Checks if the template is assigned to the page
     */
    public function view_project_template( $template ) {

        global $post;

        if (!isset($this->templates[get_post_meta(
            $post->ID, '_wp_page_template', true
        )] ) ) {

            return $template;

        }

        $file = plugin_dir_path(__FILE__). get_post_meta(
                $post->ID, '_wp_page_template', true
            );

        // Just to be safe, we check if the file exist first
        if( file_exists( $file ) ) {
            return $file;
        }
        else { echo $file; }

        return $template;

    }

    public static function wp_load_callback() {
        $sidebar_args = array(
            'name'          => "Blog Sidebar",
            'id'            => 'blog_sidebar',
            'description'   => '',
            'class'         => '',
            'before_widget' => '<li id="%1$s" class="blog-sidebar-widget widget %2$s">',
            'after_widget'  => '</li>',
            'before_title'  => '<h2 class="widgettitle">',
            'after_title'   => '</h2>' );
        register_sidebar($sidebar_args);

        register_nav_menu( 'pre-footer', "Pre footer menu" );

        $sidebar_args = array(
            'name'          => "Pre footer middle",
            'id'            => 'prefooter_sidebar',
            'description'   => '',
            'class'         => '',
            'before_widget' => '<li id="%1$s" class="prefooter-sidebar-widget widget %2$s">',
            'after_widget'  => '</li>',
            'before_title'  => '<h2 class="widgettitle">',
            'after_title'   => '</h2>' );
        register_sidebar($sidebar_args);

        $sidebar_args = array(
            'name'          => "Pre footer right",
            'id'            => 'prefooter_right_sidebar',
            'description'   => '',
            'class'         => '',
            'before_widget' => '<li id="%1$s" class="prefooter-sidebar-widget widget %2$s">',
            'after_widget'  => '</li>',
            'before_title'  => '<h2 class="widgettitle">',
            'after_title'   => '</h2>' );
        register_sidebar($sidebar_args);
    }

    public static function pre_footer() {
        include WME__PLUGIN_DIR . "/page_templates/footer.php";
    }
} 