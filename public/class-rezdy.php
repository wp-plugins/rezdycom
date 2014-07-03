<?php
/**
 * Plugin Name.
 *
 * @package   Rezdy
 * @author    Rezdy <info@rezdy.com>
 * @license   GPL-2.0+
 * @link      http://rezdy.com
 * @copyright 2014 Rezdy
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-rezdy-admin.php`
 *
 * @package Rezdy
 * @author  Rezdy <info@rezdy.com>
 */
class Rezdy {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'rezdy';

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Array of current instance options.
     *
     * @since    1.0.0
     *
     * @var      array
     */
    protected $options = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

        $this->options = get_option($this->plugin_slug);

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        // Register the shortcode [rezdy]
        add_shortcode( 'rezdy', array( &$this, 'render_shortcode' ) );

	}

    /**
     * Fired when the plugin is activated.
     *
     * @since    1.0.0
     *
     */
    public static function activate( ) {

        $options = get_option(Rezdy::plugin_slug);

        die(Rezdy::plugin_slug);

        print_r($options);


    }

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

    /**
     * Return the plugin slug.
     *
     * @since    1.0.0
     *
     * @return    bool slug variable.
     */
    public function is_setup() {
        return ($this->options !== false && !empty($this->options['alias']));
    }

    /**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        if (!$this->is_setup())
            return false;

        wp_enqueue_script( $this->plugin_slug . '-plugin-script', '//' . $this->options['alias'] . '.rezdy.com/pluginJs', array( 'jquery' ), self::VERSION );
	}

    /**
     * Renders the rezdy iframe
     *
     * @since    1.0.0
     */
    function render_shortcode( $atts )
    {

        if (!$this->is_setup())
            return false;

        $defaults = array(
            'alias' => $this->options['alias'],
            'catalog' => ''
        );
        extract( shortcode_atts( $defaults, $atts ) );

        //  URL

        $url = "https://" . $alias . ".rezdy.com/";

        if (!empty($catalog))
        {
            $parts = parse_url($catalog);
            $url .= ltrim( $parts['path'],'/');
        }

        $url .= '?iframe=true';

        //  DEBUG

//        echo "<pre>";
//        print_r($atts);
//        print_r($defaults);
//        echo "</pre>";
//
//        echo 'Alias: ' . $alias . '<br />';
//        echo 'Catalog: ' . $catalog . '<br />';
//        echo 'Url: ' . $url . '<br />';

        //  IFRAME

        return '<iframe seamless="" frameborder="0" width="100%" height="1000px" class="rezdy" src="' . $url . '"></iframe>';
    }
}

