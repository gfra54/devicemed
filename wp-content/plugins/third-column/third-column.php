  <?php
/*
Plugin Name: Third Column
Plugin URI: http://www.bang-on.net/thirdcolumn.zip
Description: Adds a third column to the page and post edit form
Author: Marcus Downing
Author URI: http://www.bang-on.net
Version: 2.0
*/

/*  Copyright 2011  Marcus Downing  (email : marcus@bang-on.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if (!defined('BANG_THIRD_COLUMN_DEBUG'))
  define('BANG_THIRD_COLUMN_DEBUG', false);


//  Initialise

add_action('dbx_post_advanced', 'third_column_edit_form_init');
function third_column_edit_form_init() {
  if (BANG_THIRD_COLUMN_DEBUG) do_action('log', 'Third column: Initialise edit form');

  // the JS and CSS
  add_action('admin_enqueue_scripts', 'third_column_enqueue_scripts');

  // the actual sidebar writers
  add_action('edit_form_top', 'third_column_edit_form_top', 10, 1);
  add_action('edit_form_after_title', 'third_column_edit_form_after_title', 10, 1);
  add_action('edit_form_after_editor', 'third_column_edit_form_after_editor', 10, 1);
  add_action('dbx_post_sidebar', 'third_column_dbx_post_sidebar', 10, 1);
}

function third_column_enqueue_scripts () {
  //  change the screen options
  add_screen_option('layout_columns', array('max' => 3, 'default' => 3) );
   add_screen_option('mini_columns', array('max' => 3, 'default' => 3, 'label' => 'Mini columns') );

  // add scripts and styles
  wp_enqueue_style('third-column', plugins_url('admin.css', __FILE__));
  wp_enqueue_script('third-column', plugins_url('scripts/third-column.js', __FILE__));
}


/* Edit form */


function third_column_edit_form_top($post) {
}

function third_column_edit_form_after_title($post) {
}

function third_column_edit_form_after_editor($post) {
  ?>
  <div id='postbox-subcols'>
    <div id="postbox-container-left" class="postbox-container">
      <?php do_meta_boxes(null, 'left', $post); ?>
    </div>
    <div id="postbox-container-right" class="postbox-container">
      <?php do_meta_boxes(null, 'right', $post); ?>
    </div>
  </div>
  <?php
}

function third_column_dbx_post_sidebar($post) {
  $post_type = $post->post_type;

  ?><div id="postbox-container-3" class="postbox-container"><?php
    do_meta_boxes($post_type, 'column3', $post);
  ?></div><?php
}









// add_action('submitpost_box', 'third_column_edit_form');
// add_action('submitpage_box', 'third_column_edit_form');
function third_column_edit_form() {
  global $post;
  $post_type = $post->post_type;
  //  check post types
  $side_meta_boxes2 = do_meta_boxes($post_type, 'column3', $post);

  /*  Obscure case:
   *  The taxBox javascript is only initialised if the page loads with a tax box within
   *  #side-sortables, #normal-sortables or #advanced-sortables
   *  Since we're adding an unanticipated #column3-sortables, we need to force it to initialise.
   */
  ?><script type='text/javascript'>
    jQuery(document).ready(function($) {
      var toInit = false;
      $('#column3-sortables div.postbox').each(function(){
        if ( this.id.indexOf('tagsdiv-') === 0 ) {
          toInit = true;
        }
      });
      $('#side-sortables, #normal-sortables, #advanced-sortables').children('div.postbox').each(function(){
        if ( this.id.indexOf('tagsdiv-') === 0 ) {
          toInit = false;
        }
      });
      tagBox.init();
    });
  </script><?php
}