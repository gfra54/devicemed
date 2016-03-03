<?php
class DM_Wordpress_Posts_Admin
{
	static public function initialize()
	{
//		add_action('add_meta_boxes_post', array(__CLASS__, 'metabox_publishing_options'));
//		add_action('save_post', array(__CLASS__, 'metabox_publishing_options_save'));
	}
	
	//---------------------------------------------------------------
	// Metabox Publishing Options
	//---------------------------------------------------------------

	static public function metabox_publishing_options()
	{
/*		add_meta_box(
			'post-dm-publishing-options',
			__('Options de publication'),
			array(__CLASS__, 'metabox_publishing_options_template'),
			'post',
			'side',
			'default'
		);*/
	}
	static public function metabox_publishing_options_template(WP_Post $post)
	{
/*		$metas = get_post_meta($post->ID);
		DM_Wordpress::template('posts_metabox_publishing_options', array(
			'is_featured' => isset($metas['_dm_featured']),
			'is_last_posts' => isset($metas['_dm_last_posts'])
		));*/
	}
	static public function metabox_publishing_options_save($post_id)
	{
		if (isset($_POST['post_dm_publishing_options_featured']))
		{
			update_post_meta($post_id, '_dm_featured', 1);
		}
		else
		{
			delete_post_meta($post_id, '_dm_featured');
		}
		if (isset($_POST['post_dm_publishing_options_last_posts']))
		{
			update_post_meta($post_id, '_dm_last_posts', 1);
		}
		else
		{
			delete_post_meta($post_id, '_dm_last_posts');
		}
	}
}