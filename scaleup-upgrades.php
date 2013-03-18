<?php
/**
 * Plugin Name: ScaleUp Upgrades
 * Description: Allows apps & addons to have upgrade scripts that can be deployed with the source code.
 */

define( 'SCALEUP_UPGRADES_DIR', dirname( __FILE__ ) );

function scaleup_upgrades_scaleup_init() {
  /**
   * Upgrade features container
   */
  include( SCALEUP_UPGRADES_DIR . '/classes/upgrades-class.php' );
  /**
   * Upgrade feature available to ScaleUp
   */
  include( SCALEUP_UPGRADES_DIR . '/classes/upgrade-class.php' );
}
add_action( 'scaleup_init', 'scaleup_upgrades_scaleup_init' );

function scaleup_upgrades_scaleup_app_init() {
  /**
   * Upgrades Addon available to ScaleUp App
   */
  include( SCALEUP_UPGRADES_DIR . '/classes/addon-class.php' );
}
add_action( 'scaleup_app_init', 'scaleup_upgrades_scaleup_app_init' );