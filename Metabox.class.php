<?php
/**
 *
 */
class MetaboxEditor {

	var $title;
	var $key = "custom_metabox_";
	var $titleKey = "custom_metabox_title_";
	var $enabledKey = "custom_metabox_enabled_";
	static $metabox_id = 0;
	/**
	 * @param $title : Title of the metabox
	 */
	function __construct($title) {
		
		$this -> title = $title;
		$this -> key .= self::$metabox_id;
		$this -> titleKey .= self::$metabox_id;
		$this -> enabledKey .= self::$metabox_id;
		
		self::$metabox_id = self::$metabox_id + 1;
	}

	public function init() {
		add_action('add_meta_boxes', array($this, 'add_new_metabox'));
		add_action('save_post', array($this, 'save_metabox_data'), 1, 2);
	}

	function add_new_metabox() {
		add_meta_box('add_new_metabox_'.$this->title, $this -> title, array($this, 'add_new_metabox_callback'), CONTEXT_ID, 'normal', 'high');
	}

	function add_new_metabox_callback() {
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="' . $this -> key . '_noncename" id="' . $this -> key . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';

		$this -> add_new_editor();

	}

	private function add_new_editor() {
		global $post;

		// Get original data if entered
		$currentTab = get_post_meta($post -> ID, $this -> key, true);
		
		$value = isset($currentTab['description']) ? $currentTab['description'] : "";
		$titleOfTab = isset($currentTab['title']) ? $currentTab['title'] : "";
		$isBoxEnabled = isset($currentTab['enabled']) ? $currentTab['enabled'] : "true";
		
		$trueButton = $isBoxEnabled == "true"? "checked" :"";
		$falseButton = $isBoxEnabled == "false" ? "checked" :"";
		
		
		echo '
		<div style="background: white;width: 700px;border: solid 1px #ccc;border-radius:5px;padding: 10px;">
		Do you want to Enable This Tab ? <input type="radio" value="true" name= "'.$this->enabledKey.'"  '.$trueButton.'/>Yes &nbsp;&nbsp;&nbsp;
		<input type="radio" value="false" name= "'.$this->enabledKey.'" '.$falseButton.'/>No ';
		
		echo "<span style='color: #666;' ><i>(currently this box is ";
		echo ($trueButton == "checked" ? "ENABLED" : "DISABLED").")</i></span>";
		
		echo '<br/><br/>
		Tab Title : &nbsp;&nbsp;<input type="text" name="'.$this->titleKey.'" value="' . $titleOfTab  . '"   />
		</div>
		';
		
		wp_editor($value, $this -> key, array('textarea_name' => $this -> key, 'editor_css' => '<style>
										#wp-' . $this -> key . '-editor-container
										{
											background-color:white;
											width:100%;
										}
									</style>'));

		echo '<table id="post-status-info" cellspacing="0">
				<tbody>
					<tr>
						<td id="wp-word-count">Word count: <span class="word-count_2">';
		$words = strip_tags($value);
		$count = str_word_count($words, 0);
		echo $count;
		echo '</span>
			</td>
				<td class="autosave-info">
					<span class="autosave-message">&nbsp;</span>
				</td>
			</tr>
			</tbody>
			</table>';
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

		// OK, we're authenticated: we need to find and save the data

		// We'll put it into an array to make it easier to loop though.
		$thisTab = array(
		'enabled' => $_POST[$this->enabledKey],
		'title' => $_POST[$this->titleKey],
		'description' => $_POST[$this->key]
		);
	
			if ($post -> post_type == 'revision')
				return;
				
			if (get_post_meta($post -> ID, $this->key, FALSE)) {// If the custom field already has a value
				update_post_meta($post -> ID, $this->key, $thisTab);
			} else {// If the custom field doesn't have a value
				add_post_meta($post -> ID, $this->key, $thisTab);
			}
			
	}

}

class MetaboxTextArea{
	var $title;
	var $key;
	function __construct($title,$key){
		
		$this->title = $title;
		$this->key =  $key;
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
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="' . $this -> key . '_noncename" id="' . $this -> key . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';

		echo 	"<textarea name='$this->key' id='$this->key' style='width:98%;height:4em'>"
				.get_post_meta($post -> ID, $this -> key, true).
				"</textarea>";
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

		// OK, we're authenticated: we need to find and save the data

		// We'll put it into an array to make it easier to loop though.
		$thisTab = $_POST[$this->key];
	
			if ($post -> post_type == 'revision')
				return;
				
			if (get_post_meta($post -> ID, $this->key, FALSE)) {// If the custom field already has a value
				update_post_meta($post -> ID, $this->key, $thisTab);
			} else {// If the custom field doesn't have a value
				add_post_meta($post -> ID, $this->key, $thisTab);
			}
	}
}
?>