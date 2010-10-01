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
	<form enctype="multipart/form-data" action="<?= PA::$url?>/groupmedia_post.php?type=YouTube<?php
		if (!empty($_REQUEST['gid'])) echo '&amp;gid='.$_REQUEST['gid'] ?>" method="POST">
	<fieldset class="youtube">
		<div id="preview" style="display: none">
			<p>Video Preview</p>
		</div>

		<div class="field">
			<label for="video_url"><?=__("You can copy and paste a link to a YouTube video here.") ?></label>
			<input name="video_url" type="text" id="video_url" class="text long" value="" />
		</div>

		<input type="hidden" name="media_type" value="youtube" />
		<input type="hidden" name="content_type" value="media" />
<?php if (!empty($_REQUEST['gid'])) { ?>
		<input type="hidden" name="group_id" value="<?=$_REQUEST['gid'];?>" />
<? } ?>
		<input type="submit" class="button-submit" name="submitbtn" value="<?= __("Attach video") ?>" />
	</fieldset>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#video_url").change(embedVideo);
	});

	function embedVideo()
	{
		// @todo: look into the Zend YouTube class to use with a PHP service instaed
		if($("#video_url").val().match(/http\:\/\/www\.youtube\.com/))
		{
			$.get('ajax/youtube_helper.php', { url: $("#video_url").val() },
				function(data) {
					$('#preview').html(data);
					$('#preview').css('display', 'block');
				}
			);
		}
		else
		{
			$('#preview').html('<p>No Preview Available</p>');
			$('#preview').css('display', 'block');
		}
	}
</script>