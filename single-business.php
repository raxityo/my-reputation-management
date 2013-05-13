<?php
/*
Template Name:Business
*/
	$pluginDirName = "my-reputation-management";
	$plugins_url = plugins_url($pluginDirName)."/";
	$currentBusiness = get_post_meta(get_the_ID(),'businessinfo',true);
	extract($currentBusiness);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?=$plugins_url?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$plugins_url?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="<?=$plugins_url?>js/jquery.min.js"></script>
<script src="<?=$plugins_url?>js/bootstrap.min.js"></script>
<title>Review <?=get_the_title()?></title>
</head>
<body>
	<div id="container">
		<div class="center">
		<!-- 	header -->
			<div id="header">
				<h1><b>At  <?=get_the_title()?></b></h1>
				<h2>we value your opinion.</h2>
				<h3>Please take a moment and leave us a short review.</h3>
			</div>
			<div id="middle">
				<div id="review">
					<div class="midleft">
						<h2><b>I Had a Bad experience <br/>
						at  <?=get_the_title()?></b></h2>
													<!-- STEP 4 ADD IN WUFOO URL - STAY INBETWEEN THE QUOTATION MARKS-->
						<a class="leftimg" href="#responseform" data-toggle="modal"></a>
						
					</div>
					<div class="midright">
						<h2><b>I Had a great experience<br/>
						at  <?=get_the_title()?></b></h2>
						<a class="rightimg" href="<?=$positive_url?>"></a>
					</div>
				</div>
				<!-- Modal -->
				<div id="responseform" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="responseForm" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="responseForm" class="text-center">Response for <?=get_the_title()?> </h3>
					</div>
					<div class="modal-body">
						<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							This is just a demo of form.<br/>
							Actual form will send data to <strong><?=$email?></strong>
						</div>
						<form class="bs-docs-example form-horizontal">
						    <div class="control-group">
								<label class="control-label" for="inputName">Name</label>
								<div class="controls">
									<input type="text" id="inputName" placeholder="Enter your name ">
								</div>
						    </div>
						    <div class="control-group">
								<label class="control-label" for="inputEmail">Email</label>
								<div class="controls">
									<input type="text" id="inputEmail" placeholder="Enter your email address">
								</div>
						    </div>
						    <div class="control-group">
								<label class="control-label" for="inputComments">Comment</label>
								<div class="controls">
									<textarea rows="6" id="inputComments" placeholder="Enter your comments here"></textarea>
								</div>
						    </div>
						    <div class="control-group">
								<div class="controls">
									<button type="submit" class="btn btn-success">Submit</button>
								    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
								</div>
						    </div>
						</form>
					</div>
				</div>
			</div>
		<!-- 	/ middle -->
		</div>  
	</div>  
	<div id="footer">
		<div class="center">
			<p class="rights">&copy; Copyright <?=date("Y")?>  <?=get_the_title()?>| All Rights Reserved.</p>
			<?php if(!empty($facebook_url)) {?>
				<p class="ftimg"><a href="<?=$facebook_url?>"><img src="<?=$plugins_url?>img/footerimg1.png" alt="" border="0"/></a></p>
			<?php } ?>
		</div>
	</div>
 </body>
</html>