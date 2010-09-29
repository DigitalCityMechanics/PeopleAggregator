<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<link href="/Themes/Default/jquery-ui-1.8.5.custom.css" type="text/css" media="screen" rel="stylesheet" />
<script src="/Themes/Default/javascript/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$("#tabs-contributions").tabs();
	});
</script>
<style type="text/css">
div.participation {
	background-color:#FFF;
	margin-bottom:10px;
	padding:4px;
}
div.participation img {
	float:left;
	margin:0 13px 5px;
}
div.participation h2 {
	text-decoration:underline;
}
div.participation div.below {
	clear:both;
	padding:5px;
}
</style>
<?php global  $login_uid;?>

<div id="tabs-contributions">
	<ul>
		<li><a href="#tabs-contributions-1">Contributions</a></li>
		<li><a href="#tabs-contributions-2">Thoughts</a></li>
	</ul>
	<div id="tabs-contributions-1">
		<div class="participation">
			<div class="above">
				<img src="/Themes/Default/images/best-friend.jpg" />
				<p>Here is the text they contributed</p>
			</div>
			<div class="below">
				<a href="#">6 Participants</a> | <a href="#">17 Contributions</a>
			</div>
		</div>
		<div class="participation">
			<div class="above">
				<img src="/Themes/Default/images/audio.png" />
				<p>Here is the text they contributed. This might be a little bit longer. Like, this text, for instance. Maybe another sentence to really make this about a good length.</p>
			</div>
			<div class="below">
				<a href="#">60 Participants</a> | <a href="#">1337 Contributions</a>
			</div>
		</div>
	</div>
	<div id="tabs-contributions-2">
		<div class="participation">
			<div class="above">
				<img src="/Themes/Default/images/blog.png" />
				<p>Here is the text they contributed</p>
			</div>
			<div class="below">
				<a href="#">16 Participants</a> | <a href="#">117 Contributions</a>
			</div>
		</div>
	</div>
  </div>	
  <?php /*
		Here begins the code copied from the Testimonials Module. I will leave it here because perhaps it will provide insight into
		the way to write the module so that it actually pulls down the data.	-Tom

  $cnt = count($links);
  if (  $cnt > 0) { ?>
  
      <div class="group_list">
        <table cellspacing="0" cellpadding="0">
        <? for ($i=0; $i < $cnt; $i++) {
          $pic = $links[$i]['picture'];?>         
            <tr>
              
              <td align="center" valign="top" width="80">
                <a href="<?php echo $links[$i]['hyper_link'];?>"><?= uihelper_resize_mk_img($pic, 60, 55, DEFAULT_USER_PHOTO_REL, 'alt="sender"', RESIZE_CROP) ?></a>
              </td>
              
              <td valign="top" width="415">
              <b><a href="<?php echo $links[$i]['hyper_link'];?>"><?php echo $links[$i]['user_name'];?> said:</a><br />
              

               <?php echo stripslashes($links[$i]['comment']); ?>
                
                <div class="post_info">
                   <?php 
                     if(!empty($links[$i]['delete_link'])) { 
                     ?>
                     <div id="buttonbar">
                       <ul>
                           <li>
                             <a href="<?php echo $links[$i]['delete_link'];?>"><?= __("Delete") ?></a>
                           </li>
                       </ul>
                     </div>  
                    <? }
                   ?>
 
                 </div>
              </td>
                   
               <td align="center" valign="top">
               </td>
       </tr>
            
      <? } ?>
      </table>
    </div>
    <?  } */ /* if( $page_links ) {?>
   <div class="prev_next">
     <?php if ($page_first) { echo $page_first; }?>
     <?php echo $page_links?>
     <?php if ($page_last) { echo $page_last;}?>
   </div>
  <?php } */ ?>
