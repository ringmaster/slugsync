<?php

class SlugsyncPlugin extends Plugin {
	public function filter_post_update_change($new_fields, Post $post, $orig_fields)
	{
		if($new_fields['title'] != $orig_fields['title'] && $new_fields['slug'] == $orig_fields['slug']) {
			$new_fields['slug'] = $new_fields['title'];
		}
		return $new_fields;
	}
}

?>