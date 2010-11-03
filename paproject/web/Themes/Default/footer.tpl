<?php
  global $network_info;
  require_once "api/FooterLink/FooterLink.php";

  $footer_links = FooterLink::get(array('is_active' => ACTIVE));
  $count_footer_links = count($footer_links);
  $link_html = NULL;
  for ($counter = 0; $counter < $count_footer_links; $counter++) {
    $extra_data = unserialize($footer_links[$counter]->extra);
    $target = NULL;
    if ($extra_data['is_external'] == 1) {
      $target = "target=\"_blank\"";
    }
    $link_html .= '<li><a href="'.$footer_links[$counter]->url.'" '.$target.'>'.$footer_links[$counter]->caption.'<a></li> | ';
  }
  $link_html = substr($link_html, 0, -2);
?>
<div class="footer" id="footer"><div id="footer-inner">
	
	<ul class='sub-nav'> 
		<li><a href='<?= PA::$url; ?>/home' title='Blog'>Blog</a></li> 
		<li><a href="<?php echo CC_APPLICATION_URL; ?>/about">About Us</a></li> 
		<li><a href="<?php echo CC_APPLICATION_URL; ?>/help">Help</a></li> 
		<li><a href="<?php echo CC_APPLICATION_URL; ?>/faq">FAQ</a></li> 
		<li><a href="<?php echo CC_APPLICATION_URL; ?>/principles">Mission &amp; Principles</a></li> 
		<li><a href="<?php echo CC_APPLICATION_URL; ?>/team">Team</a></li> 
		<li><a href="<?php echo CC_APPLICATION_URL; ?>/partners">Partners</a></li> 
		<li><a href="<?php echo CC_APPLICATION_URL; ?>/press">In The News</a></li> 
	</ul> 
	<p>The Civic Commons is <?= sprintf(__("&copy; Copyright %s"), date('Y')) ?> by the Legal Entity.  Content is licensed under License. [<?= get_svn_version() ?>]</p>	
	<ul class='social-media'> 
		<li><a href='http://www.facebook.com/pages/Civic-Commons/143930632284131' id='facebook'>Facebook</a></li> 
		<li><a href='http://twitter.com/civiccommons' id='twitter'>Twitter</a></li> 
		<li><a href='http://www.youtube.com/user/neociviccommons' id='youtube'>YouTube</a></li> 
		<li><a href='#' id='rss'>RSS</a></li> 
	</ul>
</div></div><!-- /.footer -->
