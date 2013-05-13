<?php
add_action('wp_ajax_send_review_mail', 'send_review_mail');
add_action('wp_ajax_nopriv_send_review_mail', 'send_review_mail');

function send_review_mail(){
	$businessinfo =  get_post_meta($_POST['id'],'businessinfo',true);
	$to = $businessinfo['email'];
	$subject = "You have received some feedback";
	$message = "Hi ! \n".
	$_POST['name'].($_POST['email'] != "" ? " (".$_POST['email'].")" : "" )." submitted feedback about your business.\nFollowing is the comment from them : \n\n\n".
	$_POST['comments'].
	"\n\n\n
	(auto-generated email)
	";
	$headers[] = 'From: '.$_POST['name']."<".$_POST['email'].">";

	echo wp_mail( $to, $subject, $message, $headers);
	die();
}
?>