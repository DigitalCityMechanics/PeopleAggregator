<h1><?= __("Basic info") ?></h1>
<form enctype="multipart/form-data" action="" method="post" name="formBasicProfile">

    <div class="form-block">
      <label for="first-name"> <?= __("First Name:") ?></label>
      <?php
        if (!empty($request_data['first_name'])) {
      ?>
      <input type="text" name="first_name" value="<?php echo $request_data['first_name']?>" class="textbox short" id="first-name" maxlength="45" />
      <?php
        } else {
      ?>
      <input type="text" name="first_name" value="<?php echo $user_info->first_name?>" class="textbox short" id="first-name" maxlength="45" />
      <?php
        }
      ?>
    </div>

    <div class="form-block">
      <label for="last-name"> <?= __("Last Name:") ?></label>
      <?php
        if (!empty($request_data['last_name'])) {
      ?>
      <input type="text" name="last_name" value="<?php echo $request_data['last_name']?>" class="textbox short" id="last-name" maxlength="45" />
      <?php
        } else {
      ?>
      <input type="text" name="last_name" value="<?php echo $user_info->last_name?>" class="textbox short" id="last-name" maxlength="45" />
      <?php
        }
      ?>
    </div>

    <div class="form-block">
      <label for="user-email"><?= __("Email Address:") ?></label>
      <?php
        if (!empty($request_data['last_name'])) {
      ?>
      <input class="textbox short" id="user-email" type="text" name="email_address" value="<?php echo $request_data['email_address'];?>" />
      <?php
        } else {
      ?>
      <input class="textbox short" id="user-email" type="text" name="email_address" value="<?php echo $user_info->email?>" />
      <?php
        }
      ?>
    </div>
    <?php    
	    //TODO: sanitize these inputs
        $dynProf->textfield(__("Zip Code:"), "postal_code", "basic", NULL, FALSE);
		$dynProf->textarea(__("About Me:"), "about", "basic", NULL, FALSE);
    ?>
    <div class="form-block">
      <label for="upload_user_image"><?= __("Upload an Image:") ?></label>
      <input name="userfile" type="file" class="textbox" id="upload_user_image"/>
      <input type="hidden" name="uid" value="<?php echo $uid?>" />
      <input type="hidden" name="deletepicture" value="false" id="deletepicture" />
      <input type="hidden" name="profile_type" value="basic" /><br />
    </div>

    <div class="form-block">
      <div class="curr_image">
      	<span class="title"><?= __("Current Image:") ?></span>
        <?php print "<a href=\"". PA::$url . PA_ROUTE_USER_PUBLIC . "/$uid\">".uihelper_resize_mk_user_img($user_info->picture, 75, 80, 'alt="Current Image"')."</a>"; ?>
        <span class="remove_picture">
          <?php
            if (!empty($user_info->picture)) {
              echo '<a onClick=\'javascript:document.getElementById("deletepicture").value="true";this.innerHTML="Press Apply Changes to confirm."\' >'.__("Remove Picture").'</a>';
            }
          ?>
        </span>
      </div>
    </div>
    <div class="form-block">
      <label for="password"> <?= __("Password:") ?></label>
      <input type="password" id="password" name="pass" class="textbox short" value="" />
    </div>

    <div class="form-block">
      <label for="confirm-password"> <?= __("Password Again:") ?></label>
      <input class="textbox short" id="confirm-password" type="password" name="conpass" value=""/>
    </div>
    

  <div class="form-block">
    <input type="hidden" name="action" value="SaveProfile" />
    <input type="submit" class="submit" name="submit" value="<?= __("Apply Changes") ?>" />
  </div>
</form>