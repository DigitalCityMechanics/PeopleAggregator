<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<link href="/Themes/Default/jquery-ui-1.8.5.custom.css" type="text/css" media="screen" rel="stylesheet" />
<script src="/Themes/Default/javascript/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
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

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Conversations</a></li>
		<li><a href="#tabs-2">Issues</a></li>
		<li><a href="#tabs-3">Following</a></li>
	</ul>
<?php if(count($conversations) > 0){ ?>
	<div id="tabs-1">
	<?php foreach($conversations  as $conversation){ ?>
		<div class="participation">
			<div class="above">
				<?php if(isset($conversation['image'])){ ?>
					<img src="<?php echo $conversation['image']; ?>" alt="Conversation image"/>
				<?php } ?>
				<h2><a href="#"><?php echo $conversation['title']; ?></a></h2>
				<p><?php echo $conversation['summary']; ?></p>
			</div>
			<div class="below">
				<a href="#"><?php echo $conversation['participant_count']; ?> Participants</a> | <a href="#"><?php echo $conversation['contribution_count']; ?> Contributions</a>
			</div>
		</div>
	<?php } // end foreach ?>
	</div>
<?php } // end if ?>	

<?php if(count($issues) > 0){ ?>
	<div id="tabs-2">
	<?php foreach($issues  as $issue){ ?>
		<div class="participation">
			<div class="above">
				<?php if(isset($issue['image'])){ ?>
					<img src="<?php echo $issue['image']; ?>" alt="Issue image"/>
				<?php } ?>
				<h2><a href="#"><?php echo $issue['title']; ?></a></h2>
				<p><?php echo $issue['summary']; ?></p>
			</div>
			<div class="below">
				<a href="#"><?php echo $issue['participant_count']; ?> Participants</a> | <a href="#"><?php echo $issue['contribution_count']; ?> Contributions</a>
			</div>
		</div>
	<?php } // end foreach ?>
	</div>
<?php } // end if ?>	

<?php if(count($following) > 0){ ?>
	<div id="tabs-3">
	<?php foreach($following  as $followed){ ?>
		<div class="participation">
			<div class="above">
				<?php if(isset($followed['image'])){ ?>
					<img src="<?php echo $followed['image']; ?>" alt="Following image"/>
				<?php } ?>
				<h2><a href="#"><?php echo $followed['title']; ?></a></h2>
				<p><?php echo $followed['summary']; ?></p>
			</div>
			<div class="below">
				<a href="#"><?php echo $followed['participant_count']; ?> Participants</a> | <a href="#"><?php echo $followed['contribution_count']; ?> Contributions</a>
			</div>
		</div>
	<?php } // end foreach ?>
	</div>
<?php } // end if ?>	
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
