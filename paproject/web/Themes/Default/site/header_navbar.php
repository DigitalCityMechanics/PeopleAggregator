<?php  
  $level_1 = $navigation_links['level_1'];
  unset($level_1['highlight']);
  if (PA::$network_info->type == MOTHER_NETWORK_TYPE) {
    $caption = sprintf(__("%s Networks"), PA::$site_name);
  }
  else {
    $caption = ucfirst(PA::$network_info->name).' Network';
  }

  $can_manage_network = PermissionsHandler::can_user(PA::$login_uid, array('permissions' => 'manage_settings'));;
?>
<!-- Main Header -->
<header class="main-header">
  <!-- Logo -->
  <a href="<?= PA::$url . PA_ROUTE_HOME_PAGE ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="<?php echo PA::$theme_url;?>/img/50x50_Logo.png" alt="<?= $caption ?>"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><?= $caption ?></span>
  </a>      
  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <?php if (!isset($_SESSION['user'])) { ?>
            <li>
                <a href="<?= UrlHelper::url_for(PA::$url . "/login.php", array(), "https") ?>">
                    <i class="fa fa-sign-in"></i> <span><?= __("Sign in") ?></span>
                </a>
            </li>
            <li>
                <a href="<?= UrlHelper::url_for(PA::$url . "/register.php", array(), "https") ?>">
                    <i class="fa fa-user-plus"></i> <span><?= __("Register") ?></span>
                </a>
            </li>
            <?php
        } else {
            $login_user = PA::$login_user;
            $user_name = $login_user->first_name . " " . $login_user->last_name;
            ?> 
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success"><?= "$message_count";?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have <?= "$message_count";?> messages</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                      <li><a href="<?php echo PA::$url; ?>/myAccount/newMessage"><?= __("Compose message") ?></a></li>
                  </ul>
                </li>
                <li class="footer"><a href="<?php echo PA::$url; ?>/myAccount/messages">See All Messages</a></li>
              </ul>
            </li>              
            <!-- User Account: style can be found in dropdown.less -->             
            <li class="dropdown user user-menu">
                <a href="<?= PA::$url . PA_ROUTE_USER_PUBLIC . '/' . $login_user->user_id ?>" class="dropdown-toggle" data-toggle="dropdown">
                    <?php echo uihelper_resize_mk_user_img($login_user->picture, 160, 160, 'class="user-image" alt="User Image"'); ?>
                    <span class="hidden-xs"><?php echo $login_user->login_name; ?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <?php echo uihelper_resize_mk_user_img($login_user->picture, 160, 160, 'class="img-circle" alt="User Image"'); ?>
                        <p>
                            <?php echo $login_user->login_name; ?>
                            <small>Member since Nov. 2012</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="<?= PA::$url . PA_ROUTE_USER_PRIVATE ?>" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="/logout.php" class="btn btn-default btn-flat"><?= __("Sign out") ?></a>
                        </div>
                    </li>
                </ul>
            </li>            
            <?php } ?>   
          <?php 
            $i = 0;
            $cnt = count($level_1);
            $links_string = NULL;
            foreach ($level_1 as $key=>$value) {
              $i++;
              $link_string = '<a href="' . $value['url'] . '"' . $value['extra'] . '>' . '<i class="' . $value['icon'] . '"></i>' . '<span>' . $value['caption'] . '</span>' . '</a> ';
              if( $key == 'join_network') {
                $link_string = $link_string;
              } 
              $link_string = ( $cnt == $i ) ? $link_string : $link_string.' | ';
              $link_string = '<li>'.$link_string.'</li>';
              $links_string .= $link_string;
            }

            echo $links_string;
          ?>    
          <!-- Languages: style can be found in dropdown.less-->
          <li class="dropdown languages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-language"></i>
            </a>
            <ul class="dropdown-menu"> 
              <?php if(PA::$extra['language_bar_enabled']) { ?>
                  <?php foreach(array_keys($app->installed_languages) as $lang) {
                    $src_url = add_querystring_var($app->request_uri, "lang", $lang);
                    echo "<li><a href=\"$src_url\"><img src= \"" . PA::$theme_url . "/images/flags/$lang.png\" /></a></li> ";
                  } ?>
              <?php } ?>
            </ul>
          </li>
          <!-- /.languages-menu -->              
          <!-- Control Sidebar Toggle Button -->
          <?php if($can_manage_network) { ?>
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>   
          <?php } ?>
        </ul>
    </div>
  </nav>    
</header>    
<!-- =============================================== -->