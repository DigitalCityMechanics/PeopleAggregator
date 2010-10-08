<?php
	

 ?>
<?php
  global $app;
  $level_2 = $navigation_links['level_2'];
  if (!empty(PA::$config->simple['use_simplenav'])) {
    $level_3 = array();
	  $left_user_public_links = array();
  } else {
    $level_3 = $navigation_links['level_3'];
	  $left_user_public_links = $navigation_links['left_user_public_links'];
  }
  $mothership_info = mothership_info();

 ?>
<?php
   $img_desktop_info = get_network_image();
   $style = null;
   $extra = unserialize($network_info->extra);
   if (!empty($img_desktop_info) && @$extra['basic']['header_image']['display'] == DESKTOP_IMAGE_DISPLAY) {
       $img_desktop_info = manage_user_desktop_image($extra['basic']['header_image']['name'], $extra['basic']['header_image']['option']);
       $style = ' style="background: url('.$img_desktop_info['url'].') '.$img_desktop_info['repeat'].'"';
   }
?>
<div id="header-wrapper"><div id="header"<?php echo $style?>>
  <?php if(@PA::$extra['language_bar_enabled']) : ?>
    <div class="language_bar">
      <?php foreach(array_keys($app->installed_languages) as $lang) {
        $src_url = add_querystring_var($app->request_uri, "lang", $lang);
        echo "<a href=\"$src_url\"><img src= \"" . PA::$theme_url . "/images/flags/$lang.png\" /></a> ";
      } ?>
    </div>
  <?php endif; ?>
	<a id='logo' href='/' title='Civic Commons'>Civic Commons</a>
	<div id="header-utility">
	<?  if(!isset($_SESSION['user'])) { ?>
	<div id="login-status" class="signed-out">
		<div class="offset-2">
			<div id="user">
				<p class="login-link">
					<a href="<?php echo CC_APPLICATION_URL . "/people/login" ?>">
					<strong>
					Login to your account
					</strong>
					</a>
				</p>
				<p class="createacct-link">
					<a href="<?php echo CC_APPLICATION_URL . "/people/register/new" ?>">Create an account</a>
				</p>
			</div>
		</div>
	</div>
      <? } else {
             $login_user = PA::$login_user;
             $user_name = $login_user->first_name." ".$login_user->last_name;
      ?>
		<div id="login-status"  onmouseover="javascript:show_hide_shortcuts.onmouseover('open_close');" onmouseout="javascript:show_hide_shortcuts.onmouseout('open_close');">
			<div class="offset-2">
				<?php echo uihelper_resize_mk_user_img($login_user->picture, 40, 40, 'alt="User Picture" class="callout"'); ?>
				<h4><a href="<?= PA::$url . PA_ROUTE_USER_PUBLIC . '/' . $login_user->user_id ?>"><?php echo $user_name; ?></a></h4>
				<a title="logout" href="<?php echo CC_APPLICATION_URL . "/people/logout" ?>">Logout</a>
			</div>
       		<?php /*include("web/includes/shortcuts_menu.php");*/ ?>
		</div>
      <? } ?>
		<div class="important">
			<p>We need your help. <a href="/post_content.php?blog_type=Suggestion">Suggest a Topic</a></p>
		</div>
	</div><!-- /.header-utility -->
</div></div><!-- /.header -->

<div id='nav-wrapper'><div id="nav">
	<?php if($level_2) {?>
		<ul id="main-nav">
		  <?php
			$highlight = @$level_2['highlight'];
          	unset($level_2['highlight']);
          	$cnt = count($level_2);
          	$i=0;
          	$links_string = NULL;
          	foreach ($level_2 as $key=>$value) {
			?>
				<?php
				$sublinks_ul = null;
            	$id = '';
            	$id2 = '';
            	$i++;
            	if ( $key == $highlight ) {
              		$id = ' id="current"';
              		$id2 = ' id="active"';
            	}

				if(isset($value['url'])){
            		$link_string = '<a href="'.$value['url'].'"'.$id.' title="'.$value['caption'].'">'.$value['caption'].'</a>';
				}else{
					$link_string = $value['caption'];
				}

				if(isset($value['sublinks']) && count($value['sublinks']) > 0){
					$sublinks_content = null;
					$sublinks_anchor = null;
					foreach($value['sublinks'] as $sublink){
						$sublinks_anchor = '<a href="'.$sublink['url'].'"'.$id.' title="'.$sublink['caption'].'">'.$sublink['caption'].'</a>';
						$sublinks_content .= '<li>'.$sublinks_anchor.'</li>';
					}
					if(isset($sublinks_content)){
						$sublinks_ul = "<ul>$sublinks_content</ul>";
					}
				}
        		?>
				<li<?php echo $id2;?> class="<?php echo (isset($sublinks_ul)) ? "drop" : ''; ?>" ><?php echo $link_string . $sublinks_ul; ?></li>
			<?php } ?>
		</ul>
		
        <form id="search" method="post">
        	<input type="text" class="textbox placeholder" id="search" name="search" placeholder="Name, Keyword, Date..." />
        	<input type="submit" class="submit" value="Search" />
        </form>
	<?php } ?>
</div></div><!-- /.nav -->