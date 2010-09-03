<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<div id="image_gallery_upload">
	<form enctype="multipart/form-data" action="<?= PA::$url?>/groupmedia_post.php?type=Videos<?php
		if (!empty($_REQUEST['gid'])) echo '&amp;gid='.$_REQUEST['gid'] ?>" method="POST">
	<fieldset class="youtube">
		<div id="preview">
			<p>Video Preview</p>
		</div>

		<div class="field">
			<label for="select_file"><?=__("You can copy and paste a link to a YouTube video here.") ?></label>
			<input name="userfile_0" type="text" id="select_file" class="text long" value="" />
		</div>

		<div class="field">
			<label for="image_title"><?= __("Video title") ?></label>
			<input type="text" name="caption[0]" value="" class="text long" id="image_title"  />
		</div>

		<input type="hidden" name="media_type" value="video" />
		<input type="hidden" name="content_type" value="media" />
		<input type="hidden" name="image_perm[0]" value="1" />
<?php if (!empty($_REQUEST['gid'])) { ?>
		<input type="hidden" name="group_id" value="<?=$_REQUEST['gid'];?>" />
<? } ?>
		<input type="submit" class="button-submit" name="submitbtn" value="<?= __("Attach video") ?>" />
	</fieldset>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#select_file").change(embedVideo);
	});

	function embedVideo()
	{
		// @todo: look into the Zend YouTube class to use with a PHP service instaed
		if($("#select_file").val().match(/http\:\/\/www\.youtube\.com/))
		{
			var url = 'http://www.youtube.com/v/';
			if($(this).val().match(/http\:\/\/www\.youtube\.com\/v\//))
			{
				// http://www.youtube.com/v/xxxxxxxxxxx
				url += $(this).val().substring(25);
			}
			else if($(this).val().match(/http\:\/\/www\.youtube\.com\/watch\?v\=/))
			{
				// http://www.youtube.com/watch?v=xxxxxxxxx
				url += $(this).val().substring(31);
			}
			$('#preview').html('<object width="480" height="385"><param name="movie" value="' + url + '?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="' + url + '?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>');
		}
		else
		{
			$('#preview').html('<p>No Preview Available</p>');
		}
	}
</script>