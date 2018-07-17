<?php
require_once(__DIR__ . '/../../../vendor/autoload.php');
(new \Dotenv\Dotenv(__DIR__.'/../../../'))->load();

require_once('lib/Genesis/GenesisTimberContextInjection.php');
require_once('lib/Genesis/GenesisTwigExtensions.php');
require_once('lib/Genesis/GenesisAjaxEndpoints.php');


// If the Timber plugin is not active the theme wont work
if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	return;
}

class GenesisSite extends TimberSite {
	private $timberContextInjection;

	function __construct() {
		$this->theme_support();

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'add_ajax_endpoints' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		parent::__construct();
	}

	private function theme_support() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	}

	public function add_ajax_endpoints() {
		//Register scripts and endpoints for specific pages
		//TODO: Add support for multiple endpoints for a single script
		$ajaxScripts = array(
			// array(
			// 	'name' => 'posts',
			// 	'file' => 'ajax-posts.js',
			// 	'dependencies' => array('jquery'),
			// 	'endpoint' => 'ajaxPostsEndpoint', //Name of function in GenesisAjaxEndpoints
			// 	'pageName' => 'page-slug-here' //js will only be served to this page
			// ),
		);
		new GenesisAjaxEndpoints($ajaxScripts);
	}

	public function register_post_types() {
		//this is where you can register custom post types

		register_post_type( 'author',
			array(
				'labels' => array(
					'name' => __( 'Authors' ),
					'singular_name' => __( 'Author' )
				),
				'public' => true,
				'has_archive' => false,
				'supports' => array('title', 'editor', 'thumbnail')
			)
		);
	}

	public function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	public function register_menus() {
		//this is where you can register menus
		register_nav_menus( array(
			'main_menu' => 'Main menu',
			'footer_menu' => 'Footer links'
		) );
	}

	public function enqueue_scripts() {
		//Enqueue all scripts
		wp_register_script('owl.carousel', get_template_directory_uri() . '/assets/node_modules/owl.carousel/dist/owl.carousel.min.js', array(),'2.3.4', true);
		wp_register_script('carbonate', get_template_directory_uri() . '/assets/dist/js/script.js', array('jquery', 'owl.carousel'),'1.0', true);
		wp_enqueue_script('owl.carousel');
		wp_enqueue_script('carbonate');

		//Enqueue fonts as styles
		wp_register_style('open-sans-font', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800');
		wp_enqueue_style('open-sans-font');

		//Enqueue stylesheets
		wp_register_style('carbonate', get_template_directory_uri() . '/assets/dist/css/style.css');
		wp_enqueue_style('carbonate');

		$this->_enqueue_page_specific_scripts();
	}

	public function add_to_context( $context ) {
		$this->timberContextInjection = new GenesisTimberContextInjection( $context );
		$context['uploads'] = wp_upload_dir();
		return $context;
	}

	public function add_context_dependency( $dependency, &$context, $data = null ) {
		$this->timberContextInjection->add_dependency( $dependency, $context, $data );
	}

	public function add_to_twig( $twig ) {
		new GenesisTwigExtensions( $twig );
		return $twig;
	}

	private function _enqueue_page_specific_scripts() {
		global $post;
		// Register scripts that are for specific pages like this:
   	// if( $post->post_name=='latest-updates' ) {
		// 	wp_register_script('latest-updates-script', get_template_directory_uri() . '/assets/js/latest-updates.js', array('jquery'),'1.0', true);
		// 	wp_enqueue_script('latest-updates-script');
		// }
	}

}

$GLOBALS['GenesisSite'] = new GenesisSite();
