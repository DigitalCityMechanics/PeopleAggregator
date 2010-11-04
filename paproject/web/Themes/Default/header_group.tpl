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
	<a id='logo' href='<?php echo CC_APPLICATION_URL . "/" ?>' title='Civic Commons'>Civic Commons</a>
	<div id="header-utility">
	<?  if(!isset($_SESSION['user'])) { ?>
	<div id="login-status" class="signed-out">
		<div class="offset-2">
			<div id="user">
				<p>
					<a href="<?php echo CC_APPLICATION_URL . "/people/login" ?>" class="button login-link">
						Login to your account
					</a>
				</p>
				<a href="<?php echo CC_APPLICATION_URL . "/people/register/new" ?>" class="createacct-link">
					Create an account
				</a>
			</div>
		</div>
	</div>
      <? } else {
             $login_user = PA::$login_user;
             $user_name = $login_user->first_name." ".$login_user->last_name;
      ?>
		<div id="login-status">
			<div class="offset-2">
   				<a href="<?= PA::$url . PA_ROUTE_USER_PRIVATE ?>" title="<?php echo $user_name; ?>">
	   				<?php
	   				$aWidth = 40;
					$aHeight = 40;
   				
   					if(isset($login_user->avatar_small_dimensions['width']) && $login_user->avatar_small_dimensions['width'] > 0){
						$aWidth = $login_user->avatar_small_dimensions['width'];
					}

   					if(isset($login_user->avatar_small_dimensions['height']) && $login_user->avatar_small_dimensions['height'] > 0){
						$aHeight = $login_user->avatar_small_dimensions['height'];
					}
   					?>
   					<?php echo uihelper_resize_mk_user_img($login_user->avatar_small, $aWidth, $aHeight, 'alt="User Picture" class="callout"'); ?>
				</a>
				<h4><a href="<?= PA::$url . PA_ROUTE_USER_PRIVATE ?>"><?php echo $user_name; ?></a></h4>
				<div class="login-actions">
					<p>
						<a href="/myAccount/editProfile" class="user-link">Edit My Account</a>
					</p>
					<p>
						<a title="logout" href="/logout.php" class="user-link">Logout</a>
					</p>				
				</div>				
			</div>
       		<?php /*include("web/includes/shortcuts_menu.php");*/ ?>
		</div>
      <? } ?>
		<div class="important">
			<p>
				<a href="<?= PA::$url ?>/post_content.php?blog_type=Suggestion">Help build the Commons</a> 
 			</p>
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
<?php
/*
		<div id="search">
	        <form method="post">
	        	<input type="text" class="textbox placeholder" id="search" name="search" placeholder="Name, Keyword, Date..." />
		        <input type="submit" class="submit" value="Search" />
	        </form>
        </div>
*/
?>
	<?php } ?>
</div></div><!-- /.nav -->
<?php if(isset($use_feature_mast) && $use_feature_mast){ ?>
<div class="feature-mast">
	<div class="wrapper">
		<div class="content-container">
			<div class="main-content">
				<h1><?php echo (isset($title) && $title != '') ? $title : '(no title set)'; ?></h1>
				<p class="convo-meta"><?php echo (isset($metadata) && $metadata != '') ? $metadata : ''; ?></p>
			</div>
			<div class="aside supplementary">
				<?php echo (isset($aside) && $aside != '') ? $aside : ''; ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>