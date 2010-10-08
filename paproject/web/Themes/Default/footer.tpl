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
	<ul class="sub-nav">
		<?php echo $link_html;?>
	</ul>
	<p>The Civic Commons is <?= sprintf(__("&copy; Copyright %s"), date('Y')) ?> by the Legal Entity.  Content is licensed under License. [<?= get_svn_version() ?>]</p>	
	<ul class="social-media">
		<li><a href="#" id="facebook">Facebook</a></li>
		<li><a href="#" id="twitter">Twitter</a></li>
		<li><a href="#" id="youtube">YouTube</a></li>
		<li><a href="#" id="rss">RSS</a></li>
	</ul>
</div></div><!-- /.footer -->
