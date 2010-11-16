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
<div id="<?= $link['user_id'] ?>" class="buddyimg">
  <div class="img-container" id="imgcontainer_<?= $link['user_id'] ?>">
    <a href="<?= $link['user_url'] ?>">
    	<?php 
    		$width = 70;
    		$height = 70;
    		if(isset($link['avatar_width']) && $link['avatar_width'] > 0){
    			$width = $link['avatar_width'];
    		}
    		if(isset($link['avatar_height']) && $link['avatar_height'] > 0){
    			$height = $link['avatar_height'];
    		}
    	?>
      <img id="img_<?= $link['user_id'] ?>" src="<?= $link['big_picture'] ?>" alt="" style="width: <?= $width ?>px; height: <?= $height ?>px; border: 4px; border-style:solid; border-color:#E0E0E0; display: block" />
	</a>
  </div>

  <div class="text-container" id="label_<?= $link['user_id'] ?>">
    <h4><a href="<?= $link['user_url'] ?>"><?= $link['display_name'] ?></a></h4>
  </div>
</div>
