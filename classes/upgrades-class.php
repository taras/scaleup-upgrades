<?php
class ScaleUp_Upgrades_Addon extends ScaleUp_Addon {

  function get_defaults() {
    return wp_parse_args(
      array(
        'name'      => 'upgrades',
        'url'       => '/upgrades',
        'views'     => array( 'upgrades' ),
        'templates' => array(
          'upgrades' => array(
            'path'     => SCALEUP_UPGRADES_DIR . '/templates',
            'template' => '/upgrades/upgrades.php',
          )
        ),
      ), parent::get_defaults() );
  }


  function get_upgrades( $view, $args ) {

    get_template_part( '/upgrades/upgrades.php' );
    return $args;
  }

  function post_upgrades( $view, $args ) {

    get_template_part( '/upgrades/upgrades.php' );
    return $args;
  }

}

ScaleUp::register( 'addon', array( 'name' => 'upgrades', '__CLASS__' => 'ScaleUp_Upgrades_Addon' ) );

