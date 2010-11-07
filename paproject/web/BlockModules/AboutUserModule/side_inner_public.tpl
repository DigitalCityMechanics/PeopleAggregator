<?php
  // global var $_base_url has been removed - please, use PA::$url static variable

?>
<div class="module_icon_list">
  <ul class="members">
    <li>
    <span>
		<?php if(!empty($user_data_general['about'])) { echo $user_data_general['about'] . "<br />"; } ?>
    </span>
    </li>
  </ul>
</div>
