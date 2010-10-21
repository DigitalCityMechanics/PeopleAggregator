<?php

$profile = &$this->user->{'general'};

$non_us_state = FALSE;
if(!empty($profile['state']) && !in_array($profile['state'], array_values(PA::getStatesList()))) {
  $non_us_state = TRUE;
}

if (isset($_POST['submit']) && ($_POST['profile_type'] == 'general')) {
  if (!empty($_POST['state']) && $_POST['state'] == 'Other') {
    $_POST['state'] = trim($_POST['state_other']);
  }

  $personal_website = @$_POST['personal_website']['value'];
  $day = @trim($_POST['dob_day']['value']);
  $month = @trim($_POST['dob_month']['value']);
  $year = @trim($_POST['dob_year']['value']);
  $_POST['dob']['value'] = $year.'-'.$month.'-'.$day; // YYYY-MM-DD

  if ($day && $month && $year && $day !=0 && $month !=0 ) {
    $day = ($day < 10) ? '0'.$day : $day;
    $month = ($month < 10) ? '0'.$month : $month;
    $dob = $year.'-'.$month.'-'.$day; // YYYY-MM-DD
    $dob_validation = checkdate($month, $day, $year);
    if (! $dob_validation) {
      $msg = __("The Date of Birth is invalid.");
      $error = TRUE;
    }
  } else {
    $dob = '';
  }

  $this->processPOST('general'); // so we get this data for display

 if(!empty($personal_website) && !Validation::isValidURL($personal_website)) {
    $msg = __('Url is invalid');
    $error = TRUE;
  }

  if ($error != TRUE) {

    $tags = explode(',', $_POST['user_tags']['value']);
    foreach ($tags as $term) {
      $tr = trim($term);
      if ($tr) {
        $terms[] = $tr;
      }
    }

    // here we can define fields which have permission for everybody
    $copy_over = Array('user_caption_image', 'desktop_image_action', 'desktop_image_display');
    foreach($copy_over as $f) {
      $_POST[$f] = $user_data_general[$f];
      $_POST[$f . '_perm'] = 1;
    }

    try {
      // $this is  DynamicProfile class instance
// Parag Jagdale - 10-21-10: hard codes the permissions to be 1 (everyone)
      $this->save('general', GENERAL, 1);
      Tag::add_tags_to_user(PA::$user->user_id, $terms);
    } catch (PAException $e) {
      $msg = "$e->message";
      $save_error = TRUE;
    }
  }

  if ($error == TRUE || $save_error == TRUE) {
    $msg = __('Sorry: you are unable to save data.').'<br>'.__('Reason: ').$msg;
  } else {
    // invalidate the cache for user profile
    header("Location: ".PA::$url.PA_ROUTE_EDIT_PROFILE."?type=general&updated=1");
  }
}
?>

  <h1><?= __("General Info") ?></h1>
  <?php
  if (!empty(PA::$config->simple['use_families'])) {
  ?>
<div>
		<form action="<?=PA::$url.PA_ROUTE_FAMILY_EDIT?>">
<fieldset>	<div style="float:right;">
		<?php 
		$createType = "family";
		$createLabel = __("Family");
		?>
			<input type="hidden" name="entityType" value="<?=$createType?>" />
			<input type="submit" name="submit" value="<?=
				sprintf(__("Create new %s"), $createLabel)
				?>" />
	</div>
	<br style="clear:both;" />
</fieldset>
		</form>
</div>
<?php } ?>
      <form enctype="multipart/form-data" name="drop_list" action="" method="post">

          <?php
            $this->textfield(__('Slogan'), 'user_caption', 'general', NULL, FALSE, __("Slogan will appear on your Public Page."));
            $this->textfield(__('Shout Out'), 'sub_caption', 'general', NULL, FALSE, __("Shout out will appear on your Public Page."));

          $sex = array();
          $sex[] = array('label'=>'Male','value'=>'Male');
          $sex[] = array('label'=>'Female','value'=>'Female');
          $this->radiobar(__("Gender"), 'sex', $sex, 'general', NULL, FALSE);
          $this->dateselect(__("Date of Birth"), 'dob', 'general',NULL, FALSE);
          $this->textfield(__("Address"), "homeAddress1", 'general',NULL, FALSE, NULL);
          $this->textfield(__("Address 2"), "homeAddress2", 'general',NULL, FALSE, NULL);
          $this->textfield(__("City"), "city", 'general', NULL, FALSE);
//          $this->select(__('State/Province'), 'state', array_values(PA::getStatesList()), 'general');
          ?>
<!--
          <div class="form-block" id="other_state_div" style="display:none;">
          <?php echo $this->textfield(__('Other state'), 'state_other', 'general', NULL, FALSE); ?>
          </div>
-->
          <?php
          $this->textfield(__('State/Province'), 'state', "general", NULL, FALSE);
          $this->select(__("Country"), "country", array_values(PA::getCountryList()), 'general', NULL, FALSE);
//          $this->textfield(__("Country"), "country", "general", NULL, FALSE);
          $this->textfield(__("Zip/Postal Code"), "postal_code", "general", NULL, FALSE);
          $this->textfield(__("Phone"), "phone", 'general',NULL, FALSE, NULL);
          $this->textfield(__("Mobile Phone"), "mobilePhone", 'general',NULL, FALSE, NULL);


          $this->textarea(__("User Tags (Interests)"), "user_tags", "general", NULL, FALSE,
          __("Seperate tags with commas."));
          ?>

        <div class="button_position">
          <input type="hidden" name="profile_type" value="general" />
          <input type="submit" name="submit" class="submit" value="<?= __("Apply Changes") ?>" />
        </div>


      </form>
