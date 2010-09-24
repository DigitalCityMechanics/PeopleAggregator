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
	require_once('Zend/Gdata/YouTube.php');

	/**
	 * Finds the URL for the flash representation of the specified video
	 *
	 * @param  Zend_Gdata_YouTube_VideoEntry $entry The video entry
	 * @return string|null The URL or null, if the URL is not found
	 */
	function findFlashUrl($entry)
	{
	    foreach ($entry->mediaGroup->content as $content) {
	        if ($content->type === 'application/x-shockwave-flash') {
	            return $content->url;
	        }
	    }
	    return null;
	}

	$youtube = new Zend_Gdata_YouTube();
	$videoId = 'KHLrEF9tHjw';
	$entry = $youtube->getVideoEntry($videoId);
    $videoTitle = $entry->mediaGroup->title;
    $videoUrl = findFlashUrl($entry);

	print <<<END
	<p><b>$videoTitle</b></p>
	<object width="425" height="350">
		<param name="movie" value="${videoUrl}"></param>
		<param name="allowFullScreen" value="true"></param>
		<param name="allowscriptaccess" value="always"></param>
		<embed src="${videoUrl}" type="application/x-shockwave-flash"
			allowscriptaccess="always" allowfullscreen="true" width=425" height="350"></embed>
	</object>
END;
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

		<div class="field">
			<label for="video_title"><?= __("Video title") ?></label>
			<input type="text" name="video_title" value="" class="text long" id="video_title"  />
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
			$('#preview').css('display', 'block');
		}
		else
		{
			$('#preview').html('<p>No Preview Available</p>');
			$('#preview').css('display', 'block');
		}
	}
</script>