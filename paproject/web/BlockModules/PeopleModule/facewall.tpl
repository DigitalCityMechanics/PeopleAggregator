<?php

global $aim_api_key, $aim_presence_key;
$query_args = array();
  if (!empty($_REQUEST)) {
  // code for appending the GET string in filters
    $query_string_array = $_REQUEST;
    if (isset($query_string_array['sort_by'])) {
      unset($query_string_array['sort_by']);
    }

	parse_str($_SERVER['QUERY_STRING'], $query_args);
	if(!empty($show_people_with_photo)) {
		$query_args['show_people_with_photo'] = $show_people_with_photo;
	}
  }

  $style = 'style="display:none;"';
  $toggle_text = __('Advanced Search');
  if ($show_advance_search_options) {
    $style = null;
    $toggle_text = __('Simple Search');
  }
?>

<h1><?= __("Community") ?></h1>

<ul id="filters" style="display: none;">
    <li<?php echo (empty($_REQUEST['sort_by']) || (!empty($_REQUEST['sort_by']) && $_REQUEST['sort_by'] == 'recent_users') ) ? ' class="active"' : '';?>><a href="<?php echo PA::$url . PA_ROUTE_PEOPLES_PAGE;?>?<?php $query_args['sort_by'] = 'recent_users'; echo htmlspecialchars(http_build_query($query_args)); ?>"><?= __("Recent Users") ?></a></li>
    <li<?php echo (!empty($_REQUEST['sort_by']) && $_REQUEST['sort_by'] == 'alphabetic') ? ' class="active"' : '';?>><a href="<?php echo PA::$url . PA_ROUTE_PEOPLES_PAGE;?>?<?php $query_args['sort_by'] = 'alphabetic'; echo htmlspecialchars(http_build_query($query_args)); ?>"><?= __("Alphabetical") ?></a></li>
</ul>

<form name="myform_search" action="" method="get" class="clear">

<fieldset class="search" style="display: none;">
    <legend><?= __("Search") ?></legend>
<script type="text/javascript">
var _names_cleared = false;
function name_focus(el) {
  if (_names_cleared) return;
  document.getElementById("allnames").value = '';
  _names_cleared = true;
}
</script>
	<input id="allnames" type="text" name="allnames" class="text normal" <?php
        if (!empty($_REQUEST['allnames']) || !empty($_REQUEST['allnames']) || $show_advance_search_options) {
          ?>value="<?php echo htmlspecialchars(@$_REQUEST['allnames']) ?>"<?php
        } else {
          ?>value="<?= __("Name") ?>" onfocus='name_focus()'<?php
        }?> />
	<a class="button" href="javascript: document.forms['myform_search'].submit();"><?= __("Find Users") ?></a>

    <input type="hidden" name="submit_search" value="search" />
  </fieldset>
</form>

<div id="PeopleModule">


  <div style="clear: both;">
  <?php foreach($links as $link) {
   include "_buddy.tpl.php";
  } ?>
  </div>

<?php if( $page_links ) { ?>
	<div class="pagination">
		<?php echo $page_links; ?>
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
