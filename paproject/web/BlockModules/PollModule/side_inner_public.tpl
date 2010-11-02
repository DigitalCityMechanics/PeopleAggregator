<div>
    <div id="poll-module">
      <p class="question"><strong><?= $topic[0]->title ?></strong></p>
		<form method="post" action="<?= PA::$url?>/save_vote.php?silent=true&authToken=<?php echo $authToken; ?>">
			<input name="authToken" type="hidden" value="<?php echo $authToken; ?>" />
			<input name="silent" type="hidden" value="true" />
      <p class="votes">(<?php echo ($total_vote == 1) ? $total_vote.' vote' : $total_vote.' votes'; ?>)</p>
	<div class="general-aside">
		<div class="form-block-radio">
      <?php $cnt = count($options);
           for ($i=1; $i<=$cnt; $i++) {
           	if ($options['option'.$i] != '') {
           		if ($flag == 0) {
	              $vote = $options['option'.$i]; 
  	         		?>
		<label class="option_text" for="option_<?= $i; ?>">
			<input type="radio" id="option_<?= $i; ?>" name="vote" value="<?= htmlentities(addslashes($vote));?>" />
			<?= $options['option'.$i]; ?>
		</label>
            <?php 
            } else { 
              $j = $i-1;
            ?>
              <p class="option"><?= $options['option'.$i]; ?></p>
			  <span class="percent"><?=$percentage[$j]?>%</span>
			  <img src="<?=PA::$url ?>/makebar.php?rating=<?=$percentage[$j]?>&amp;width=150&amp;height=10" border="0" />
              <span class="count">(<?=$vote_count[$j]?> votes)</span>
          <?php
          }
       }
     } ?>
     
      <input type="hidden" value="<?= $topic[0]->poll_id;?>" name="poll_id" />
      </div>
      <?php 
      if ($flag == 0 && PA::$login_uid != null) { ?>
        <div class="form-block" id="poll_button">
          <input class="submit" type="submit" name="submit" value="<?= __("Submit") ?>" />
        </div>
     <? } elseif($flag == 0 && PA::$login_uid == null) { ?>
		<p>Please login to vote.</p>
     <? } else { ?>
		<?php echo ($show_poll_link != '') ? '<p class="vote_link"><a href="'.$show_poll_link.'">OK, I\'m ready to vote!</a></p>'."\n" : ''; ?>
	<?php } ?>
		</div>
	  </form>
    </div>
  <?php
  if (false && !empty($cnt_prev)) {
  	?>
  	<div class="view_all">
  	<a href="<?=PA::$url.PA_ROUTE_POLL_ARCHIVE?>?gid=<?php echo $gid; ?>"><?=__("See all recent Surveys")?></a>
  	</div>
  	<?php
  }
  ?>
</div>
<br style="clear:both" />
