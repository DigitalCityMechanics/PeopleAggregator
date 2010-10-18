<div>
    <div id="poll_module">
      <p><?= $topic[0]->title ?></p>
		<form method="post" action="<?= PA::$url?>/save_vote.php">
      <p class="votes">(<?= $total_vote?> votes)</p>
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
      if ($flag == 0) { ?>
        <div class="form-block" id="poll_button">
          <input class="submit" type="submit" name="submit" value="<?= __("Answer") ?>" /> or <?php echo ($show_results_link != '') ? '<a href="'.$show_results_link.'">View Responses</a>'."\n" : ''; ?>
        </div>
     <? } else { ?>
		<?php echo ($show_poll_link != '') ? '<p class="vote_link"><a href="'.$show_poll_link.'">OK, I\'m ready to vote!</a></p>'."\n" : ''; ?>
	<?php } ?>
		</div>
	  </form>
    </div>
  <?php
  if (!empty($cnt_prev)) {
  	?>
  	<div class="view_all">
  	<a href="<?=PA::$url.PA_ROUTE_POLL_ARCHIVE?>?gid=<?php echo $_GET['gid'];?>"><?=__("See all recent Surveys")?></a>
  	</div>
  	<?php
  }
  ?>
</div>
<br style="clear:both" />
