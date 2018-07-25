<p>Recent Reviews</p>

<?php if (empty($mod->reviews)) { ?>
  <p>No reviews yet.</p>
<? } else foreach ($mod->reviews as $review) { ?>
  <div class="review">
    Review by <?= $review->author["login_name"] ?>: <?= $review->body ?>
  </div>
<?php } ?>
