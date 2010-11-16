<?php
 if(count($thoughts) > 0){ ?>
	<ul class='link-list'>
		<?php foreach($thoughts as $thought){ ?>
		<li><a href="<?= $thought['url'] ?>" title="View <?= $thought['title'] ?>"><?= $thought['title'] ?></a></li>
		<?php } // end foreach ?>
	</ul>
	<?php if(isset($manage_thoughts_url)): ?>
		<div class="view_all"><a class="button" href="<?= $manage_thoughts_url ?>">Manage Thoughts</a></div>
	<?php endif; ?>
<?php } // end count check ?>