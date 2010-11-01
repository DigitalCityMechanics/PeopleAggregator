<?php

global $aim_api_key, $aim_presence_key;
$query_string = null;
  if (!empty($_REQUEST)) {
  // code for appending the GET string in filters
    $query_string_array = $_REQUEST;
    if (isset($query_string_array['sort_by'])) {
      unset($query_string_array['sort_by']);
    }

    $query_string = null;
    foreach ($query_string_array as $key => $value) {
      if($key <> 'PHPSESSID') {
        $query_string .= '&'.$key.'='.$value;
      }
    }
    if(!empty($show_people_with_photo)) {
      $query_string .= "&show_people_with_photo=$show_people_with_photo";
    }
  }

  $style = 'style="display:none;"';
  $toggle_text = __('Advanced Search');
  if ($show_advance_search_options) {
    $style = null;
    $toggle_text = __('Simple Search');
  }


?>

<ul id="filters">
    <li<?php echo (empty($_REQUEST['sort_by']) || (!empty($_REQUEST['sort_by']) && $_REQUEST['sort_by'] == 'recent_users') ) ? ' class="active"' : '';?>><a href="<?php echo PA::$url . PA_ROUTE_PEOPLES_PAGE;?>/sort_by=recent_users<?php echo htmlspecialchars($query_string) ?>"><?= __("Recent Users") ?></a></li>
    <li<?php echo (!empty($_REQUEST['sort_by']) && $_REQUEST['sort_by'] == 'alphabetic') ? ' class="active"' : '';?>><a href="<?php echo PA::$url . PA_ROUTE_PEOPLES_PAGE;?>/sort_by=alphabetic<?php echo htmlspecialchars($query_string) ?>"><?= __("Alphabetical") ?></a></li>
</ul>

<h1><?= __(PA::$people_noun) ?></h1>

<div id="PeopleModule">


  <?php if( $page_links ) { ?>
   <div class="prev_next">
     <?php if ($page_first) { echo $page_first; }?>
     <?php echo $page_links?>
     <?php if ($page_last) { echo $page_last;}?>
   </div>
  <?php }  ?>
  <div style="padding-left: 18px; clear: both; float: left; width:540px">
  <?php foreach($links as $link) {
   include "_buddy.tpl.php";
  } ?>
  </div>

  <?php if( $page_links ) {?>
   <div class="prev_next" id="page_next">
     <?php if ($page_first) { echo $page_first; }?>
     <?php echo $page_links?>
     <?php if ($page_last) { echo $page_last;}?>
   </div>
  <?php }  ?>


  <?php
    if (isset($aim_api_key))
      { ?>
    <div id="AIMBuddyListContainer" wim_key="<?php echo $aim_api_key ?>" class="hand" >
	    <a onclick="{AIM.widgets.buddyList.launch();return false;}"
	href="nojavascript.html"><img alt="AIM" border="1" src="<?php echo PA::$url ."/images/aim-online.png"?>">AIM Buddies</a>
	</div>
     <?php
	  }
      ?>
</div>

<form name="myform_search" action="" method="get" class="clear">

<fieldset class="center_box">
    <legend><?= __("Search") ?></legend>
<script type="text/javascript">
var _names_cleared = false;
function name_focus(el) {
  if (_names_cleared) return;
  document.getElementById("allnames").value = document.getElementById("last_name").value = "";
  _names_cleared = true;
}
</script>

    <table cellpadding="0" cellspacing="0" class="search_user">
      <tr>
        <td width="150">
        <input id="allnames" type="text" name="allnames" class="text normal" <?php
        if (!empty($_REQUEST['allnames']) || !empty($_REQUEST['allnames']) || $show_advance_search_options) {
          ?>value="<?php echo htmlspecialchars(@$_REQUEST['allnames']) ?>"<?php
        } else {
          ?>value="<?= __("First name") ?>" onfocus='name_focus()'<?php
        }?> /></td>
        <td width="150">
        <input id="last_name" type="text" name="last_name" class="text normal" <?php
        if (!empty($_GET['first_name']) || !empty($_GET['last_name']) || $show_advance_search_options) {
          ?>value="<?php echo htmlspecialchars(@$_GET['last_name']) ?>"<?php
        } else {
          ?>value="<?= __("Last name") ?>" onfocus='name_focus()'<?
        } ?> /></td>
        <td width="250" id="buttonbar">
          <ul>
          <li><a href="javascript: document.forms['myform_search'].submit();"><?= __("Find Users") ?></a></li>
        </ul>
      </td>
      </tr>
    </table>

    <input type="hidden" name="submit_search" value="search" />
  </fieldset>
</form>
