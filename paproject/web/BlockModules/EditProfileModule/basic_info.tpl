<h1><?= __("Basic info") ?></h1>
<form enctype="multipart/form-data" action="" method="post" name="formBasicProfile">
    <div class="form-block">
      <label><?= __("Login Name") ?></label>
      <?php echo $user_info->login_name;?>
    </div>

    <div class="form-block">
      <label for="password"> <?= __("Password") ?></label>
      <input type="password" id="password" name="pass" class="textbox short" value="" />
    </div>

    <div class="form-block">
      <label for="confirm-password"> <?= __("Confirm Password") ?></label>
      <input class="textbox short" id="confirm-password" type="password" name="conpass" value=""/>
    </div>

    <div class="form-block">
      <label for="first-name"> <?= __("First Name") ?></label>
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
      <label for="last-name"> <?= __("Last Name") ?></label>
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
      <label for="user-email"><?= __("Email") ?></label>
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

  <div class="form-block">
    <input type="hidden" name="action" value="SaveProfile" />
    <input type="submit" class="submit" name="submit" value="<?= __("Apply Changes") ?>" />
  </div>
</form>
