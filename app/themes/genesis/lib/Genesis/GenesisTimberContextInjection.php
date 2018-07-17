<?php
class GenesisTimberContextInjection
{
  const DEPENDENCIES = array(
    'example_dependancy_name'    => '_add_example_dependancy_data',
  );

  function __construct( &$context ) {
    $this->_add_menu( $context );
    $this->_add_post( $context );
    $this->_add_sections( $context );
    $this->_add_acf( $context );
    $this->_add_globals( $context );
	}

  private function _add_menu( &$context ) {
    $context['menu']        = new TimberMenu('main_menu');
    $context['footer_menu'] = new TimberMenu('footer_menu');
  }

 private function _add_post( &$context ) {
    $context['post'] = new TimberPost();
  }
  //
  private function _add_globals( &$context ) {
    $context['logout_url'] = wp_logout_url( home_url('/'));
  }

  private static function _add_sections( &$context ) {
    $context['sections'] = array();
  }

  private function _add_acf( &$context ) {
    $context['acf'] = get_field_objects($context['post']->ID);
  }


  /*--------------------------
   * Dependency management functions
   *--------------------------*/

  // Call this function from a template php file to inject the dependency into
  // the twig context
  public static function add_dependency( $dependency, &$context, $data = null ) {
    if( array_key_exists( $dependency, self::DEPENDENCIES ) ) {
      $functionName = self::DEPENDENCIES[$dependency];
      self::$functionName( $context, $data );
    }
  }


  private static function _add_example_dependancy_data( &$context, $data ) {
    $section = array(
      'template' => 'views/sections/example.twig',
      'data' => $data
    );
    array_push( $context['sections'], $section );
  }

  }
