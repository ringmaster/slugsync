<?php

class SlugsyncPlugin extends Plugin
{
	public function filter_post_update_change($new_fields, Post $post, $orig_fields)
	{
		if(
			$orig_fields['status'] == Post::status('draft')     // Leaving draft
			|| $new_fields['status'] == Post::status('draft')   // going to draft
			|| Options::get('slugsync__draftupdates', '') != 1  // Don't care if it's draft
		) {
			if($new_fields['title'] != $orig_fields['title'] && $new_fields['slug'] == $orig_fields['slug']) {
				$new_fields['slug'] = $new_fields['title'];
			}
		}
		return $new_fields;
	}

	public function configure()
	{
		$form = new FormUI( 'slugsync' );
		$form->append('checkbox', 'draft_updates', 'slugsync__draftupdates', _t( 'Only update when post status is draft: ', 'slugsync' ));
		$form->append('submit', 'save', 'Save');
		$form->set_option('success_message', _t( 'Slugsync options saved.', 'slugsync' ) );
		return $form;
	}
}

?>