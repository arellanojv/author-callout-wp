<?php

/*
  Plugin Name: Featured Author Block Type
  Version: 1.0
  Author: JVA
  Author URI: 
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once plugin_dir_path(__FILE__) . 'inc/generateAuthorHTML.php';
require_once plugin_dir_path(__FILE__) . 'inc/customEeatFields.php';

class FeaturedAuthor
{
  function __construct()
  {
    add_action('init', [$this, 'onInit']);
    add_action('rest_api_init', [$this, 'authorHTML']);
  }

  function authorHTML()
  {
    register_rest_route('featuredAuthor/v1', 'getHTML', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => [$this, 'getAuthorHTML'],
      'permission_callback' => '__return_true',
    ));
  }

  function getAuthorHTML($data)
  {
    $data['userId'];
    return generateAuthorHTML($data['userId']);
  }

  function onInit()
  {
    wp_register_script('featuredAuthorScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredAuthorStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    register_block_type('ourplugin/featured-author', array(
      'render_callback' => [$this, 'renderCallback'],
      'editor_script' => 'featuredAuthorScript',
      'editor_style' => 'featuredAuthorStyle'
    ));
  }

  function renderCallback($attributes)
  {
    if ($attributes['authorId']) {
      wp_enqueue_style('featuredAuthorStyle');
      return generateAuthorHTML($attributes['authorId']);
    } else {
      return NULL;
    }
  }
}

$featuredAuthor = new FeaturedAuthor();
