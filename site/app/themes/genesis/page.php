<?php
/**
 * The template for displaying all pages.
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$templates = array( 'page.twig' );
$GenesisSite->add_context_dependency( 'page_intro', $context );

Timber::render( $templates, $context );
