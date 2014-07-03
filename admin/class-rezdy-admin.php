<?php
/**
 * Rezdy Admin
 *
 * @package   Rezdy_Admin
 * @author    Rezdy <info@rezdy.com>
 * @license   GPL-2.0+
 * @link      http://rezdy.com
 * @copyright 2014 Rezdy
 */

class Rezdy_Admin {

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $support_link = "https://support.rezdy.com/entries/47217670-How-to-use-Rezdy-Wordpress-plugin";

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

    /**
     * Slug of the plugin screen.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_screen_hook_suffix = null;

    /**
     * Slug of the plugin.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_slug = null;

    /**
     * Array of current instance options.
     *
     * @since    1.0.0
     *
     * @var      array
     */
    protected $options = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 */
		$plugin = Rezdy::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
        $this->options = get_option($this->plugin_slug);

        // Load admin style sheet and JavaScript.
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		// Add the options page and menu item.
        add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'settings_init' ) );
        //add_action( 'admin_notices', array( $this, 'settings_errors') );

        // Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

        //  setup the custom TinyMCE button
        //$show_shortcode = (isset($this->options['show-shortcode']) && $this->options['show-shortcode'] == '1');
        //if ($show_shortcode && $plugin->is_setup())
        add_action( 'admin_init', array( $this, 'register_editor' ) );

	}

    /**
     * Register editor
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    function register_editor() {
        add_filter( "mce_external_plugins", array( $this, 'add_editor_plugin' ) );
        add_filter( 'mce_buttons', array( $this, 'add_editor_button' ) );
    }

    /**
     * Register editor
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    function add_editor_plugin( $plugin_array ) {
        $plugin_array[$this->plugin_slug] = plugins_url( 'assets/js/editor.js', __FILE__ );
        return $plugin_array;
    }

    /**
     * Register editor
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    function add_editor_button( $buttons ) {
        array_push( $buttons, $this->plugin_slug ); // rezdy
        return $buttons;
    }

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

        if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
        if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Rezdy::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Rezdy::VERSION );
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
         */
        $menu_icon = plugins_url( 'assets/favicon.png', dirname(__FILE__) ) ;
        $this->plugin_screen_hook_suffix = add_menu_page(
			__( 'Settings', $this->plugin_slug ),
			__( 'Rezdy', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' ),
            $menu_icon
		);

//        $this->plugin_help_screen_hook_suffix = add_submenu_page(
//            $this->plugin_slug,
//            __( 'Help', $this->plugin_slug ),
//            __( 'Help', $this->plugin_slug ),
//            'manage_options',
//            $this->plugin_slug . '-help',
//            array(&$this, 'display_plugin_admin_help_page')
//        );

	}

    /**
     * Register and add settings
     *
     * @since    1.0.0
     */
    public function settings_init()
    {

        add_settings_section(
            'general',
            __("General Settings", $this->plugin_slug),
            array( $this, 'settings_general_info' ),
            $this->plugin_slug
        );

        add_settings_field(
            'alias',
            __('Alias', $this->plugin_slug),
            array( $this, 'settings_alias_callback' ),
            $this->plugin_slug,
            'general'
        );

        /*
        add_settings_field(
            'show-shortcode',
            __("Shortcode Button", $this->plugin_slug),
            array( $this, 'settings_show_shortcode_callback' ),
            $this->plugin_slug,
            'general'
        );
        */

        register_setting(
            $this->plugin_slug,
            $this->plugin_slug,
            array($this, 'settings_validate')
        );

    }

    /**
     * Prints section heading
     */
    public function settings_general_info()
    {
        print __('Please enter your rezdy.com alias or url ', $this->plugin_slug);
        print '<a href="' . Rezdy_Admin::$support_link . '" target="_blank">';
        print __('(need help finding it?)', $this->plugin_slug);
        print '</a>';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function settings_alias_callback()
    {

        echo "<span class='rezdy-helper'>https://</span>";

        printf(
            '<input type="text" id="' . $this->plugin_slug . '-alias" name="' . $this->plugin_slug . '[alias]" value="%s" />',
            isset($this->options['alias']) ? esc_attr( $this->options['alias'] ) : ''
        );

        echo "<span class='rezdy-helper'>.rezdy.com</span>";

        if  ( isset($this->options['alias']) && !empty($this->options['alias']) )
            echo '<span class="dashicons dashicons-yes" style="font-size: 30px; color: #008000"></div>';
    }

    /**
     * Get the settings option array and print one of its values
    function settings_show_shortcode_callback($args)
    {

        $checked = checked( 1, isset( $this->options['show-shortcode'] ) ? $this->options['show-shortcode'] : 0, false );

        if ($this->options == false)
            $checked = checked(1, 1, false);

        $html = '<input type="checkbox" id="show-shortcode" name="' . $this->plugin_slug . '[show-shortcode]" value="1" ' . $checked . '/>';

        $html .= '<label for="show-shortcode">&nbsp;'  . __("Show 'Add Rezdy Shortcode' Button on Editor", $this->plugin_slug) . '</label>';

        echo $html;

    }
    */

    /**
     * Validate Settings Input
     */
    function settings_validate( $input ) {

        $output = array();

        if (isset($input['alias']))
        {

            $alias = $input['alias'];

            //  process if URL entered
            if (strstr($alias, "https") || strstr($alias, ".rezdy.com"))
            {
                $alias = str_replace("https://", "", $alias);
                $alias = str_replace(".rezdy.com", "", $alias);
                $alias = rtrim($alias, "/");
            }

            if (function_exists('curl_version'))
            {

                $url = "https://" . $alias . ".rezdy.com/pluginJs";

                $handle = curl_init($url);
                curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
                $response = curl_exec($handle);
                $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                if($httpCode == 404)
                {
                    add_settings_error(
                        $this->plugin_slug,
                        'alias-error',
                        __('Alias does not exist: ', $this->plugin_slug) . $alias,
                        'error'
                    );
                }
                else
                {

                    $output['alias'] = sanitize_text_field( $alias );

                }

                curl_close($handle);

            }
            else
            {
                $output['alias'] = sanitize_text_field( $alias );
            }

        }

        //if (isset($input['show-shortcode']))
        //    $output['show-shortcode'] = $input[ 'show-shortcode'];

        // Return the array processing any additional functions filtered by this action
        return $output;

    }


    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    function settings_errors() {
        settings_errors( $this->plugin_slug );
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page() {
        include_once('views/admin.php');
    }

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

}
