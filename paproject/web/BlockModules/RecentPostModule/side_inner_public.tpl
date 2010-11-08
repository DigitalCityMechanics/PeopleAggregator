<?php 
$gidQuery = "";
if (!empty($gid)) {
  $gidQuery = '?ccid='.$gid;
}?>
  <ol class="posts divided">
    <?php
      $links_count = count($links); 
      if (!empty($links_count)) { 
        for ($counter = 0; (($counter < $links_count) && ($counter < $limit)); $counter++) {
    ?>        
        <li>
          <strong><a href="<?php echo PA::$url . PA_ROUTE_CONTENT ;?>/cid=<?php echo $links[$counter]['content_id'];?>">
            <?php echo _out($links[$counter]['title']); ?>
          </strong></a>
        </li>   
    <?php
        }
      }
    ?>
    
  </ol>  
