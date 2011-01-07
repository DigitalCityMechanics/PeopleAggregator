<?php
global $app;

// Takes the CivicCommons URL from AppConfig and adds it to the URL fed to externalRedirect.php?url=
// This can't be done in the redirect_rules.php because AppConfig is not yet loaded when redirect_rules.php is used
$civiccommons_app_url = $app->configData['configuration']['civic_commons_settings']['value']['CC_APPLICATION_URL']['value'];
$url = $civiccommons_app_url . '/' .  $_GET['url'];
header("Location: " . $url);
?>