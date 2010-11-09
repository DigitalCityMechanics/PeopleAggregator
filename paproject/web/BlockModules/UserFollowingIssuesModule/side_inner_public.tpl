<?php if(count($issues) > 0){ ?>
	<ul class='link-list'>
		<?php foreach($issues as $issue){ ?>
		<li><a href="<?=$issue['url'] ?>"><?=$issue['title'] ?></a></li>
		<?php } // end foreach ?>
	</ul>
<?php } // end count check ?>