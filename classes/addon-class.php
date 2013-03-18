<?php
class ScaleUp_Upgrades_Addon extends ScaleUp_Addon {

  function activation() {
    $context      = $this->get( 'context' );
    $context_name = $context->get( 'name' );
    $this->set( 'option_key', "{$context_name}_upgrades" );

    $this->add( 'view', array(
      'name'  => 'upgrades',
    ));

    $this->add( 'view', array(
      'name'  => 'upgrade',
      'url'   => '/upgrade/{name}',
    ));

    $this->add( 'template', array(
      'path'     => SCALEUP_UPGRADES_DIR . '/templates',
      'template' => '/upgrades/upgrades.php',
    ));

    $this->add( 'form', array(
      'name'  => 'upgrades',
    ));

  }

  function get_defaults() {
    return wp_parse_args(
      array(
        'name'  => 'upgrades',
        'url'   => '/upgrades',
      ), parent::get_defaults() );
  }

  function setup_form( $args ) {

    /** @var $context ScaleUp_Feature */
    $context  = $this->get( 'context' );
    $upgrades = $context->get_features( 'upgrades' );
    $form     = get_form( 'upgrades' );

    $executed_upgrades = $this->get_executed_upgrades();

    if ( is_array( $upgrades ) && !empty( $upgrades ) ) {
      $form->add( 'form_field', array(
        'name'    => 'button',
        'type'    => 'button',
        'text'    => 'execute',
      ) );
      /** @var $upgrade ScaleUp_Upgrade */
      foreach ( $upgrades as $name => $upgrade ) {
        $form->add( 'form_field', array(
          'name'     => $name,
          'type'     => 'checkbox',
          'label'    => $name,
          'disabled' => in_array( $name, $executed_upgrades ),
          'help'     => $upgrade->get( 'description' ),
        ) );
      }
    } else {
      $form->add( 'alert', array(
        'type'  => 'info',
        'msg'   => "You don't have any upgrades yet."
      ));
    }

    return $args;
  }

  function get_executed_upgrades() {
    $option_key        = $this->get( 'option_key' );
    $executed_upgrades = get_option( $option_key );
    if ( false === $executed_upgrades ) {
      $executed_upgrades = array();
    }
    return $executed_upgrades;
  }

  function get_upgrades( $args ) {
    $this->setup_form( $args );
    get_template_part( '/upgrades/upgrades.php' );
    return true;
  }

  function post_upgrade( $args ) {

    $return = ( object ) array( 'success' => false, 'data' => array() );

    if ( isset( $args[ 'name' ] ) && !empty( $args[ 'name' ] ) ) {

      $name = $args[ 'name' ];

      $executed_upgrades = $this->get_executed_upgrades();

      if ( !in_array( $name, $executed_upgrades ) ) {
        $context = $this->get( 'context' );
        $upgrade = $context->get_feature( 'upgrade', $name );
        if ( is_object( $upgrade ) ) {
          $return = $upgrade->apply_filters( 'execute', (object) array(
            'success' => true,
            'data'    => array(),
            'args'    => $args,
            'alerts'  => array(),
          ) );
        }
        if ( is_object( $return ) && true === $return->success ) {
          $executed_upgrades[] = $name;
          $saved = update_option( $this->get( 'option_key' ), $executed_upgrades );
        }
      }

    }

    return $return;
  }

}

ScaleUp::register( 'addon', array( 'name' => 'upgrades', '__CLASS__' => 'ScaleUp_Upgrades_Addon' ) );

