<?php
global $app;
$level_1 = $navigation_links['level_1'];
unset($level_1['highlight']);
if (PA::$network_info->type == MOTHER_NETWORK_TYPE) {
    $network_name = sprintf(__("%s Platform"), PA::$site_name);
} else {
    $network_name = ucfirst(PA::$network_info->name) . ' Network';
}

$level_2 = $navigation_links['level_2'];
if (!empty(PA::$config->simple['use_simplenav'])) {
    $level_3 = array();
    $left_user_public_links = array();
} else {
    $level_3 = $navigation_links['level_3'];
    $left_user_public_links = $navigation_links['left_user_public_links'];
}

$mother_network = Network::get_mothership_info();
$extra = unserialize($mother_network->extra);
$mothership_info = mothership_info();

$can_manage_network = PermissionsHandler::can_user(PA::$login_uid, array('permissions' => 'manage_settings'));;

?>
<!-- search form -->
<form action="#" method="get" class="sidebar-form">
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search...">
    <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
  </div>
</form>
<!-- /.search form -->
<?php  if(!isset($_SESSION['user'])) { ?>
<ul class="sidebar-menu">
    <li class="header"><?= __("USER NAVIGATION") ?></li>
    <li class="treeview">
        <?php $target = (!empty($_REQUEST['gid'])) ? '?ccid='.$_REQUEST['gid'] : null; ?>
        <a href="<?= UrlHelper::url_for(PA::$url . "/login.php", array(), "https") ?>">
            <i class="fa fa-sign-in"></i> <span><?= __("Sign in") ?></span>
        </a>
    </li>
    <li class="treeview">
        <a href="<?= UrlHelper::url_for(PA::$url . "/register.php", array(), "https") ?>">
            <i class="fa fa-user-plus"></i> <span><?= __("Register") ?></span>
        </a>
    </li>    
</ul>     
<?php } else {
$login_user = PA::$login_user;
$user_name = $login_user->first_name." ".$login_user->last_name;
?> 
<!-- Sidebar user panel -->
<div class="user-panel">
  <div class="pull-left image">
    <?php echo uihelper_resize_mk_user_img($login_user->picture, 160, 160, 'class="img-circle" alt="User Image"'); ?>
  </div>
  <div class="pull-left info">
    <p><?php echo $login_user->login_name; ?></p>
    <a href="#"><i class="fa fa-circle text-success"></i> <?= __("Online") ?></a>
  </div>
</div>
<ul class="sidebar-menu">
    <li class="header"><?= __("USER NAVIGATION") ?></li>
    <li class="treeview">
        <?php $target = (!empty($_REQUEST['gid'])) ? '?ccid='.$_REQUEST['gid'] : null; ?>
        <a href="<?= PA::$url;?>/post_content.php<?=$target?>">
            <i class="fa fa-file-text"></i> <span><?= __("Create Post") ?></span>
        </a>
    </li>
    <li class="treeview">
        <a href="<?= PA::$url .PA_ROUTE_MYMESSAGE;?>">
            <i class="fa fa-envelope"></i> <span><?= __("Messages ") ?><?= "($message_count)";?></span>
        </a>
    </li>
    <li class="treeview">
        <a href="<?= PA::$url.PA_ROUTE_EDIT_PROFILE?>">
            <i class="fa fa-wrench"></i> <span><?= __("Edit my account") ?></span>
        </a>
    </li>
    <?php if($can_manage_network) { ?>
    <li class="treeview">
        <a href="<?= PA::$url . PA_ROUTE_CONFIGURE_NETWORK;?>">
            <i class="fa fa-cog"></i> <span><?= __("Configure") ?></span>
        </a>
    </li>  
    <?php } ?>
    <li class="treeview">
        <a href="<?= UrlHelper::url_for(PA::$url . "/logout.php", array(), "https") ?>">
            <i class="fa fa-sign-out"></i> <span><?= __("Sign out") ?></span>
        </a>
    </li>      
</ul>    
<?php } ?>

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="treeview">
        <a href="<?= PA::$url . PA_ROUTE_HOME_PAGE ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <?php
    if (!empty($left_user_public_links)) {
        $cnt = count($left_user_public_links);
        $i = 0;
        $links_string = NULL;
        foreach ($left_user_public_links as $key => $value) {
            $i++;
            $link_string = '<a href="' . $value['url'] . '"' . $value['extra'] . '>' . '<i class="' . $value['icon'] . '"></i> ' . '<span>' . $value['caption'] . '</span>' . '</a> ';
            $link_string = ( $cnt == $i ) ? $link_string : $link_string;
            ?>
            <li><?php echo $link_string; ?></li>
            <?php
        }
    }
    ?>

    <?php if (!(array_key_exists('top_navigation_bar', $extra)) || ($extra['top_navigation_bar'] == NET_YES)) { ?>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-globe"></i> <span><?= __("Network") ?></span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <?php
                $i = 0;
                $cnt = count($level_1);
                $links_string = NULL;
                foreach ($level_1 as $key => $value) {
                    $i++;
                    $link_string = '<a href="' . $value['url'] . '"><i class="fa fa-circle-o"></i>' . $value['caption'] . '</a>';
                    if ($key == 'join_network') {
                        $link_string = $link_string;
                    }
                    $link_string = ( $cnt == $i ) ? $link_string : $link_string;
                    $link_string = '<li>' . $link_string . '</li>';
                    $links_string .= $link_string;
                }
                echo $links_string;
                ?>            
            </ul>
        </li>          
    <?php } ?>

    <?php
    if ($level_2) {
        $highlight = $level_2['highlight'];
        unset($level_2['highlight']);
        $cnt = count($level_2);
        $i = 0;
        $links_string = NULL;
        foreach ($level_2 as $key => $value) {
            $id = '';
            $id2 = '';
            $i++;
            if ($key == $highlight) {
                $id = ' id="current"';
                $id2 = ' id="active"';
            }
            $link_string = '<a href="' . $value['url'] . '"' . $value['extra'] . '>' . '<i class="' . $value['icon'] . '"></i>' . '<span>' . $value['caption'] . '</span>' . '</a> ';
            $link_string = ( $cnt == $i ) ? $link_string : $link_string;
            ?>
            <li <?php echo $id2; ?>><?php echo $link_string; ?></li>
            <?php
        }
    }

    $highlight = $level_3['highlight'];
    unset($level_3['highlight']);
    if (count($level_3)) {
        $links_string = NULL;
        $cnt = count($level_3);
        $i = 0;
        foreach ($level_3 as $key => $value) {
            $id = '';
            $i++;
            if ($key == $highlight) {
                $id = ' class="active"';
            }
            $extra_info = (!empty($value['extra'])) ? $value['extra'] : null;
            $link_string = '<a href="' . $value['url'] . '" ' . $extra_info . '>' . $value['caption'] . '</a>';
            $link_string = ( $cnt == $i ) ? $link_string : $link_string;
            ?>
            <li<?php echo $id; ?>><?php echo $link_string; ?></li>
            <?php
        }
    }
    ?>
</ul>