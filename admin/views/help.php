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

                <h3>Help</h3>

                <h4>Finding Rezdy Alias or URL</h4>

                <ol class="rezdy-help-list">

                    <li>

                        <h4>Login to your Rezdy account at <a href="https://app.rezdy.com/login" target="_blank">https://app.rezdy.com/login</a></h4>

                    </li>

                    <li>

                        <h4>Click the 'View Booking Form' link to the right of the dashboard</h4>

                        <p>
                            <a href="<?php echo plugins_url( '../assets/help/Rezdy-Alias-Step-1-View-Booking-Form.png', dirname(__FILE__) ) ?>"" target="_blank">
                                <img src="<?php echo plugins_url( '../assets/help/Rezdy-Alias-Step-1-View-Booking-Form.png', dirname(__FILE__) ) ?>" width="300">
                            </a>
                        </p>

                    </li>

                    <li>

                        <h4>Copy the URL at the top of your browser into the Rezdy plugin settings page</h4>

                        <p>
                            <a href="<?php echo plugins_url( '../assets/help/Rezdy-Alias-Step-2-Copy-Url.png', dirname(__FILE__) ) ?>"" target="_blank">
                                <img src="<?php echo plugins_url( '../assets/help/Rezdy-Alias-Step-2-Copy-Url.png', dirname(__FILE__) ) ?>" width="300">
                            </a>
                        </p>

                    </li>

                </ol>

                <h4>Finding Rezdy Catalog URL</h4>

                <ol class="rezdy-help-list">

                    <li>

                        <h4>Login to your Rezdy account at <a href="https://app.rezdy.com/login" target="_blank">https://app.rezdy.com/login</a></h4>

                    </li>

                    <li>

                        <h4>Navigate to the 'Inventory' > 'Catalogs' Menu Item</h4>

                        <p>
                            <a href="<?php echo plugins_url( '../assets/help/Rezdy-Catalog-Step-1-Catalogs.png', dirname(__FILE__) ) ?>"" target="_blank">
                                <img src="<?php echo plugins_url( '../assets/help/Rezdy-Catalog-Step-1-Catalogs.png', dirname(__FILE__) ) ?>" width="300">
                            </a>
                        </p>

                    </li>

                    <li>

                        <h4>Select the 'Online Bookings Catalogs' item on the 'Catalogs' screen</h4>

                    </li>

                    <li>

                        <h4>Click the name of the catalog you would like to display</h4>

                    </li>

                    <li>

                        <h4>Click the 'View Online' button on the selected catalog screen</h4>

                        <p>
                            <a href="<?php echo plugins_url( '../assets/help/Rezdy-Catalog-Step-2-View-Tours.png', dirname(__FILE__) ) ?>"" target="_blank">
                                <img src="<?php echo plugins_url( '../assets/help/Rezdy-Catalog-Step-2-View-Tours.png', dirname(__FILE__) ) ?>" width="300">
                            </a>
                        </p>

                    </li>

                    <li>

                        <h4>Copy the URL into the Rezdy shortcode dialog</h4>

                        <p>
                            <a href="<?php echo plugins_url( '../assets/help/Rezdy-Catalog-Step-3-Copy-Url.png', dirname(__FILE__) ) ?>"" target="_blank">
                                <img src="<?php echo plugins_url( '../assets/help/Rezdy-Catalog-Step-3-Copy-Url.png', dirname(__FILE__) ) ?>" width="300">
                            </a>
                        </p>

                    </li>

                </ol>

            </div>

        </div>

    </form>


</div>
