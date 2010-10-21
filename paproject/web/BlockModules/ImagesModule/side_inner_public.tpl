<?php
?>
 <div id="gallery-images" class="image_list display_true">
   <ul>
     <?php
       if($links_count = count($links['images'])) {
         for( $counter = 0; $counter < $links_count; $counter++) {
           $image = $links['images'][$counter]['image_file'];
           $cid = $links['images'][$counter]['content_id'];
           $permalink = (!empty($gid)) ? PA::$url .'/media_full_view.php?gid='.$gid.'&amp;type=image&amp;cid='.$cid : PA::$url .'/media_full_view.php?cid='.$cid.'&amp;type=image&amp;media';
//            $permalink = PA::$url .'/media_full_view.php?cid='.$cid.'&amp;type=image&media';
           if(strstr($image, 'http://')) {
            $image= (verify_image_url($image)) ? $image:PA::$theme_url . '/images/no_img_found.gif';
     ?>
    <li>
        <a href="<?php echo $permalink; ?>">
         <img alt="PA" border="0" src="<?php echo $image; ?>" width="70" height="65" />
         </a>
       </li>
       <?php } else { ?>
    <li>
         <a href="<?php echo $permalink; ?>">
         <?php  echo uihelper_resize_mk_img($image, 70, 65); ?>  
         </a>
    </li>
       <?php
              }
            }
         } else {
             echo '<li>'.__("No images have been published yet.").'</li>';
         }
       ?>
   </ul>
  </div>