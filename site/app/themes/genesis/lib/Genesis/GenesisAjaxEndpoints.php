<?php

class GenesisAjaxEndpoints {

  private $scripts = array();

  public function __construct( $_scripts ) {
    $this->scripts = $_scripts;
    add_action( 'wp_loaded', array( $this, 'scriptsRegister' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'scriptsEnqueue' ) );

    # Logged in users:
    # add_action( "wp_ajax_{$this['name']}_action", array( $this, 'ajaxCb' ) );

    foreach( $this->scripts as $key => $script ) {
      add_action( "wp_ajax_{$script['name']}_action", array( $this, $script['endpoint'] ) );
      add_action( "wp_ajax_nopriv_{$script['name']}_action", array( $this, $script['endpoint'] ) );
    }
    add_action( 'wp_enqueue_scripts', array( $this, 'scriptsLocalize' ) );
  }

  public function scriptsRegister( $page ) {
    foreach( $this->scripts as $key => $script ) {
      wp_register_script(
        $script['name'],
        get_template_directory_uri()."/assets/dist/js/single/{$script['file']}",
        $script['dependencies'],
        filemtime( get_template_directory( __FILE__ )."/assets/dist/js/single/{$script['file']}" ),
        true
      );
      $this->scripts[$key]['nonce'] = wp_create_nonce( "{$script['name']}_action" );
    }

  }

  public function scriptsEnqueue( $page ) {
    global $post;
    foreach( $this->scripts as $script ) {
      //If the script is for a specific page and this isn't that page, ignore it
      if( array_key_exists( 'pageName', $script )
        && $script['pageName'] !== $post->post_name ) {
        continue;
      }
    wp_enqueue_script( $script['name'] );
    }
  }

  public function scriptsLocalize( $page ) {
    foreach( $this->scripts as $script ) {
      wp_localize_script( $script['name'], "{$script['name']}_object", array(
        'ajaxurl'          => admin_url( 'admin-ajax.php' ),
        '_ajax_nonce'      => $script['nonce'],
        'action'           => "{$script['name']}_action"
      ));
    }
  }

  public function ajaxPostsEndpoint() {
    $data = array_map( 'esc_attr', $_GET );
    ! check_ajax_referer( $data['action'], "_ajax_nonce", false )
      AND wp_send_json_error();

    $default_posts_per_page = get_option( 'posts_per_page' );

    $args = array();

    if( $data['paged'] ) {
      $args['paged'] = $data['paged'];
    }
    if( $data['limit'] ) {
      $args['posts_per_page'] = $data['limit'];
    } else {
      $args['posts_per_page'] = $default_posts_per_page;
    }

    $posts = new Timber\PostQuery($args);

    $responseData = array();

    $context = Timber::get_context();
    $context['posts'] = posts;
    ob_start();
    Timber::render( 'path/to/listing/templat.twig', $context );
    $responseData['html'] = ob_get_contents();
    ob_end_clean();

    wp_send_json_success( $responseData );
  }
}
?>
