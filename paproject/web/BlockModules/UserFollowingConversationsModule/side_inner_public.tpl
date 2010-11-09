<?php if(count($following) > 0){ ?>
	<ul class='link-list'>
		<?php foreach($following as $followed){ ?>
		<li><a href="<?=$followed['url'] ?>"><?=$followed['title'] ?></a></li>
		<?php } // end foreach ?>
	</ul>
<?php } // end count check ?>