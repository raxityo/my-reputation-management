<?php
class MetaTextBox{
	var $title;
	var $key;
	var $key_email;
	var $key_positive_url;
	var $key_facebook_url;

	function __construct($title,$key){
		
		$this->title = $title;
		$this->key =  $key;
		$this->key_email =  $key."_email";
		$this->key_positive_url =  $key."_positive_url";
		$this->key_facebook_url =  $key."_facebook_url";
	}
	
	public function init() {
		add_action('add_meta_boxes', array($this, 'add_new_metabox'));
		add_action('save_post', array($this, 'save_metabox_data'), 1, 2);
	}
	
	function add_new_metabox() {
		add_meta_box('add_new_metabox_'.$this->title, $this -> title, array($this, 'add_new_metabox_callback'), CONTEXT_ID, 'normal', 'high');
	}
	
	function add_new_metabox_callback() {
		global $post;

		//Get older value 
		$currentBusiness = get_post_meta($post -> ID, $this -> key, true);
		$email = isset($currentBusiness['email']) ? $currentBusiness['email'] : "";
		$positive_url = isset($currentBusiness['positive_url']) ? $currentBusiness['positive_url'] : "";
		$facebook_url = isset($currentBusiness['facebook_url']) ? $currentBusiness['facebook_url'] : "";
		
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="' . $this -> key . '_noncename" id="' . $this -> key . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
		echo 	"<label for='$this->key_email'>Business Email :  <input type='email' name='$this->key_email' id='$this->key_email' value='$email' style='width: 400px' /></label><br/>";
		echo 	"<label for='$this->key_positive_url'>Positive response URL :  <input type='text' name='$this->key_positive_url' id='$this->key_positive_url' value='$positive_url' style='width: 400px' /></label><br/>";
		echo 	"<label for='$this->key_facebook_url'>Facebook fanpage URL  :  <input type='text' name='$this->key_facebook_url' id='$this->key_facebook_url' value='$facebook_url' style='width: 400px' /> (Leave blank if you don't want to show facebook)</label>";
		
	}
	
	public function save_metabox_data($post_id) {
		global $post;
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if (!wp_verify_nonce($_POST[$this -> key . '_noncename'], plugin_basename(__FILE__)))
			return $post -> ID;
		// Is the user allowed to edit the post or page?
		if (!current_user_can('edit_post', $post -> ID))
			return $post -> ID;

		// We'll put it into an array to make it easier to loop though.
		$currentBusiness = array(
			'email' => $_POST[$this->key_email],
			'positive_url' => $_POST[$this->key_positive_url],
			'facebook_url' => $_POST[$this->key_facebook_url]
		);
		if ($post -> post_type == 'revision')
			return;
			
		if (get_post_meta($post -> ID, $this->key, FALSE)) {// If the custom field already has a value
			update_post_meta($post -> ID, $this->key, $currentBusiness);
		} else {// If the custom field doesn't have a value
			add_post_meta($post -> ID, $this->key, $currentBusiness);
		}
	}
}
?>