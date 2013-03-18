<?php
class ScaleUp_Upgrades extends ScaleUp_Base {

  function __construct( $args = array() ) {
    parent::__construct( $args );

    $context = $this->get( 'context' );
    $context->add_action( 'activation', array( $this, '_activation' ) );
  }

  /**
   * On context activation add each method in this class as an upgrade to the context item
   */
  function _activation() {

    $context = $this->get( 'context' );
    if ( !is_null( $context ) ) {
      $methods = $this->getDeclaredMethods( __CLASS__ );
      foreach ( $methods as $method ) {
        $context->add( 'upgrade', array(
          'name'    => $method,
          'execute' => array( $this, $method ),
        ) );
      }
    }

  }

  /**
   * Return array of methods for the declared class
   *
   * @see http://stackoverflow.com/questions/3712671/get-only-declared-methods-of-a-class-in-php
   * @param $className
   * @return array
   */
  function getDeclaredMethods( $className ) {

    $reflector      = new ReflectionClass( $className );
    $methodNames    = array();
    $lowerClassName = strtolower( $className );
    foreach ( $reflector->getMethods( ReflectionMethod::IS_PUBLIC ) as $method ) {
      if ( strtolower( $method->class ) == $lowerClassName ) {
        $methodNames[ ] = $method->name;
      }
    }

    return $methodNames;
  }

}