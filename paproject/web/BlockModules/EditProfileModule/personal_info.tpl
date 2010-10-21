<?php
global $msg1, $user_personal_data;
global $error_msg;

// echo "<pre>" . print_r($this->user,1) . "</pre>";
$profile = &$this->user->{'personal'};

if (isset($_POST['submit']) && ($_POST['profile_type'] == 'personal')) {
  // $this is  DynamicProfile class instance
  $this->processPOST('personal');
  $save_error = false;
  try {
    // $this is  DynamicProfile class instance
// Parag Jagdale - 10-21-10: hard codes the permissions to be 1 (everyone)
    $this->save('personal', PERSONAL, 1);
  } catch (PAException $e) {
    $msg = "$e->message";
    $save_error = TRUE;
  }
  if ($save_error == TRUE) {
    $error_msg = __('Sorry: you are unable to save data.').'<br>'.__(' Reason: ').$msg;
  } else {
		$error_msg = __('Profile updated successfully.');
  }
}


?>
  <h1><?= __("Personal Info") ?></h1>

    <form enctype="multipart/form-data" name="drop_list" action="" method="post">

  <?php
    $this->select(__('Ethnicity'), 'ethnicity', PA::$config->ethnicities, 'personal', NULL, FALSE);
    $this->select(__('Religion'), 'religion', PA::$config->religions, 'personal', NULL, FALSE);
    $this->select(__('Political View'), 'political_view', PA::$config->political_views, 'personal', NULL, FALSE);
    $this->textarea(__("Passion"), "passion", "personal", NULL, FALSE);
    $this->textarea(__("Activities"), "activities", "personal", NULL, FALSE);
    $this->textarea(__("Books"), "books", "personal", NULL, FALSE);
    $this->textarea(__("Movies"), "movies", "personal", NULL, FALSE);
    $this->textarea(__("Music"), "music", "personal", NULL, FALSE);
    $this->textarea(__("TV Shows"), "tv_shows", "personal", NULL, FALSE);
    $this->textarea(__("Cuisines"), "cusines", "personal", NULL, FALSE);
  ?>

      <div class="form-block">
        <input type="hidden" name="profile_type" value="personal" />
        <input type="submit" name="submit" class="submit" value="<?= __("Apply Changes") ?>" />
      </div>

    </form>
