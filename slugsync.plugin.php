<?php

class SlugsyncPlugin extends Plugin
{
	public function filter_plugin_config( $actions, $plugin_id )
	{
		if ( $this->plugin_id() == $plugin_id ){
			$actions[]= _t( 'Configure', 'slugsync' );
		}
		return $actions;
	}

	public function action_plugin_ui( $plugin_id, $action )
	{
		if ( $this->plugin_id() == $plugin_id ) {
			switch ( $action ) {
				case _t( 'Configure', 'slugsync' ):
					$form = new FormUI( 'slugsync' );
					$form->append('checkbox', 'image_classes', 'option:slugsync__draftupdates', _t( 'Only update when post is not published (yet): ', 'slugsync' ));
					$form->append( 'submit', 'save', 'Save' );
					$form->on_success( array($this, 'formui_submit' ) );
					$form->out();
					break;
			}
		}
	}

	public function formui_submit( FormUI $form )
	{
		Session::notice( _t( 'Slugsync options saved.', 'slugsync' ) );
		$form->save();
	}
	
	public function filter_post_update_change($new_fields, Post $post, $orig_fields)
	{
		if($post->status != Post::status('published') || !Options::get('slugsync__draftupdates')) {
			if($new_fields['title'] != $orig_fields['title'] && $new_fields['slug'] == $orig_fields['slug']) {
				$new_fields['slug'] = $new_fields['title'];
			}
		}
		return $new_fields;
	}
}

?>