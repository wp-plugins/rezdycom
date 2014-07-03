<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Rezdy
 * @author    Rezdy <info@rezdy.com>
 * @license   GPL-2.0+
 * @link      http://rezdy.com
 * @copyright 2014 Rezdy
 */

$plugin = Rezdy_Admin::get_instance();

?>

<div class="wrap" id="rezdy-settings">

    <form method="post" action="options.php">

        <?php settings_errors(); ?>

        <div id="rezdy-options">

            <h2>
                <img src="<?php echo plugins_url( '../assets/rezdy-logo.png', dirname(__FILE__) ) ?>" alt="Rezdy" />
                <?php // echo esc_html( get_admin_page_title() ); ?>
            </h2>

            <div class="form-fields">
                <?php
                    settings_fields( $this->plugin_slug );
                    do_settings_sections($this->plugin_slug);
                ?>

                <div class="rezdy-help">

                </div>


            </div>

        </div>

        <?php
            submit_button();
        ?>

    </form>


</div>
