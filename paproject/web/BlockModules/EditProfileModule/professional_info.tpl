<?php
 

// echo "<pre>" . print_r($this->user,1) . "</pre>";
$profile = &$this->user->{'professional'};

if (isset($_POST['submit']) && ($_POST['profile_type'] == 'professional')) {
  global $msg, $nsg2, $msg_pro;

  require_once "web/includes/classes/file_uploader.php";
  if (!empty($_FILES['user_cv']['name'])) {
     $myUploadobj = new FileUploader; //creating instance of file.
     $file_type = 'doc';
     $file = $myUploadobj->upload_file(PA::$upload_path,'user_cv',true,true,$file_type);
     if( $file == false) {
       $msg = $myUploadobj->error;
       $error = TRUE;
     } else {
       $user_cv = $file;
       $_POST['user_cv']['value'] = $user_cv;
       Storage::link($user_cv, array("role" => "cv", "user" => PA::$login_user->user_id));
     }
   } else if (!empty($this->user->{'professional'}['user_cv']['value'])) {
     $user_cv = $this->user->{'professional'}['user_cv']['value'];
     $_POST['user_cv']['value'] = $user_cv;
   }

  // $this is  DynamicProfile class instance
  $this->processPOST('professional');
  if (empty($error)) {
    try {
      // $this is  DynamicProfile class instance
// Parag Jagdale - 10-21-10: hard codes the permissions to be 1 (everyone)
      $this->save('professional', PROFESSIONAL, 1);
    } catch (PAException $e) {
      $msg = "$e->message";
      $save_error = TRUE;
    }
  }

  if (!empty($error) || !empty($save_error)) {
    $msg = __('Sorry: you are unable to save data').'<br>'.__('Reason: ')."$msg";
  } else {
		global $error_msg;
		$error_msg = __('Profile updated successfully.');
  }
}
?>

  <h1><?= __("Professional Info") ?></h1>
      <form enctype="multipart/form-data" action="" method="post" >

  <?php
    $label = __("Upload CV");
    $fieldname = "user_cv";
    $f = @$this->user->{'professional'}[$fieldname];
    $v = @$f['value'];
  ?>
      <div class="field_medium">
        <label for="<?=$fieldname.'[value]'?>"><?=$label?></label>
        <div class="center">
        <input type="file" class="text normal" id="user_cv" name="user_cv" />
        </div>
            <div class="form-block">
              <?= __("Valid file types are .doc and .pdf") ?>.
              <?php if (!empty($v)) {
              ?><span class="required"><?= __("This will replace your current CV") ?> (<a href="<?= htmlspecialchars(Storage::getURL($v)) ?>">click here to download</a>)<span>
              <? } ?>
            </div>
      </div>

          <?php
            $this->textfield(__("Headline"), "headline", "professional", NULL, FALSE);
            $this->textfield(__("Industry"), "industry", "professional", NULL, FALSE);
            $this->textfield(__("Company"), "company", "professional", NULL, FALSE);
            $this->textfield(__("Title"), "title", "professional", NULL, FALSE);
            $this->textfield(__("Work Phone"), "workPhone", 'professional', NULL, FALSE);
            $this->textfield(__("Website"), "website", "professional", NULL, FALSE);
            $this->textarea(__("Career Skills"), "career_skill", "professional", NULL, FALSE, "Enter Career Skill separated by commas");
            $this->textfield(__("Prior Company"), "prior_company", "professional", NULL, FALSE);
            $this->textfield(__("City"), "prior_company_city", "professional", NULL, FALSE);
            $this->textfield(__("Prior Title"), "prior_company_title", "professional", NULL, FALSE);
            $this->textfield(__("College Name"), "college_name", "professional", NULL, FALSE);
            $this->textfield(__("Degree"), "degree", "professional", NULL, FALSE);
            $this->textarea(__("Summary"), "summary", "professional", NULL, FALSE, __("Your full Professional biography here. Please note there is a 2,500 character limit."));
            $this->textarea(__("Languages"), "languages", "professional", NULL, FALSE);
            $this->textarea(__("Honors &amp; Awards"), "awards", "professional", NULL, FALSE);
          ?>

        <div class="form-block">
          <input type="hidden" name="profile_type" value="professional" />
          <input type="submit" name="submit" class="submit" value="<?= __("Apply Changes") ?>" />
        </div>

      </form>
