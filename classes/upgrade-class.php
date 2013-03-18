<?php
class ScaleUp_Upgrade extends ScaleUp_Feature {

  function init() {
    $this->add_filter( 'execute', array( $this, 'execute' ) );
  }

  function execute( $args ) {

    if ( $this->has( 'execute' ) && is_callable( $this->get( 'execute' ) ) ) {
      $callable = $this->get( 'execute' );
      $return = call_user_func( $callable, $args );
    } else {
      $return = false;
    }

    if ( is_object( $return ) ) {
      header('Content-Type: application/json');
      echo json_encode( $return );
    }

    return $return;
  }

  function get_defaults() {
    return wp_parse_args(
      array(
        '_feature_type' => 'upgrade',
      ), parent::get_defaults()
    );
  }

}

ScaleUp::register_feature_type( 'upgrade', array(
  '__CLASS__'     => 'ScaleUp_Upgrade',
  '_plural'       => 'upgrades',
  '_container'    => 'ScaleUp_Upgrades',
  '_duck_types'   => array( 'contextual' ),
));

ScaleUp::extend_feature_type( array(
  'app' => array(
    '_supports' => array( 'upgrades' ),
  ),
  'addon' => array(
    '_supports' => array( 'upgrades' ),
  )
));