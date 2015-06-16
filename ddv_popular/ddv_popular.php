<?php
/*
Plugin Name: DDV Popular
Plugin URI: http://devdever.com
Description: A plugin that records post views and contains functions to easily list posts by popularity
Version: 1.0
Author: Mr. Silasak
Author URI: http://devdever.com
License: GPL2
*/


/**
 * Adds a view to the post being viewed
 *
 * Finds the current views of a post and adds one to it by updating
 * the postmeta. The meta key used is "ddv_pop_views".
 *
 * @global object $post The post object
 * @return integer $new_views The number of views the post has
 *
 */

function ddvpop_add_view() {

  if(is_single()) {
    global $post;
    $current_views = get_post_meta($post->ID, "ddv_pop_views", true);
    if(!isset($current_views) OR empty($current_views) OR !is_numeric($current_views) ) {
       $current_views = 0;
    }
    $new_views = $current_views + 1;
    update_post_meta($post->ID, "ddv_pop_views", $new_views);
    return $new_views;
  }
  
}
add_action("wp_head", "ddvpop_add_view");





/**
 * Retrieve the number of views for a post
 *
 * Finds the current views for a post, returning 0 if there are none
 *
 * @global object $post The post object
 * @return integer $current_views The number of views the post has
 *
 */
function ddvpop_get_view_count() {
  global $post;
  $current_views = get_post_meta($post->ID, "ddv_pop_views", true);
  if(!isset($current_views) OR empty($current_views) OR !is_numeric($current_views) ) {
  $current_views = 0;
  }
  return $current_views;
}




/**
 * Shows the number of views for a post
 *
 * Finds the current views of a post and displays it together with some optional text
 *
 * @global object $post The post object
 * @uses ddvpop_get_view_count()
 *
 * @param string $singular The singular term for the text
 * @param string $plural The plural term for the text
 * @param string $before Text to place before the counter
 *
 * @return string $views_text The views display
 *
 */
function ddvpop_show_views($content,$singular = "view", $plural = "views", $before = "This post has: ") {

  global $post;
  $current_views = ddvpop_get_view_count();
  $views_text = $before . $current_views . " ";
  if ($current_views == 1) {
     $views_text .= $singular;
  }
  else {
     $views_text .= $plural;
  }
  return $content.$views_text;
}

add_filter( 'the_content', 'ddvpop_show_views');


?>