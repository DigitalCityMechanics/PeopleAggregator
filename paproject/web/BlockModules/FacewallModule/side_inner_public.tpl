  <div class="module_icon_list" id="list_members">
  <?php
    if(!empty($sort_by)) {
      if(isset($_REQUEST['gid'])) {
         $_gid = $_REQUEST['gid'];
         $ajax_call = "javascript: ajax_call_method_for_sorting_group_members('$block_name', '$_gid', '/ajax/ajax_sortby.php', 'sort_users')";
      } else {
         $ajax_call = "javascript: ajax_call_method_for_sorting('$block_name', '', '/ajax/ajax_sortby.php', 'sort_users')";
      }
  ?>
    <select id="sort_users" name="sort_users" onchange="<?=$ajax_call?>">
      <option value="last_login" selected="selected"><?= __("Last login") ?></option>
      <option value="latest_registered" selected="selected"><?= __("Latest registered") ?></option>
      <option value="0" selected="selected">-- <?= __("Sort By") ?> --</option>
    </select>
    <?php
      }
    ?>          
    <ul class="members">
      <?php
        for ($counter = 0; $counter < count($links['users_data']); $counter++) {
          $class = (( $counter%2 ) == 0) ? 'class="color"': NULL;
      ?>  
      <li <?php echo $class?>>
        <?= link_to(uihelper_resize_mk_user_img($links['users_data'][$counter]['picture'], 40, 40, 'alt="PA"'),
		    "user_blog", array("login" => urlencode($links['users_data'][$counter]['user_id']))) ?>
        <span>
          <b><?= link_to($links['users_data'][$counter]['display_name'],
			 "user_blog", array("login" => urlencode($links['users_data'][$counter]['user_id']))) ?></b><br/>
          <?= sprintf(__("(%d friends)"), $links['users_data'][$counter]['no_of_relations']) ?>
        </span>
        <div class="clear"></div>
      </li>
      <?php 
        }
      ?>          
    </ul>         
  </div>