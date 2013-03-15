<?php
class ScaleUp_Upgrade extends ScaleUp_Feature {

  function activation() {

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
  '_duck_types'   => array( 'contextual' ),
));
